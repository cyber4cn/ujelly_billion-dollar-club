<?php
/**
 * Description of Project
 *
 * @author greg
 * @package 
 */

class Wpjb_Project extends Daq_ProjectAbstract
{
    protected static $_instance = null;

    /**
     * Version is modified by build script.
     */
    const VERSION = "3.5.3";

    /**
     * Returns instance of self
     *
     * @return Wpjb_Project
     */
    public static function getInstance()
    {
        if(self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function run()
    {
        add_action("edit_user_profile", array(self::$_instance, "editUserProfile"));
        add_action("edit_user_profile_update", array(self::$_instance, "saveUserProfile"));
        add_filter("init", array(self::$_instance, "init"));
        add_filter("wp_title", array(self::$_instance, "injectTitle"));
        add_filter("single_post_title", array(self::$_instance, "injectTitle"));
        add_filter('rewrite_rules_array', array(self::$_instance, "rewrite"));
        add_filter('the_title', array(self::$_instance, "theTitle"), 10, 2);
        add_filter('the_content', array(self::$_instance, "theContent"));
        add_filter('wp', array(self::$_instance, "execute"));
        add_filter('redirect_canonical', array(self::$_instance, "redirectCanonical"));

        add_action('delete_user', array(self::$_instance, "removeUser"));

        add_action('admin_menu', array(self::$_instance, "addAdminMenu"));
        add_action('admin_print_scripts', array(self::$_instance, "addScripts"));
        add_action('wp_print_scripts', array(self::$_instance, "addScriptsFront"));
        add_action('admin_notices', array(self::$_instance, "adminNotices"));
        add_action('wp_dashboard_setup', array(self::$_instance, "addDashboardWidgets"));

        add_filter('query_vars', array(self::$_instance, "queryVars"));
        add_action("wp_footer", array(self::$_instance, "shutdown"));
        
        add_action("wp_enqueue_scripts", array(self::$_instance, "enqueueScripts"));
        add_action("admin_bar_menu", array($this, "adminBarMenu"), 1000 );
        
        add_shortcode('wpjb_search', 'wpjb_search_form');

        $this->_init();
        $directory = $this->env("directory");
        $logo = site_url()."/wp-content/plugins/$directory";
        $logo.= $this->pathRaw("admin_public")."/wpjb-midi.gif";
        $this->getAdmin()->getView()->slot("midi_logo", $logo);
        
        $paymentFactory = new Wpjb_Payment_Factory;
        foreach((array)glob($this->getBaseDir()."/application/libraries/Payment/*.php") as $ajax) {
            $ctrl = basename($ajax, ".php");
            if(in_array($ctrl, array("Factory", "Interface"))) {
                continue;
            }
            $payment = "Wpjb_Payment_".$ctrl;
            $payment = new $payment;
            if($payment instanceof Wpjb_Payment_Interface) {
                $paymentFactory->register($payment);
            }
        }
        Wpjb_Utility_Registry::set("payment_factory", $paymentFactory);

    }

    public function init()
    {
        load_plugin_textdomain(WPJB_DOMAIN, false, "wpjobboard/environment/lang");
        Daq_Loader::registerLocale("wpjobboard/framework/Locale");
        
        wp_register_script("wpjb-suggest", site_url()."/wp-content/plugins/wpjobboard/templates/wpjb-suggest.js", array("jquery"));
        wp_register_script("wpjb-color-picker", site_url()."/wp-content/plugins/wpjobboard/application/views/jquery.colorPicker.js");
    }
    
    public function adminNotices()
    {
        $path = array();
        $path[] = $this->path("user_images");
        $path[] = $this->path("company_logo");
        $path[] = $this->path("tmp_images");
        $path[] = $this->path("apply_file");
        $path[] = $this->path("logs");
        $path[] = $this->path("resume_photo");

        $notWritable = array();
        foreach($path as $p) {
            if(!is_writable($p)) {
                $notWritable[] = $p;
            }
        }

        if(empty($notWritable)) {
            return;
        }

        $head = "<strong>WPJobBoard encountered problem.</strong><br/>";
        $msg = "";
        if(!empty($notWritable)) {
            $msg.= "<li>Following paths in 'wpjobboard/environment' directory are not writable: ";
            $mArr = array();
            foreach($notWritable as $p) {
                $dir = basename($p);
                $mArr[] = "<abbr title=\"$p\">'$dir'</abbr>";
            }
            $msg.= implode(", ", $mArr).". ";
            $msg.= "In order to fix this problem set CHMOD on this directories to 0755 (or 0777). ";
            $msg.= "Until then users will be unable to upload files and images.</li>";
        }

        echo "<div class='error'>$head<ol>$msg</ol></div>";
        
    }

    public static function scheduleEvent()
    {
        $query = Wpjb_Model_Job::activeSelect();
        $query->select("t1.job_category AS category_id, COUNT(*) AS cnt");
        $query->group("t1.job_category");

        $cAll = array();
        foreach($query->fetchAll() as $row) {
            $cAll[$row->category_id] = $row->cnt;
        }

        $query = Wpjb_Model_Job::activeSelect();
        $query->select("t1.job_type AS type_id, COUNT(*) AS cnt");
        $query->group("t1.job_type");

        $tAll = array();
        foreach($query->fetchAll() as $row) {
            $tAll[$row->type_id] = $row->cnt;
        }

        $conf = self::getInstance();
        $conf->setConfigParam("count", array("category"=>$cAll, "type"=>$tAll));
        $conf->saveConfig();
    }

    public function removeUser($id)
    {
        $query = new Daq_Db_Query();
        $result = $query->select()
            ->from("Wpjb_Model_Employer t")
            ->where("user_id = ?", $id)
            ->limit(1)
            ->execute();

        if($result[0]) {
            $employer = $result[0];
            
            $query = new Daq_Db_Query();
            $query->select();
            $query->from("Wpjb_Model_Job t");
            $query->where("employer_id = ?", $employer->id);
            $result = $query->execute();
            
            foreach($result as $job) {
                $job->delete();
            }
            
            $employer->delete();
        }
        
        $query = new Daq_Db_Query();
        $result = $query->select()
            ->from("Wpjb_Model_Resume t")
            ->where("user_id = ?", $id)
            ->limit(1)
            ->execute();

        if($result[0]) {
            $employer = $result[0];
            $employer->delete();
        }
    }

    public function addAdminMenu()
    {
        $ini = Daq_Config::parseIni(
            $this->path("app_config")."/admin-menu.ini",
            $this->path("user_config")."/admin-menu.ini",
            true
        );

        $logo = site_url()."/wp-content/plugins/wpjobboard";
        $logo.= $this->pathRaw("admin_public")."/wpjb-mini.png";

        if(!$this->conf("cv_enabled")) {
            unset($ini['resumes_manage']);
        }
        
        $query = new Daq_Db_Query();
        $query->select("COUNT(*) AS cnt")->from("Wpjb_Model_Job t1");
        $query->join("t1.category t2");
        $query->join("t1.type t3");
        $query->where("t1.is_approved = 0");
        $query->where("t1.is_active = 0");
        $pending = $query->fetchColumn();
        if(isset($ini["jobs"]["page_title"])) {
            $warning = __("jobs awaiting approval", WPJB_DOMAIN);
            $ini["jobs"]["menu_title"]  = $ini["jobs"]["page_title"];
            $ini["jobs"]["menu_title"] .= "<span class='update-plugins wpjb-bubble-jobs count-$pending' title='$warning'><span class='update-count'>".$pending."</span></span>";
        }
        
        $query = new Daq_Db_Query();
        $query->select();
        $query->from("Wpjb_Model_Employer t")->join("t.users u")->select("COUNT(*) AS cnt")->limit(1);
        $pending = $query->where("t.is_active=?", 2)->fetchColumn();
        if(isset($ini["companies"]["page_title"])) {
            $warning = __("employers requesting approval", WPJB_DOMAIN);
            $ini["companies"]["menu_title"]  = $ini["companies"]["page_title"];
            $ini["companies"]["menu_title"] .= "<span class='update-plugins wpjb-bubble-companies count-$pending' title='$warning'><span class='update-count'>".$pending."</span></span>";
        }
        
        $query = new Daq_Db_Query();
        $query->select()->from("Wpjb_Model_Resume t")->join("t.users t2")->order("t.updated_at DESC");
        $query->select("COUNT(*) AS cnt")->limit(1);
        $pending = $query->where("t.is_approved=?", Wpjb_Model_Resume::RESUME_PENDING)->fetchColumn();
        if(isset($ini["resumes_manage"]["page_title"])) {
            $warning = __("resumes pending approval", WPJB_DOMAIN);
            $ini["resumes_manage"]["menu_title"]  = $ini["resumes_manage"]["page_title"];
            $ini["resumes_manage"]["menu_title"] .= "<span class='update-plugins wpjb-bubble-resumes count-$pending' title='$warning'><span class='update-count'>".$pending."</span></span>";
        }
        
        foreach($ini as $key => $conf) {
            
            
            
            if(isset($conf['parent'])) {
                
                if(isset($conf["menu_title"])) {
                    $menu_title = $conf["menu_title"];
                } else {
                    $menu_title = $conf["page_title"];
                }
                
                add_submenu_page(
                    "wpjb".$ini[$conf['parent']]['handle'],
                    $conf['page_title'],
                    $menu_title,
                    $conf['access'],
                    "wpjb".$conf['handle'],
                    array($this, "dispatch")
                );
            } else {
                add_menu_page(
                    $conf['page_title'],
                    $conf['page_title'],
                    $conf['access'],
                    "wpjb".$conf['handle'],
                    array($this, "dispatch"),
                    $logo
                );
            }
        }
    }

    public function addScripts()
    {
        echo '<link type="text/css" rel="stylesheet" href="'.site_url().'/wp-content/plugins/wpjobboard/application/views/admin.css" />' . "\n";
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('wpjobboard_admin', site_url().'/wp-content/plugins/wpjobboard/application/views/admin.js');
        wp_enqueue_script("wpjb-color-picker", null, null, null, true);
        wp_enqueue_script('wpjb-suggest', trim(site_url(), "/").'/wp-content/plugins/wpjobboard/templates/wpjb-suggest.js', array("jquery"));
         
        $l10n = array(
            "addField_empty" => __("You cannot add empty option.", WPJB_DOMAIN),
            "addField_120" => __("Option text length cannot be longer then 120 characters.", WPJB_DOMAIN),
            "addField_remove" => __("[remove]", WPJB_DOMAIN),
            "slug_save" => __("save", WPJB_DOMAIN),
            "slug_cancel" => __("cancel", WPJB_DOMAIN),
            "slug_change" => __("change", WPJB_DOMAIN),
            "remove" => __("Do you really want to delete", WPJB_DOMAIN),
            "selectAction" => __("Select action first", WPJB_DOMAIN),
            "addField_file" => __("File", WPJB_DOMAIN),
            "category_notEmpty" => __("Category still contains jobs. It cannot be deleted.", WPJB_DOMAIN),
            "jobtype_notEmpty" => __("Job Type still contains jobs. It cannot be deleted.", WPJB_DOMAIN),
            
        );
        
        wp_localize_script("wpjobboard_admin", "WpjbAdminLang", $l10n);
    }   
    
    public function enqueueScripts()
    {
        if(!is_wpjb() && !is_wpjr()) {
            return;
        }

        
 
    }
    
    public function addScriptsFront()
    {
        if(!is_wpjb() && !is_wpjr()) {
            return;
        }
        
        wp_enqueue_script('wpjb-js', trim(site_url(), "/").'/wp-content/plugins/wpjobboard/templates/js.js', array("jquery"));
         
        $listing = array();
        if(is_wpjb() && $this->router()->isRoutedTo("addJob.add")) {
            $query = new Daq_Db_Query();
            $result = $query->select("*")
                ->from("Wpjb_Model_Listing t")
                ->where("is_active = 1")
                ->execute();
            foreach($result as $l) {
                /* @var $l Wpjb_Model_Listing */
                $temp = $l->toArray();
                $temp['symbol'] = Wpjb_List_Currency::getCurrencySymbol($l->currency);
                $listing[] = $temp;
            }
            
            wp_enqueue_script("wpjb-suggest");
        }
        
        if(wpjb_is_routed_to(array("employer_new", "employer_edit"), "frontend")) {
			wp_enqueue_script("wpjb-suggest");
		}
        
        $object = array(
            "Listing" => $listing,
            "Lang" => json_encode(array(
                "Check" => __("check", WPJB_DOMAIN),
                "SelectListingType" => __("Select listing type", WPJB_DOMAIN),
                "ListingCost" => __("Listing cost", WPJB_DOMAIN),
                "Discount" => __("Discount", WPJB_DOMAIN),
                "Total" => __("Total", WPJB_DOMAIN),
                "Remove" => __("remove", WPJB_DOMAIN),
                "CurrencyMismatch" => __("Cannot use selected coupon with this listing. Currencies does not match.", WPJB_DOMAIN),
                "ResetForm" => __("Reset all form fields?", WPJB_DOMAIN)
            )),
            "Ajax" => admin_url("admin-ajax.php"),
            "AjaxRequest" => Wpjb_Project::getInstance()->getUrl()."/plain/discount",
            "Protection" => Wpjb_Project::getInstance()->conf("front_protection", "pr0t3ct1on"),
        );
        
        //wp_localize_script("wpjb-js", "Wpjb.Lang", $object);
    }

    public function addDashboardWidgets()
    {
        if(!current_user_can("edit_dashboard")) {
            return;
        }

        wp_add_dashboard_widget('wpjb_dashboard_stats', __("Job Board Stats", WPJB_DOMAIN), array("Wpjb_Dashboard_Stats", "render"));
    }

    public function install()
    {
        global $wpdb, $wp_rewrite;

        if(stripos(PHP_OS, "win")!==false || true) {
            $mods = explode(",", $wpdb->get_var("SELECT @@session.sql_mode"));
            $mods = array_map("trim", $mods);
            $invalid = array(
                "STRICT_TRANS_TABLES", "STRICT_ALL_TABLES", "TRADITIONAL"
            );
            foreach($invalid as $m) {
                if(in_array($m, $mods)) {
                    $wpdb->query("SET @@session.sql_mode='' ");
                    break;
                }
            }
        }
        
        $db = Daq_Db::getInstance();
        if($db->getDb() === null) {
            $db->setDb($wpdb);
        }

        wp_clear_scheduled_hook("wpjb_event_counter");
        wp_schedule_event(time(), "daily", "wpjb_event_counter");

        $instance = self::getInstance();
        $appj = $instance->getApplication("frontend");
        $appr = $instance->getApplication("resumes");

        $config = $instance;
        $wp_rewrite->flush_rules();
        
        if($appj->getPage() === null) {
            // link new page
            /* @var $appj Wpjb_Application_Frontend */
            $jId = wp_insert_post(array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_title' => 'Jobs',
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_content' => $appj->getOption("shortcode")
            ));
            $config->setConfigParam("link_jobs", $jId);
            $config->saveConfig();
        }
        if($appr->getPage() === null) {
            // link new page
            $rId = wp_insert_post(array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_title' => 'Resumes',
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_content' => $appr->getOption("shortcode")
            ));
            $config->setConfigParam("link_resumes", $rId);
            $config->saveConfig();
        }

        update_usermeta(wp_get_current_user()->ID, "is_employer", 1);

        if($this->conf("front_template")!==null) {
            return true;
        }

        $config->setConfigParam("front_show_related_jobs", 1);
        $config->setConfigParam("cv_enabled", 1);
        $config->saveConfig();

        $file = $this->path("install") . "/install.sql";
        $queries = explode("; --", file_get_contents($file));

        foreach($queries as $query) {
            $wpdb->query($query);
        }

        $email = get_option("admin_email");
        $query =  new Daq_Db_Query();
        $result = $query->select("*")->from("Wpjb_Model_Email t")->execute();
        foreach($result as $r) {
            if($r->mail_from == "") {
                $r->mail_from = $email;
                $r->save();
            }
        }

        $config = Wpjb_Project::getInstance();
        $config->setConfigParam("front_template", "twentyten");
        $config->saveConfig();

        Wpjb_Upgrade_Manager::upgrade();
        $wp_rewrite->flush_rules();

        return true;
    }

    public static function uninstall()
    {
        global $wpdb;

        if(self::VERSION == "#"."version"."#") {
            // don't do that on development server
            return;
        }

        $file = $this->path("install") . "/uninstall.sql";
        $queries = explode("; --", file_get_contents($file));

        foreach($queries as $query) {
            $wpdb->query($query);
        }

        return true;
    }

    public function deactivate()
    {
        wp_clear_scheduled_hook("wpjb_event_counter");
    }

    public static function editUserProfile($user)
    {
?>
<table class="form-table">
<tr>
	<th><label for="is_employer"><?php _e("Is Employer", WPJB_DOMAIN) ?></label></th>

	<td>
            <input type="checkbox" name="is_employer" id="is_employer" value="1" <?php if(get_the_author_meta("is_employer", $user->ID )): ?>checked="checked" <?php endif; ?> class="regular-text" /><br />
            <span class="description"><?php _e("Check if user can access employer panels.", WPJB_DOMAIN) ?></span>
	</td>
</tr>
</table>
<?php
    }

    public static function saveUserProfile($user_id)
    {
        if (!current_user_can('edit_user', $user_id ) ) {
            return false;
        }

        update_usermeta( $user_id, "is_employer", (int)$_POST['is_employer'] );
    }
    
    public function adminBarMenu()
    {
        global $wp_admin_bar;
        
        if (!is_super_admin() || !is_admin_bar_showing()) {
            return;
        }

        if(is_wpjb() || is_wpjr()) {
            $wp_admin_bar->remove_menu("edit");
            $wp_admin_bar->remove_menu("comments");
        }
        
        if(is_wpjb() && $this->router()->isRoutedTo("index.single")) {
            $object = $this->getApplication("frontend")->controller;
            if(is_object($object)) {
                $object = $object->getObject();
                $wp_admin_bar->add_menu(array(
                    'id' => 'edit-job',
                    'title' => __("Edit Job", WPJB_DOMAIN),
                    'href' => admin_url("admin.php?page=wpjb/job&action=edit/id/".$object->getId())
                ));
            }
        }
        
        if(is_wpjr() && $this->router("resumes")->isRoutedTo("index.view")) {
            $object = $this->getApplication("resumes")->controller;
            if(is_object($object)) {
                $object = $object->getObject();
                $wp_admin_bar->add_menu(array(
                    'id' => 'edit-resume',
                    'title' => __("Edit Resume", WPJB_DOMAIN),
                    'href' => admin_url("admin.php?page=wpjb/resumes&action=edit/id/".$object->getId())
                ));
            }
        }

    }

}





?>

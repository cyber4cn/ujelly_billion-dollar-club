<?php
/* 
 * General Template Functions
 */

function wpjb_conf($param, $default = null) {
    return Wpjb_Project::getInstance()->conf($param, $default);
}

function wpjb_find_jobs(array $options = null) {
    return Wpjb_Model_JobSearch::search($options);
}

function wpjb_search_form() {
	$view = Wpjb_Project::getInstance()->getApplication("frontend")->getView();
	$view->form = new Wpjb_Form_AdvancedSearch();
	$view->form->getElement("query")->setValue("");
	$view->shortcode = true;
    
    ob_start();
    $view->render("search.php");
    return ob_get_clean();
}

function wpjb_find_resumes(array $options = null) {
    
}

function wpjb_is_routed_to($path, $module = "frontend") {
	$i = Wpjb_Project::getInstance();
	$path = (array)$path;
	
	foreach($path as $p) {
		$router = false;
		if($module == "frontend" && is_wpjb()) {
			$router = $i->getApplication($module)->getRouter()->isRoutedTo($p);
		} elseif($module == "resumes" && is_wpjr()) {
			$router = $i->getApplication($module)->getRouter()->isRoutedTo($p);
		} 
		
		if($router) {
			return true;
		}
	}
	
	return false;
}

function wpjb_view($param, $default = null)
{
    $ph = Wpjb_Project::getInstance()->placeHolder;
    
    if($param == "job" && $ph->get("func_i", null) !== null) {
        $param = "func_job";
    }
    if($param == "resume" && $ph->get("func_ri", null) !== null) {
        $param = "func_resume";
    }
    if($param == "application" && $ph->get("func_ai", null) !== null) {
        $param = "func_application";
    }

    return $ph->get($param, $default);
}

function wpjb_link_to($key, $object = null, $param = array())
{
    $router = Wpjb_Project::getInstance()->router();
    $link = $router->linkTo($key, $object, $param);
    return Wpjb_Project::getInstance()->getUrl()."/".$link;
}

function wpjb_url()
{
    return Wpjb_Project::getInstance()->getUrl();
}

function wpjb_title()
{
    esc_html_e(Wpjb_Project::getInstance()->title);
}

function wpjb_description()
{
    if(strlen(wpjb_view("main_description"))>0) {
        $list = '<p><a><b><strong><em><i><ul><li><h3><h4><br>';
        return nl2br(strip_tags(wpjb_view("main_description"), $list));
    } else {
        return null;
    }
}

function wpjb_new_img($file = "new.png")
{
    echo wpjb_img($file);
}

function wpjb_img($file)
{
    return Wpjb_Project::getInstance()->media()."images/".$file;
}

function wpjb_view_set($param, $value)
{
    $ph = Wpjb_Project::$placeHolder;
    $ph->set($param, $value);
}

function wpjr_paginate_links()
{
    _wpjb_paginate_links("resumes");
}

function wpjb_paginate_links()
{
    _wpjb_paginate_links("frontend");
}

function _wpjb_paginate_links($app = "frontend")
{
    $pFormat = wpjb_view("cDir");
    if(!empty($pFormat)) {
        $pFormat = "/".rtrim($pFormat, "/");
    }

    $qString = "";
    $qs = trim(wpjb_view("qString"));
    if(!empty($qs)) {
        $qString = "?".$qs;
    }

    $baseUrl = wpjb_view("baseUrl");
    if(empty($baseUrl)) {
        $baseUrl = Wpjb_Project::getInstance()->getUrl($app);
    }

    echo paginate_links( array(
        'base' => $baseUrl.$pFormat."%_%".$qString,
        'format' => '/page/%#%',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => wpjb_view("jobCount"),
        'current' => wpjb_view("jobPage")
    ));
}

function wpjb_flash()
{
    $flash = Wpjb_Project::getInstance()->placeHolder->_flash;

    if(!is_object($flash)) {
        return;
    }

    foreach($flash->getInfo() as $info):
    ?>
    <div class="wpjb-flash-info">
        <span><?php echo $info; ?></span>
    </div>
    <?php
    endforeach;

    foreach($flash->getError() as $error):
    ?>
    <div class="wpjb-flash-error">
        <span><?php echo $error; ?></span>
    </div>
    <?php
    endforeach;

}

function wpjb_job_created_at($format, $job)
{
    $time = current_time("timestamp");
    $ytime = strtotime("yesterday", $time);
    $jtime = strtotime($job->job_created_at);
    if(date("Y-m-d", $time) == date("Y-m-d", $jtime)) {
        return __("Today", WPJB_DOMAIN);
    } elseif(date("Y-m-d", $time) == date("Y-m-d", $ytime)) {
        return __("Yesterday", WPJB_DOMAIN);
    } else {
        return date_i18n($format, $jtime);
    }
}

function wpjb_job_created_time_ago($format, $job = null)
{
    if(!$job) {
        $job = wpjb_view("job");
    }
    
    echo str_replace(
        array("{time_ago}", "{date}"),
        array(
            daq_time_ago_in_words(strtotime($job->job_created_at)),
            date("Y-m-d")),
        $format
    );
}

function wpjb_time_ago($date, $format = "{time_ago}")
{
    if(!is_numeric($date)) {
        $date = strtotime($date);
    }
    
    echo str_replace(
        array("{time_ago}", "{date}"),
        array(
            daq_time_ago_in_words($date),
            date("Y-m-d")),
        $format
    );
}

function wpjb_job_features(Wpjb_Model_Job $job = null)
{
    if(!$job) {
       $job = wpjb_view("job"); 
    }
    
    if($job->is_featured) {
        echo " wpjb-featured";
    }
    if($job->is_filled) {
        echo " wpjb-filled";
    }
    if($job->isNew()) {
        echo " wpjb-new";
    }
    if($job->isFree()) {
        echo " wpjb-free";
    }
    echo " wpjb-type-".$job->job_type;
    echo " wpjb-category-".$job->job_category;
}

function wpjb_panel_features(Wpjb_Model_Job $job) 
{
    if($job->expired()) {
        echo " wpjb-expired";
    } elseif(time()-strtotime($job->job_expires_at) > 24*3600*3) {
        echo " wpjb-expiring";
    }
}

function wpjb_job_company(Wpjb_Model_Job $job = null)
{
    $company = esc_html($job->company_name);
    if(strlen($job->company_website) > 0) {
        $url = esc_html($job->company_website);
        echo '<a href="'.$url.'" class="wpjb-job-company">'.$company.'</a>';
    } else {
        echo $company;
    }
}

function wpjb_job_company_profile($company, $text = null)
{
    /* @var $company Wpjb_Model_Employer */

    if(!$company instanceof Wpjb_Model_Employer) {
        return;
    }

    if(!$company->hasActiveProfile()) {
        return;
    }

    if(wpjb_view("company")) {
        $link = wpjb_link_to("company", $company);

        if($text === null) {
            $text = __("view profile", WPJB_DOMAIN);
        }

        echo " (<a href=\"".$link."\">".$text."</a>)";
    }
}


function wpjb_job_category()
{
    $category = wpjb_view("job")->getCategory();
    $title = esc_html($category->title);
    echo '<a href="'.wpjb_link_to("category", $category).'">'.$title.'</a>';
}

function wpjb_job_type()
{
    $type = wpjb_view("job")->getType();
    $title = esc_html($type->title);
    echo '<a href="'.wpjb_link_to("jobtype", $type).'">'.$title.'</a>';
}


function wpjb_job_description($job)
{
    $job = $job->job_description;
    $job = strip_tags($job, '<p><a><b><strong><em><i><ul><li><h3><h4><br>');
    $job = nl2br($job);
    $find = array("</ul><br />", "</li><br />", "</ol><br />");
    $repl = array("</ul>", "</li>", "</ol>");
    echo str_replace($find, $repl, $job);
}

/*
* Job additional fields
 */


function wpjb_field_value($field)
{
    if($field->getField()->type == 6) {
        $list = '<p><a><b><strong><em><i><ul><li><h3><h4><br>';
        echo nl2br(strip_tags($field->value, $list));
    } else {
        echo esc_html($field->value);
    }
}

function wpjb_job_tracker()
{
    $url = wpjb_link_to("tracker", null, array("id"=>wpjb_view("job")->id));
    echo "<script type=\"text/javascript\" src=\"".$url."\"></script>";

}

/**
 * Add Job Form
 */

function wpjb_add_job_steps()
{
    $view = Wpjb_Project::getInstance()->getApplication("frontend")->getView();
    $view->render("step.php");
}

function wpjb_user_can_post_job()
{
    return (bool)wpjb_view("canPost");
}

function wpjb_form_render_hidden($form)
{
    /* @var $form Daq_Form_Abstract */
    echo $form->renderHidden();
}

function wpjb_form_render_input(Daq_Form_Abstract $form, Daq_Form_Element $input)
{
    $tag = $form->getRenderer()->renderTag($input);
    
    if($input->hasRenderer()) {
        $callback = $input->getRenderer();
        call_user_func($callback, $input, array("tag"=>$tag));
    } else {
        echo $tag;
    }
}

function wpjb_form_input_features(Daq_Form_Element $e)
{
    $cl = array();
    if(count($e->getErrors())>0) {
        $cl[] = "wpjb-error";
    }
    
    $cl[] = "wpjb-element-".$e->getTypeTag();
    $cl[] = "wpjb-element-name-".$e->getName();
    
    echo join(" ", $cl);
}

function wpjb_form_input_hint(Daq_Form_Element $e, $tag = "small", $class = "wpjb-hint")
{
    $hint = $e->getHint();
    if(!empty($hint)) {
        $hint = esc_html($hint); 
        echo "<$tag class=\"$class\">$hint</$tag>";
    }
}

function wpjb_form_input_errors(Daq_Form_Element $e, $wrap1 = "ul", $wrap2 = "li")
{
    $err = $e->getErrors();

    if(count($err) == 0) {
        return null;
    }

    $html = "";
    if($wrap1) {
        $html .= "<".$wrap1." class=\"wpjb-errors\">";
    }
    foreach($err as $e) {
        if($wrap2) {
            $html .= "<$wrap2>".esc_html($e)."</$wrap2>";
        } else {
            $html .= esc_html($e);
        }
    }
    if($wrap1) {
        $html .= "</$wrap1>";
    }
    echo $html;
}

function wpjb_form_input_classes()
{
    $class = array();
    if(wpjb_form_input_errors()) {
        $class[] = "wpjb_error";
    }

    $input = wpjb_form_element();
    $class[] = "wpjb-".$input->getTypeTag();

    return join(" ", $class);
}

/**
 *
 * @return Wpjb_Model_Job
 */
function wpjb_job()
{
    return wpjb_view("job");
}

function wpjb_job_template()
{
    $view = Wpjb_Project::getInstance()->getApplication("frontend")->getView();
    $view->render("job.php");
}

// steps

function wpjb_render_step($num, $mark = "<strong>&raquo; {text}</strong>")
{
    $steps = array(
        array(esc_html(Wpjb_Project::getInstance()->conf("seo_step_1")), __("Create ad", WPJB_DOMAIN)),
        array(esc_html(Wpjb_Project::getInstance()->conf("seo_step_2")), __("Preview", WPJB_DOMAIN)),
        array(esc_html(Wpjb_Project::getInstance()->conf("seo_step_3")), __("Done!", WPJB_DOMAIN))
    );

    $current = $steps[($num-1)];
    if(strlen($current[0])==0) {
        $current = $current[1];
    } else {
        $current = $current[0];
    }

    $currentStep = wpjb_view("current_step");
    
    if($currentStep == $num) {
        $title = str_replace("{text}", $current, $mark);
        echo $title;
        Wpjb_Project::getInstance()->title = $current;
    } else {
        echo $current;
    }
}

/**
 * Company profile page
 */

function wpjb_company_website(Wpjb_Model_Employer $company, $default = "")
{
    $website = $company->company_website;
    if(empty($website)) {
        echo esc_html($default);
    } else {
        $website = esc_html($website);
        echo "<a href=\"{$website}\" class=\"wpjb-company-link\">{$website}</a>";
    }
}
function wpjb_company_info(Wpjb_Model_Employer $company)
{
    $list = '<p><a><b><strong><em><i><ul><li><h3><h4><br>';
    echo nl2br(strip_tags($company->company_info, $list));
}

// resumes functions

function wpjb_resume_last_update_at($format, $resume)
{
    $t = strtotime($resume->updated_at);
    if($t <= strtotime("1970-01-01 00:00:00")) {
        echo __("never", WPJB_DOMAIN);
    } else {
        echo date_i18n($format, $t);
    }
}

function wpjb_resume_mods()
{
    
}

function wpjb_resume_title()
{
    // @deprecated
    echo esc_html(wpjb_view("resume")->title);
}

function wpjb_resume_headline()
{
    // @deprecated
    echo esc_html(wpjb_view("resume")->headline);
}

function wpjb_resume_photo()
{
    $resume = wpjb_view("resume");
    /* @var $resume Wpjb_Model_Resume */

    $url = $resume->getImageUrl();
    if(is_null($url)) {
        $url = Wpjb_Project::getInstance()->media()."/user.png";
    }

    return $url;
}

function wpjr_link_to($key, $object = null, $param = array())
{
    $app = Wpjb_Project::getInstance()->getApplication("resumes");
    $router = $app->getRouter();
    $url = $app->getUrl();
    $link = $router->linkTo($key, $object, $param);
    return $url."/".$link;
}

function wpjb_block_resume_details()
{
    _e("<small><i>register to see</i></small>", WPJB_DOMAIN);
}

function wpjb_resume_degree($resume)
{
    $d = Wpjb_Form_Admin_Resume::getDegrees();
    echo $d[$resume->degree];
}

function wpjb_resume_experience($resume)
{
    $d = Wpjb_Form_Admin_Resume::getExperience();
    echo $d[$resume->years_experience];
}

function wpjr_url()
{
    return Wpjb_Project::getInstance()->getApplication("resumes")->getUrl();
}

function is_wpjb()
{
    return is_page(Wpjb_Project::getInstance()->conf("link_jobs"));
}

function is_wpjr()
{
    return is_page(Wpjb_Project::getInstance()->conf("link_resumes"));
}

function wpjb_current_category_link($default = null)
{
    if(!wpjb_view("current_category")) {
        $url = Wpjb_Project::getInstance()->getUrl();
        $title = __("All Categories", WPJB_DOMAIN);
    } else {
        $current_category = wpjb_view("current_category");
        $url = wpjb_link_to("category", $current_category);
        $title = esc_html($current_category->title);
    }

    echo "<a href=\"$url\" class=\"wpjb-current-category\">$title</a>";
}

function wpjb_current_type_link()
{
    $url = Wpjb_Project::getInstance()->getUrl();
    $title = __("All Jobs", WPJB_DOMAIN);

    if(wpjb_view("current_type")) {
        $current_type = wpjb_view("current_type");
        $url = wpjb_link_to("jobtype", $current_type);
        $title = esc_html($current_type->title);
    }

    echo "<a href=\"$url\" class=\"wpjb-current-jobtype\">$title</a>";
}

/**
 * Returns resume object
 *
 * @return Wpjb_Model_Resume
 */
function wpjb_resume()
{
    return wpjb_view("resume");
}

function wpjb_resume_status($resume)
{
    $object = $resume;

    if($object->is_approved < Wpjb_Model_Resume::RESUME_PENDING) {
        return __("None", WPJB_DOMAIN);
    } elseif($object->is_approved == Wpjb_Model_Resume::RESUME_PENDING) {
        return __("Pending approval", WPJB_DOMAIN);
    } elseif($object->is_approved == Wpjb_Model_Resume::RESUME_DECLINED) {
        return __("Declined (update your resume and submit it again)", WPJB_DOMAIN);
    } else {
        return __("Approved", WPJB_DOMAIN);
    }
}

function wpjb_resume_last_update($format, $object)
{
    if(strtotime($object->updated_at)) {
        $exchange = array(
            "{ago}" => daq_time_ago_in_words(strtotime($object->updated_at)),
            "{date}" => date("Y-m-d H:i:s", strtotime($object->updated_at))
        );
        return str_replace(array_keys($exchange), array_values($exchange), __("{ago} ago", WPJB_DOMAIN));
    } else {
        return __("Never", WPJB_DOMAIN);
    }
}

/**
 * Returns employer object
 *
 * @return Wpjb_Model_Employer
 */

function wpjb_date($format, $date)
{
    if(!is_numeric($date)) {
        $date = strtotime($date);
    }
    return date($format, $date);
}

function wpjb_rich_text($text)
{
    $find = array("</p><br/>", "</ul><br/>", "</li><br/>", "<ul><br/>");
    $repl = array("</p>", "</ul>", "</li>", "<ul>");
    
    $list = '<p><a><b><strong><em><i><ul><li><h3><h4><br>';
    $text = nl2br(strip_tags($text, $list));
    $text = str_replace($find, $repl, $text);
    echo $text;
}


function wpjb_format_bytes($size) {
    $units = array(' bytes', ' kB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) {
        $size /= 1024;
    }
    return round($size, 2).$units[$i];
}

function wpjb_get_categories($options = null) {
    
    return Wpjb_Utility_Registry::getCategories();
}

function wpjb_get_jobtypes($options = null) {
    
    return Wpjb_Utility_Registry::getJobTypes();
}

/**
 * FORM HELPERS
 */

function wpjb_form_helper_logo_upload(Daq_Form_Element $field, array $options = array())
{
    echo $options["tag"];
    
    $ext = Daq_Request::getInstance()->session("wpjb.job_logo_ext");
    if($ext) {
        /// some special treatment
        $path = get_bloginfo("url")."/wp-content/plugins/wpjobboard";
        $path.= Wpjb_List_Path::getRawPath("tmp_images")."/temp_".session_id().".".$ext;
        echo '<p class="wpjb-add-job-img"><img src="'.$path.'" alt="" /></p>';
    }
}

function wpjb_form_helper_listing(Daq_Form_Element $field, array $options = array())
{
    $listing = wpjb_view("listing");
    
    foreach($field->getOptions() as $option) {

        $id = $option["value"];
        $l = $listing[$id];
    ?>
        <label class="wpjb-listing-type-item" for="listing_<?php echo $id ?>">
            <input name="listing" id="listing_<?php echo $id ?>" type="radio" value="<?php echo $id ?>" <?php if($field->getValue()==$id): ?>checked="checked"<?php endif; ?> />
            <span class="wpjb-listing-type-item-s1"><?php esc_html_e($l->title) ?></span>
            <span class="wpjb-listing-type-item-s2"><?php echo $l->getTextPrice() ?></span>
            <span class="wpjb-listing-type-item-s3">
                <?php if(($l->description)): ?>
                <?php echo $l->description; ?>
                <?php else: ?>
                <?php _e("visible for {$l->visible} days", WPJB_DOMAIN) ?>
                <?php endif; ?>
            </span>
        </label>    
    <?php 
    
    }
}

function wpjb_locale() {

    list($lang, $cc) = explode("_", get_locale());
    $country = Wpjb_List_Country::getAll();
    if(isset($country[$cc])) {
        $r = $country[$cc]["code"];
    } else {
        $r = 840;
    }
    
    $r = apply_filters("wpjb_locale", $r);
    
    return $r;
}

function wpjb_recaptcha_form() {
    
    if(!function_exists("recaptcha_get_html")) {
        $rc = "/application/vendor/recaptcha/recaptchalib.php";
        $rc = Wpjb_Project::getInstance()->getBaseDir().$rc;
        require_once $rc;
    }
    $pubkey = Wpjb_Project::getInstance()->getConfig("front_recaptcha_public");
	
    if ($pubkey == null || $pubkey == '') {
		_e("reCAPTCHA public API key is missing.", WPJB_DOMAIN);
        return;
	}
    
    echo '<style type="text/css">#recaptcha_widget_div div { padding: 0px; margin: 0px }</style>';
    echo recaptcha_get_html($pubkey);
}

function wpjb_recaptcha_check() {
    if(!function_exists("recaptcha_get_html")) {
        $rc = "/application/vendor/recaptcha/recaptchalib.php";
        include_once Wpjb_Project::getInstance()->getBaseDir().$rc;
    }
    
    $privkey = Wpjb_Project::getInstance()->getConfig("front_recaptcha_private");
	if ($privkey == null || $privkey == '') {
		return true;
	}
    
    $resp = recaptcha_check_answer (
        $privkey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]
    );

    if (!$resp->is_valid) {
        return $resp->error;
    } else {
        return true;
    }

}

?>

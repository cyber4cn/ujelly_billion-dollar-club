<?php
/**
 * Description of Frontend
 *
 * @author greg
 * @package 
 */

class Wpjb_Controller_Frontend extends Daq_Controller_Abstract
{
    private $_object = null;

    public function __construct()
    {
        wp_enqueue_script("jquery");
        add_action('wp_head', array($this, "_injectMedia"));
        add_filter("wp_title", array($this, "_injectTitle"));
        parent::__construct();
    }

    public function _injectMedia()
    {
        $dir = Wpjb_Project::getInstance()->media();

        $include = array("css"=>true, "js"=>true);
        $include = apply_filters("wpjb_inject_media", $include);

        $css = trim($dir, "/") . "/style.css";
        if($include["css"]) {
            echo "\n".'<link rel="stylesheet" href="'.$css.'" type="text/css" media="screen" />'."\n";
        }
        
        echo '<script type="text/javascript">';
        $query = new Daq_Db_Query();
        $listing = array();
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

        echo 'Wpjb.Listing = '.json_encode($listing).';';
        $class = new stdClass;
        $class->Check = __("check", WPJB_DOMAIN);
        $class->SelectListingType = __("Select listing type", WPJB_DOMAIN);
        $class->ListingCost = __("Listing cost", WPJB_DOMAIN);
        $class->Discount = __("Discount", WPJB_DOMAIN);
        $class->Total = __("Total", WPJB_DOMAIN);
        $class->Remove = __("remove", WPJB_DOMAIN);
        $class->CurrencyMismatch = __("Cannot use selected coupon with this listing. Currencies does not match.", WPJB_DOMAIN);
        $class->ResetForm = __("Reset all form fields?", WPJB_DOMAIN);
        echo 'Wpjb.Lang = '.json_encode($class).';';
        echo 'Wpjb.Ajax = "'.admin_url("admin-ajax.php").'";';
        echo 'Wpjb.AjaxRequest = "'.esc_html(Wpjb_Project::getInstance()->getUrl()."/plain/discount").'";';
        echo 'Wpjb.Protection = "'.esc_html(Wpjb_Project::getInstance()->conf("front_protection", "pr0t3ct1on")).'";';
        echo 'Wpjb.PerPage = 20;';
        echo '</script>';
    }

    public function _injectTitle()
    {
        if(strlen(Wpjb_Project::getInstance()->title)>0) {
            return esc_html(Wpjb_Project::getInstance()->title)." \r\n";
        }
    }

    public function setCanonicalUrl($url)
    {
        Wpjb_Project::setEnv("canonical", $url);
    }

    public function setObject(Daq_Db_OrmAbstract $object)
    {
        $this->_object = $object;
    }

    /**
     * Returns object resolved during request dispatch
     *
     * @return Daq_Db_OrmAbstract
     * @throws Exception If trying to get object before it was set
     */
    public function getObject()
    {
        if(!$this->_object instanceof Daq_Db_OrmAbstract) {
            throw new Exception("Object is not instanceof Daq_Db_OrmAbstract");
        }
        return $this->_object;
    }

    /**
     *
     * @param <type> $module
     * @return Daq_Router
     */
    protected function _getRouter($module = "frontend")
    {
        return Wpjb_Project::getInstance()->getApplication($module)->getRouter();
    }

    /**
     * Returns Current Request Object
     * 
     * @return Daq_Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    public function isMember()
    {
        $info = wp_get_current_user();
        $isAdmin = true;
        if($info->ID > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function _isUserAdmin()
    {
        $info = wp_get_current_user();
        $isAdmin = true;
        if(!isset($info->wp_capabilities) || !$info->wp_capabilities['administrator']) {
            $isAdmin = false;
        }
        return $isAdmin;
    }
    
}

?>

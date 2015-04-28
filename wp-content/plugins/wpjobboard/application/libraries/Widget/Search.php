<?php
/**
 * Description of Recent Jobs
 *
 * @author greg
 * @package
 */

class Wpjb_Widget_Search extends Daq_Widget_Abstract
{
    public function __construct() 
    {
        $this->_context = Wpjb_Project::getInstance();
        $this->_viewAdmin = "search.php";
        $this->_viewFront = "search.php";
        
        parent::__construct(
            "wpjb-search", 
            __("Search Jobs", WPJB_DOMAIN),
            array("description"=>__("Search jobs widget.", WPJB_DOMAIN))
        );
    }
    
    public function update($new_instance, $old_instance) 
    {
	$instance = $old_instance;
	$instance['title'] = htmlspecialchars($new_instance['title']);
	$instance['hide'] = (int)($new_instance['hide']);
        return $instance;
    }
    
    protected function _filter()
    {
        global $wp_rewrite;
        $this->view->use_permalinks = $wp_rewrite->using_permalinks();
    }

}

?>
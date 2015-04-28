<?php
/**
 * Description of Categories
 *
 * @author greg
 * @package
 */

class Wpjb_Widget_Categories extends Daq_Widget_Abstract
{
    public function __construct() 
    {
        $this->_context = Wpjb_Project::getInstance();
        $this->_viewAdmin = "categories.php";
        $this->_viewFront = "categories.php";
        
        parent::__construct(
            "wpjb-job-categories", 
            __("Job Categories", WPJB_DOMAIN),
            array("description"=>__("Displays list of available job categories", WPJB_DOMAIN))
        );
    }
    
    public function update($new_instance, $old_instance) 
    {
	$instance = $old_instance;
	$instance['title'] = htmlspecialchars($new_instance['title']);
	$instance['hide'] = (int)($new_instance['hide']);
	$instance['count'] = (int)($new_instance['count']);
	$instance['hide_empty'] = (int)($new_instance['hide_empty']);
        return $instance;
    }

    public function _filter()
    {
        $query = new Daq_Db_Query();
        $this->view->categories = $query->select()
            ->order("title")
            ->from("Wpjb_Model_Category t")
            ->execute();
        
    }
}

?>
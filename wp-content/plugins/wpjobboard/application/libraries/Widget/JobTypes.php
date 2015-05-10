<?php
/**
 * Description of Categories
 *
 * @author greg
 * @package
 */

class Wpjb_Widget_JobTypes extends Daq_Widget_Abstract
{
    public function __construct() 
    {
        $this->_context = Wpjb_Project::getInstance();
        $this->_viewAdmin = "job-types.php";
        $this->_viewFront = "job-types.php";
        
        parent::__construct(
            "wpjb-job-types", 
            __("Job Types", WPJB_DOMAIN),
            array("description"=>__("Displays list of available job types", WPJB_DOMAIN))
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
        $this->view->job_types = $query->select()
            ->from("Wpjb_Model_JobType t")
            ->order("title")
            ->execute();
    }

}

?>
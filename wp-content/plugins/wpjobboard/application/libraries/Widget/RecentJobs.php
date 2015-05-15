<?php
/**
 * Description of Recent Jobs
 *
 * @author greg
 * @package
 */

class Wpjb_Widget_RecentJobs extends Daq_Widget_Abstract
{
    public function __construct() 
    {
        $this->_context = Wpjb_Project::getInstance();
        $this->_viewAdmin = "recent-jobs.php";
        $this->_viewFront = "recent-jobs.php";
        
        parent::__construct(
            "wpjb-recent-jobs", 
            __("Recent Jobs", WPJB_DOMAIN),
            array("description"=>__("Displays list of recently posted jobs", WPJB_DOMAIN))
        );
    }
    
    public function update($new_instance, $old_instance) 
    {
	$instance = $old_instance;
	$instance['title'] = htmlspecialchars($new_instance['title']);
	$instance['count'] = (int)($new_instance['count']);
	$instance['hide'] = (int)($new_instance['hide']);
        return $instance;
    }

    public function _filter()
    {
        $query = new Daq_Db_Query();
        $this->view->jobList = Wpjb_Model_Job::activeSelect()
            ->order("t1.job_created_at DESC")
            ->limit($this->_get("count", 5))
            ->execute();
    }

}

?>
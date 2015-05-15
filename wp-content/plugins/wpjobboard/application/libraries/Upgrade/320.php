<?php
/**
 * Description of 320
 *
 * @author greg
 * @package 
 */


class Wpjb_Upgrade_320 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.2.0";
    }

    public function execute()
    {
        $this->_sql($this->getVersion());

        set_time_limit(0);
        $query = new Daq_Db_Query();
        $query->select()->from("Wpjb_Model_Job t")
            ->joinLeft("t.search s")
            ->where("is_active = 1")
            ->where("s.job_id IS NULL");

        foreach($query->execute() as $job) {
            Wpjb_Model_JobSearch::createFrom($job);
        }

        $db = Daq_Db::getInstance();
        $wpdb = $db->getDb();

        $config = Wpjb_Project::getInstance();
        $config->setConfigParam("front_template", "twentyten");
        $config->saveConfig();

        if(!Wpjb_Project::getInstance()->conf("link_jobs")) {

            $jId = wp_insert_post(array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_title' => 'Jobs',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ));
            $config->setConfigParam("link_jobs", $jId);
            $config->saveConfig();
        }

        if(!Wpjb_Project::getInstance()->conf("link_resumes")) {

            $rId = wp_insert_post(array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_title' => 'Resumes',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ));
            $config->setConfigParam("link_resumes", $rId);
            $config->saveConfig();
        }

        return;
    }
}

?>
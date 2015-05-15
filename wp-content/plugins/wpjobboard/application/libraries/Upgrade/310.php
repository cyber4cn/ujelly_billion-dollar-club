<?php
/**
 * Description of 310
 *
 * @author greg
 * @package 
 */


class Wpjb_Upgrade_310 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.1.0";
    }

    public function execute()
    {
        $config = Wpjb_Project::getInstance();
        $config->setConfigParam("api_twitter_username", "");
        $config->setConfigParam("api_twitter_password", "");
        $config->saveConfig();

        $db = Daq_Db::getInstance()->getDb();
        $db->query("DELETE FROM `wpjb_field_value` WHERE (SELECT `wpjb_job`.`id` FROM `wpjb_job` WHERE `wpjb_job`.`id`=`job_id` LIMIT 1) IS NULL");
        $db->query("ALTER TABLE `wpjb_field_value` ADD FOREIGN KEY ( `job_id` ) REFERENCES `wpjb_job` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");

        // SELECT wpjb_field_value.id, wpjb_job.id FROM `wpjb_field_value` LEFT JOIN `wpjb_job` ON `wpjb_job`.`id`=`job_id`

        return;
    }
}

?>
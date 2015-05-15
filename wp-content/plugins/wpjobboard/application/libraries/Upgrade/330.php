<?php
/**
 * Description of 320
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_330 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.3.0";
    }

    public function execute()
    {
        $db = Daq_Db::getInstance()->getDb();
        $db->query("ALTER TABLE `wpjb_job` ADD `job_expires_at` DATETIME NOT NULL AFTER `job_created_at`");
        $db->query("UPDATE `wpjb_job` SET `job_expires_at` = DATE_ADD(`job_created_at`, INTERVAL `job_visible` DAY)");
        $db->query("ALTER TABLE `wpjb_additional_field` ADD `field_for` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1:job; 2:job apply, 3:resume'");
        $db->query("UPDATE `wpjb_additional_field` SET field_for = 1");

        wp_schedule_event(time(), "daily", "wpjb_event_counter");

    }
}

?>
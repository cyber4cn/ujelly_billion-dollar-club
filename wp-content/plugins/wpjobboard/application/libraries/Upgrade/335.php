<?php
/**
 * Description of 335
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_335 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.3.5";
    }

    public function execute()
    {
        $db = Daq_Db::getInstance()->getDb();
        $db->query("ALTER TABLE `wpjb_field_value` DROP FOREIGN KEY `wpjb_field_value_ibfk_2`");
        $db->query("ALTER TABLE `wpjb_discount` ADD `used` INT( 11 ) NOT NULL ,ADD `max_uses` INT( 11 ) NOT NULL ");
        $db->query("ALTER TABLE `wpjb_job` ADD `discount_id` INT( 11 ) NOT NULL DEFAULT 0");
    }
}

?>
<?php
/**
 * Description of 310
 *
 * @author greg
 * @package 
 */

class Wpjb_Upgrade_304 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.0.4";
    }

    public function execute()
    {
        $db = Daq_Db::getInstance()->getDb();
        $db->query("ALTER TABLE `wpjb_field_value` CHANGE `value` `value` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

        return;
    }
}
?>
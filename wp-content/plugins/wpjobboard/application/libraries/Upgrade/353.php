<?php
/**
 * Description of 351
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_353 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.5.3";
    }

    public function execute()
    {
        $db = Daq_Db::getInstance()->getDb();
        $db->query("UPDATE wpjb_job SET stat_apply=0");
        $db->query("UPDATE wpjb_job SET stat_apply=(SELECT COUNT(*) FROM wpjb_application WHERE wpjb_job.id=wpjb_application.job_id)");
        
    }
}

?>

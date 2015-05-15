<?php
/**
 * Description of 351
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_351 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.5.1";
    }

    public function execute()
    {
        $db = Daq_Db::getInstance()->getDb();
        $db->query("UPDATE wpjb_employer SET jobs_posted=0");
        $db->query("UPDATE wpjb_employer SET jobs_posted=(SELECT COUNT(*) FROM wpjb_job WHERE wpjb_job.employer_id=wpjb_employer.id)");
        
    }
}

?>

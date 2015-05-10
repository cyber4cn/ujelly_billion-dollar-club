<?php
/**
 * Description of 320
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_326 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.2.6";
    }

    public function execute()
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")->from("Wpjb_Model_Job t")->execute();

        foreach($result as $job) {
            Wpjb_Model_JobSearch::createFrom($job);
        }

    }
}

?>
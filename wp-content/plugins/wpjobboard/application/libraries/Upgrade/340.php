<?php
/**
 * Description of 340
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_340 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.4.0";
    }

    public function execute()
    {
        $this->_sql($this->getVersion());
        
        $query = new Daq_Db_Query;
        $query->select("*");
        $query->from("Wpjb_Model_Employer t1");
        $query->where("jobs_posted > 0");
        $list = $query->execute();
        
        foreach($list as $emp) {
            update_usermeta($emp->user_id, "is_employer", 1);
        }
        
        return;
    }
}

?>
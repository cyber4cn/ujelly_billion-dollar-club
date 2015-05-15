<?php
/**
 * Description of Category
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_Category extends Daq_Db_OrmAbstract
{
    protected $_name = "wpjb_category";

    protected function _init()
    {
        $this->_reference["jobs"] = array(
            "localId" => "id",
            "foreign" => "Wpjb_Model_Job",
            "foreignId" => "job_category",
            "type" => "ONE_TO_ONE"
        );
    }

    public function getCount()
    {
        $count = Wpjb_Project::getInstance()->conf("count", array("category"=>array()));
        $count = $count["category"];

        if(!array_key_exists($this->getId(), $count)) {
            return null;
        }

        return $count[$this->getId()];
    }
}

?>
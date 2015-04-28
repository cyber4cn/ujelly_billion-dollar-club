<?php
/**
 * Description of JobType
 *
 * @author greg
 * @package
 */

class Wpjb_Model_JobType extends Daq_Db_OrmAbstract
{
    protected $_name = "wpjb_type";

    protected function _init()
    {
        $this->_reference["jobs"] = array(
            "localId" => "id",
            "foreign" => "Wpjb_Model_Job",
            "foreignId" => "job_type",
            "type" => "ONE_TO_ONE"
        );
    }

    public function getCount()
    {
        $count = Wpjb_Project::getInstance()->conf("count", array("type"=>array()));
        $count = $count["type"];

        if(!array_key_exists($this->getId(), $count)) {
            return null;
        }

        return $count[$this->getId()];
    }
    
    public function getHexColor()
    {
        $hex = $this->color;
        if(strlen($hex)<6) {
            return "inherit";
        } else {
            return "#".$hex;
        }
    }
}

?>
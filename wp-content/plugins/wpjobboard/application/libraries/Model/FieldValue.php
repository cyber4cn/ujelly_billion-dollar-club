<?php
/**
 * Description of FieldValue
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_FieldValue extends Daq_Db_OrmAbstract
{
    protected $_name = "wpjb_field_value";

    public function _init()
    {
        $this->_reference["field"] = array(
            "localId" => "field_id",
            "foreign" => "Wpjb_Model_AdditionalField",
            "foreignId" => "id",
            "type" => "ONE_TO_ONE"
        );
    }

    public function getTextValue()
    {
        $value = $this->value;
        return $value;
    }
    
    public function getLabel()
    {
        return $this->getField()->label;
    }
}

?>
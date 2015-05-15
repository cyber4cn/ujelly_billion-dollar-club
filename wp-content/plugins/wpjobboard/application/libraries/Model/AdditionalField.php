<?php
/**
 * Description of AdditionalField
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_AdditionalField extends Daq_Db_OrmAbstract
{
    protected $_name = "wpjb_additional_field";

    protected $_option = null;

    public function _init()
    {
        $this->_reference["options"] = array(
            "localId" => "id",
            "foreign" => "Wpjb_Model_FieldOption",
            "foreignId" => "field_id",
            "type" => "ONE_TO_MANY"
        );
        $this->_reference["value"] = array(
            "localId" => "id",
            "foreign" => "Wpjb_Model_FieldValue",
            "foreignId" => "field_id",
            "type" => "ONE_TO_ONE"
        );
    }

    public function getFieldType()
    {
        $arr =  array(
            1 => 'Short Text',
            3 => 'Checkbox',
            4 => 'Dropdown',
            5 => 'File',
            6 => 'TextArea',
        );
        return $arr[$this->type];
    }

    public function getOptionList()
    {
        if(!is_null($this->_option)) {
            return $this->_option;
        }

        if($this->getId() < 1) {
            throw new Exception("Cannot get list for unsaved additional field");
        }

        if($this->type != Daq_Form_Element::TYPE_SELECT) {
            return array();
        }

        $query = new Daq_Db_Query();
        $result = $query->select("*")
            ->from("Wpjb_Model_FieldOption t")
            ->where("field_id = ?", (int)$this->getId())
            ->execute();

        $this->_option = $result;

        return $result;
    }
}

?>
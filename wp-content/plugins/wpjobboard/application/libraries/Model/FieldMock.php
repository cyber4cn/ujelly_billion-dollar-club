<?php
/**
 * Description of FieldMock
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_FieldMock
{
    protected $_field = array();

    public function getField()
    {
        return $this;
    }

    public function __set($key, $value)
    {
        $this->_field[$key] = $value;
    }

    public function __get($key)
    {
        return $this->_field[$key];
    }

    public function getTextValue()
    {
        return $this->value;
    }
    
    public function getLabel()
    {
        return $this->getField()->label;
    }
}

?>
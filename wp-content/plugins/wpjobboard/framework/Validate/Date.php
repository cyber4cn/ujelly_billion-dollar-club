<?php
/**
 * Description of Date
 *
 * @author greg
 * @package 
 */

class Daq_Validate_Date
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{
    protected $_format = null;

    public function __construct($format = "Y-m-d")
    {
        $this->_format = $format;
    }

    public function isValid($value)
    {
        $time = strtotime($value);
        if ($time === false || $value != date($this->_format, $time)) {
            $this->setError(__("Invalid date format", DAQ_DOMAIN));
            return false;
        }
        return true;
    }
}
?>
<?php
/**
 * Description of StringLength
 *
 * @author greg
 * @package 
 */

class Daq_Validate_StringLength
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{
    protected $_min = null;

    protected $_max = null;

    public function __construct($min = null, $max = null)
    {
        $this->_min = $min;
        $this->_max = $max;
    }

    public function isValid($value)
    {
        $result = true;
        if(!is_null($this->_min) && strlen($value)<$this->_min) {
            $this->setError(__("String is to short", DAQ_DOMAIN));
            $result = false;
        }

        if(!is_null($this->_max) && strlen($value)>$this->_max) {
            $this->setError(__("String is to long", DAQ_DOMAIN));
            $result = false;
        }

        return $result;
    }
}

?>
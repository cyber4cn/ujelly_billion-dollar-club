<?php
/**
 * Description of InArray
 *
 * @author greg
 * @package 
 */

class Daq_Validate_InArray
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{
    protected $_allowed = array();

    public function __construct(array $allowed)
    {
        $this->_allowed = $allowed;
    }

    public function isValid($value)
    {
        if(!in_array($value, $this->_allowed)) {
            $this->setError(__("Unrecognized value", DAQ_DOMAIN));
            return false;
        }

        return true;
    }
}

?>
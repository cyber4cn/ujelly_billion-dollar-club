<?php
/**
 * Description of Required
 *
 * @author greg
 * @package 
 */

class Daq_Validate_Required
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{
    public function isValid($value)
    {
        if(is_array($value) && $value["size"]==0) {
            $this->setError(__("Field cannot be empty", DAQ_DOMAIN));
            return false;
        } elseif(strlen($value)==0) {
            $this->setError(__("Field cannot be empty", DAQ_DOMAIN));
            return false;
        }

        return true;
    }
}

?>
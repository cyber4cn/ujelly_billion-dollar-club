<?php
/**
 * Description of Slug
 *
 * @author greg
 * @package 
 */

class Daq_Validate_Slug
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{
    public function isValid($value)
    {

        // [ADMIN]
        $err = __('Slug cannot be empty', DAQ_DOMAIN);
        if(strlen($value)<1) {
            $this->setError($err);
            return false;
        }

        // [ADMIN]
        $err = __("Slug can contain only letters, numbers, and hyphens and underscores", DAQ_DOMAIN);
        if(!eregi("^([A-z0-9_-]+)$", $value)) {
            $this->setError($err);
            return false;
        }


        return true;
    }
}

?>
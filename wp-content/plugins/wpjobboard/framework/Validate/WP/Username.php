<?php
/**
 * Description of Date
 *
 * @author greg
 * @package
 */

class Daq_Validate_WP_Username
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{

    public function isValid($value)
    {
        
        if ($value == '') {
            $this->setError(__('Please enter a username.', WPJB_DOMAIN));
            return false;
        } elseif ( ! validate_username( $value ) ) {
            $this->setError(__('This username is invalid because it uses illegal characters. Please enter a valid username.', WPJB_DOMAIN) );
            $value = '';
            return false;
        } elseif ( username_exists( $value ) ) {
            $this->setError(__('This username is already registered, please choose another one.', WPJB_DOMAIN));
            return false;
	}

        return true;
    }
}
?>
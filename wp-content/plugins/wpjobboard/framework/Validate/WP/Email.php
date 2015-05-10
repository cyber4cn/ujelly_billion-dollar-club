<?php
/**
 * Description of Date
 *
 * @author greg
 * @package
 */

class Daq_Validate_WP_Email
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{

    public function isValid($value)
    {
        require_once( ABSPATH . WPINC . '/registration.php');
        $user_email = $value;
        
        if ( $user_email == '' ) {
            $this->setError(__('Please type your e-mail address.', WPJB_DOMAIN) );
            return false;
        } elseif ( ! is_email( $user_email ) ) {
            $this->setError(__('The email address isn&#8217;t correct.', WPJB_DOMAIN) );
            $user_email = '';
            return false;
        } elseif ( email_exists( $user_email ) ) {
            $this->setError(__('This email is already registered, please choose another one.', WPJB_DOMAIN) );
            return false;
        }

        return true;
    }
}
?>
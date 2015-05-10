<?php

/**
 * Description of Login
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Login extends Daq_Form_Abstract
{
    public function init()
    {
        $e = new Daq_Form_Element("user_login", Daq_Form_Element::TYPE_TEXT);
        $e->setLabel(__("Username", WPJB_DOMAIN));
        $e->setRequired(true);
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("user_password", Daq_Form_Element::TYPE_PASSWORD);
        $e->setLabel(__("Password", WPJB_DOMAIN));
        $e->setRequired(true);
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("remember", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setLabel(__("Remember me", WPJB_DOMAIN));
        $e->addOption(1, 1, "");
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("redirect_to", Daq_Form_Element::TYPE_HIDDEN);
        $e->setValue(wpjb_url());
        $this->addElement($e, "hidden");

        apply_filters("wpjb_form_init_login", $this);
    }

    public function isValid(array $values)
    {
        $valid = parent::isValid($values);
        if(!$valid) {
            return false;
        }

        $credentials = $values;
	$user = wp_authenticate($credentials['user_login'], $credentials['user_password']);

        if ( is_wp_error($user) ) {
            if ( $user->get_error_codes() == array('empty_username', 'empty_password') ) {
                $user = new WP_Error('', '');
            }

            return $user;
	}

	wp_set_auth_cookie($user->ID, $credentials['remember'], $secure_cookie);
	do_action('wp_login', $credentials['user_login']);

        return $user;
    }

}

?>
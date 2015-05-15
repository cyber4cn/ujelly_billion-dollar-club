<?php

/**
 * Description of Login
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Resumes_Register extends Daq_Form_Abstract
{
    public function init()
    {
        $this->addGroup("default", __("Register", WPJB_DOMAIN));

        $e = new Daq_Form_Element("user_login", Daq_Form_Element::TYPE_TEXT);
        $e->setLabel(__("Username", WPJB_DOMAIN));
        $e->setRequired(true);
        $e->addFilter(new Daq_Filter_Trim());
        $e->addValidator(new Daq_Validate_WP_Username());
        $this->addElement($e, "default");
        
        $e = new Daq_Form_Element("user_password", Daq_Form_Element::TYPE_PASSWORD);
        $e->setLabel(__("Password", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Trim());
        $e->addValidator(new Daq_Validate_StringLength(4, 32));
        $e->addValidator(new Daq_Validate_PasswordEqual("user_password2"));
        $e->setRequired(true);
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("user_password2", Daq_Form_Element::TYPE_PASSWORD);
        $e->setLabel(__("Password (repeat)", WPJB_DOMAIN));
        $e->setRequired(true);
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("user_email", Daq_Form_Element::TYPE_TEXT);
        $e->setLabel(__("E-mail", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Trim());
        $e->addValidator(new Daq_Validate_WP_Email());
        $e->setRequired(true);
        $this->addElement($e, "default");

        apply_filters("wpjr_form_init_register", $this);
    }


}

?>
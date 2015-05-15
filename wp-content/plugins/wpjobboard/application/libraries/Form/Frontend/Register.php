<?php

/**
 * Description of Login
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Frontend_Register extends Daq_Form_Abstract
{
    public function init()
    {
        $this->addGroup("auth", __("User Account", WPJB_DOMAIN));
        $this->addGroup("default", __("Company", WPJB_DOMAIN));
        $this->addGroup("location", __("Location", WPJB_DOMAIN));

        $e = new Daq_Form_Element("user_login", Daq_Form_Element::TYPE_TEXT);
        $e->setLabel(__("Username", WPJB_DOMAIN));
        $e->setRequired(true);
        $e->addFilter(new Daq_Filter_Trim());
        $e->addFilter(new Daq_Filter_WP_SanitizeUser());
        $e->addValidator(new Daq_Validate_WP_Username());
        $this->addElement($e, "auth");

        $e = new Daq_Form_Element("user_password", Daq_Form_Element::TYPE_PASSWORD);
        $e->setLabel(__("Password", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Trim());
        $e->addValidator(new Daq_Validate_StringLength(4, 32));
        $e->addValidator(new Daq_Validate_PasswordEqual("user_password2"));
        $e->setRequired(true);
        $this->addElement($e, "auth");

        $e = new Daq_Form_Element("user_password2", Daq_Form_Element::TYPE_PASSWORD);
        $e->setLabel(__("Password (repeat)", WPJB_DOMAIN));
        $e->setRequired(true);
        $this->addElement($e, "auth");

        $e = new Daq_Form_Element("user_email", Daq_Form_Element::TYPE_TEXT);
        $e->setLabel(__("E-mail", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Trim());
        $e->addValidator(new Daq_Validate_WP_Email());
        $e->setRequired(true);
        $this->addElement($e, "auth");

        $e = new Daq_Form_Element("company_name");
        $e->setLabel(__("Company name", WPJB_DOMAIN));
        $e->setRequired(true);
        $e->addFilter(new Daq_Filter_Trim());
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("company_website");
        $e->setLabel(__("Company website", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Url());
        $e->addFilter(new Daq_Filter_WP_Url);
        $e->addFilter(new Daq_Filter_Trim());
        $this->addElement($e, "default");

        $e = new Daq_Form_Element_File("company_logo", Daq_Form_Element::TYPE_FILE);
        $e->setLabel(__("Company Logo", WPJB_DOMAIN));
        $e->setHint(__("Max. file size 30 kB. Image size 300x100 px. File formats *.jpg; *.gif; *.png .", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_File_Default());
        $e->addValidator(new Daq_Validate_File_Ext("jpg,jpeg,gif,png"));
        $e->addValidator(new Daq_Validate_File_Size(30000));
        $e->addValidator(new Daq_Validate_File_ImageSize(300, 100));
        //$this->addElement($e, "default");

        $e = new Daq_Form_Element("company_info", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setLabel(__("Company info", WPJB_DOMAIN));
        $e->setRequired(true);
        $e->addFilter(new Daq_Filter_Trim());
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("is_public", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setLabel(__("Publish Profile", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Allow job seekers to view company profile", WPJB_DOMAIN));
        $e->setValue($this->_object->is_public);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e, "default");
        
        $def = wpjb_locale();
        $e = new Daq_Form_Element("company_country", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Company Country", WPJB_DOMAIN));
        $e->setValue(($this->_object->company_country) ? $this->_object->company_country : $def);
        foreach(Wpjb_List_Country::getAll() as $listing) {
            $e->addOption($listing['code'], $listing['code'], $listing['name']);
        }
        $e->addClass("wpjb-location-country");
        $this->addElement($e, "location");

        $e = new Daq_Form_Element("company_state");
        $e->setLabel(__("Company State", WPJB_DOMAIN));
        $e->setValue($this->_object->company_state);
        $e->addClass("wpjb-location-state");
        $this->addElement($e, "location");

        $e = new Daq_Form_Element("company_zip_code");
        $e->setLabel(__("Company Zip-Code", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(null, 20));
        $e->setValue($this->_object->company_zip_code);
        $this->addElement($e, "location");
        
        $e = new Daq_Form_Element("company_location");
        $e->setLabel(__("Company Location", WPJB_DOMAIN));
        $e->setValue($this->_object->company_location);
        $e->addClass("wpjb-location-city");
        $this->addElement($e, "location");

        apply_filters("wpjb_form_init_register", $this);
    }


}

?>
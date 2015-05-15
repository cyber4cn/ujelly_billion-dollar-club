<?php
/**
 * Description of Frontend
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Admin_Config_Frontend extends Daq_Form_Abstract
{
    public $name = null;

    public function init()
    {
        $this->name = __("Job Board Frontend Configuration", WPJB_DOMAIN);
        
        $instance = Wpjb_Project::getInstance();

        $e = new Daq_Form_Element("front_jobs_per_page");
        $e->setRequired(true);
        $e->setValue($instance->getConfig("front_jobs_per_page", 20));
        $e->setLabel(__("Job offers per page", WPJB_DOMAIN));
        $e->setHint(__("Number of listings per page.", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Int(1));
        $this->addElement($e);

        $e = new Daq_Form_Element("front_marked_as_new");
        $e->setRequired(true);
        $e->setValue($instance->getConfig("front_marked_as_new", 7));
        $e->setLabel(__("Days marked as new", WPJB_DOMAIN));
        $e->setHint(__("Number of days since posting job will be displayed as new.", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Int(1));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("front_mark_as_old");
        $e->setRequired(true);
        $e->setValue($instance->getConfig("front_mark_as_old", 7));
        $e->setLabel(__("Mark as old after", WPJB_DOMAIN));
        $e->setHint(__("Number of days after which job posting will be marked as old", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Int(1));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("front_job_board_url");
        $e->setValue($instance->getConfig("front_job_board_url"));
        $e->setLabel(__("Job Board URL", WPJB_DOMAIN));
        $e->setHint(__("Do NOT modify this setting, unless you read intruction and you know what you are doing!", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Url());
        //$this->addElement($e);

        $e = new Daq_Form_Element("front_full_rewrite", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("front_full_rewrite"));
        $e->setLabel(__("Full URL Rewrite", WPJB_DOMAIN));
        $e->setHint(__("Checking this option will hide index.php in the URL", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        //$this->addElement($e);
        
        $e = new Daq_Form_Element("front_hide_filled", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("front_hide_filled"));
        $e->setLabel(__("Hide Filled Jobs", WPJB_DOMAIN));
        $e->setHint(__("When job is marked as filled it will not be visible to job seekers", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("front_allow_edition", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("front_allow_edition"));
        $e->setLabel(__("Allow Job Edition", WPJB_DOMAIN));
        $e->setHint(__("If checked allows employers to edit their job listings.", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("front_apply_members_only", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("front_apply_members_only"));
        $e->setLabel(__("Only members can apply", WPJB_DOMAIN));
        $e->setHint(__("Allow only registered members to apply for jobs.", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("front_show_related_jobs", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("front_show_related_jobs"));
        $e->setLabel(__("Show Related Jobs", WPJB_DOMAIN));
        $e->setHint(__("If checked related jobs will be listed in job details page.", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("front_listing_tpl");
        $e->setValue($instance->getConfig("front_listing_tpl"));
        $e->setLabel(__("Listing Template", WPJB_DOMAIN));
        $e->setHint(__("You can use variables: {price}, {title}, {visible}", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("front_enable_protection", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($instance->getConfig("front_enable_protection"));
        $e->setLabel(__("Anti SPAM protection", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Simple Anti-SPAM protection", WPJB_DOMAIN));
        $e->addOption(2, 2, __("reCAPTCHA", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("front_protection");
        $e->setValue($instance->getConfig("front_protection"));
        $e->setLabel(__("Anti SPAM key", WPJB_DOMAIN));
        $e->setHint(__("Enter between 6 and 32 random alphanumeric characters here.", WPJB_DOMAIN));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("front_recaptcha_public");
        $e->setValue($instance->getConfig("front_recaptcha_public"));
        $e->setLabel(__("reCAPTCHA Public Key", WPJB_DOMAIN));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("front_recaptcha_private");
        $e->setValue($instance->getConfig("front_recaptcha_private"));
        $e->setLabel(__("reCAPTCHA Private Key", WPJB_DOMAIN));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("show_maps", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("show_maps"));
        $e->setLabel(__("Show Google Maps", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e);

        apply_filters("wpja_form_init_config_frontend", $this);

    }
}

?>
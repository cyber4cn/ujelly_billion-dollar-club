<?php
/**
 * Description of Posting
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Admin_Config_Posting extends Daq_Form_Abstract
{
    public $name = null;

    public function init()
    {
        $this->name = __("Job Posting", WPJB_DOMAIN);
        $instance = Wpjb_Project::getInstance();

        $e = new Daq_Form_Element("posting_allow", Daq_Form_Element::TYPE_SELECT);
        $e->setValue(Wpjb_Project::getInstance()->conf("posting_allow"));
        $e->addOption(1, 1, __("Anyone", WPJB_DOMAIN));
        $e->addOption(2, 2, __("Registered Users", WPJB_DOMAIN));
        $e->addOption(3, 3, __("Admin", WPJB_DOMAIN));
        $e->setLabel(__("Who Can Post Jobs", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("posting_moderation", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("posting_moderation"));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $e->setLabel(__("Moderate Jobs", WPJB_DOMAIN));
        $e->setHint(__("Held jobs for moderation until Admin will approve them.", WPJB_DOMAIN));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("posting_encourage_reg", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("posting_encourage_reg"));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $e->setLabel(__("Encourage Registration", WPJB_DOMAIN));
        $e->setHint(__("On job posting page displays a message encouraging registration.", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("posting_tweet", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("posting_tweet"));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $e->setLabel(__("Tweet Jobs", WPJB_DOMAIN));
        $e->setHint(__("Post jobs to Twitter. (Requires that you configure Twitter username and password.)", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("posting_tweet_template");
        $e->setValue($instance->getConfig("posting_tweet_template"));
        $e->setLabel(__("Tweet Template", WPJB_DOMAIN));
        $e->setHint(__('Allowed variables: {title}, {url}, {category}, {type}', WPJB_DOMAIN));
        $this->addElement($e);

        apply_filters("wpja_form_init_config_posting", $this);
    }
}

?>
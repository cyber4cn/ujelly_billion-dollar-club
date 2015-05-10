<?php
/**
 * Description of Frontend
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Admin_Config_Integration extends Daq_Form_Abstract
{
    public $name = null;

    public function init()
    {
        $this->name = __("Integrations", WPJB_DOMAIN);
        $instance = Wpjb_Project::getInstance();

        $e = new Daq_Form_Element("api_cb_key");
        $e->setValue($instance->getConfig("api_cb_key"));
        $e->setLabel(__("Career Builder API Key", WPJB_DOMAIN));
        $e->setHint(__("Claim your key at http://api.careerbuilder.com/RequestDevKey.aspx, It's required to use Import feature", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("indeed_publisher");
        $e->setValue($instance->getConfig("indeed_publisher"));
        $e->setLabel(__("Indeed Publisher API Key", WPJB_DOMAIN));
        $e->setHint(__("Claim your key at https://ads.indeed.com/jobroll/, It's required to use Indeed Import", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("api_twitter_consumer_key");
        $e->setValue($instance->getConfig("api_twitter_consumer_key"));
        $e->setLabel(__("Twitter Consumer Key", WPJB_DOMAIN));
        $e->setHint(__("You must configure both Twitter and Bit.ly in order to automatically post jobs to Twitter", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("api_twitter_consumer_secret");
        $e->setValue($instance->getConfig("api_twitter_consumer_secret"));
        $e->setLabel(__("Twitter Consumer Secret", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("api_twitter_oauth_token");
        $e->setValue($instance->getConfig("api_twitter_oauth_token"));
        $e->setLabel(__("Twitter OAuth Token", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("api_twitter_oauth_secret");
        $e->setValue($instance->getConfig("api_twitter_oauth_secret"));
        $e->setLabel(__("Twitter OAuth Secret", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("api_bitly_login");
        $e->setValue($instance->getConfig("api_bitly_login"));
        $e->setLabel(__("Bit.ly Login", WPJB_DOMAIN));
        $e->setHint(__("Bit.ly is an URL shortening service", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("api_bitly_key");
        $e->setValue($instance->getConfig("api_bitly_key"));
        $e->setLabel(__("Bit.ly API Key", WPJB_DOMAIN));
        $this->addElement($e);

        apply_filters("wpja_form_init_config_integration", $this);

    }
}

?>
<?php
/**
 * Description of PayPal
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Admin_Config_Payment extends Daq_Form_Abstract
{
    private $_env;

    public $name = null;

    public function init()
    {
        
        $this->name = __("Payment Settings", WPJB_DOMAIN);
        $this->_env = array(
            1 => __("Sandbox (For testing only)", WPJB_DOMAIN),
            2 => __("Production (Real money)", WPJB_DOMAIN)
        );

        $instance = Wpjb_Project::getInstance();

        $e = new Daq_Form_Element("paypal_email");
        $e->setValue($instance->getConfig("paypal_email"));
        $e->setLabel(__("PayPal eMail", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Email());
        $this->addElement($e);

        $e = new Daq_Form_Element("paypal_env", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($instance->getConfig("paypal_env"));
        $e->setLabel(__("PayPal Environment", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_InArray(array_keys($this->_env)));
        foreach($this->_env as $k => $v) {
            $e->addOption($k, $k,  $v);
        }
        $this->addElement($e);
        
        apply_filters("wpja_form_init_config_payment", $this);

    }
}

?>
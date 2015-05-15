<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Resumes Access
 *
 * @author greg
 */
class Wpjb_Form_Frontend_ResumesAccess extends Daq_Form_Abstract
{
    public function init()
    {
        $this->addGroup("default");
        $this->addGroup("hidden");
        
        $e = new Daq_Form_Element("purchase", Daq_Form_Element::TYPE_HIDDEN);
        $e->setValue(1);
        $e->setRequired(true);
        $this->addElement($e, "hidden");
        
        $payment = new Wpjb_Payment_Factory;
        if(count($payment->getEngines())>1) {
            $v = array();
            $e = new Daq_Form_Element("payment_method", Daq_Form_Element::TYPE_SELECT);
            $e->setRequired(true);
            $e->setLabel(__("Payment Method", WPJB_DOMAIN));
            foreach($payment->getEngines() as $key => $engine) {
                /* @var $engine Wpjb_Payment_Interface */
                $engine = new $engine;
                $pTitle = $engine->getTitle();
                $e->addOption($key, $key, $pTitle);
                $v[] = $key;
            }
            $e->addValidator(new Daq_Validate_InArray($v));
            $this->addElement($e, "default");
        } else {
            $engine = current($payment->getEngines());
            $engine = new $engine;
            $e = new Daq_Form_Element("payment_method", Daq_Form_Element::TYPE_HIDDEN);
            $e->setValue($engine->getEngine());
            $e->addValidator(new Daq_Validate_InArray(array($engine->getEngine())));
            $e->setRequired(true);
            $this->addElement($e, "hidden");
        }

    }
}
?>

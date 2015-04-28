<?php
/**
 * Description of Apply
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Alert extends Daq_Form_Abstract
{
    public function init()
    {
        $e = new Daq_Form_Element("keyword", Daq_Form_Element::TYPE_TEXT);
        $e->setRequired(true);
        $this->addElement($e, "alert");

        $e = new Daq_Form_Element("email", Daq_Form_Element::TYPE_TEXT);
        $e->setRequired(true);
        $e->addValidator(new Daq_Validate_Email());
        $this->addElement($e, "apply");

        apply_filters("wpjb_form_init_alert", $this);
    }

}

?>
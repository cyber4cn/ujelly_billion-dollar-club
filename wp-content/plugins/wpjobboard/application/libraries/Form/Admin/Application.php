<?php
/**
 * Description of Application
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Admin_Application extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_Application";

    public function _exclude()
    {
        if($this->_object->getId()) {
            return array("id" => $this->_object->getId());
        } else {
            return array();
        }
    }

    public function init()
    {
        $e = new Daq_Form_Element("id", Daq_Form_Element::TYPE_HIDDEN);
        $e->setValue($this->_object->id);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e);

        $e = new Daq_Form_Element("applicant_name");
        $e->setRequired(true);
        $e->setValue($this->_object->applicant_name);
        $e->setLabel(__("Applicant Name", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("email");
        $e->setRequired(true);
        $e->setValue($this->_object->email);
        $e->setLabel(__("E-mail", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("resume", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setValue($this->_object->resume);
        $e->setLabel(__("Resume/Message", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("is_rejected", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($this->_object->is_rejected);
        $e->setLabel(__("Reject application", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addValidator(new Daq_Validate_InArray(array(0,1)));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $e->addOption(0, 0, __("No", WPJB_DOMAIN));
        $this->addElement($e);

        apply_filters("wpja_form_init_application", $this);

    }
}

?>
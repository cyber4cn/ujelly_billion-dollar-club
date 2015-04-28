<?php
/**
 * Description of Listing
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Admin_AdditionalField extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_AdditionalField";

    protected function _typeArr()
    {
        return array(
            array(1, 1, __('Short Text', WPJB_DOMAIN)),
            //array(2, 3, 'Checkbox'),
            array(3, 4, __('Dropdown', WPJB_DOMAIN)),
            array(4, 6, __('TextArea', WPJB_DOMAIN)),
        );
    }

    protected function _validatorArr()
    {
        return array(
            array(0, 0, __('None', WPJB_DOMAIN)),
            array(1, 1, __('Text no longer then 80 characters', WPJB_DOMAIN)),
            array(2, 2, __('Text no longer then 160 characters', WPJB_DOMAIN)),
            array(3, 3, __('Integer', WPJB_DOMAIN)),
            array(4, 4, __('Floating point number', WPJB_DOMAIN))
        );
    }

    public function init()
    {
        $e = new Daq_Form_Element("id", Daq_Form_Element::TYPE_HIDDEN);
        $e->setValue($this->_object->id);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e);

        $e = new Daq_Form_Element("field_for", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($this->_object->field_for);
        $e->setLabel(__("Field For", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Add job form", WPJB_DOMAIN));
        $e->addOption(2, 2, __("Apply for job form", WPJB_DOMAIN));
        $e->addOption(3, 3, __("Add resume form", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("type", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($this->_object->type);
        $e->setLabel(__("Field Type", WPJB_DOMAIN));
        foreach($this->_typeArr() as $c) {
            $e->addOption($c[0], $c[1], $c[2]);
        }
        $this->addElement($e);

        $e = new Daq_Form_Element("validator", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($this->_object->validator);
        $e->setLabel(__("Validation", WPJB_DOMAIN));
        $e->setHint(__("Select how field should be validated", WPJB_DOMAIN));
        $inArray = array();
        foreach($this->_validatorArr() as $c) {
            $inArray[] = $c[0];
            $e->addOption($c[0], $c[1], $c[2]);
        }
        $e->addValidator(new Daq_Validate_InArray($inArray));
        $this->addElement($e);

        $e = new Daq_Form_Element("label");
        $e->setRequired(true);
        $e->setValue($this->_object->label);
        $e->setLabel(__("Label", WPJB_DOMAIN));
        $e->setHint(__('Field Title', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(1, 120));
        $this->addElement($e);

        $e = new Daq_Form_Element("hint");
        $e->setValue($this->_object->hint);
        $e->setLabel(__("Description", WPJB_DOMAIN));
        $e->setHint(__('Short field description (just like this text).', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(1, 250));
        $this->addElement($e);

        $e = new Daq_Form_Element("default_value");
        $e->setRequired(true);
        $e->setValue($this->_object->default_value);
        $e->setLabel(__("Default Value", WPJB_DOMAIN));
        $e->setHint(__('Default value. Leave empty if there is none.', WPJB_DOMAIN));
        //$this->addElement($e);

        $e = new Daq_Form_Element("is_required", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($this->_object->is_required);
        $e->setLabel(__("Is Required", WPJB_DOMAIN));
        $e->setHint(__("Required fields has to be filled by job poster", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("is_active", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($this->_object->is_active);
        $e->setLabel(__("Is Active", WPJB_DOMAIN));
        $e->setHint(__("Only active fields are visible on job posting form.", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);

        apply_filters("wpja_form_init_additionalfield", $this);
    }

    public function isValid($values)
    {
        if($values["type"] == 1) {
            $inArr = array();
            foreach($this->_validatorArr() as $arr) {
                $inArr[] = $arr[0];
            }
            $this->getElement("type")->addValidator(new Daq_Validate_InArray($inArr));
        }

        if($values["field_for"] == 2) {
            $this->getElement("type")->addOption(5, 5, "");
        }
        
        $isValid = parent::isValid($values);
        
        if($values["type"] == 4) {
            if(!isset($values['option']) || count($values['option']) < 1) {
                $this->getElement("type")->pushError(__("Field type of Dropdown has to have at least one option.", WPJB_DOMAIN));
                return false;
            }
            foreach($values['option'] as $option) {
                if(strlen(trim($option)) == 0) {
                    $this->getElement("type")->pushError(__("One of options is empty", WPJB_DOMAIN));
                    return false;
                }
            }
        }

        return $isValid;
    }
}

?>
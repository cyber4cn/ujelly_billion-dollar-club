<?php
/**
 * Description of Listing
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Admin_Listing extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_Listing";

    public function _exclude()
    {
        if($this->_object->getId()) {
            return array("id" => $this->_object->getId());
        } else {
            return array();
        }
    }

    protected function _currArr()
    {
        $list = array();
        foreach(Wpjb_List_Currency::getList() as $k => $arr) {
            $v = $arr['name'];
            if($arr['symbol'] != null) {
                $v = $arr['symbol'].' '.$v;
            }
            $list[] = array($k, $k, $v);
        }
        return $list;
    }

    public function init()
    {
        $e1 = new Daq_Form_Element("id", Daq_Form_Element::TYPE_HIDDEN);
        $e1->setValue($this->_object->id);
        $e1->addFilter(new Daq_Filter_Int());
        $this->addElement($e1);

        $e = new Daq_Form_Element("title");
        $e->setRequired(true);
        $e->setValue($this->_object->title);
        $e->setLabel(__("Listing Title", WPJB_DOMAIN));
        $e->setHint(__('Listing title should be a short name that explains listing details for example "Featured listing".', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(1, 120));
        $this->addElement($e);

        $e = new Daq_Form_Element("price");
        $e->setRequired(true);
        $e->setValue($this->_object->price);
        $e->setLabel(__("Listing Price", WPJB_DOMAIN));
        $e->setHint(__('Listing price, examples of valid values are: "50.00", "140.00".', WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Float());
        $e->addValidator(new Daq_Validate_Float(0));
        $this->addElement($e);

        $e = new Daq_Form_Element("currency", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($this->_object->currency);
        $e->setLabel(__("Currency", WPJB_DOMAIN));
        foreach($this->_currArr() as $c) {
            $e->addOption($c[0], $c[1], $c[2]);
        }
        $this->addElement($e);

        $e = new Daq_Form_Element("visible");
        $e->setValue($this->_object->visible);
        $e->setLabel(__("Visible", WPJB_DOMAIN));
        $e->setHint(__("Number of days that listing will be visible. (0 = forever)", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addValidator(new Daq_Validate_Int(0));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("is_featured", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($this->_object->is_featured);
        $e->setLabel(__("Is Featured", WPJB_DOMAIN));
        $e->setHint(__("In short featured listings are listings that are displayed before normal listings (so they usually cost more).", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("is_active", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($this->_object->is_active);
        $e->setLabel(__("Is Active", WPJB_DOMAIN));
        $e->setHint(__("Only active listings can be used by job posters.", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Float());
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);
        
        $e4 = new Daq_Form_Element("description", Daq_Form_Element::TYPE_TEXTAREA);
        $e4->setValue($this->_object->description);
        $e4->setLabel(__("Description", WPJB_DOMAIN));
        $e4->setHint(__("Briefly describe listing type. You can include cost and number of days listing will be visible.", WPJB_DOMAIN));
        $this->addElement($e4);

        apply_filters("wpja_form_init_listing", $this);

    }
}

?>
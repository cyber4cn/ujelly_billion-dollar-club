<?php
/**
 * Description of Listing
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Admin_Discount extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_Discount";

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

    protected function _typeArr()
    {
        return array(
            array(1, 1, __('Percentage (%)', WPJB_DOMAIN)),
            array(2, 2, __('Fixed amount of money', WPJB_DOMAIN)),
        );
    }

    public function init()
    {
        $e = new Daq_Form_Element("id", Daq_Form_Element::TYPE_HIDDEN);
        $e->setValue($this->_object->id);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e);

        $e = new Daq_Form_Element("title");
        $e->setRequired(true);
        $e->setValue($this->_object->title);
        $e->setLabel(__("Discount Title", WPJB_DOMAIN));
        $e->setHint(__('This is the official promotion name that identifies promotion.', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(1, 120));
        $this->addElement($e);

        $e = new Daq_Form_Element("code");
        $e->setRequired(true);
        $e->setValue($this->_object->code);
        $e->setLabel(__("Code", WPJB_DOMAIN));
        $e->setHint(__('The secret code that client has to know in order to use selected promo code.', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(1, 20));
        $e->addValidator(new Daq_Validate_Db_NoRecordExists("Wpjb_Model_Discount", "code", $this->_exclude()));
        $this->addElement($e);

        $e = new Daq_Form_Element("discount");
        $e->setRequired(true);
        $e->setValue($this->_object->discount);
        $e->setLabel(__("Discount Value", WPJB_DOMAIN));
        $e->setHint(__('Examples of valid values. "1234.00", "34.00", "45"', WPJB_DOMAIN));
        //$e->addFilter(new Daq_Filter_Float());
        $e->addValidator(new Daq_Validate_Float(0.01));
        $this->addElement($e);

        $e = new Daq_Form_Element("type", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($this->_object->type);
        $e->setLabel(__("Discount Type", WPJB_DOMAIN));
        $e->setHint(__("Specyfing Discount Value is not enough, you have to also select type of discount you can choose either fixed amount of money or percentage of total price.", WPJB_DOMAIN));
        foreach($this->_typeArr() as $c) {
            $e->addOption($c[0], $c[1], $c[2]);
        }
        $this->addElement($e);

        $e = new Daq_Form_Element("currency", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($this->_object->currency);
        $e->setLabel(__("Currency", WPJB_DOMAIN));
        foreach($this->_currArr() as $c) {
            $e->addOption($c[0], $c[1], $c[2]);
        }
        $this->addElement($e);

        $e = new Daq_Form_Element("expires_at");
        $e->setRequired(true);
        $e->setValue($this->_object->expires_at);
        $e->setLabel(__("Expiration Date", WPJB_DOMAIN));
        $e->setHint(__('Discount expiration date in format "yyyy-mm-dd".', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Date("Y-m-d"));
        $this->addElement($e);

        $e = new Daq_Form_Element("used");
        $e->addFilter(new Daq_Filter_Int());
        $e->setValue($this->_object->used);
        $e->setLabel(__("Used", WPJB_DOMAIN));
        $e->setHint(__("Number of times coupon was already used.", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Int);
        $this->addElement($e);

        $e = new Daq_Form_Element("max_uses");
        $e->addFilter(new Daq_Filter_Int());
        $e->setValue($this->_object->max_uses);
        $e->setLabel(__("Max uses", WPJB_DOMAIN));
        $e->setHint(__("Maximum number of times coupon can be used. (Zero equal to unlimited uses.)", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Int);
        $this->addElement($e);

        $e = new Daq_Form_Element("is_active", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($this->_object->is_active);
        $e->setLabel(__("Is Active", WPJB_DOMAIN));
        $e->setHint(__("Only active discounts can be used by job posters.", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Float());
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e);

        apply_filters("wpja_form_init_discount", $this);
    }

    public function isValid($values)
    {
        if($values["type"] == 1) {
            $this->getElement("discount")->addValidator(new Daq_Validate_Float(0, 100));
        }

        return parent::isValid($values);
    }
}

?>
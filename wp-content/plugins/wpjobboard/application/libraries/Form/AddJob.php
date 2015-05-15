<?php
/**
 * Description of AddJob
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_AddJob extends Wpjb_Form_AbstractJob
{

    protected function _getListingArr()
    {
        $query = new Daq_Db_Query();
        return $query->select("t.*")->from("Wpjb_Model_Listing t")->where("is_active=1")->execute();
    }

    public function setDefaults(array $default)
    {
        foreach($this->_field as $field) {
            /* @var $field Daq_Form_Element */
            if(isset($default[$field->getName()])) {
                $field->setValue($default[$field->getName()]);
            }
        }
    }
    
    public function init()
    {
        parent::init();

        $this->removeElement("id");

        $e = new Daq_Form_Element("coupon");
        $e->setLabel(__("Coupon", WPJB_DOMAIN));
        $this->addElement($e, "coupon");

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
            $this->addElement($e, "coupon");
        } else {
            $engine = current($payment->getEngines());
            $engine = new $engine;
            $e = new Daq_Form_Element("payment_method", Daq_Form_Element::TYPE_HIDDEN);
            $e->setValue($engine->getEngine());
            $e->addValidator(new Daq_Validate_InArray(array($engine->getEngine())));
            $e->setRequired(true);
            $this->addGroup("hidden");
            $this->addElement($e, "hidden");
        }
        
        $e = new Daq_Form_Element("listing", Daq_Form_Element::TYPE_RADIO);
        $e->setRequired(true);
        $e->setLabel(__("Listing Type", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Db_RecordExists("Wpjb_Model_Listing", "id"));
        $default = __("<b>{title}</b> {price} ~ days visible: {visible}", WPJB_DOMAIN);
        $tpl = Wpjb_Project::getInstance()->conf("front_listing_tpl", $default);
        foreach($this->_getListingArr() as $listing) {
            $visible = $listing->visible;
            if($visible == 0) {
                $visible = __("<i>unlimited</i>", WPJB_DOMAIN);
            }
            $find = array("{price}", "{title}", "{visible}");
            $repl = array($listing->getTextPrice(), $listing->title, $visible);
            $e->addOption($listing->id, $listing->id, str_replace($find, $repl, $tpl));
        }
        $e->setRenderer("wpjb_form_helper_listing");
        $this->addElement($e, "coupon");
        
        apply_filters("wpjb_form_init_addjob", $this);

        $this->setModifiedScheme(Wpjb_Project::getInstance()->conf("form_add_job", true));
    }

    public function isValid($values)
    {
        if(!$this->hasElement("listing")) {
            $listing = new Daq_Db_Query();
            $listing->select("*")->from("Wpjb_Model_Listing t")->limit(1);
            list($listing) = $listing->execute();
            $e = new Daq_Form_Element("listing");
            $e->setValue($listing->id);
            $this->addElement($e);
            $values["listing"] = $listing->id;
        }
        
        if(!$this->hasElement("payment_method")) {
            $payment = new Wpjb_Payment_Factory;
            $engine = new ArrayIterator($payment->getEngines());
            $engine = $engine->key();

            $e = new Daq_Form_Element("payment_method");
            $e->setValue($engine);
            $this->addElement($e);
            $values["payment_method"] = $engine;
        }
        
        $listing = new Wpjb_Model_Listing($values["listing"]);
        $validator = new Wpjb_Validate_Coupon($listing->currency);

        if($this->hasElement("coupon")) {
            $this->getElement("coupon")->addValidator($validator);
        }

        $valid = parent::isValid($values);

        $discountObject = null;
        if(strlen($values['coupon'])>0 && $valid) {
            $query = new Daq_Db_Query();
            $result = $query->select("*")->from("Wpjb_Model_Discount t")
                ->where("code = ?", $values['coupon'])
                ->limit(1)
                ->execute();

            $discountObject = $result[0];
            $listing->addDiscount($discountObject);
        }

        if($valid) {

            list($price, $discount) = $listing->calculatePrice();

            if($discountObject) {
                $e = new Daq_Form_Element("discount_id");
                $e->setValue($discountObject->id);
                $this->addElement($e);
            }

            $e = new Daq_Form_Element("job_modified_at");
            $e->setValue(date("Y-m-d H:i:s"));
            $this->addElement($e);

            $e = new Daq_Form_Element("job_created_at");
            $e->setValue(date("Y-m-d H:i:s"));
            $this->addElement($e);

            $e = new Daq_Form_Element("job_expires_at");
            if($listing->visible == 0) {
                $expiresAt = "9999-12-31 23:59:59";
            } else {
                $expiresAt = strtotime("now +".$listing->visible." days");
                $expiresAt = date("Y-m-d H:i:s", $expiresAt);
            }
            $e->setValue($expiresAt);
            $this->addElement($e);

            $e = new Daq_Form_Element("job_visible");
            $e->setValue($listing->visible);
            $this->addElement($e);

            $e = new Daq_Form_Element("job_source");
            $e->setValue(1);
            $this->addElement($e);

            $e = new Daq_Form_Element("is_filled");
            $e->setValue(0);
            $this->addElement($e);

            $isActive = Wpjb_Project::getInstance()->getConfig("posting_moderation");
            $isActive = !(bool)($isActive);
            if($price > 0) {
                $isActive = false;
            }

            $e = new Daq_Form_Element("is_approved");
            $e->setValue($isActive);
            $this->addElement($e);

            $e = new Daq_Form_Element("is_active");
            $e->setValue($isActive);
            $this->addElement($e);

            $e = new Daq_Form_Element("is_featured");
            $e->setValue($listing->is_featured);
            $this->addElement($e);

            $e = new Daq_Form_Element("payment_sum");
            $e->setValue($price);
            $this->addElement($e);

            $e = new Daq_Form_Element("payment_paid");
            $e->setValue(0);
            $this->addElement($e);

            $e = new Daq_Form_Element("payment_currency");
            $e->setValue($listing->currency);
            $this->addElement($e);

            $e = new Daq_Form_Element("payment_discount");
            $e->setValue($discount);
            $this->addElement($e);

            $slug = Wpjb_Utility_Slug::generate(Wpjb_Utility_Slug::MODEL_JOB, $values['job_title']);
            $e = new Daq_Form_Element("job_slug");
            $e->setValue($slug);
            $this->addElement($e);

            $e = new Daq_Form_Element("employer_id");
            $e->setValue($this->_getEmployerId());
            $this->addElement($e);
        }

        return $valid;
    }

    private function _getEmployerId()
    {
        if(!is_user_logged_in()) {
            return null;
        }

        $company = Wpjb_Model_Employer::current();
        return $company->getId();
    }

    public function save()
    {
        $valueList = $this->getValues();
        parent::save();
        $this->_saveAdditionalFields($valueList);

        apply_filters("wpjb_form_save_addjob", $this);
    }
}

?>
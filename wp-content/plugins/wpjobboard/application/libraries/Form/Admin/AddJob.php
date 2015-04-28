<?php
/**
 * Description of Job
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Admin_AddJob extends Wpjb_Form_AbstractJob
{
    protected $_model = "Wpjb_Model_Job";

    public static $isAdmin = false;

    public function _exclude()
    {
        if($this->_object->getId()) {
            return array("id" => $this->_object->getId());
        } else {
            return array();
        }
    }

    public function isAdminMode()
    {
        return self::$isAdmin;
    }

    public function init()
    {
        parent::init();

        $this->addGroup("other", "Other");

        $e = new Daq_Form_Element("job_slug");
        $e->setRequired(true);
        $e->setLabel(__("Job Slug", WPJB_DOMAIN));
        $e->setHint(__("The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", WPJB_DOMAIN));
        $e->setValue($this->_object->job_slug);
        $e->addValidator(new Daq_Validate_StringLength(1, 120));
        $e->addValidator(new Daq_Validate_Slug());
        $e->addValidator(new Daq_Validate_Db_NoRecordExists("Wpjb_Model_Job", "job_slug", $this->_exclude()));
        $this->addElement($e, "other");

        $e = new Daq_Form_Element("is_active", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setLabel(__("Is Active", WPJB_DOMAIN));
        $e->setValue($this->_object->is_active);
        $e->addFilter(new Daq_Filter_Int());
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $this->addElement($e, "other");

        if($this->getObject()->getId() && $this->isAdminMode()) {

            $e = new Daq_Form_Element("is_featured", Daq_Form_Element::TYPE_CHECKBOX);
            $e->setLabel(__("Is Featured", WPJB_DOMAIN));
            $e->setValue($this->getObject()->is_featured);
            $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
            $e->addFilter(new Daq_Filter_Float());
            $this->addElement($e, "other");

            $e = new Daq_Form_Element("job_visible");
            $e->setLabel(__("Visible", WPJB_DOMAIN));
            $e->setValue($this->getObject()->job_visible);
            $e->setHint(__("Number of days job will be visible (Overwrites listing type settings)", WPJB_DOMAIN));
            $e->addFilter(new Daq_Filter_Int());
            $e->addValidator(new Daq_Validate_Int(0));
            $this->addElement($e, "other");
        }
        
        if(!$this->getObject()->getId()) {
            $e = new Daq_Form_Element("listing", Daq_Form_Element::TYPE_SELECT);
            $e->setLabel(__("Listing Type",WPJB_DOMAIN));
            $e->addValidator(new Daq_Validate_Db_RecordExists("Wpjb_Model_Listing", "id"));
            foreach($this->_getListingArr() as $listing) {
                $e->addOption($listing->id, $listing->id, $listing->title);
            }
            $this->addElement($e, "other");
        }

        if(!$this->isAdminMode()) {
            $this->removeElement("is_active");
            $this->removeElement("job_slug");
        }

        $e = new Daq_Form_Element("is_filled", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setLabel(__("Is Filled", WPJB_DOMAIN));
        $e->setValue($this->getObject()->is_filled);
        $e->addOption(1, 1, __("Yes, this position is taken", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e, "other");

        if($this->getObject()->getId()>0 && !$this->getObject()->isFree()) {
            $e = new Daq_Form_Element("payment_paid");
            $e->setValue($this->_object->payment_paid);
            $e->addValidator(new Daq_Validate_Float());
            $this->addElement($e, "unknown");
        }

        apply_filters("wpja_form_init_addjob", $this);

        $this->setModifiedScheme(Wpjb_Project::getInstance()->conf("form_add_job", true));
    }

    public function isValid($values)
    {
        $isValid = parent::isValid($values);

        if(!$this->hasElement("listing")) {
            $listing = new Daq_Db_Query();
            $listing->select("*")->from("Wpjb_Model_Listing t")->limit(1);
            list($listing) = $listing->execute();
            $e = new Daq_Form_Element("listing");
            $e->setValue($listing->id);
            $this->addElement($e);
        }
        
        $ext = null;
        if($this->hasElement("company_logo")) {
            $ext = $this->getElement("company_logo")->getExt();
        }
        $value = $this->getValues();

        if($ext) {
            $e = new Daq_Form_Element("company_logo_ext");
            $e->setValue($ext);
            $this->addElement($e);
        }

        $e = new Daq_Form_Element("job_modified_at");
        $e->setValue(date("Y-m-d H:i:s"));
        $this->addElement($e);

        if($this->hasElement("job_visible")) {
            // dokonczyc tutaj poprawne zapisywanie daty
            $days = $values["job_visible"];
            $now = $this->getObject()->job_created_at;

            $e = new Daq_Form_Element("job_expires_at");
            if($days == 0) {
                $expiresAt = "9999-12-31 23:59:59";
            } else {
                $expiresAt = strtotime("$now +".$days." days");
                $expiresAt = date("Y-m-d H:i:s", $expiresAt);
            }
            $e->setValue($expiresAt);
            $this->addElement($e);
        }

        if($value['is_active'] == 1) {
            $e = new Daq_Form_Element("is_approved");
            $e->setValue(1);
            $this->addElement($e);
        }

        if($isValid && $this->getObject()->getId() < 1) {

            $listing = new Wpjb_Model_Listing($value['listing']);

            $e = new Daq_Form_Element("job_source");
            $e->setValue(2);
            $this->addElement($e);

            $e = new Daq_Form_Element("job_visible");
            $e->setValue($listing->visible);
            $this->addElement($e);

            $e = new Daq_Form_Element("job_created_at");
            $e->setValue(date("Y-m-d H:i:s"));
            $this->addElement($e);

            $days = $listing->visible;
            $e = new Daq_Form_Element("job_expires_at");
            if($listing->visible == 0) {
                $expiresAt = "9999-12-31 23:59:59";
            } else {
                $expiresAt = strtotime("now +".$listing->visible." days");
                $expiresAt = date("Y-m-d H:i:s", $expiresAt);
            }
            $e->setValue($expiresAt);
            $this->addElement($e);

            $e = new Daq_Form_Element("is_filled");
            $e->setValue(0);
            $this->addElement($e);

            $e = new Daq_Form_Element("is_featured");
            $e->setValue($listing->is_featured);
            $this->addElement($e);

            $e = new Daq_Form_Element("payment_sum");
            $e->setValue($listing->price);
            $this->addElement($e);

            $e = new Daq_Form_Element("payment_paid");
            $e->setValue($listing->price);
            $this->addElement($e);

            $e = new Daq_Form_Element("payment_currency");
            $e->setValue($listing->currency);
            $this->addElement($e);

            $e = new Daq_Form_Element("payment_discount");
            $e->setValue(0);
            $this->addElement($e);
        }

        return $isValid;
    }

    public function save()
    {
        $file = null;
        if($this->hasElement("company_logo")) {
            $file = $this->getElement("company_logo");
        }

        $valueList = $this->getValues();

        parent::save();

        $this->_saveAdditionalFields($valueList);
        $this->_additionalFields();
        
        $baseDir = Wpjb_Project::getInstance()->getProjectBaseDir();
        
        if($file && $file->fileSent()) {
            $file->setDestination($baseDir."/environment/images/");
            $file->upload("job_".$this->getObject()->getId().".".$file->getExt());
        }
        
        apply_filters("wpja_form_save_addjob", $this);

        $this->reinit();
    }
}

?>
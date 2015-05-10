<?php
/**
 * Description of Company
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Admin_Company extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_Employer";

    const MODE_ADMIN = 1;

    const MODE_SELF = 2;

    private $_mode = null;

    public function __construct($id, $mode = self::MODE_ADMIN)
    {
        $this->_mode = $mode;
        parent::__construct($id);
    }

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
        $this->addGroup("default", __("Company", WPJB_DOMAIN));
        $this->addGroup("location", __("Location", WPJB_DOMAIN));
        
        $e = new Daq_Form_Element("company_name");
        $e->setLabel(__("Company Name", WPJB_DOMAIN));
        $e->setRequired(true);
        $e->setValue($this->_object->company_name);
        $this->addElement($e, "default");
        
        $e = new Daq_Form_Element_File("company_logo", Daq_Form_Element::TYPE_FILE);
        $e->setLabel(__("Company Logo", WPJB_DOMAIN));
        $e->setHint(__("Max. file size 30 kB. Image size 300x100 px. File formats *.jpg; *.gif; *.png .", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_File_Default());
        $e->addValidator(new Daq_Validate_File_Ext("jpg,jpeg,gif,png"));
        $e->addValidator(new Daq_Validate_File_Size(30000));
        $e->addValidator(new Daq_Validate_File_ImageSize(300, 100));
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("company_website");
        $e->setLabel(__("Company Website", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Url());
        $e->addFilter(new Daq_Filter_WP_Url);
        $e->setValue($this->_object->company_website);
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("company_info", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setLabel(__("Company Info", WPJB_DOMAIN));
        $eDesc = str_replace(
            '{tags}',
            '<p><a><b><strong><em><i><ul><li><h3><h4><br>',
            __("Use this field to describe your company profile (what you do, company size etc). Only {tags} HTML tags are allowed", WPJB_DOMAIN)
        );
        $e->setHint($eDesc);

        $e->setValue($this->_object->company_info);
        $this->addElement($e, "default");
        
        $def = wpjb_locale();
        $e = new Daq_Form_Element("company_country", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Company Country", WPJB_DOMAIN));
        $e->setValue(($this->_object->company_country) ? $this->_object->company_country : $def);
        foreach(Wpjb_List_Country::getAll() as $listing) {
            $e->addOption($listing['code'], $listing['code'], $listing['name']);
        }
        $e->addClass("wpjb-location-country");
        $this->addElement($e, "location");

        $e = new Daq_Form_Element("company_state");
        $e->setLabel(__("Company State", WPJB_DOMAIN));
        $e->setValue($this->_object->company_state);
        $e->addClass("wpjb-location-state");
        $this->addElement($e, "location");

        $e = new Daq_Form_Element("company_zip_code");
        $e->setLabel(__("Company Zip-Code", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(null, 20));
        $e->setValue($this->_object->company_zip_code);
        $this->addElement($e, "location");
        
        $e = new Daq_Form_Element("company_location");
        $e->setLabel(__("Company Location", WPJB_DOMAIN));
        $e->setValue($this->_object->company_location);
        $e->addClass("wpjb-location-city");
        $this->addElement($e, "location");

        $e = new Daq_Form_Element("is_public", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setLabel(__("Publish Profile", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Allow job seekers to view company profile", WPJB_DOMAIN));
        $e->setValue($this->_object->is_public);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e, "default");

        if($this->_mode != self::MODE_ADMIN) {
            return;
        }

        $e = new Daq_Form_Element("slug");
        $e->setRequired(true);
        $e->setValue($this->_object->slug);
        $e->setLabel("Company Slug");
        $e->setHint("The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.");
        $e->addValidator(new Daq_Validate_Slug());
        $e->addValidator(new Daq_Validate_Db_NoRecordExists("Wpjb_Model_Employer", "slug", $this->_exclude()));
        //$this->addElement($e, "manage");

        $e = new Daq_Form_Element("is_active", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setLabel(__("Is Active", WPJB_DOMAIN));
        $e->setHint(__("Activates company account", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $e->setValue($this->_object->is_active);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e, "default");

        apply_filters("wpja_form_init_company", $this);
    }

    public function isValid($values)
    {
        $isValid = parent::isValid($values);

        $ext = $this->getElement("company_logo")->getExt();
        $value = $this->getValues();

        if($ext) {
            $e = new Daq_Form_Element("company_logo_ext");
            $e->setValue($ext);
            $this->addElement($e);
        }

        return $isValid;
    }

    public function save()
    {
        $file = $this->getElement("company_logo");
        parent::save();

        if($file->fileSent()) {
            $file->setDestination(Wpjb_List_Path::getPath("company_logo"));
            $file->upload("logo_".$this->getObject()->getId().".".$file->getExt());
        }
    }

}

?>

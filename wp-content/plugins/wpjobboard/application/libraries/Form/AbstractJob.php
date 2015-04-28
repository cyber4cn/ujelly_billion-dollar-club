<?php
/**
 * Description of AbstractJob
 *
 * @author greg
 * @package 
 */

abstract class Wpjb_Form_AbstractJob extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_Job";

    public function _exclude()
    {
        if($this->_object->getId()) {
            return array("id" => $this->_object->getId());
        } else {
            return array();
        }
    }

    protected function _getCategoryArr()
    {
        $query = new Daq_Db_Query();
        return $query->select("t.*")
            ->from("Wpjb_Model_Category t")
            ->order("title")
            ->execute();
    }

    protected function _getTypeArr()
    {
        $query = new Daq_Db_Query();
        return $query->select("t.*")
            ->from("Wpjb_Model_JobType t")
            ->order("title")
            ->execute();
    }

    protected function _getListingArr()
    {
        $query = new Daq_Db_Query();
        return $query->select("t.*")
            ->from("Wpjb_Model_Listing t")
            ->order("title")
            ->execute();
    }

    public function init()
    {
        $this->addGroup("company", __("Company Information", WPJB_DOMAIN));
        $this->addGroup("job", __("Job Information", WPJB_DOMAIN));
        $this->addGroup("fields", __("Additional Fields", WPJB_DOMAIN));
        $this->addGroup("location", __("Location", WPJB_DOMAIN));
        $this->addGroup("coupon", __("Coupon", WPJB_DOMAIN));

        $e = new Daq_Form_Element("company_name");
        $e->setRequired(true);
        $e->setLabel(__("Company Name", WPJB_DOMAIN));
        $e->setValue($this->_object->company_name);
        $this->addElement($e, "company");

        $e = new Daq_Form_Element("company_email");
        $e->setRequired(true);
        $e->setLabel(__("Company Email", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Email());
        $e->setValue($this->_object->company_email);
        $this->addElement($e, "company");

        $e = new Daq_Form_Element("company_website");
        $e->setLabel(__("Company Website", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Url());
        $e->addFilter(new Daq_Filter_WP_Url);
        $e->setValue($this->_object->company_website);
        $this->addElement($e, "company");

        $e = new Daq_Form_Element_File("company_logo", Daq_Form_Element::TYPE_FILE);
        $e->setLabel(__("Company Logo", WPJB_DOMAIN));
        $e->setHint(__("Max. file size 30 kB. Image size 300x100 px. File formats *.jpg; *.gif; *.png .", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_File_Default());
        $e->addValidator(new Daq_Validate_File_Ext("jpg,jpeg,gif,png"));
        $e->addValidator(new Daq_Validate_File_Size(30000));
        $e->addValidator(new Daq_Validate_File_ImageSize(300, 100));
        $e->setRenderer("wpjb_form_helper_logo_upload");
        $this->addElement($e, "company");



        $e = new Daq_Form_Element("id", Daq_Form_Element::TYPE_HIDDEN);
        $e->setValue($this->_object->id);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e, "job");

        $e = new Daq_Form_Element("job_type", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Job Type", WPJB_DOMAIN));
        $e->setValue($this->_object->job_type);
        $e->addValidator(new Daq_Validate_Db_RecordExists("Wpjb_Model_JobType", "id"));
        foreach($this->_getTypeArr() as $type) {
            $e->addOption($type->id, $type->id, $type->title);
        }
        $this->addElement($e, "job");

        $e = new Daq_Form_Element("job_category", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Job Category", WPJB_DOMAIN));
        $e->setValue($this->_object->job_category);
        $e->addValidator(new Daq_Validate_Db_RecordExists("Wpjb_Model_Category", "id"));
        foreach($this->_getCategoryArr() as $category) {
            $e->addOption($category->id, $category->id, $category->title);
        }
        $this->addElement($e, "job");

        $e = new Daq_Form_Element("job_title");
        $e->setRequired(true);
        $e->setLabel(__("Job Title", WPJB_DOMAIN));
        $e->setValue($this->_object->job_title);
        $e->addValidator(new Daq_Validate_StringLength(1, 120));
        $this->addElement($e, "job");

        $e = new Daq_Form_Element("job_description", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setRequired(true);
        $e->setLabel(__("Job Description", WPJB_DOMAIN));
        $eDesc = str_replace(
            '{tags}',
            '<p><a><b><strong><em><i><ul><li><h3><h4><br>',
            __("Only {tags} HTML tags are allowed", WPJB_DOMAIN)
        );
        $e->addClass("wpjb-textarea-wide");
        $e->setHint($eDesc);
        $e->setValue($this->_object->job_description);
        $this->addElement($e, "job");

        $def = wpjb_locale();
        $e = new Daq_Form_Element("job_country", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Job Country", WPJB_DOMAIN));
        $e->setValue(($this->_object->job_country) ? $this->_object->job_country : $def);
        foreach(Wpjb_List_Country::getAll() as $listing) {
            $e->addOption($listing['code'], $listing['code'], $listing['name']);
        }
        $e->addClass("wpjb-location-country");
        $this->addElement($e, "location");

        $e = new Daq_Form_Element("job_state");
        $e->setLabel(__("Job State", WPJB_DOMAIN));
        $e->setValue($this->_object->job_state);
        $e->addClass("wpjb-location-state");
        $this->addElement($e, "location");

        $e = new Daq_Form_Element("job_zip_code");
        $e->setLabel(__("Job Zip-Code", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(null, 20));
        $e->setValue($this->_object->job_zip_code);
        $this->addElement($e, "location");

        $e = new Daq_Form_Element("job_location");
        $e->setValue($this->_object->job_location);
        $e->setRequired(true);
        $e->setLabel(__("Job City/Location", WPJB_DOMAIN));
        $e->setHint(__('For example: "Chicago", "London", "Anywhere" or "Telecommute".', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(null, 120));
        $e->addClass("wpjb-location-city");
        $this->addElement($e, "location");

        $this->_additionalFields();
        
    }

    protected function _additionalFields()
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")->from("Wpjb_Model_AdditionalField t")
            ->joinLeft("t.value t2", "job_id=".$this->getObject()->getId())
            ->where("field_for = 1")
            ->where("is_active = 1")
            ->execute();


        foreach($result as $field) {
            $e = new Daq_Form_Element("field_".$field->getId(), $field->type);
            $e->setLabel($field->label);
            $e->setHint($field->hint);


            if($field->type == Daq_Form_Element::TYPE_SELECT) {
                $query = new Daq_Db_Query();
                $option = $query->select("*")
                    ->from("Wpjb_Model_FieldOption t")
                    ->where("field_id=?", $field->getId())
                    ->execute();

                foreach($option as $o) {
                    if($o->value == $field->getValue()->value) {
                        $e->setValue($o->id);
                        break;
                    }
                }

            } else {
                $e->setValue($field->getValue()->value);
            }

            if($field->type != Daq_Form_Element::TYPE_CHECKBOX) {
                $e->setRequired((bool)$field->is_required);
            } else {
                $e->addFilter(new Daq_Filter_Int());
            }

            if($field->type == Daq_Form_Element::TYPE_TEXT) {
                switch($field->validator) {
                    case 1:
                        $e->addValidator(new Daq_Validate_StringLength(0, 80));
                        break;
                    case 2:
                        $e->addValidator(new Daq_Validate_StringLength(0, 160));
                        break;
                    case 3:
                        $e->addValidator(new Daq_Validate_Int());
                        break;
                    case 4:
                        $e->addValidator(new Daq_Validate_Float());
                        break;
                }
            }

            foreach((array)$field->getOptionList() as $option) {
                $e->addOption($option->getId(), $option->getId(), $option->value);
            }

            $this->addElement($e, "fields");
        }
    }

    protected function _saveAdditionalFields(array $valueList)
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")
            ->from("Wpjb_Model_AdditionalField t")
            ->where("is_active = 1")
            ->where("field_for = 1")
            ->execute();

        $query = new Daq_Db_Query();
        $fieldValue = $query->select("*")
            ->from("Wpjb_Model_FieldValue t")
            ->where("job_id = ?", $this->getObject()->getId())
            ->execute();

        foreach($result as $option) {
            $id = "field_".$option->getId();
            $value = $valueList[$id];
            if($option->type == Daq_Form_Element::TYPE_SELECT) {
                foreach((array)$option->getOptionList() as $opt) {
                    if($opt->id == $value) {
                        $value = $opt->value;
                        break;
                    }
                }
            }

            $object = null;
            foreach($fieldValue as $temp) {
                if($temp->field_id == $option->getId()) {
                    $object = $temp;
                    break;
                }
            }

            if($object === null) {
                $object = new Wpjb_Model_FieldValue();
                $object->field_id = $option->getId();
                $object->job_id = $this->getObject()->getId();
            }

            $object->value = $value;
            $object->save();
        }
    }
}

?>

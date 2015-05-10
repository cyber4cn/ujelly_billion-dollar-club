<?php
/**
 * Description of Resume
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Admin_Resume extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_Resume";

    const MODE_ADMIN = 1;

    const MODE_SELF = 2;

    public static $mode = 1;

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

    public static function getDegrees()
    {
        return array(
            0  => __("None", WPJB_DOMAIN),
            1  => __("Some High School Coursework", WPJB_DOMAIN),
            2  => __("High School or equivalent", WPJB_DOMAIN),
            3  => __("Certification", WPJB_DOMAIN),
            4  => __("Vocational", WPJB_DOMAIN),
            5  => __("Some College Coursework Completed", WPJB_DOMAIN),
            6  => __("Associate Degree", WPJB_DOMAIN),
            7  => __("Bachelors Degree", WPJB_DOMAIN),
            8  => __("Masters Degree", WPJB_DOMAIN),
            9  => __("Doctorate", WPJB_DOMAIN),
            19 => __("Professional", WPJB_DOMAIN),
        );
    }

    public static function getExperience()
    {
        return array(
            0  => __("No Work Experience", WPJB_DOMAIN),
            1  => __("Less than 1 Year", WPJB_DOMAIN),
            2  => __("1+ to 2 Years", WPJB_DOMAIN),
            3  => __("2+ to 3 Years", WPJB_DOMAIN),
            4  => __("3+ to 5 Years", WPJB_DOMAIN),
            5  => __("5+ to 7 Years", WPJB_DOMAIN),
            6  => __("7+ to 10 Years", WPJB_DOMAIN),
            7  => __("10+ to 15 Years", WPJB_DOMAIN),
            8  => __("More than 15 Years", WPJB_DOMAIN),
        );

    }
    
    public function init()
    {
        $this->addGroup("default", __("Personal Information", WPJB_DOMAIN));
        $this->addGroup("resume", __("Resume", WPJB_DOMAIN));
        $this->addGroup("fields", __("Additional Fields", WPJB_DOMAIN));

        $e = new Daq_Form_Element("firstname");
        $e->setLabel(__("First Name", WPJB_DOMAIN));
        $e->setRequired(true);
        $e->setValue($this->_object->firstname);
        $this->addElement($e, "default");
        
        $e = new Daq_Form_Element("lastname");
        $e->setLabel(__("Last Name", WPJB_DOMAIN));
        $e->setRequired(true);
        $e->setValue($this->_object->lastname);
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("country", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Country", WPJB_DOMAIN));
        $e->setValue($this->_object->country ? $this->_object->country : wpjb_locale());
        foreach(Wpjb_List_Country::getAll() as $listing) {
            $e->addOption($listing['code'], $listing['code'], $listing['name']);
        }
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("address");
        $e->setValue($this->_object->address);
        $e->setLabel(__("Address", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(null, 250));
        $this->addElement($e, "default");
        
        $e = new Daq_Form_Element("email");
        $e->setRequired(true);
        $e->setLabel(__("Email Address", WPJB_DOMAIN));
        $e->setHint(__('This field will be shown only to registered employers.', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Email());
        $e->setValue($this->_object->email);
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("phone");
        $e->setLabel(__("Phone Number", WPJB_DOMAIN));
        $e->setHint(__('This field will be shown only to registered employers.', WPJB_DOMAIN));
        $e->setValue($this->_object->phone);
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("website");
        $e->setLabel(__("Website", WPJB_DOMAIN));
        $e->setHint(__('This field will be shown only to registered employers.', WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Url());
        $e->setValue($this->_object->website);
        $this->addElement($e, "default");
        
        $e = new Daq_Form_Element("is_active", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setLabel(__("Is Resume Active", WPJB_DOMAIN));
        $e->setHint(__("If resume is inactive employers won't find you search results.", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $e->setValue($this->_object->is_active);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e, "default");

        $e = new Daq_Form_Element_File("image", Daq_Form_Element::TYPE_FILE);
        $e->setLabel(__("Your Photo", WPJB_DOMAIN));
        $e->setHint(__("Max. file size 30 kB. Image size 100x100 px. File formats *.jpg; *.gif; *.png .", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_File_Default());
        $e->addValidator(new Daq_Validate_File_Ext("jpg,jpeg,gif,png"));
        $e->addValidator(new Daq_Validate_File_Size(30000));
        $e->addValidator(new Daq_Validate_File_ImageSize(100, 100));
        $this->addElement($e, "default");
        
        $e = new Daq_Form_Element_File("file", Daq_Form_Element::TYPE_FILE);
        $e->setLabel(__("File", WPJB_DOMAIN));
        $e->setHint(__("Allowed Formats: pdf; doc; docx; rtf; txt.", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_File_Default());
        $e->addValidator(new Daq_Validate_File_Ext("pdf,doc,docx,rtf,txt"));
        $this->addElement($e, "default");

        $e = new Daq_Form_Element("title");
        $e->setLabel(__("Professional Headline", WPJB_DOMAIN));
        $e->setHint(__("Describe yourself in few words, for example: Experienced Web Developer", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(1, 120));
        $e->setValue($this->_object->title);
        $this->addElement($e, "resume");

        $e = new Daq_Form_Element("category_id", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Category", WPJB_DOMAIN));
        $e->setValue($this->_object->category_id);
        $e->addValidator(new Daq_Validate_Db_RecordExists("Wpjb_Model_Category", "id"));
        foreach($this->_getCategoryArr() as $category) {
            $e->addOption($category->id, $category->id, $category->title);
        }
        $this->addElement($e, "resume");

        $e = new Daq_Form_Element("headline", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setLabel(__("Profile Summary", WPJB_DOMAIN));
        $e->setHint(__("Use this field to list your skills, specialities, experience or goals", WPJB_DOMAIN));
        $e->setValue($this->_object->headline);
        $this->addElement($e, "resume");

        $e = new Daq_Form_Element("years_experience", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Experience Summary", WPJB_DOMAIN));
        $e->setValue($this->_object->years_experience);
        foreach(self::getExperience() as $k => $v) {
            $e->addOption($k, $k, $v);
        }
        $this->addElement($e, "resume");

        $e = new Daq_Form_Element("experience", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setLabel(__("Experience", WPJB_DOMAIN));
        $e->setHint(__("List companies you worked for (remember to include: company name, time period, your position and job description)", WPJB_DOMAIN));
        $e->setValue($this->_object->experience);
        $this->addElement($e, "resume");
        
        $e = new Daq_Form_Element("degree", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Degree", WPJB_DOMAIN));
        $e->setValue($this->_object->degree);
        foreach(self::getDegrees() as $k => $v) {
            $e->addOption($k, $k, $v);
        }
        $this->addElement($e, "resume");

        $e = new Daq_Form_Element("education", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setLabel(__("Education", WPJB_DOMAIN));
        $e->setHint(__("Your education, describe schools you attended, time period, degree and fields of study", WPJB_DOMAIN));
        $e->setValue($this->_object->education);
        $this->addElement($e, "resume");

        if(self::$mode == self::MODE_ADMIN) {
            $e = new Daq_Form_Element("is_approved", Daq_Form_Element::TYPE_SELECT);
            $e->setLabel(__("Resume Status", WPJB_DOMAIN));
            $e->addOption(Wpjb_Model_Resume::RESUME_PENDING, Wpjb_Model_Resume::RESUME_PENDING, __("Pending Approval", WPJB_DOMAIN));
            $e->addOption(Wpjb_Model_Resume::RESUME_DECLINED, Wpjb_Model_Resume::RESUME_DECLINED, __("Declined", WPJB_DOMAIN));
            $e->addOption(Wpjb_Model_Resume::RESUME_APPROVED, Wpjb_Model_Resume::RESUME_APPROVED, __("Approved", WPJB_DOMAIN));
            $e->setValue($this->_object->is_approved);
            $e->addFilter(new Daq_Filter_Int());
            $this->addElement($e, "admin");
        }

        $this->_additionalFields();

        apply_filters("wpja_form_init_resume", $this);

        $this->setModifiedScheme(Wpjb_Project::getInstance()->conf("form_admin_resume", true));
    }

    public function isValid($values)
    {
        $isValid = parent::isValid($values);

        $ext = null;
        if($this->hasElement("image")) {
            $ext = $this->getElement("image")->getExt();
        }
        
        $value = $this->getValues();

        if($ext) {
            $e = new Daq_Form_Element("image_ext");
            $e->setValue($ext);
            $this->addElement($e);
        }

        return $isValid;
    }

    public function save()
    {
        $image = null;
        if($this->hasElement("image")) {
            $image = $this->getElement("image");
        }
        
        $file = null;
        if($this->hasElement("file")) {
            $file = $this->getElement("file");
        }

        $valueList = $this->getValues();
        parent::save();
        $this->_saveAdditionalFields($valueList);

        if($image && $image->fileSent()) {
            $image->setDestination(Wpjb_List_Path::getPath("resume_photo"));
            $image->upload("photo_".$this->getObject()->getId().".".$image->getExt());
        }
        if($file && $file->fileSent()) {
            $file->setDestination(Wpjb_List_Path::getPath("resume_photo"));
            $file->upload("file_".$this->getObject()->getId().".".$file->getExt());
        }

        apply_filters("wpja_form_save_resume", $this);

        $this->reinit();
    }


    protected function _additionalFields()
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")->from("Wpjb_Model_AdditionalField t")
            ->joinLeft("t.value t2", "job_id=".$this->getObject()->getId())
            ->where("t.field_for = 3")
            ->where("t.is_active = 1")
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
            ->where("field_for = 3")
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

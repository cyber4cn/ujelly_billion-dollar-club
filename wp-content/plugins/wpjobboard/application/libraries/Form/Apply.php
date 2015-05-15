<?php
/**
 * Description of Apply
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Apply extends Daq_Form_ObjectAbstract
{
    private $_add = array();

    private $_userId = null;

    private $_jobId = null;

    private $_files = array();

    protected $_model = "Wpjb_Model_Application";

    public function getUserId()
    {
        return $this->_userId;
    }

    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function getJobId()
    {
        return $this->_jobId;
    }

    public function setJobId($jobId)
    {
        $this->_jobId = $jobId;
    }


    public function init()
    {
        $this->addGroup("apply", "Apply");

        $e = new Daq_Form_Element("applicant_name", Daq_Form_Element::TYPE_TEXT);
        $e->addFilter(new Daq_Filter_Trim());
        $e->setLabel(__("Your name", WPJB_DOMAIN));
        $e->setRequired(true);
        $this->addElement($e, "apply");

        $e = new Daq_Form_Element("email", Daq_Form_Element::TYPE_TEXT);
        $e->setLabel(__("Your e-mail address", WPJB_DOMAIN));
        $e->setRequired(true);
        $e->addValidator(new Daq_Validate_Email());
        $this->addElement($e, "apply");
        
        $e = new Daq_Form_Element_File("cv_file", Daq_Form_Element::TYPE_FILE);
        $e->setDestination(Wpjb_List_Path::getPath("apply_file"));
        $e->setLabel(__("Your CV file", WPJB_DOMAIN));
        $this->addElement($e, "apply");

        $resume = Wpjb_Model_Resume::current();
        $isEmp = get_user_meta(wp_get_current_user()->ID, "is_employer", true);
        if(($resume->id>0 && !$isEmp) || is_admin()) {
            $e = new Daq_Form_Element("resume_id", Daq_Form_Element::TYPE_CHECKBOX);
            $e->setLabel(__("Send my profile resume", WPJB_DOMAIN));
            $id = $resume->id;
            $e->addOption($id, $id, "");
            $e->addValidator(new Daq_Validate_InArray(array($id)));
            $this->addElement($e, "apply");
        }
        
        $e = new Daq_Form_Element("resume", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setLabel(__("Your resume/message", WPJB_DOMAIN));
        $this->addElement($e, "apply");

        $this->_additionalFields();
        
        if(Wpjb_Project::getInstance()->conf("front_enable_protection")==1) {
            $e = new Daq_Form_Element("protection", Daq_Form_Element::TYPE_HIDDEN);
            $e->addValidator(new Daq_Validate_InArray(array(Wpjb_Project::getInstance()->conf("front_protection", "pr0t3ct1on"))));
            $e->setRequired(true);
            $this->addElement($e, "hidden");
        } elseif(Wpjb_Project::getInstance()->conf("front_enable_protection")==2) {
            $e = new Daq_Form_Element("recaptcha_response_field");
            $e->setRequired(true);
            $e->addValidator(new Daq_Validate_Callback("wpjb_recaptcha_check"));
            $e->setRenderer("wpjb_recaptcha_form");
            $e->setLabel(__("Captcha", WPJB_DOMAIN));
            $this->addElement($e, "apply");
        }
        
        apply_filters("wpjb_form_init_apply", $this);

        $this->setModifiedScheme(Wpjb_Project::getInstance()->conf("form_apply_for_job", true));
    }

    protected function _additionalFields()
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")->from("Wpjb_Model_AdditionalField t")
            ->where("field_for = 2")
            ->where("is_active = 1")
            ->execute();

        foreach($result as $field) {

            if($field->type == Daq_Form_Element::TYPE_FILE) {
                $e = new Daq_Form_Element_File("field_".$field->getId(), Daq_Form_Element::TYPE_FILE);
            } else {
                $e = new Daq_Form_Element("field_".$field->getId(), $field->type);
            }
            $e->setLabel($field->label);
            $e->setHint($field->hint);

            if($field->type == Daq_Form_Element::TYPE_FILE) {
                $e->setDestination(Wpjb_List_Path::getPath("apply_file"));
            } else {
                $this->_add[] = "field_".$field->getId();
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

            $this->addElement($e, "apply");
        }
    }

    public function _isValid($values)
    {
        if($this->hasElement("resume_id") && 
            is_numeric($values["resume_id"])) {
            $this->getElement("resume_id")->setValue($values["resume_id"]);
            $isValid = $this->getElement("resume_id")->validate();
        } else {
            $isValid = parent::isValid($values);
            $e = __("You have to send CV file if you want to leave this field empty", WPJB_DOMAIN);

            if($this->hasElement("cv_file") && $this->hasElement("cv_text")) {
                $file = $this->getElement("cv_file");
                $text = $this->getElement("cv_text");
                if(!$file->fileSent() && strlen(trim($text->getValue()))==0) {
                    $this->getElement("cv_text")->pushError($e);

                    return false;
                }
            }
        }

        return $isValid;
    }

    public function _getFiles()
    {
        $fArr = array();
        foreach($this->_field as $field) {
            if($field->getType() == Daq_Form_Element::TYPE_FILE) {
                $fArr[] = $field;
            }
        }
        return $fArr;
    }

    public function getAdditionalText()
    {
        return $this->_add;
    }

    protected function _saveAdditionalFields(array $valueList)
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")
            ->from("Wpjb_Model_AdditionalField t")
            ->where("field_for = 2")
            ->where("is_active = 1")
            ->execute();

        $query = new Daq_Db_Query();
        $fieldValue = $query->select("*")
            ->from("Wpjb_Model_FieldValue t")
            ->where("job_id = ?", $this->getObject()->getId())
            ->execute();

        foreach($result as $option) {
            $id = "field_".$option->getId();
            $value = $valueList[$id];
            
            if($option->type == Daq_Form_Element::TYPE_FILE) {
                continue;
            }
            
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

    protected function _quickAdd($name, $value)
    {
        $e = new Daq_Form_Element($name);
        $e->setValue($value);
        $this->addElement($e);
    }

    public function save()
    {
        $this->_quickAdd("applied_at", date("Y-m-d H:i:s"));
        $this->_quickAdd("job_id", $this->getJobId());
        $this->_quickAdd("user_id", $this->getUserId());

        $valueList = $this->getValues();

        foreach($this->_object->getFieldNames() as $f) {
            if(isset($valueList[$f])) {
                $this->_object->$f = $valueList[$f];
            }
        }

        $this->_object->save();
        
        $this->_saveAdditionalFields($valueList);
        $this->_saveFiles();

        apply_filters("wpjb_form_save_apply", $this);

        // reinit() form manually!
    }

    protected function _saveFiles()
    {
        $file = array();
        $application = $this->getObject();
        if($this->hasElement("resume_id")) {
            $resume_id = $this->getElement("resume_id")->getValue();
        }
        $name = $this->getElement("applicant_name")->getValue();

        $destination = Wpjb_List_Path::getPath("apply_file")."/".$application->id;
        if(!is_dir($destination)) {
            mkdir($destination);
        }
        foreach($this->_getFiles() as $f) {
            if($f->fileSent()) {
                /* @var $f Daq_Form_Element_File */
                $f->setDestination($destination);
                $this->_files[] = $f->upload();
            }
        }
        if(isset($resume_id) && is_numeric($resume_id)) {
            $filename = sanitize_file_name($name.".html");
            $resume = new Wpjb_Model_Resume($resume_id);
            $rendered = $resume->renderHTML();
            file_put_contents($destination."/".$filename, $rendered);
            $this->_files[] = $destination."/".$filename;
        }
    }

    public function getFiles()
    {
        return $this->_files;
    }
}

?>
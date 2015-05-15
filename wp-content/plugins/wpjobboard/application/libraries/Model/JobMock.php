<?php
/**
 * Description of JobMock
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_JobMock extends Wpjb_Model_Job
{
    public function save()
    {
        throw new Exception("JobMock cannot be saved!");
    }

    public function delete()
    {
        throw new Exception("JobMock cannot be deleted!");
    }

    public function setType(Wpjb_Model_JobType $type)
    {
        $this->_loaded["Wpjb_Model_JobType"] = $type;
    }

    public function setCategory(Wpjb_Model_Category $category)
    {
        $this->_loaded["Wpjb_Model_Category"] = $category;
    }

    public function setAdditionalFields(array $fields)
    {
        $this->_fields = array();
        $this->_textareas = array();

        foreach($fields as $field) {
            if($field->getField()->type != Daq_Form_Element::TYPE_TEXTAREA) {
                $this->_fields[] = $field;
            } else {
                $this->_textareas[] = $field;
            }
        }
    }

    public function getImageUrl()
    {
        if($this->hasImage()) {
            $url = site_url();
            $url.= "/wp-content/plugins/wpjobboard";
            $url.= Wpjb_List_Path::getRawPath("tmp_images");
            $url.= "/temp_".session_id().".".$this->company_logo_ext;
            return $url;
        }
        return null;
    }

    public function getFields()
    {
        return $this->_fields;
    }

    public function getTextareas()
    {
        return $this->_textareas;
    }
    
    public function getFieldValue($id)
    {
        foreach($this->getFields() as $field) {
            if($field->id == $id) {
                return $field->value;
            }
        }
        
        return null;
    }
}

?>
<?php
/**
 * Description of Application
 *
 * @author greg
 * @package
 */

class Wpjb_Model_Application extends Daq_Db_OrmAbstract
{
    protected $_name = "wpjb_application";

    protected $_fields = array();

    protected $_textareas = array();

    protected function _init()
    {
        $this->_reference["job"] = array(
            "localId" => "job_id",
            "foreign" => "Wpjb_Model_Job",
            "foreignId" => "id",
            "type" => "ONE_TO_ONE"
        );
    }

    public function addFile($file)
    {
        $path = Wpjb_List_Path::getPath("apply_file");
        $path.= "/".$this->id."/";

        if(!is_dir($path)) {
            mkdir($path);
        }
        
        copy($file, $path.basename($file));
    }

    public function getFiles()
    {
        $path = Wpjb_List_Path::getPath("apply_file");
        $path.= "/".$this->id."/";

        $files = glob($path."*");

        if(!is_array($files)) {
            return array();
        }

        $fArr = array();
        foreach($files as $file) {
            $f = new stdClass;
            $f->basename = basename($file);
            $f->url = rtrim(site_url(), "/")."/wp-content/plugins/wpjobboard";
            $f->url.= Wpjb_List_Path::getRawPath("apply_file")."/";
            $f->url.= $this->getId()."/".$f->basename;
            $f->size = filesize($file);
            $f->ext = pathinfo($file, PATHINFO_EXTENSION);
            $f->dir = $file;
            $fArr[] = $f;
        }

        return $fArr;
    }
    
    public function _loadAdditionalFields()
    {
        $query = new Daq_Db_Query();
        $fields = $query->select("*")
            ->from("Wpjb_Model_FieldValue t")
            ->join("t.field t3")
            ->where("t3.field_for = 2")
            ->where("t3.is_active = 1")
            ->where("t.job_id = ?", $this->getId())
            ->execute();

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
    
    public function getFields()
    {
        if($this->_fields == null) {
            $this->_loadAdditionalFields();
        }
        return $this->_fields;
    }

    public function getNonEmptyFields()
    {
        $fields = $this->getFields();
        $fArr = array();
        foreach($fields as $field) {
            /* @var $field Wpjb_Model_FieldValue */
            $value = trim($field->getTextValue());
            if(!empty($value)) {
                $fArr[] = $field;
            }
        }
        return $fArr;
    }

    public function getTextareas()
    {
        if($this->_textareas == null) {
            $this->_loadAdditionalFields();
        }
        return $this->_textareas;
    }

    public function getNonEmptyTextareas()
    {
        $textareas = $this->getTextareas();
        $fArr = array();
        foreach($textareas as $field) {
            /* @var $field Wpjb_Model_FieldValue */
            $value = trim($field->value);
            if(!empty($value)) {
                $fArr[] = $field;
            }
        }
        return $fArr;
    }
}

?>
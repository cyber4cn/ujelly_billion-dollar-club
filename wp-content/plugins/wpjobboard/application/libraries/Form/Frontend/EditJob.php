<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EditJob
 *
 * @author greg
 */
class Wpjb_Form_Frontend_EditJob extends Wpjb_Form_AbstractJob
{
    protected $_model = "Wpjb_Model_Job";

    public function  __construct($id, $exclude = true)
    {
        parent::__construct($id, $exclude);
    }

    public function init()
    {
        parent::init();

        $this->addGroup("other", "Other");

        $e = new Daq_Form_Element("is_filled", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setLabel(__("Is Filled", WPJB_DOMAIN));
        $e->setValue($this->getObject()->is_filled);
        $e->addOption(1, 1, __("Yes, this position is taken", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e, "other");

        apply_filters("wpja_form_init_editjob", $this);

        $this->setModifiedScheme(Wpjb_Project::getInstance()->conf("form_add_job", true));
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
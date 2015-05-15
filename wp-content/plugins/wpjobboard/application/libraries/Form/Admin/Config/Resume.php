<?php
/**
 * Description of PayPal
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Admin_Config_Resume extends Daq_Form_Abstract
{

    public $name = null;
    
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
    
    public function init()
    {
        $this->name = __("Resumes Settings", WPJB_DOMAIN);
        $instance = Wpjb_Project::getInstance();

        $e = new Daq_Form_Element("cv_enabled", Daq_Form_Element::TYPE_CHECKBOX);
        $e->setValue($instance->getConfig("cv_enabled"));
        $e->setLabel(__("Enable 'Resumes' Module", WPJB_DOMAIN));
        $e->setHint(__("If NOT checked, users won't be able to post resumes and employers won't be able to browse them", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addOption(1, 1, "Yes");
        $this->addElement($e);

        $e = new Daq_Form_Element("cv_access", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($instance->getConfig("cv_access"));
        $e->setLabel(__("Grant Resumes Access", WPJB_DOMAIN));
        $e->setHint(__("Note that automatically activating employer accounts might cause, potential security issue for employers since anyone will be able to browse their personal data", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addOption(1, 1, __("To all", WPJB_DOMAIN));
        $e->addOption(4, 4, __("To registered members", WPJB_DOMAIN));
        $e->addOption(2, 2, __("To activated employers", WPJB_DOMAIN));
        $e->addOption(3, 3, __("To premium employers", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("cv_privacy", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($instance->getConfig("cv_privacy"));
        $e->setLabel(__("Resumes Privacy", WPJB_DOMAIN));
        $e->addOption(0, 0, __("Hide contact details only.", WPJB_DOMAIN));
        $e->addOption(1, 1, __("Hide resume list and details", WPJB_DOMAIN));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("cv_approval", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($instance->getConfig("cv_approval"));
        $e->setLabel(__("Resumes Approval", WPJB_DOMAIN));
        $e->setHint("");
        $e->addValidator(new Daq_Validate_InArray(array(0,1)));
        $e->addOption(0, 0, __("Instant", WPJB_DOMAIN));
        $e->addOption(1, 1, __("By Administrator", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("cv_access_cost");
        $e->setValue($instance->getConfig("cv_access_cost"));
        $e->setLabel(__("Resumes Access Cost", WPJB_DOMAIN));
        $e->setHint(__("How much do you want to charge premium members.", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Float());
        $e->addValidator(new Daq_Validate_Float(0));
        $this->addElement($e);

        $e = new Daq_Form_Element("cv_access_curr", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($instance->getConfig("cv_access_curr"));
        $e->setLabel(__("Resumes Cost Currency", WPJB_DOMAIN));
        $e->setHint(__("Currency for 'Resumes Access Cost'", WPJB_DOMAIN));
        foreach($this->_currArr() as $c) {
            $e->addOption($c[0], $c[1], $c[2]);
        }
        $this->addElement($e);

        $e = new Daq_Form_Element("cv_extend");
        $e->setValue($instance->getConfig("cv_extend"));
        $e->setLabel(__("Grant Access", WPJB_DOMAIN));
        $e->setHint(__("Number of days premium member will have access to resumes after purchase.", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addValidator(new Daq_Validate_Int(0));
        $this->addElement($e);

        apply_filters("wpja_form_init_config_resume", $this);

    }
}

?>
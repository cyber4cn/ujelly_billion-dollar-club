<?php
/**
 * Description of Config
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Config extends Wpjb_Controller_Admin
{
    public function indexAction()
    {

    }

    public function editAction()
    {
        $section = $this->_request->getParam("section");
        $this->view->section = $section;

        $fArr = array("payment", "posting", "frontend", "seo", "integration", "resume");
        $fList = array();

        if($section === null || !in_array($section, $fArr)) {
            foreach($fArr as $key) {
                $class = "Wpjb_Form_Admin_Config_".ucfirst($key);
                $fList[$key] = new $class;
            }
        } else {
            $class = "Wpjb_Form_Admin_Config_".ucfirst($section);
            $fList[$section] = new $class;
        }

        if($this->isPost() && apply_filters("_wpjb_can_save_config", $this)) {
            $isValid = true;
            foreach($fList as $k => $obj) {
                if(!$obj->isValid($this->_request->getAll())) {
                    $isValid = false;
                }
                $fList[$k] = $obj;
            }
            if($isValid) {
                $instance = Wpjb_Project::getInstance();
                foreach($fList as $k => $obj) {
                    // @todo: save config
                    foreach($obj->getValues() as $k => $v) {
                        $instance->setConfigParam($k, $v);
                    }
                }
                $instance->saveConfig();
                $this->_addInfo(__("Configuration saved.", WPJB_DOMAIN));
            } else {
                $this->_addError(__("There are errors in the form.", WPJB_DOMAIN));
            }
        }

        if($this->_request->getParam("saventest")) {
            $list = new Daq_Db_Query();
            $list->select("*");
            $list->from("Wpjb_Model_Job t");
            $list->limit(1);
            $result = $list->execute();
            
            if(empty($result)) {
                $this->_addError(__("Twitter: You need to have at least one posted job to send test tweet.", WPJB_DOMAIN));
            } else {
                $job = $result[0];
                try {
                    Wpjb_Service_Twitter::tweet($job);
                    $this->_addInfo(__("Tweet has been posted, please check your Twitter account.", WPJB_DOMAIN));
                } catch(Exception $e) {
                    $this->_addError($e->getMessage());
                }
            }
        }
        
        $this->view->fList = $fList;
    }
}

?>
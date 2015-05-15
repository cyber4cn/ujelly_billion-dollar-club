<?php
/**
 * Description of ${name}
 *
 * @author ${user}
 * @package 
 */

class Wpjb_Module_Admin_VisualEditor extends Wpjb_Controller_Admin
{
    public function init()
    {

    }

    private function _sort($a, $b)
    {
        if($a["order"]>$b["order"]) {
            return 1;
        } elseif($a["order"]==$b["order"]) {
            return 0;
        } else {
            return -1;
        }
    }

    private function _getGroup()
    {
        $group = $this->_request->getParam("group");

        uasort($group, array($this, "_sort"));
        foreach($group as $key => $gr) {
            $element = $gr["element"];
            if(is_array($element)) {
                uasort($element, array($this, "_sort"));
            }
            $group[$key]["element"] = $element;
        }

        return $group;
    }

    public function indexAction()
    {
        
    }

    public function editAction()
    {
        switch($this->_request->get("form")) {
            case "apply" : $this->_handle("Wpjb_Form_Apply", "form_apply_for_job"); break;
            case "resume": $this->_handle("Wpjb_Form_Admin_Resume", "form_admin_resume"); break;
            default: $this->_handle("Wpjb_Form_AddJob", "form_add_job");
        }
        
    }

    private function _handle($form, $param)
    {
        $this->_forced($form);

        if($this->isPost() && $this->hasParam("reset")) {
            $conf = Wpjb_Project::getInstance();
            $conf->setConfigParam($param, null);
            $conf->saveConfig();
            $this->view->_flash->addInfo(__("Form layout has been reseted.", WPJB_DOMAIN));
        }
        elseif($this->isPost()) {
            $conf = Wpjb_Project::getInstance();
            $conf->setConfigParam($param, $this->_getGroup());
            $conf->saveConfig();
            $this->view->_flash->addInfo(__("Form layout has been saved.", WPJB_DOMAIN));
        }

        $form = new $form(null, false);
        $this->view->scheme = $form->getFinalScheme();
        //print_r($this->view->scheme);
    }

    private function _forced($form)
    {
        $arr = array(
            "Wpjb_Form_Apply" => array(),
            "Wpjb_Form_Admin_Resume" => array(),
            "Wpjb_Form_AddJob" => array("job_type", "job_category", "category_id")
        );

        $this->view->forced = $arr[$form];
    }
}

?>

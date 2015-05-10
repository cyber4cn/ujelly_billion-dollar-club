<?php
/**
 * Description of JobBoardMenu
 *
 * @author greg
 * @package
 */

class Wpjb_Widget_Alerts extends Daq_Widget_Abstract
{
    public function __construct() 
    {
        $this->_context = Wpjb_Project::getInstance();
        $this->_viewAdmin = "alerts.php";
        $this->_viewFront = "alerts.php";
        
        parent::__construct(
            "wpjb-widget-alerts", 
            __("Job Alerts", WPJB_DOMAIN),
            array("description"=>__("Allows to create new job alert", WPJB_DOMAIN))
        );
    }
    
    public function update($new_instance, $old_instance) 
    {
	$instance = $old_instance;
	$instance['title'] = htmlspecialchars($new_instance['title']);
	$instance['hide'] = (int)($new_instance['hide']);
        return $instance;
    }

    public function _filter()
    {
        $request = Daq_Request::getInstance();
        if($request->post("add_alert", 0)) {
            $form = $this->_addAlert();
            $this->view->form_sent = 1;
            $this->view->is_valid = !$form->hasErrors();
        }
    }

    protected function _addAlert()
    {
        $request = Daq_Request::getInstance();
        $form = new Wpjb_Form_Alert();

        if($form->isValid($request->getAll())) {
            $alert = new Wpjb_Model_Alert();
            $alert->created_at = date("Y-m-d H:i:s");
            $alert->keyword = $request->post("keyword");
            $alert->email = $request->post("email");
            $alert->is_active = 1;
            $alert->save();
        }

        return $form;
    }
}

?>
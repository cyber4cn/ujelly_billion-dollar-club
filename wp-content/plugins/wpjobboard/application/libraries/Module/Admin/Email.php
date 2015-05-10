<?php
/**
 * Description of Email
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Email extends Wpjb_Controller_Admin
{
    protected $_mailList = null;

    public function __construct()
    {
        $this->_init();
        parent::__construct();
    }

    public function _init()
    {
        $this->_mailList = array(

        );
        $this->view->mailList = $this->_mailList;
    }

    public function indexAction()
    {
        $query = new Daq_Db_Query();
        $data = $query->select("t1.*")->from("Wpjb_Model_Email t1")->order("sent_to")->execute();
        $item = array();
        
        foreach($data as $d) {
            if(!isset($item[$d->sent_to]) || !is_array($item[$d->sent_to])) {
                $item[$d->sent_to] = array();
            }
            $item[$d->sent_to][] = $d;
        }
        
        $desc = array(
            1 => __("Emails sent to admin (emails are sent From and To email address specified in Mail From field)", WPJB_DOMAIN),
            2 => __("Emails sent to job poster (to email address specified in Company Email field)", WPJB_DOMAIN),
            3 => __("Other Emails", WPJB_DOMAIN)
        );
        
        $this->view->desc = $desc;
        $this->view->data = $item;
    }

    public function editAction()
    {
        $form = new Wpjb_Form_Admin_Email($this->_request->getParam("id"));
        $this->view->id = $this->_request->getParam("id");
        if($this->isPost()) {
            $isValid = $form->isValid($this->_request->getAll());
            if($isValid) {
                $this->_addInfo(__("Email Template saved.", WPJB_DOMAIN));
                $form->save();
            } else {
                $this->_addError(__("There are errors in the form.", WPJB_DOMAIN));
            }
        }

        $this->view->form = $form;
    }
}

?>
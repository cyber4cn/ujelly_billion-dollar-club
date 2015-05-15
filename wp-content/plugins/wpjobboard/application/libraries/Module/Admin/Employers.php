<?php
/**
 * Description of Employers
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Employers extends Wpjb_Controller_Admin
{

    public function init()
    {
       $this->_virtual = array(
            "editAction" => array(
                "form" => "Wpjb_Form_Admin_Company",
                "info" => __("Form saved.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "activate" => array(
                    "success" => __("Number of activated employer accounts: {success}", WPJB_DOMAIN)
                ),
                "deactivate" => array(
                    "success" => __("Number of deactivated employer accounts: {success}", WPJB_DOMAIN)
                )
            )
       );

       if(Wpjb_Project::getInstance()->conf("cv_access")==2) {
           $this->_virtual['_multi']['approve'] = array('success' => __("Number of approved employer accounts: {success}", WPJB_DOMAIN));
           $this->_virtual['_multi']['decline'] = array('success' => __("Number of declined employer accounts: {success}", WPJB_DOMAIN));
       }
    }
    
    public function indexAction()
    {
        $this->_multi();

        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $perPage = $this->_getPerPage();

        $perPage = $this->_getPerPage();
        $query = new Daq_Db_Query();
        $query->select()
            ->from("Wpjb_Model_Employer t")
            ->join("t.users u")
            ->join("t.usermeta um")
            ->where("um.meta_key = ?", "is_employer")
            ->where("um.meta_value > 0");

        $prep = clone $query;

        $show = $this->_request->get("show", "all");
        if($show == "pending") {
            $query->where("t.is_active=?", 2);
        }
        
        $total = $query->select("COUNT(*) AS `totoal`")->fetchColumn();

        $this->view->data = $query->select("*")->limitPage($page, $perPage)->execute();
        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);

        $prep->select("COUNT(*) AS cnt")->limit(1);

        $total = clone $prep;
        $pending = clone $prep;

        $this->view->show = $show;

        $stat = new stdClass();
        $stat->total = $total->where("jobs_posted > 0")->fetchColumn();
        $stat->pending = $pending->where("t.is_active=?", 2)->fetchColumn();
        $this->view->stat = $stat;

        $this->view->qstring = "";

    }

    protected function _multiActivate($id)
    {
        $object = new Wpjb_Model_Employer($id);
        $object->is_active = Wpjb_Model_Employer::ACCOUNT_ACTIVE;
        $object->save();
        return true;
    }
    
    protected function _multiDeactivate($id)
    {
        $object = new Wpjb_Model_Employer($id);
        $object->is_active = Wpjb_Model_Employer::ACCOUNT_INACTIVE;
        $object->save();
        return true;
    }

    protected function _multiApprove($id)
    {
        $object = new Wpjb_Model_Employer($id);
        $object->is_active = Wpjb_Model_Employer::ACCOUNT_FULL_ACCESS;
        $object->save();
        return true;
    }

    protected function _multiDecline($id)
    {
        $object = new Wpjb_Model_Employer($id);
        $object->is_active = Wpjb_Model_Employer::ACCOUNT_DECLINED;
        $object->save();
        return true;
    }



}

?>

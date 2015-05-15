<?php
/**
 * Description of Index
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Job extends Wpjb_Controller_Admin
{
    public function init()
    {
       $this->_virtual = array(
            "editAction" => array(
                "form" => "Wpjb_Form_Admin_AddJob",
                "info" => __("Form saved.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_delete" => array(
                "model" => "Wpjb_Model_Job",
                "info" => __("Job deleted.", WPJB_DOMAIN),
                "error" => __("Job could not be deleted.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "delete" => array(
                    "success" => __("Number of deleted jobs: {success}", WPJB_DOMAIN)
                ),
                "activate" => array(
                    "success" => __("Number of activated jobs: {success}", WPJB_DOMAIN)
                ),
                "deactivate" => array(
                    "success" => __("Number of deactivated jobs: {success}", WPJB_DOMAIN)
                ),
                "approve" => array(
                    "success" => __("Number of approved jobs: {success}", WPJB_DOMAIN)
                )
            ),
            "_multiDelete" => array(
                "model" => "Wpjb_Model_Job"
            )
        );
    }

    private function _employers()
    {
        
    }

    public function indexAction()
    {
        $this->_delete();
        $this->_multi();
        $this->_employers();

        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $perPage = $this->_getPerPage();
        $qstring = array();

        $employer = 0;
        if($this->_request->get("employer") > 0) {
            $emp = new Wpjb_Model_Employer($this->_request->get("employer"));
            if($emp->getId() > 0) {
                $employer = $emp->getId();
                $this->view->company = $emp;
                $this->view->repr = $emp->getUsers(true);
                $qstring['employer'] = $employer;
            }
        }

        $show = $this->_request->get("show", "all");
        $days = $this->_request->post("days", null);
        if($days === null) {
            $days = $this->_request->get("days", "");
        }

        $query1 = new Daq_Db_Query();
        $query1->select("*")->from("Wpjb_Model_Job t1")
            ->join("t1.category t2")
            ->join("t1.type t3");

        $query2 = new Daq_Db_Query();
        $query2->select("COUNT(*) AS total")
            ->from("Wpjb_Model_Job t1")
            ->join("t1.category t2")
            ->join("t1.type t3");

        if($show == "active") {
            $query1->where("t1.is_active = 1");
            $query1->where("(t1.job_created_at > DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)");
            $query1->orWhere("t1.job_visible = 0)");
            $query2->where("t1.is_active = 1");
            $query2->where("(t1.job_created_at > DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)");
            $query2->orWhere("t1.job_visible = 0)");
        } elseif($show == "inactive") {
            $query1->where("t1.is_active = 0");
            $query1->orWhere("(t1.job_created_at < DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)");
            $query1->Where("t1.job_visible > 0)");
            $query2->where("t1.is_active = 0");
            $query2->orWhere("(t1.job_created_at < DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)");
            $query2->Where("t1.job_visible > 0)");
        } elseif($show == "awaiting") {
            $query1->where("t1.is_approved = 0");
            $query1->where("t1.is_active = 0");
            $query2->where("t1.is_approved = 0");
            $query2->where("t1.is_active = 0");
        }

        if(is_numeric($days)) {
            $query1->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
            $query2->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
        }
        if($employer > 0) {
            $query1->where("t1.employer_id = ?", $employer);
            $query2->where("t1.employer_id = ?", $employer);
        }

        $result = $query1
            ->order("t1.job_created_at DESC")
            ->limitPage($page, $perPage)
            ->execute();

        $total = $query2
            ->limit(1)
            ->fetchColumn();

        $this->view->employer = $employer;

        $this->view->days = $days;
        $this->view->show = $show;
        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);
        $this->view->data = $result;

        $query = new Daq_Db_Query();
        $list = array(
            "COUNT(*) AS c_total",
            "SUM(t1.is_approved) AS c_awaiting"
        );
        $query->select(join(", ", $list));
        $query->from("Wpjb_Model_Job t1");

        if(is_numeric($days)) {
            $query->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
            $qstring['days'] = $days;
        }
        if($employer > 0) {
            $query->where("t1.employer_id = ?", $employer);
        }
        $summary1 = $query->fetch();

        $query = new Daq_Db_Query();
        $query = $query->select("COUNT(*) AS c_active")
            ->from("Wpjb_Model_Job t1")
            ->where("t1.is_active = 1")
            ->where("t1.is_approved = 1")
            ->where("(t1.job_created_at > DATE_SUB(NOW(), INTERVAL t1.job_visible DAY)")
            ->orWhere("t1.job_visible = 0)");

        if(is_numeric($days)) {
            $query->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
        }
        if($employer > 0) {
            $query->where("t1.employer_id = ?", $employer);
        }

        $summary2 = $query->fetch();

        $stat = new stdClass;
        $stat->total = $summary1->c_total;
        $stat->active = $summary2->c_active;
        $stat->inactive = $summary1->c_total - $summary2->c_active;
        $stat->awaiting = $summary1->c_total - $summary1->c_awaiting;

        $this->view->stat = $stat;

        $qs = "";
        foreach($qstring as $k => $v) {
            $qs.= $k."/".esc_html((string)$v);
        }
        $this->view->qstring = $qs;

    }

    public function editAction()
    {
        if($this->_request->post("remove_image") == 1) {
            $id = $this->_request->post("id");
            $job = new Wpjb_Model_Job($id);
            $job->deleteImage();
            $job->save();
            
            Wpjb_Form_Admin_AddJob::$isAdmin = true;
            $form = new Wpjb_Form_Admin_AddJob($id);
            $form->init();
            $this->view->form = $form;
            Wpjb_Form_Admin_AddJob::$isAdmin = false;
        } else {
            Wpjb_Form_Admin_AddJob::$isAdmin = true;
            parent::editAction();
            Wpjb_Form_Admin_AddJob::$isAdmin = false;
        }
    }

    public function introAction()
    {
        
    }

    protected function _multiActivate($id)
    {
        $object = new Wpjb_Model_Job($id);
        $object->is_approved = 1;
        $object->is_active = 1;
        $object->save();
        return true;
    }

    protected function _multiDeactivate($id)
    {
        $object = new Wpjb_Model_Job($id);
        $object->is_active = 0;
        $object->save();
        return true;
    }

    protected function _multiApprove($id)
    {
        $object = new Wpjb_Model_Job($id);
        $object->is_approved = 1;
        $object->save();
        return true;
    }
}

?>
<?php
/**
 * Description of Resumes
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Resumes extends Wpjb_Controller_Admin
{

    public function init()
    {
       $this->_virtual = array(
            "editAction" => array(
                "form" => "Wpjb_Form_Admin_Resume",
                "info" => __("Resume has been saved.", WPJB_DOMAIN),
                "error" => __("There are errors in the form.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "approve" => array(
                    "success" => __("Number of approved resumes: {success}", WPJB_DOMAIN)
                ),
                "decline" => array(
                    "success" => __("Number of declined resumes: {success}", WPJB_DOMAIN)
                )
            )
       );
    }

    public function indexAction()
    {
        $this->_multi();
        $object = Wpjb_Model_Resume::current();

        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $perPage = $this->_getPerPage();

        $query = new Daq_Db_Query();
        $query->select()->from("Wpjb_Model_Resume t")
            ->join("t.users t2")
            ->order("t.updated_at DESC");

        $prep = clone $query;

        $show = $this->_request->get("show", "all");
        if($show == "pending") {
            $query->where("t.is_approved=?", Wpjb_Model_Resume::RESUME_PENDING);
        }

        $count = $query->select("COUNT(*) AS cnt")->limit(1)->fetchColumn();

        $result = $query
            ->select("*")
            ->limitPage($page, $perPage)
            ->execute();

        $this->view->data = $result;

        $prep->select("COUNT(*) AS cnt")->limit(1);

        $total = clone $prep;
        $active = clone $prep;

        $this->view->show = $show;

        $stat = new stdClass();
        $stat->total = $total->fetchColumn();
        $stat->pending = $active->where("t.is_approved=?", Wpjb_Model_Resume::RESUME_PENDING)->fetchColumn();
        $this->view->stat = $stat;

        $this->view->current = $page;
        $this->view->total = ceil($stat->total/$perPage);
    }

    protected function _multiApprove($id)
    {
        $object = new Wpjb_Model_Resume($id);
        $object->is_approved = Wpjb_Model_Resume::RESUME_APPROVED;
        $object->save();
        return true;
    }

    protected function _multiDecline($id)
    {
        $object = new Wpjb_Model_Resume($id);
        $object->is_approved = Wpjb_Model_Resume::RESUME_DECLINED;
        $object->save();
        return true;
    }
    
    public function editAction()
    {
        if($this->_request->post("remove_image") == 1) {
            $id = $this->_request->post("id");
            $resume = new Wpjb_Model_Resume($id);
            $resume->deleteImage();
            $resume->save();

            $form = new Wpjb_Form_Admin_Resume($id);
            $form->init();
            $this->view->form = $form;
        } elseif($this->_request->post("remove_file") == 1) {
            $id = $this->_request->post("id");
            $resume = new Wpjb_Model_Resume($id);
            $resume->deleteFile();

            $form = new Wpjb_Form_Admin_Resume($id);
            $form->init();
            $this->view->form = $form;
        } else {
            parent::editAction();
        }
    }

}

?>
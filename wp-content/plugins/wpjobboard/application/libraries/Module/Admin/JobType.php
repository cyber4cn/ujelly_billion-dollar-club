<?php
/**
 * Description of JobType
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_JobType extends Wpjb_Controller_Admin
{
    public function init()
    {
        $this->_virtual = array(
            "editAction" => array(
                "form" => "Wpjb_Form_Admin_JobType",
                "info" => __("Form saved.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_delete" => array(
                "model" => "Wpjb_Model_JobType",
                "info" => __("Job Type deleted.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "delete" => array(
                    "success" => __("Number of deleted job types: {success}", WPJB_DOMAIN)
                ),
                "activate" => array(
                    "success" => __("Number of activated job types: {success}", WPJB_DOMAIN)
                ),
                "deactivate" => array(
                    "success" => __("Number of deactivated job types: {success}", WPJB_DOMAIN)
                )
            ),
        );
    }

    protected function _multiDelete($id)
    {
        $query = new Daq_Db_Query();
        $total = $query->select("COUNT(*) AS cnt")
            ->from("Wpjb_Model_Job")
            ->where("job_type = ?", $id)
            ->fetchColumn();

        if($total > 0) {
            $err = __("Cannot delete job type identified by ID #{id}. There are still jobs using this type.", WPJB_DOMAIN);
            $err = str_replace("{id}", $id, $err);
            $this->view->_flash->addError($err);
            return false;
        }

        try {
            $model = new Wpjb_Model_JobType($id);
            $model->delete();
            return true;
        } catch(Exception $e) {
            // log error
            return false;
        }
    }

    public function indexAction()
    {
        $this->_delete();
        $this->_multi();

        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $perPage = $this->_getPerPage();

        $sq1 = new Daq_Db_Query();
        $sq1->select("count(*) AS `c_all`")->from("Wpjb_Model_Job t2")->where("t2.job_type=t1.id");

        $sq2 = new Daq_Db_Query();
        $sq2->select("count(*) AS `c_active`")->from("Wpjb_Model_Job t3")
            ->where("t3.job_type=t1.id")
            ->where("t3.is_active = 1")
            ->where("t3.is_approved = 1")
            ->where("(t3.job_created_at > DATE_SUB(NOW(), INTERVAL t3.job_visible DAY)")
            ->orWhere("t3.job_visible = 0)");

        $query = new Daq_Db_Query();
        $result = $query->select("t1.*, (".$sq1->toString().") AS `c_all`, (".$sq2->toString().")  AS `c_active`")
            ->from("Wpjb_Model_JobType t1")
            ->limitPage($page, $perPage);

        $result = $query->execute();

        $total = (int)$query->select("COUNT(*) as `total`")->limit(1)->fetchColumn();

        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);
        $this->view->data = $result;
    }
    
}

?>
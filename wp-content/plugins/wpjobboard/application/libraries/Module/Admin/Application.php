<?php
/**
 * Description of Category
 *
 * @author greg
 * @package
 */

class Wpjb_Module_Admin_Application extends Wpjb_Controller_Admin
{
    public function init()
    {
        $this->_virtual = array(
            "editAction" => array(
                "form" => "Wpjb_Form_Admin_Application",
                "info" => __("Form saved.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_delete" => array(
                "model" => "Wpjb_Model_Application",
                "info" => __("Application deleted.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "delete" => array(
                    "success" => __("Number of deleted applications: {success}", WPJB_DOMAIN)
                )
            ),
            "_multiDelete" => array(
                "model" => "Wpjb_Model_Application"
            )
        );
    }

    protected function _multiDelete($id)
    {
        extract($this->_virtual[__FUNCTION__]);
        
        try {
            $model = new $model($id);
            $model->delete();

            $job = new Wpjb_Model_Job($model->job_id);
            $job->stat_apply--;
            $job->save();
            
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
        $qstring = array();

        $sq1 = new Daq_Db_Query();
        $sq1->select("count(*) AS `c_all`")->from("Wpjb_Model_Job t2")->where("t2.job_category=t1.id");

        $query = new Daq_Db_Query();
        $query->select("*");
        $query->from("Wpjb_Model_Application t");
        $query->join("t.job t2");
        $query->order("is_rejected ASC, applied_at DESC");
        $query->limitPage($page, $perPage);

        if($this->_request->get("job") > 0) {
            $jId = $this->_request->get("job");
            $query->where("job_id = ?", $jId);
            $this->view->job = new Wpjb_Model_Job($jId);
            $qstring["job"] = $jId;
        }

        $result = $query->execute();
        $total = (int)$query->select("COUNT(*) as `total`")->limit(1)->fetchColumn();

        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);
        $this->view->data = $result;

        $qs = "";
        foreach($qstring as $k => $v) {
            $qs.= $k."/".esc_html((string)$v);
        }
        $this->view->qstring = $qs;
    }

    protected function _delete()
    {
        extract($this->_virtual[__FUNCTION__]);
        
        if($this->isPost() && $this->hasParam("delete")) {
            $id = $this->_request->post("id", 0);
            try {
                $model = new $model($id);
                $job = new Wpjb_Model_Job($model->job_id);
                $model->delete();
                $job->stat_apply--;
                $job->save();
                $this->_addInfo($info);
            } catch(Exception $e) {
                $this->_addError($e->getMessage());
                // @todo: logging
            }
        }
    }
}

?>
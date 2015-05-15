<?php
/**
 * Description of Employer
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Employer extends Wpjb_Controller_Admin
{

    public function init()
    {
       $this->_virtual = array(
            "editAction" => array(
                "form" => "Wpjb_Form_Admin_AddJob",
                "info" => __("Form saved.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "filled" => array(
                    "success" => __("Number of jobs set to filled: {success}", WPJB_DOMAIN)
                ),
                "unfilled" => array(
                    "success" => __("Number of jobs set to NOT filled: {success}", WPJB_DOMAIN)
                )
            )
       );
    }

    protected function _multiFilled($id)
    {
        $object = new Wpjb_Model_Job($id);
        $object->is_filled = 1;
        $object->save();
        return true;
    }

    protected function _multiUnfilled($id)
    {
        $object = new Wpjb_Model_Job($id);
        $object->is_filled = 1;
        $object->save();
        return true;
    }



    public function editAction()
    {
        $id = $this->_request->get("id");
        $job = new Wpjb_Model_Job($id);

        if($job->employer_id != Wpjb_Model_Employer::current()->getId()) {
            $this->_addError(__("You do not have access to this page.", WPJB_DOMAIN));
            $this->view->revoke_access = true;
            return;
        }

        if(!Wpjb_Project::getInstance()->conf("front_allow_edition")) {
            $this->_addError(__("Administrator does not allow job postings edition.", WPJB_DOMAIN));
            $this->view->revoke_access = true;
            return;
        }

        if($this->_request->post("remove_image") == 1) {
            $job->deleteImage();
            $job->save();

            $form = new Wpjb_Form_Admin_AddJob($id);
            $this->view->form = $form;
        } else {
            parent::editAction();
        }
    }

    public function companyAction()
    {
        $object = Wpjb_Model_Employer::current();

        if($this->_request->post("remove_image") == 1) {
            $this->_addInfo(__("Image removed.", WPJB_DOMAIN));
            $object->deleteImage();
            $object->save();
        }

        $form = new Wpjb_Form_Admin_Company($object->getId(), Wpjb_Form_Admin_Company::MODE_SELF);
        if($this->isPost() && !$this->_request->post("remove_image")) {
            $isValid = $form->isValid($this->_request->getAll());
            if($isValid) {
                $this->_addInfo(__("Company profile saved.", WPJB_DOMAIN));
                $form->save();
            } else {
                $this->_addError(__("Cannot save profile information. There are errors in your form.", WPJB_DOMAIN));
            }
        }

        $this->view->form = $form;

    }

    public function indexAction()
    {
        $this->_multi();

        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $perPage = $this->_getPerPage();

        $show = $this->_request->get("show", "all");
        $days = $this->_request->post("days", null);
        if($days === null) {
            $days = $this->_request->get("days", "");
        }

        // list my job ads
        $query = new Daq_Db_Query();
        $query->select()->from("Wpjb_Model_Job t1")
            ->where("employer_id = ?", Wpjb_Model_Employer::current()->getId())
            ->order("t1.job_created_at DESC");

        if(Wpjb_Project::getInstance()->conf("front_hide_filled")) {
            $actAdd = " AND is_filled = 0";
            $expAdd = " AND is_filled = 1";
        } else {
            $actAdd = "";
            $expAdd = "";
        }

        if(is_numeric($days)) {
            $query->where("t1.job_created_at > DATE_SUB(NOW(), INTERVAL ? DAY)", $days);
        }

        $activeQ = "(t1.job_created_at > DATE_SUB(NOW(), INTERVAL t1.job_visible DAY) OR t1.job_visible = 0) AND t1.is_active = 1 $actAdd";
        $expiredQ = "((t1.job_created_at < DATE_SUB(NOW(), INTERVAL t1.job_visible DAY) AND  t1.job_visible <> 0) $expAdd)";
        $awaitingQ = "t1.is_approved = 0";

        $prep = clone $query;

        if($show == "active") {
            $query->where($activeQ);
        } elseif($show == "expired") {
            $query->where($expiredQ);
        } elseif($show == "awaiting") {
            $query->where($awaitingQ);
        }

        $count = $query->select("COUNT(*) AS cnt")->limit(1)->fetchColumn();

        $result = $query
            ->select("*")
            ->limitPage($page, $perPage)
            ->execute();

        $this->view->data = $result;

        $this->view->days = $days;
        $this->view->show = $show;
        $this->view->current = $page;
        $this->view->total = ceil($count/$perPage);
        $this->view->data = $result;

        $stat = new stdClass();

        $prep->select("COUNT(*) AS cnt")->limit(1);
        $total = clone $prep;
        $active = clone $prep;
        $expired = clone $prep;
        $awaiting = clone $prep;

        $stat->total = $total->fetchColumn();
        $stat->active = $active->where($activeQ)->fetchColumn();
        $stat->expired = $expired->where($expiredQ)->fetchColumn();
        $stat->awaiting = $awaiting->where($awaitingQ)->fetchColumn();

        $this->view->stat = $stat;
    }

    protected function _register()
    {
        // request employer account
        $object = Wpjb_Model_Employer::current();
        $this->view->object = $object;

        if($object->is_active == Wpjb_Model_Employer::ACCOUNT_REQUEST) {
            $this->view->already_requested = true;
            $this->_addInfo(__("You already requested employer account.", WPJB_DOMAIN));
            return;
        } elseif($object->is_active == Wpjb_Model_Employer::ACCOUNT_INACTIVE) {
            $this->view->already_requested = true;
            $this->_addError(__("Your employer account has been deactivated. Contact Administrator for more information.", WPJB_DOMAIN));
            return;
        } else {
            $this->view->already_requested = false;
        }

        if($object->is_active == 3) {
            $this->_addError(__("Your request has been declined, please update your profile and re-submit request", WPJB_DOMAIN));
        }

        if($this->_request->getParam("request_employer")) {
            $object->is_active = 2;
            $object->save();
            $this->view->request_sent = true;
        }

    }

    protected function _activeUntil()
    {
        $activeUntil = Wpjb_Model_Employer::current()->access_until;
        $activeUntil = strtotime($activeUntil);

        if($activeUntil<time()) {
            $activeUntil = time();
        }

        $extend = Wpjb_Project::getInstance()->conf("cv_extend")*3600*24;

        return $activeUntil+$extend;

    }

    protected function _premium()
    {
        $object = Wpjb_Model_Employer::current();
        $buy = (int)$this->_request->get("purchase", 0);

        $curr = Wpjb_List_Currency::getCurrencySymbol(Wpjb_Project::getInstance()->conf("cv_access_curr"));
        $this->view->payment = $curr.number_format(Wpjb_Project::getInstance()->conf("cv_access_cost"), 2);
        $this->view->active_until = $this->_activeUntil();

        if($buy != 1) {
            return;
        }

        $access = new Wpjb_Model_ResumesAccess();
        $access->employer_id = Wpjb_Model_Employer::current()->getId();
        $access->extend = Wpjb_Project::getInstance()->conf("cv_extend");
        $access->created_at = date("Y-m-d H:i:s");
        $access->save();

        $payment = new Wpjb_Model_Payment();
        $payment->object_type = Wpjb_Model_Payment::FOR_RESUMES;
        $payment->object_id = $access->getId();
        $payment->user_id = $access->employer_id;
        $payment->engine = "PayPal";
        $payment->payment_currency = Wpjb_Project::getInstance()->conf("cv_access_curr");
        $payment->payment_sum = Wpjb_Project::getInstance()->conf("cv_access_cost");
        $payment->payment_paid = 0;
        $payment->save();

        $paypal = new Wpjb_Payment_PayPal($payment);
        $this->view->paypal = $paypal;
        $this->view->purchase = 1;


        

    }

    public function accessAction()
    {
        $object = Wpjb_Model_Employer::current();
        $access = Wpjb_Project::getInstance()->conf("cv_access");

        if($access == 2) {
            $this->_register();
        } elseif($access == 3) {
            $this->_premium();
        }

        $this->view->access = $access;
    }
}

?>
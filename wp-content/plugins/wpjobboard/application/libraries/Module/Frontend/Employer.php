<?php
/**
 * Description of AddJob
 *
 * @author greg
 * @package
 */

class Wpjb_Module_Frontend_Employer extends Wpjb_Controller_Frontend
{

    protected $_employer = null;

    private function _setTitle($text, $param = array())
    {
        $k = array();
        $v = array();
        foreach($param as $key => $value) {
            $k[] = "{".$key."}";
            $v[] = $value;
        }

        Wpjb_Project::getInstance()->title = rtrim(str_replace($k, $v, $text))." ";
    }

    /**
     * 
     * @return Wpjb_Model_Employer
     */
    protected function _employer()
    {
        if(!$this->_employer) {
            $this->_employer = Wpjb_Model_Employer::current();
        }

        return $this->_employer;
    }

    protected function _isLoggedIn()
    {
        return Wpjb_Model_Employer::current()->isEmployer();
    }
    
    protected function _isCandidate()
    {
        $id = wp_get_current_user()->ID;
        $isCand = $id && !get_user_meta($id, "is_employer");
        if($isCand) {
            $err = __("You need 'Employer' account in order to access this page. Currently you are logged in as Candidate.", WPJB_DOMAIN);
            $this->_setTitle(__("Incorrect account type", WPJB_DOMAIN));
            $this->view->_flash->addError($err);
        }
        return $isCand;
    }

    public function newAction()
    {
        if(!get_option('users_can_register')) {
            $this->view->_flash->addError(__("User registration is disabled.", WPJB_DOMAIN));
            return false;
        }
        
        if($this->_isCandidate()) {
            return false;
        }

        if($this->_isLoggedIn()) {
            wp_redirect(wpjb_link_to("employer_panel"));
            return;
        }
        
        if(Wpjb_Model_Employer::current()->isEmployer()) {
            $this->view->_flash->addError(__("You need to be registered as Candidate in order to access this page. Your current account type is Employer.", WPJB_DOMAIN));
            return false;
        }

        $this->_setTitle(__("Register Employer", WPJB_DOMAIN));

        $form = new Wpjb_Form_Frontend_Register();
        $this->view->errors = array();

        if($this->isPost()) {
            $isValid = $form->isValid($this->getRequest()->getAll());
            if($isValid) {
                
                $username = $form->getElement("user_login")->getValue();
                $password = $form->getElement("user_password")->getValue();
                $email = $form->getElement("user_email")->getValue();
                $id = wp_create_user($username, $password, $email);
                $val = $form->getValues();

                update_usermeta($id, "is_employer", 1);

                $employer = new Wpjb_Model_Employer();
                $employer->user_id = $id;
                $employer->company_name = $val["company_name"];
                $employer->company_website = $val["company_website"];
                $employer->company_info = $val["company_info"];
                $employer->company_location = $val["company_location"];
                $employer->is_public = $val["is_public"];
                $employer->save();

                $instance = Wpjb_Project::getInstance();
                $router = $instance->getApplication("frontend")->getRouter();
                /* @var $router Daq_Router */
                $url = $instance->getApplication("frontend")->getUrl();
                $url.= "/".$router->linkTo("employer_login");

                $mail = new Wpjb_Utility_Message(9);
                $mail->setTo($email);
                $mail->setParam("username", $username);
                $mail->setParam("password", $password);
                $mail->setParam("login_url", $url);
                $mail->send();

                $form = new Wpjb_Form_Login;
                $form->isValid(array(
                    "user_login" => $username,
                    "user_password" => $password,
                    "remember" => false
                ));
                
                $this->view->_flash->addInfo(__("You have been registered successfully", WPJB_DOMAIN));
                
                $redirect = wpjb_link_to("employer_panel");
                wp_redirect($redirect);
            }
        }

        $this->view->form = $form;
        return "company-new";
    }

    public function loginAction()
    {
        if($this->_isLoggedIn()) {
            wp_redirect(wpjb_link_to("employer_panel"));
            exit;
        }
        
        if($this->_isCandidate()) {
            return false;
        }
        
        $this->_setTitle(__("Employer Login", WPJB_DOMAIN));
        $form = new Wpjb_Form_Login();
        $form->getElement("redirect_to")->setValue(wpjb_link_to("employer_panel"));
        $this->view->errors = array();

        if($this->isPost()) {
            $user = $form->isValid($this->getRequest()->getAll());
            if($user instanceof WP_Error) {
                foreach($user->get_error_messages() as $error) {
                    $this->view->_flash->addError($error);
                }
            } elseif($user === false) {
                $this->view->_flash->addError(__("Incorrect username or password", WPJB_DOMAIN));
            } else {
                $this->view->_flash->addInfo(__("You have been logged in.", WPJB_DOMAIN));
                $redirect = $form->getElement("redirect_to")->getValue();
                wp_redirect($redirect);
                exit;
            }
        }

        $this->view->form = $form;

        return "company-login";
    }

    public function panelactiveAction()
    {
        if($this->_isCandidate()) {
            return false;
        }
        
        $this->_setTitle("Active listings");
        
        if($this->_panel("active") === false) {
            return false;
        }

        $instance = Wpjb_Project::getInstance();
        $router = $instance->getApplication("frontend")->getRouter();
        
        $this->view->cDir = $router->linkTo("employer_panel");
        $this->view->routerIndex = "employer_panel";
        return "company-panel";
    }
    
    public function panelexpiredAction()
    {
        if($this->_isCandidate()) {
            return false;
        }
        
        $this->_setTitle("Expired listings");
        
        if($this->_panel("expired") === false) {
            return false;
        }
        
        $instance = Wpjb_Project::getInstance();
        $router = $instance->getApplication("frontend")->getRouter();
        
        $this->view->cDir = $router->linkTo("employer_panel_expired");
        $this->view->routerIndex = "employer_panel_expired";
        return "company-panel";
    }
    
    public function _panel($browse)
    {
        if(!$this->_isLoggedIn()) {
            $this->view->_flash->addError(__("You are not allowed to access this page.", WPJB_DOMAIN));
            return false;
        }
        
        $filled = $this->_request->getParam("filled", null);
        if($filled) {
            $job = new Wpjb_Model_Job($filled);
            $job->is_filled = 1;
            $job->save();
            $this->view->_flash->addInfo(__("Job status has been changed", WPJB_DOMAIN));
        } 
        
        $filled = $this->_request->getParam("notfilled", null);
        if($filled) {
            $job = new Wpjb_Model_Job($filled);
            $job->is_filled = 0;
            $job->save();
            $this->view->_flash->addInfo(__("Job status has been changed", WPJB_DOMAIN));
        } 
        
        $this->view->browse = $browse;
        
        // count jobs;
        $page = $this->_request->getParam("page", 1);
        $emp = Wpjb_Model_Employer::current();
        
        $query = new Daq_Db_Query();
        $query = $query->select("*");
        $query->from("Wpjb_Model_Job t1");
        $query->where("t1.is_active = 1");
        $query->where("employer_id = ?", $emp->getId());
        $query->order("job_expires_at ASC");
        
        // count expired jobs
        $qCount = clone $query;
        $qCount->where("t1.job_expires_at < ?", date("Y-m-d 23:59:59"));
        $qCount->select("COUNT(*) AS cnt");
        $this->view->expiredCount = (int)$qCount->fetchColumn();
        
        // count active jobs
        $qCount = clone $query;
        $qCount->where("t1.job_expires_at >= ?", date("Y-m-d 23:59:59"));
        $qCount->select("COUNT(*) AS cnt");
        $this->view->activeCount = (int)$qCount->fetchColumn();
        
        if($browse == "expired") {
            $query->where("t1.job_expires_at < ?", date("Y-m-d 23:59:59"));
        } else {
            $query->where("t1.job_expires_at >= ?", date("Y-m-d 23:59:59"));
        }
        
        $qCount = clone $query;
        $qCount->select("COUNT(*) AS cnt");
        $jobCount = $qCount->fetchColumn();
        $this->view->jobCount = ceil($jobCount/20);

        $query->limitPage($page, 20);
        $result = $query->execute();

        $this->view->jobList = $result;
        $this->view->jobPage = $page;

        return "company-panel";
    }

    public function applicationsAction()
    {
        $this->_setTitle(__("Applications", WPJB_DOMAIN));
        
        $job = $this->getObject();
        $emp = $job->getEmployer(true);
        
        if($this->_isCandidate()) {
            return false;
        }
        
        if($emp->user_id < 1 || $emp->user_id != wp_get_current_user()->ID) {
            $this->view->_flash->addError(__("You are not allowed to access this page.", WPJB_DOMAIN));
            return false;
        }

        $this->view->job = $job;

        $query = new Daq_Db_Query();
        $query->select("*");
        $query->from("Wpjb_Model_Application t");
        $query->where("job_id = ?", $job->getId());
        $query->order("is_rejected ASC, applied_at DESC");

        $result = $query->execute();
        $this->view->applicantList = $result;

        return "job-applications";
    }

    public function applicationAction()
    {
        $application = $this->getObject();
        $job = new Wpjb_Model_Job($application->job_id);
        $emp = $job->getEmployer(true);

        if($this->_isCandidate()) {
            return false;
        }
        
        $isOwner = false;
        if($emp->user_id > 0 && $emp->user_id == wp_get_current_user()->ID) {
           $isOwner = true;
        }

        if(!$isOwner && !$this->_isUserAdmin()) {
            $this->view->_flash->addError(__("You are not allowed to access this page.", WPJB_DOMAIN));
            return false;
        }

        $this->_setTitle(__("Application for position: {job_title}", WPJB_DOMAIN), array(
            "job_title" => $job->job_title
        ));
        
        $this->view->application = $application;
        $this->view->job = $job;

        return "job-application";
    }

    public function acceptAction()
    {
        $this->_setStatus(0);
    }

    public function rejectAction()
    {
        $this->_setStatus(1);
    }

    protected function _setStatus($status)
    {
        $application = $this->getObject();
        $job = new Wpjb_Model_Job($application->job_id);
        $emp = $job->getEmployer(true);

        if($emp->user_id < 1 || $emp->user_id != wp_get_current_user()->ID) {
            $this->view->_flash->addError(__("You are not allowed to access this page.", WPJB_DOMAIN));
            return false;
        }

        $application->is_rejected = $status;
        $application->save();

        if($status == 1) {
            $this->view->_flash->addInfo(__("Application was moved to archive.", WPJB_DOMAIN));
        } else {
            $this->view->_flash->addInfo(__("Application was accepted.", WPJB_DOMAIN));
        }

        wp_redirect(wpjb_link_to("job_application", $application));
        exit;
    }

    public function editAction()
    {
        $job = $this->getObject();

        if($this->_isCandidate()) {
            return false;
        }
        
        $this->_setTitle(__("Edit Job", WPJB_DOMAIN));

        if(!Wpjb_Project::getInstance()->conf("front_allow_edition")) {
            $this->view->_flash->addError(__("Administrator does not allow job postings edition.", WPJB_DOMAIN));
            return false;
        }
        if($job->employer_id != Wpjb_Model_Employer::current()->getId()) {
            $this->view->_flash->addError(__("You are not allowed to access this page.", WPJB_DOMAIN));
            return false;
        }

        $form = new Wpjb_Form_Frontend_EditJob($job->getId());
        if($this->isPost()) {
            $isValid = $form->isValid($this->getRequest()->getAll());
            if($isValid) {
                $this->view->_flash->addInfo(__("Job has been saved", WPJB_DOMAIN));
                $form->save();
            } else {
                $this->view->_flash->addError(__("There are errors in your form", WPJB_DOMAIN));
            }
        }

        $this->view->form = $form;

        return "job-edit";
    }

    public function employereditAction()
    {
        
        if($this->_isCandidate()) {
            return false;
        }
        
        if(!$this->_isLoggedIn()) {
            $this->view->_flash->addError(__("You are not allowed to access this page.", WPJB_DOMAIN));
            return false;
        }
        
        $this->_setTitle(__("Company Profile", WPJB_DOMAIN));

        $emp = Wpjb_Model_Employer::current();
        $form = new Wpjb_Form_Frontend_Company($emp->id);
        $this->view->company = $emp;

        if($this->isPost()) {
            if(!$form->isValid($this->getRequest()->getAll())) {
               $this->view->_flash->addError(__("There are errors in your form.", WPJB_DOMAIN));
            } else {
               $this->view->_flash->addInfo(__("Company information has been saved.", WPJB_DOMAIN));
               $form->save();
            }
        }

        $this->view->form = $form;

        return "company-edit";
    }

    public function accessAction()
    {
        if(!$this->_isLoggedIn()) {
            $this->view->_flash->addError(__("You are not allowed to access this page.", WPJB_DOMAIN));
            return false;
        }
        
        if($this->_isCandidate()) {
            return false;
        }

        $this->_setTitle(__("About Resumes Access", WPJB_DOMAIN));

        $object = Wpjb_Model_Employer::current();
        $access = Wpjb_Project::getInstance()->conf("cv_access");

        if($access == 2) {
            $this->_accessRequest();
        } elseif($access == 3) {
            $this->_premiumRequest();
            $this->_setTitle(__("Purchase Resumes Access", WPJB_DOMAIN));
        }

        $this->view->access = $access;

        return "company-access";
    }

    protected function _accessRequest()
    {
        // request employer account
        $object = $this->_employer();
        $this->view->object = $object;

        if($object->is_active == Wpjb_Model_Employer::ACCOUNT_REQUEST) {
            $this->view->already_requested = true;
            $this->view->_flash->addInfo(__("You already requested employer account.", WPJB_DOMAIN));
            return;
        } elseif($object->is_active == Wpjb_Model_Employer::ACCOUNT_INACTIVE) {
            $this->view->already_requested = true;
            $this->view->_flash->addError(__("Your employer account has been deactivated. Contact Administrator for more information.", WPJB_DOMAIN));
            return;
        } else {
            $this->view->already_requested = false;
        }

        if($object->is_active == Wpjb_Model_Employer::ACCOUNT_DECLINED) {
            $this->view->_flash->addError(__("Your request has been declined, please update your profile and re-submit request", WPJB_DOMAIN));
        }

        if($this->_request->getParam("request_employer")) {
            $object->is_active = 2;
            $object->save();
            $this->view->request_sent = true;
            $this->_setTitle(__("Request has been sent", WPJB_DOMAIN));
            
            $url = rtrim(site_url(), "/");
            $url.= "/wp-admin/admin.php?page=wpjb/employers&action=edit/id/";
            $url.= $object->id;
            
            $mail = new Wpjb_Utility_Message(12);
            $mail->setParams($object->toArray());
            $mail->setParam("company_admin_url", $url);
            $mail->setTo($mail->getTemplate()->mail_from);
            $mail->send();
        }
    }

    protected function _premiumRequest()
    {
        $object = Wpjb_Model_Employer::current();
        $buy = (int)$this->_request->post("purchase", 0);

        $curr = Wpjb_List_Currency::getCurrencySymbol(Wpjb_Project::getInstance()->conf("cv_access_curr"));
        $this->view->payment = $curr.number_format(Wpjb_Project::getInstance()->conf("cv_access_cost"), 2);
        $this->view->active_until = $this->_activeUntil();

        $this->view->purchase = 0;
        $this->view->form = new Wpjb_Form_Frontend_ResumesAccess;
        
        if(!$this->isPost()) {
            return;
        }
        if(!$this->view->form->isValid($this->getRequest()->getAll())) {
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
        $payment->engine = $this->view->form->getElement("payment_method")->getValue();
        $payment->payment_currency = Wpjb_Project::getInstance()->conf("cv_access_curr");
        $payment->payment_sum = Wpjb_Project::getInstance()->conf("cv_access_cost");
        $payment->payment_paid = 0;
        $payment->save();

        $paypal = Wpjb_Payment_Factory::factory($payment);
        $this->view->paypal = $paypal;
        $this->view->purchase = 1;
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

    public function logoutAction()
    {
        $this->view->_flash->addInfo(__("You have been logged out", WPJB_DOMAIN));
        wp_logout();
        wp_redirect(wpjb_url());
        exit;
    }

}

?>

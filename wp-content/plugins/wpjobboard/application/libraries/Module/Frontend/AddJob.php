<?php
/**
 * Description of AddJob
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Frontend_AddJob extends Wpjb_Controller_Frontend
{
    private $_stepAdd = null;


    public function init()
    {
        $this->_stepAdd = Wpjb_Project::getInstance()->getUrl()."/".$this->_getRouter()->linkTo("step_add");
    }

    private function _setTitle($text, $param = array())
    {
        $k = array();
        $v = array();
        foreach($param as $key => $value) {
            $k[] = "{".$key."}";
            $v[] = $value;
        }

        Wpjb_Project::getInstance()->title = " ".trim(str_replace($k, $v, $text))." ";
    }

    private function _canPost()
    {
        $info = wp_get_current_user();
        $isAdmin = true;
        if(!isset($info->wp_capabilities) || !$info->wp_capabilities['administrator']) {
            $isAdmin = false;
        }

        if(!$isAdmin && Wpjb_Project::getInstance()->conf("posting_allow")==3) {
            $this->view->_flash->addError(__("Only Admin can post jobs", WPJB_DOMAIN));
            $this->view->canPost = false;
            $this->view->can_post = false;
            return false;
        }

        $employer = Wpjb_Model_Employer::current();
        if(!$employer->isEmployer() && Wpjb_Project::getInstance()->conf("posting_allow")==2) {
            $this->view->_flash->addError(__("Only registered members can post jobs", WPJB_DOMAIN));
            $this->view->canPost = false;
            $this->view->can_post = false;
            return false;
        }
        
        if($employer->getId()>0 && $employer->is_active == Wpjb_Model_Employer::ACCOUNT_INACTIVE) {
            $this->view->_flash->addError(__("You cannot post jobs. Your account is inactive.", WPJB_DOMAIN));
            $this->view->canPost = false;
            $this->view->can_post = false;
            return false;
        }

        $this->view->canPost = true;
        $this->view->can_post = true;
        return true;
    }

    public function addAction()
    {
        $this->view->current_step = 1;
        $canPost = $this->_canPost();
        if(!$canPost) {
            return false;
        }

        if(!is_user_logged_in() && Wpjb_Project::getInstance()->conf("posting_encourage_reg")) {
            $eUrl = wpjb_link_to("employer_new");
            $m = __("<b>Quick Tip</b>: If you login before posting a job, you will be able to manage all your jobs from <a href=\"{url}\">employer account</a>.", WPJB_DOMAIN);
            $m = str_replace("{url}", $eUrl, $m);
            $this->view->_flash->addInfo($m);
        }

        $query = new Daq_Db_Query;
        $l = $query->select("*")->from("Wpjb_Model_Listing t")->execute();
        $listing = array();
        foreach($l as $li) {
            $listing[$li->getId()] = $li;
        }
        $this->view->listing = $listing;
        
        $form = new Wpjb_Form_AddJob();
        $request = $this->getRequest();
        $request->setSessionParam("wpjb.job_id", null);

        $job = new Wpjb_Model_Job($this->getRequest()->get("republish", null));
        $empId = Wpjb_Model_Employer::current()->getId();
        $arr = array();
        if($request->session("wpjb.reset_job", false)) {
            $ext = $request->session("wpjb.job_logo_ext");
            $request->setSessionParam("wpjb.job", null);
            $request->setSessionParam("wpjb.reset_job", null);
            $request->setSessionParam("wpjb.job_logo_ext", null);
            $file = Wpjb_List_Path::getPath("tmp_images")."/temp_".session_id().".".$ext;
            if(is_file($file)) {
                unlink($file);
            }
        } elseif(($empId > 0 && $job->employer_id == $empId) || current_user_can("manage_options")) {
            $arr = $job->allToArray();
            if($job->hasImage()) {
                $ext = $job->company_logo_ext;
                $path = Wpjb_List_Path::getPath("tmp_images");
                copy($job->getImagePath(), $path."/temp_".session_id().".".$ext);
                $request->setSessionParam("wpjb.job_logo_ext", $ext);
            }
        } elseif($empId > 0 && wp_get_current_user()->ID > 0 && $request->session("wpjb.job")==null) {
            $emp = Wpjb_Model_Employer::current();
            $arr = $emp->toArray();
            $arr['company_email'] = wp_get_current_user()->user_email;
            $arr['job_location'] = $emp->company_location;
            $arr['job_country'] = $emp->company_country;
            $arr['job_state'] = $emp->company_state;
            $arr['job_zip_code'] = $emp->company_zip_code;
            $m = __("<b>Note</b>: Data from your company profile is being used to fill 'Company Information' fields.", WPJB_DOMAIN);
            $this->view->_flash->addInfo($m);
            if($emp->hasImage()) {
                $ext = $emp->company_logo_ext;
                $path = Wpjb_List_Path::getPath("tmp_images");
                copy($emp->getImagePath(), $path."/temp_".session_id().".".$ext);
                $request->setSessionParam("wpjb.job_logo_ext", $ext);
            }

        }

        $jobArr = $request->session("wpjb.job", null);
        if(is_array($jobArr)) {
            if(!$form->isValid($jobArr)) {
                $this->view->_flash->addError(__("There are errors in your form. Please correct them before proceeding", WPJB_DOMAIN));
            }
        } else {
            $form->setDefaults($arr);
        }

        $this->view->form = $form;
    }

    public function previewAction()
    {
        if(!$this->_canPost()) {
            wp_redirect($this->_stepAdd);
        }

        $this->view->current_step = 2;
        $accept = array("company_name", "company_email", "company_website",
            "job_type", "job_category", "job_country", "job_state", "job_zip_code",
            "job_location", "job_title", "job_description"
        );

        $form = new Wpjb_Form_AddJob();
        $request = $this->getRequest();
        $request->setSessionParam("wpjb.job_id", null);
        $jobArr = $request->session("wpjb.job", array());

        if($this->isPost()) {
            if($request->post("wpjb_preview", false)) {
                $jobArr = $request->getAll();
                $request->setSessionParam("wpjb.job", $jobArr);
            }

            if($request->post("wpjb_reset", false)) {
                $request->setSessionParam("wpjb.job", null);
                $request->setSessionParam("wpjb.reset_job", true);
                wp_redirect($this->_stepAdd);
            }
        }

        if(!$form->isValid($jobArr)) {
            wp_redirect($this->_stepAdd);
        } else {

            if($form->hasElement("company_logo")) {
                $file = $form->getElement("company_logo");
                if($file->fileSent()) {

                    $file->setDestination(Wpjb_List_Path::getPath("tmp_images"));
                    $file->upload("temp_".session_id().".".$file->getExt());
                    $request->setSessionParam("wpjb.job_logo_ext", $file->getExt());
                }
            }

            $mock = new Wpjb_Model_JobMock();
            $values = $form->getValues();
            $arr = array();

            foreach($form->getElements() as $f) {
                
                /* @var $f Daq_Form_Element */
                if(stripos($f->getName(), "field_") !== 0) {
                    continue;
                }

                $class = new Wpjb_Model_FieldMock;
                $class->id = str_replace("field_", "", $f->getName());
                $class->is_required = $f->isRequired();
                $class->hint = $f->getHint();
                $class->type = $f->getType();
                $class->label = $f->getLabel();
                $class->value = $f->getValue();
                if($f->isMultiOption()) {
                    foreach((array)$f->getOptions() as $opt) {
                        if($opt["key"] == $f->getValue()) {
                            $class->value = $opt["desc"];
                            break;
                        }
                    }
                }
                $arr[] = $class;
            }

            foreach($accept as $field) {
                $mock->set($field, $values[$field]);
            }
            $mock->set("job_created_at", date("Y-m-d H:i:s"));
            $mock->set("company_logo_ext", $request->session("wpjb.job_logo_ext", null));
            $mock->setType(new Wpjb_Model_JobType($values["job_type"]));
            $mock->setCategory(new Wpjb_Model_Category($values["job_category"]));
            $mock->setAdditionalFields($arr);

            $text = Wpjb_Project::getInstance()->conf("seo_single", __("{job_title}", WPJB_DOMAIN));
            $param = array(
                'job_title' => $values["job_title"],
                'id' => 0
            );

            $this->_setTitle($text, $param);

            $this->view->job = $mock;

            $company = Wpjb_Model_Employer::current();
            if($company->getId()>0) {
                $this->view->company = $company;
            }
        }
    }

    public function saveAction()
    {
        if(!$this->_canPost()) {
            wp_redirect($this->_stepAdd);
        }

        $this->view->current_step = 3;
        $form = new Wpjb_Form_AddJob();
        $request = $this->getRequest();
        $id = $request->session("wpjb.job_id");

        if($id < 1) {
            if($form->isValid($request->session("wpjb.job", array()))) {
                $paymentMethod = $form->getElement("payment_method")->getValue();
                $form->save();
                $job = $form->getObject();
                if(strlen($request->session("wpjb.job_logo_ext"))>0) {
                    $ext = $request->session("wpjb.job_logo_ext");
                    $path1 = Wpjb_List_Path::getPath("tmp_images");
                    $path2 = Wpjb_List_Path::getPath("user_images");
                    $oldName = $path1."/temp_".session_id().".".$ext;
                    $newName = $path2."/job_".$job->getId().".".$ext;
                    $job->company_logo_ext = $ext;
                    $job->save();
                    rename($oldName, $newName);
                }

                if($job->payment_sum>0) {
                    $uid = null;
                    if(wp_get_current_user()->ID > 0) {
                        $uid = wp_get_current_user()->ID;
                    }
                    $payment = new Wpjb_Model_Payment();
                    $payment->user_id = $uid;
                    $payment->object_id = $job->getId();
                    $payment->object_type = Wpjb_Model_Payment::FOR_JOB;
                    $payment->engine = $paymentMethod;
                    $payment->payment_currency = $job->payment_currency;
                    $payment->payment_sum = $job->payment_sum;
                    $payment->payment_paid = 0;
                    $payment->save();
                }

                $request->setSessionParam("wpjb.job", null);
                $request->setSessionParam("wpjb.job_logo_ext", null);
                $request->setSessionParam("wpjb.job_id", $job->getId());
            } else {
                wp_redirect(Wpjb_Project::getInstance()->getUrl()."/".$this->_getRouter()->linkTo("step_add"));
            }
        } else {
            $job = new Wpjb_Model_Job($id);
        }

        if($job->payment_sum > 0) {
            if($job->payment_sum!=$job->payment_paid) {
                $action = "payment_form";
            } else {
                $action = "payment_already_sent";
            }
        } else {
            $action = "job_online";
            if($job->is_active && $job->is_approved) {
                $online = true;
            } else {
                $online = false;
            }
            $this->view->online = $online;
        }

        if($action == "payment_form") {
            $payment = Wpjb_Payment_Factory::factory($job->getPayment(true));
            $this->view->payment = $payment->render();
        }

        $this->view->action = $action;
        $this->view->job = $job;
    }

    public function completeAction()
    {
        if(!$this->_canPost()) {
            wp_redirect($this->_stepAdd);
        }
        $this->view->current_step = 3;
        $this->view->action = "payment_complete";
        return "save";
    }

}

?>
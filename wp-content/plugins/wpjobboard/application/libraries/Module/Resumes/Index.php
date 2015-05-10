<?php
/**
 * Description of ${name}
 *
 * @author ${user}
 * @package 
 */

class Wpjb_Module_Resumes_Index extends Wpjb_Controller_Frontend
{
    private $_query = null;

    private $_perPage = 20;

    public function init()
    {
        $this->_perPage = Wpjb_Project::getInstance()->conf("front_jobs_per_page", 20);
        $this->view->baseUrl = Wpjb_Project::getInstance()->getUrl("resumes");

        $query = new Daq_Db_Query();
        $query->select()
            ->from("Wpjb_Model_Resume t1")
            ->join("t1.users t2")
            ->where("is_active = 1")
            ->order("updated_at DESC");

        if(Wpjb_Project::getInstance()->conf("cv_approval") == 1) {
            $query->where("is_approved = ?", Wpjb_Model_Resume::RESUME_APPROVED);
        }

        $this->_query = $query;
    }

    private function _isEnabled()
    {
        if(Wpjb_Project::getInstance()->conf("cv_enabled") != 1) {
            $this->view->_flash->addError(__("Resumes module is disabled", WPJB_DOMAIN));
            Wpjb_Project::getInstance()->title = "";
            return false;
        }

        return true;
    }

    private function _canBrowse()
    {   
        $this->view->can_browse = true;
        $employer = Wpjb_Model_Employer::current();

        if(Wpjb_Project::getInstance()->conf("cv_access") == 2) {
            if($employer->is_active != Wpjb_Model_Employer::ACCOUNT_FULL_ACCESS) {
                $this->view->_flash->addInfo(__("Only verified employers can see employees contact details", WPJB_DOMAIN));
                $this->view->can_browse = false;
            }
        } elseif(Wpjb_Project::getInstance()->conf("cv_access") == 3) {
            if(strtotime($employer->access_until)<time()) {
                $this->view->_flash->addInfo(__("Only active premium employers can see employees contact details", WPJB_DOMAIN));
                $this->view->can_browse = false;
            }
        } elseif(Wpjb_Project::getInstance()->conf("cv_access") == 4) {
            if(!wp_get_current_user()->ID) {
                $this->view->_flash->addInfo(__("Only registered members can see employees contact details", WPJB_DOMAIN));
                $this->view->can_browse = false;
            }
        } else {
            // grant to all
        }

        if(wp_get_current_user()->has_cap("administrator")) {
            $this->view->can_browse = true;
        }

        return $this->view->can_browse;
    }

    private function _setTitle($text, $param = array())
    {
        $k = array();
        $v = array();
        foreach($param as $key => $value) {
            $k[] = "{".$key."}";
            $v[] = $value;
        }

        Wpjb_Project::getInstance()->title = str_replace($k, $v, $text);
    }

    public function indexAction()
    {
        if(!$this->_isEnabled()) {
            return false;
        }

        $canBrowse = $this->_canBrowse();

        $text = Wpjb_Project::getInstance()->conf("seo_resumes_name", __("Browse Resumes", WPJB_DOMAIN));
        $this->_setTitle($text);

        $query = clone $this->_query;

        $this->view->cDir = "";
        $this->_exec($query);

        if(!$canBrowse && wpjb_conf("cv_privacy", 0)==1) {
            return false;
        }

        return "resumes";
    }

    public function advsearchAction()
    {
        $this->_setTitle(Wpjb_Project::getInstance()->conf("seo_resume_adv_search", __("Advanced Search", WPJB_DOMAIN)));
        $form = new Wpjb_Form_ResumesSearch();

        $this->view->form = $form;
        return "resumes-search";
    }

    public function searchAction()
    {
        $request = $this->getRequest();

        $router = Wpjb_Project::getInstance()->getApplication("resumes")->getRouter();
        $text = Wpjb_Project::getInstance()->conf("seo_search_resumes", __("Search Results: {keyword}", WPJB_DOMAIN));
        $param = array(
            'keyword' => $request->get("query")
        );
        $this->_setTitle($text, $param);

        $query = $request->get("query");
        $category = $request->get("category");
        $degree = $request->get("degree");
        $experience = $request->get("experience");
        $posted = $request->get("posted");
        $count = $this->_perPage;
        $page = $request->get("page", 1);
        
        $search = Wpjb_Model_ResumeSearch::search($query, $category, $degree, $experience, $posted, $count, $page);
        
        $this->view->jobPage = $page;
        $this->view->jobCount = ceil($search->total/$count);
        $this->view->resumeList = $search->resume;
        $this->view->cDir = $router->linkTo("search", null, $param);
        $this->view->qString = $this->getServer("QUERY_STRING");
        
        $canBrowse = $this->_canBrowse();
        if(!$canBrowse && wpjb_conf("cv_privacy", 0)==1) {
            return false;
        }
        
        return "resumes";
        
    }

    public function viewAction()
    {
        if(!$this->_isEnabled()) {
            return false;
        }

        $resume = $this->getObject();
        /* @var $resume Wpjb_Model_Resume */

        if($resume->user_id != wp_get_current_user()->ID) {
            $canBrowse = $this->_canBrowse();
            if(!$canBrowse && wpjb_conf("cv_privacy", 0)==1) {
                return false;
            }
        } else {
            $this->view->can_browse = true;
        }

        $text = Wpjb_Project::getInstance()->conf("seo_resumes_view", __("{full_name}", WPJB_DOMAIN));
        $this->_setTitle($text, array("full_name"=>$resume->firstname." ".$resume->lastname));

        $this->view->resume = $resume;

        return "resume";
    }

    public function myresumeAction()
    {
        $this->_setTitle(Wpjb_Project::getInstance()->conf("seo_resume_my_resume", __("My resume details", WPJB_DOMAIN)));

        if(!$this->_isEnabled()) {
            return false;
        }

        $object = Wpjb_Model_Resume::current();

        if($object->id < 1) {
            $this->view->_flash->addError(__("You need to be logged in to access this page.", WPJB_DOMAIN));
            return false;
        }
        
        if(Wpjb_Model_Employer::current()->isEmployer()) {
            $this->view->_flash->addError(__("You need to be registered as Candidate in order to access this page. Your current account type is Employer.", WPJB_DOMAIN));
            return false;
        }

        if($this->_request->post("remove_image") == 1) {
            $this->view->_flash->addInfo(__("Image removed.", WPJB_DOMAIN));
            $object->deleteImage();
            $object->save();
        }

        $form = new Wpjb_Form_Resume($object->getId());
        if($this->isPost() && !$this->_request->post("remove_image")) {
            $isValid = $form->isValid($this->_request->getAll());
            if($isValid) {
                $this->view->_flash->addInfo(__("Your resume has been saved.", WPJB_DOMAIN));
                $form->save();
            } else {
                $this->view->_flash->addError(__("Cannot save your resume. There are errors in your form.", WPJB_DOMAIN));
            }
        }

        $this->view->resume = $form->getObject();
        $this->view->form = $form;

        return "my-resume";
    }
    
    public function myresumedelAction()
    {
        if(!$this->_isEnabled()) {
            return false;
        }

        $object = Wpjb_Model_Resume::current();

        if($object->id < 1) {
            $this->view->_flash->addError(__("You need to be logged in to access this page.", WPJB_DOMAIN));
            return false;
        }
        
        $object->deleteImage();
        $object->save();
        
        $this->view->_flash->addInfo(__("Profile picture has been deleted", WPJB_DOMAIN));
        
        wp_redirect(wpjr_link_to("myresume"));
        exit;
    }
    
    public function myresumedelfileAction()
    {
        if(!$this->_isEnabled()) {
            return false;
        }

        $object = Wpjb_Model_Resume::current();

        if($object->id < 1) {
            $this->view->_flash->addError(__("You need to be logged in to access this page.", WPJB_DOMAIN));
            return false;
        }
        
        $object->deleteFile();
        $object->save();
        
        $this->view->_flash->addInfo(__("File has been deleted", WPJB_DOMAIN));
        
        wp_redirect(wpjr_link_to("myresume"));
        exit;
    }

    public function loginAction()
    {
        $object = Wpjb_Model_Resume::current();
        if($object->id > 0) {
            wp_redirect(wpjr_link_to("myresume"));
        }

        $this->_setTitle(__("Login", WPJB_DOMAIN));
        $form = new Wpjb_Form_Resumes_Login();
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
            }
        }

        $this->view->form = $form;
        
        return "login";
    }

    public function registerAction()
    {
        if(!get_option('users_can_register')) {
            $this->view->_flash->addError(__("User registration is disabled.", WPJB_DOMAIN));
            return false;
        }

        $object = Wpjb_Model_Resume::current();
        if($object->id > 0) {
            wp_redirect(wpjr_link_to("myresume"));
        }
        
        $this->_setTitle(__("Register", WPJB_DOMAIN));

        $form = new Wpjb_Form_Resumes_Register();
        $this->view->errors = array();

        if($this->isPost()) {
            $isValid = $form->isValid($this->getRequest()->getAll());
            if($isValid) {

                $username = $form->getElement("user_login")->getValue();
                $password = $form->getElement("user_password")->getValue();
                $email = $form->getElement("user_email")->getValue();
                $id = wp_create_user($username, $password, $email);
                
                $instance = Wpjb_Project::getInstance();
                $router = $instance->getApplication("resumes")->getRouter();
                /* @var $router Daq_Router */
                $url = $instance->getApplication("resumes")->getUrl();
                $url.= "/".$router->linkTo("myresume");

                $mail = new Wpjb_Utility_Message(10);
                $mail->setTo($email);
                $mail->setParam("username", $username);
                $mail->setParam("password", $password);
                $mail->setParam("login_url", $url);
                $mail->send();

                $this->view->_flash->addInfo(__("You have been registered.", WPJB_DOMAIN));

                $form = new Wpjb_Form_Resumes_Login();
                $form->isValid(array(
                    "user_login" => $username,
                    "user_password" => $password,
                    "remember" => 0
                ));
                
                $redirect = wpjr_link_to("myresume");
                wp_redirect($redirect);
                die;
            } else {
                $this->view->_flash->addError(__("There are errors in your form.", WPJB_DOMAIN));
            }
        }

        $this->view->form = $form;

        return "register";
    }

    private function _countAll(Daq_Db_Query $query)
    {
        $q = clone $query;
        return (int)$q->select("COUNT(*) AS cnt")->limit(1)->fetchColumn();
    }

    private function _exec(Daq_Db_Query $query)
    {
        $page = $this->_request->getParam("page", 1);

        $this->view->jobPage = $page;
        $this->view->jobCount = ceil($this->_countAll($query)/$this->_perPage);
        $this->view->resumeList = $query->limitPage($page, $this->_perPage)->execute();
    }

}

?>

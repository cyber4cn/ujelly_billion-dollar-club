<?php
/**
 * Description of Index
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Frontend_Index extends Wpjb_Controller_Frontend
{
    private $_query = null;

    private $_perPage = 20;

    public function init()
    {
        $this->_perPage = Wpjb_Project::getInstance()->conf("front_jobs_per_page", 20);
        $this->_query = Wpjb_Model_Job::activeSelect();
        
    }

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

    private function _countAll(Daq_Db_Query $query)
    {
        $q = clone $query;
        return (int)$q->select("COUNT(*) AS cnt")->limit(1)->fetchColumn();
    }

    private function _exec(Daq_Db_Query $query)
    {
        $page = $this->_request->getParam("page", 1);

        // @todo: filter

        $this->view->jobPage = $page;
        $this->view->jobCount = ceil($this->_countAll($query)/$this->_perPage);
        $this->view->jobList = $query->limitPage($page, $this->_perPage)->execute();
    }

    public function indexAction()
    {
        $text = Wpjb_Project::getInstance()->conf("seo_job_board_name", __("Job Board", WPJB_DOMAIN));
        $this->_setTitle($text);
        $router = $this->_getRouter();
        $this->setCanonicalUrl(Wpjb_Project::getInstance()->getUrl());

        $query = clone $this->_query;
        $query->join("t1.category t2")->join("t1.type t3");

        $this->view->cDir = "";
        $this->_exec($query);
    }

    public function companyAction()
    {
        $company = $this->getObject();
        /* @var $company Wpjb_Model_Employer */

        $text = Wpjb_Project::getInstance()->conf("seo_job_employer", __("{company_name}", WPJB_DOMAIN));
        $param = array(
            'company_name' => $this->getObject()->company_name
        );
        $this->_setTitle($text, $param);

        if($company->is_active == Wpjb_Model_Employer::ACCOUNT_INACTIVE) {
            $this->view->_flash->addError(__("Company profile is inactive.", WPJB_DOMAIN));
        } elseif(!$company->is_public) {
            $this->view->_flash->addInfo(__("Company profile is hidden.", WPJB_DOMAIN));
        } elseif(!$company->isVisible()) {
            $this->view->_flash->addError(__("Company profile will be visible once employer will post at least one job.", WPJB_DOMAIN));
            return false;
        }

        $this->view->company = $company;

        $jList = clone $this->_query;
        $jList->order("job_created_at DESC");
        $this->view->jobList = $jList->where("employer_id = ?", $company->getId())->execute();
    }

    public function categoryAction()
    {
        $text = Wpjb_Project::getInstance()->conf("seo_category", __("Category: {category}", WPJB_DOMAIN));
        $param = array(
            'category' => $this->getObject()->title
        );

        $url = Wpjb_Project::getInstance()->getUrl()."/";
        $url.= $this->_getRouter()->linkTo("category", $this->getObject());
        $this->setCanonicalUrl($url);

        $this->view->current_category = $this->getObject();
        $this->_setTitle($text, $param);

        $object = $this->getObject();
        $query = clone $this->_query;
        $query->join("t1.category t2", "t2.id=".$object->getId())->join("t1.type t3");
        $this->view->cDir = Wpjb_Project::getInstance()->router()->linkTo("category", $this->getObject());
        $this->_exec($query);
        return "index";
    }

    public function typeAction()
    {
        $text = Wpjb_Project::getInstance()->conf("seo_job_type", __("Job Type: {type}", WPJB_DOMAIN));
        $param = array(
            'type' => $this->getObject()->title
        );

        $url = Wpjb_Project::getInstance()->getUrl()."/";
        $url.= $this->_getRouter()->linkTo("jobtype", $this->getObject());
        $this->setCanonicalUrl($url);

        $this->view->current_type = $this->getObject();
        $this->_setTitle($text, $param);

        $object = $this->getObject();
        $query = clone $this->_query;
        $query->join("t1.category t2")->join("t1.type t3", "t3.id=".$object->getId());
        $this->view->cDir = Wpjb_Project::getInstance()->router()->linkTo("jobtype", $this->getObject());
        $this->_exec($query);
        return "index";
    }

    public function searchAction()
    {
        $request = $this->getRequest();

        $text = Wpjb_Project::getInstance()->conf("seo_search_results", __("Search Results: {keyword}", WPJB_DOMAIN));
        $param = array(
            'keyword' => $request->get("query")
        );
        $this->_setTitle($text, $param);

        $request = Daq_Request::getInstance();
        
        $param = array(
            "query" => $request->get("query"),
            "category" => $request->get("category"),
            "type" => $request->get("type"),
            "page" => $request->get("page", 1),
            "count" => $request->get("count", 20),
            "country" => $request->get("country"),
            "posted" => $request->get("posted"),
            "location" => $request->get("location"),
            "is_featured" => $request->get("is_featured"),
            "employer_id" => $request->get("employer_id"),
            "field" => $request->get("field", array()),
            "sort" => $request->get("sort"),
            "order" => $request->get("order"),
        );
        
        $result = Wpjb_Model_JobSearch::search($param);

        $this->view->jobPage = $result->page;
        $this->view->jobCount = ceil($result->total/$result->perPage);
        $this->view->jobList = $result->job;
        
        $router = Wpjb_Project::getInstance()->router();
        $this->view->cDir = $router->linkTo("search", null, $param);
        $this->view->qString = $this->getServer("QUERY_STRING");
        
        return "index";
    }

    public function advsearchAction()
    {
        $this->_setTitle(Wpjb_Project::getInstance()->conf("seo_adv_search", __("Advanced Search", WPJB_DOMAIN)));
        $form = new Wpjb_Form_AdvancedSearch();
        
        $this->view->form = $form;
        return "search";
    }

    public function singleAction()
    {
        $this->_setTitle(" ");
        $job = $this->getObject();

        $url = Wpjb_Project::getInstance()->getUrl()."/";
        $url.= $this->_getRouter()->linkTo("job", $job);
        $this->setCanonicalUrl($url);
        
        $show_related = (bool)Wpjb_Project::getInstance()->conf("front_show_related_jobs");
        $this->view->show_related = $show_related;

        if(($job->is_active && $job->is_approved) || $this->_isUserAdmin()) {
            // reload job with category and type
            $query = new Daq_Db_Query();
            $job = $query->select("*")
                ->from("Wpjb_Model_Job t")
                ->join("t.category t2")
                ->join("t.type t3")
                ->where("t.id = ?", $job->getId())
                ->execute();

            $this->view->job = $job[0];
            $job = $job[0];

            $text = Wpjb_Project::getInstance()->conf("seo_single", __("{job_title}", WPJB_DOMAIN));
            $param = array(
                'job_title' => $job->job_title,
                'id' => $job->id
            );
            $this->_setTitle($text, $param);


            $old = Wpjb_Project::getInstance()->conf("front_mark_as_old");

            if($old>0 && time()-strtotime($job->job_created_at)>$old*3600*24) {
                $msg = __("Attention! This job posting is {$old} days old and might be already filled.",WPJB_DOMAIN);
                $this->view->_flash->addInfo($msg);
            }

            if($job->is_filled) {
                $msg = __("This job posting was marked by employer as filled and is probably no longer available", WPJB_DOMAIN);
                $this->view->_flash->addInfo($msg);
            }

            if($job->employer_id > 0) {
                $this->view->company = new Wpjb_Model_Employer($job->employer_id);
            }

            // related jobs
            $related = clone $this->_query;
            /* @var $related Daq_Db_Query */
            $related->join("t1.search t4");
            $q = "MATCH(t4.title, t4.description, t4.location, t4.company)";
            $q.= "AGAINST (? IN BOOLEAN MODE)";
            $related->where($q, $job->job_title);
            $related->where("t1.id <> ?", $job->getId());
            $related->limit(5);

            $this->view->related = $related->execute();
            

        } else {
            // job inactive or not exists
            $msg = __("Selected job is inactive or does not exist", WPJB_DOMAIN);
            $this->view->_flash->addError($msg);
            $this->view->job = null;
            return false;
        }
    }

    public function applyAction()
    {
        $text = Wpjb_Project::getInstance()->conf("seo_apply", __("Apply for position: {job_title} (ID: {id})", WPJB_DOMAIN));
        $param = array(
            'job_title' => $this->getObject()->job_title,
            'id' => $this->getObject()->id
        );
        $this->_setTitle($text, $param);
        
        $job = $this->getObject();
        $this->view->job = $job;

        if(!$this->isMember() && Wpjb_Project::getInstance()->conf("front_apply_members_only", false)) {
            $this->view->members_only = true;
            $this->view->_flash->addError(__("Only registered members can apply for jobs.", WPJB_DOMAIN));
            return;
        }
        
        if($job->job_source == 3) {
            wp_redirect($job->company_website);
        }

        $form = new Wpjb_Form_Apply();
        if($this->isPost()) {
            if($form->isValid($this->getRequest()->getAll())) {
                // send
                $var = $form->getValues();
                $job = $this->getObject();

                $form->setJobId($job->getId());
                $form->setUserId(Wpjb_Model_Resume::current()->user_id);

                $form->save();
                $files = $form->getFiles();
                $application = $form->getObject();

                $mail = new Wpjb_Model_Email(6);
                $append = array(
                    "applicant_email" => $var['email'],
                    "applicant_cv" => $var['resume'],
                    "applicant_name" => $var['applicant_name']
                );
                
                list($title, $body) = Wpjb_Utility_Messanger::parse($mail, $job, $append);
                $add = $form->getAdditionalText();
                if(!empty($add)) {
                    $body .= "\r\n--- --- ---\r\n";
                }
                foreach($add as $field) {

                    if(!$form->hasElement($field)) {
                        continue;
                    }
                    $opt = $form->getElement($field)->getOptions();
                    if(!empty($opt)) {
                        foreach($opt as $o) {
                            if($o["value"] == $form->getElement($field)->getValue()) {
                                $fValue = $o["desc"];
                            }
                        }
                    } else {
                        $fValue = $form->getElement($field)->getValue();
                    }

                    $body .= $form->getElement($field)->getLabel().": ";
                    $body .= $fValue."\r\n";
                }
                $headers = "From: ".$var["applicant_name"]." <".$var["email"].">\r\n";

                $email = $var["email"];

                $title = trim($title);
                if(empty($title)) {
                    $title = __("[Application] ", WPJB_DOMAIN).$var["name"];
                }

                if(apply_filters("wpjb_job_apply", $form) !== true) {
                    wp_mail($job->company_email, $title, $body, $headers, $files);
                }

                $form->reinit();

                $job->stat_apply++;
                $job->save();

                $this->view->application_sent = true;
                $this->view->_flash->addInfo(__("Your application has been sent.", WPJB_DOMAIN));
                Wpjb_Utility_Messanger::send(8, $job, array('applicant_email'=>$var['email']));
            } else {
                $this->view->_flash->addError(__("There are errors in your form.", WPJB_DOMAIN));
            }

        } elseif(Wpjb_Model_Resume::current()->id>0) {
            $resume = Wpjb_Model_Resume::current();
            if($form->hasElement("email")) {
                $form->getElement("email")->setValue($resume->email);
            }
            if($form->hasElement("applicant_name")) {
                $form->getElement("applicant_name")->setValue($resume->firstname." ".$resume->lastname);
            }
        }

        $this->view->form = $form;

    }

    public function deleteAlertAction()
    {
        $hash = $this->_request->getParam("hash");
        $query = new Daq_Db_Query();
        $result = $query->select()->from("Wpjb_Model_Alert t")
            ->where("MD5(CONCAT(id, email)) = ?", $hash)
            ->limit(1)
            ->execute();

        if($result[0]) {
            $alert = $result[0];
            /* @var $alert Wpjb_Model_Alert */
            $alert->is_active = 0;
            $alert->save();

            $this->view->_flash->addInfo(__("Alert deleted. You will no longer receive email alerts.", WPJB_DOMAIN));
        } else {
            $this->view->_flash->addError(__("Alert could not be found.", WPJB_DOMAIN));
        }

        $this->indexAction();
        return "index";
    }
    
    public function paymentAction()
    {
        $payment = $this->getObject();
        $button = Wpjb_Payment_Factory::factory($payment);
        
        $this->_setTitle(__("Payment", WPJB_DOMAIN));
        
        if($payment->payment_sum == $payment->payment_paid) {
            $this->view->_flash->addInfo(__("This payment was already processed correctly.", WPJB_DOMAIN));
            return false;
        }
        
        if($payment->object_type == 1) {
            $this->view->job = new Wpjb_Model_Job($payment->object_id);
        }
        
        $this->view->payment = $payment;
        $this->view->button = $button;
        $this->view->currency = Wpjb_List_Currency::getCurrencySymbol($payment->payment_currency);
    }
    
}

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Resumes
 *
 * @author greg
 */
class Wpjb_Module_AjaxNopriv_Resumes
{
    protected static function _push($object)
    {
        header("Content-type: application/json; charset=utf-8");
        $object->request = $_REQUEST;
        echo json_encode($object);
        die(PHP_EOL);
    }
    
    protected static function _modify(Wpjb_Model_Resume $resume)
    {
        $cb = self::_canBrowse();
        $arr = $resume->allToArray();
        
        $public = array("id", "user_id", "category_id", "title", "firstname", 
            "lastname", "headline", "experience", "education", "country", 
            "address", "email", "phone", "website", "is_active", 
            "degree", "years_experience", "created_at" 
        );

        $publish = new stdClass;
        foreach($public as $k) {
            $publish->$k = $resume->$k; 
        }
        
        foreach($arr as $k => $a) {
            if(substr($k, 0, 6) == "field_") {
                $publish->$k = $a;
            }
        }
        
        if(!$cb) {
            $private = array("address", "email", "phone", "website");
            foreach($private as $p) {
                $publish->$p = null;
            }
        }
        
        $t = strtotime($resume->updated_at);
        if($t <= strtotime("1970-01-01 00:00:00")) {
            $t = __("never", WPJB_DOMAIN);
        } else {
            $t = date("M, d", $t);
        }
        
        $publish->url = wpjr_link_to("resume", $resume);
        $publish->image = $resume->getImageUrl();
        $publish->can_browse = $cb;
        $publish->formatted_last_update = $t;
        
        return $publish;
    }
    
    protected static function _canBrowse()
    {
        $can_browse = true;
        $employer = Wpjb_Model_Employer::current();

        if(Wpjb_Project::getInstance()->conf("cv_access") == 2) {
            if($employer->is_active != Wpjb_Model_Employer::ACCOUNT_FULL_ACCESS) {
                $can_browse = false;
            }
        } elseif(Wpjb_Project::getInstance()->conf("cv_access") == 3) {
            if(strtotime($employer->access_until)<time()) {
                $can_browse = false;
            }
        } elseif(Wpjb_Project::getInstance()->conf("cv_access") == 4) {
            if(!wp_get_current_user()->ID) {
                $can_browse = false;
            }
        } else {
            // grant to all
        }

        if(wp_get_current_user()->has_cap("administrator")) {
            $can_browse = true;
        }

        return $can_browse;
    }
    
    public function searchAction()
    {
        
        $request = Daq_Request::getInstance();
        
        $query = $request->post("query");
        $category = $request->post("category");
        $degree = $request->post("degree");
        $experience = $request->post("experience");
        $posted = $request->post("posted");
        $page = $request->post("page", 1);
        $count = $request->post("count", 20);
        
        $result = Wpjb_Model_ResumeSearch::search($query, $category, $degree, $experience, $posted, $count, $page);

        $list = $result->resume;
        $result->resume = array();
        foreach($list as $resume) {
            $result->resume[] = self::_modify($resume);
        }
        
        self::_push($result);
        
    }
    
    public function detailsAction()
    {
        $cb = self::_canBrowse();
        
        $id = Daq_Request::getInstance()->post("id");
        $resume = new Wpjb_Model_Resume($id);
        
        $publish = self::_modify($resume);
        self::_push($publish);
    }
}

?>

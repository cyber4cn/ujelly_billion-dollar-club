<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Json
 *
 * @author greg
 */
class Wpjb_Module_AjaxNopriv_Jobs
{
    protected $_format = "json";
    
    protected static function _push($object)
    {
        //header("Content-type: application/json; charset=utf-8");

        echo json_encode($object);
        die(PHP_EOL);
    }
    
    protected static function _modify(Wpjb_Model_Job $job)
    {
        $arr = $job->allToArray();
        
        foreach(Wpjb_Utility_Registry::getCategories() as $category) {
            if($category->id == $job->job_category) {
                break;
            }
        }
        foreach(Wpjb_Utility_Registry::getJobTypes() as $type) {
            if($type->id == $job->job_type) {
                break;
            }
        }
        
        $public = array("id", "company_name", "company_website", "job_type",
            "job_category", "job_country", "job_state", "job_zip_code",
            "job_location", "job_limit_to_country", "job_title", "job_slug",
            "job_created_at", "job_expires_at", "job_description",
            "is_active", "is_filled", "is_featured", "stat_view", "stat_unique",
            "stat_apply"
        );

        $publish = new stdClass;
        foreach($public as $k) {
            $publish->$k = $job->$k; 
        }
        
        $arr = $job->allToArray();
        foreach($arr as $k => $a) {
            if(substr($k, 0, 6) == "field_") {
                $publish->$k = $a;
            }
        }
        
        $publish->url = wpjb_link_to("job", $job);
        $publish->image = $job->getImageUrl();
        $publish->formatted_created_at = wpjb_date("M, d", $job->job_created_at);
        $publish->location = $job->locationToString();
        $publish->category = $category->toArray();
        $publish->type = $type->toArray();
        $publish->is_new = $job->isNew();
        $publish->is_free = $job->isFree();

        return $publish;
    }
    
    public function searchAction()
    {
        $request = Daq_Request::getInstance();
        
        $query = $request->post("query");
        $category = $request->post("category");
        $type = $request->post("type");
        $posted = $request->post("posted");
        $page = $request->post("page", 1);
        $count = $request->post("count", 20);
        
        $param = array(
            "query" => $request->post("query"),
            "category" => $request->post("category"),
            "type" => $request->post("type"),
            "page" => $request->post("page", 1),
            "count" => $request->post("count"),
            "country" => $request->post("country"),
            "posted" => $request->post("posted"),
            "location" => $request->post("location"),
            "is_featured" => $request->post("is_featured"),
            "employer_id" => $request->post("employer_id"),
            "field" => $request->post("field", array()),
            "sort" => $request->post("sort"),
            "order" => $request->post("order"),
        );
        
        $result = Wpjb_Model_JobSearch::search($param);
        
        $list = $result->job;
        $result->job = array();
        foreach($list as $job) {
            $result->job[] = self::_modify($job);
        }

        self::_push($result);
    }
    
    public function detailsAction()
    {
        $request = Daq_Request::getInstance();
        $job = new Wpjb_Model_Job($request->post("id"));
        
        if(!$job->is_active || !$job->is_approved || time()>strtotime($job->job_expires_at)) {
            exit(0);
        }
        
        $publish = self::_modify($job);
        
        self::_push($publish);
    }
    
    public function categoriesAction()
    {
        $select = new Daq_Db_Query;
        $select->select("*");
        $select->from("Wpjb_Model_Category t");
        $result = $select->execute();
        $response = array();
        foreach($result as $r) {
            $row = $r->toArray();
            $row["url"] = wpjb_link_to("category", $r);
            $response[] = $row;
        }
        
        self::_push($response);
    }
    
    public function typesAction()
    {
        $select = new Daq_Db_Query;
        $select->select("*");
        $select->from("Wpjb_Model_JobType t");
        $result = $select->execute();
        $response = array();
        foreach($result as $r) {
            $row = $r->toArray();
            $row["url"] = wpjb_link_to("jobtype", $r);
            $response[] = $row;
        }
        
        self::_push($response);
    }
    
    public function applyAction()
    {
        throw new Exception("For future use.");
    }
}

?>

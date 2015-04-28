<?php
/**
 * Description of CareerBuilder
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Ajax_CareerBuilder
{
    public function importAction()
    {
        $request = Daq_Request::getInstance();
        
        if($request->post("engine") == "indeed") {
            self::_indeed();
        } elseif($request->post("engine") == "careerbuilder") {
            self::_careerbuilder();
        } else{
        }
    }
    
    public function _indeed()
    {
        $response = new stdClass;
        $response->complete = false;
        $response->isError = false;
        
        $request = Daq_Request::getInstance();
        
        $posted = $request->post("posted_within", 1);
        $country = $request->post("country", "US");
        $location = $request->post("location", "");
        $max = $request->post("max");
        $added = $request->post("added");
        $instance = Wpjb_Project::getInstance();

        $publisher = $instance->getConfig("indeed_publisher");
        
        $url = "http://api.indeed.com/ads/apisearch?publisher=";
        $url.= $publisher."&co=".$country."&limit=";
        $url.= $max."&l=".urlencode($location)."&fromage=".$posted;
        $url.= "&q=".urlencode($request->post("keyword", ""));
        $url.= "&v=2";

        $str = file_get_contents($url);
        $xml = new SimpleXMLElement($str);
        $found = intval($xml->totalresults);

        if($found < $max) {
            $max = $found;
        }
        
        if(!$xml->xpath("//result")) {
            $response->complete = true;
            die(json_encode($response));
        }

        try {
            $all = $xml->xpath("//result");
            foreach($xml->results->result as $r) {
                $keys[] = (string)$r->jobkey;
            }
            for($i = 0 ; $i < count($keys) ; $i++) {
                if($i != count($keys)) {
                    $key .= $keys[$i].",";
                } else {
                    $key .= $keys[$i];
                }
            }

            $url = "http://api.indeed.com/ads/apigetjobs?publisher=$publisher&jobkeys=".$key."&v=2";
            $str = file_get_contents($url);
            $xml = new SimpleXMLElement($str);

            $all = $xml->xpath("//result");
            foreach($xml->results->result as $r) {
                $added++;
                $response->added = $added;
                self::_insertIndeedJob($r);
            }
        } catch(Exception $e) {
            $response->error = $e->getMessage();
            $response->isError = true;
            die(json_encode($response));
        }

        if($added >= $max) {
            $response->complete = true;
        }


        $response->max = $max;
        die(json_encode($response));
    }
    
    public function _careerbuilder()
    {
        $response = new stdClass;
        $response->complete = false;
        $response->isError = false;
        
        $request = Daq_Request::getInstance();

        $category = new Wpjb_Model_Category($request->post("category_id"));
        if($category->getId() < 1) {
            $response->error = "Provided category ID does not exist. Import Cancelled.";
            $response->isError = true;
            die(json_encode($response));
        }

        $key = Wpjb_Project::getInstance()->getConfig("api_cb_key");
        if(strlen(trim($key)) < 1) {
            $response->error = "CareerBuilder API key is missing. Import Cancelled.";
            $response->isError = true;
            die(json_encode($response));
        }
        
        $builder = new Wpjb_Service_CareerBuilder($key);

        $keyword = $request->post("keyword", "");
        $posted = $request->post("posted_within", 1);
        $country = $request->post("country", "US");
        $page = $request->post("page", 1);
        $location = $request->post("location", "");

        if($page >= 50) {
            $response->complete = true;
            die(json_encode($response));
        }

        $added = $request->post("added");
        $max = $request->post("max");

        try {
            $result = $builder->search($keyword, $posted, $country, $page, 10, $location);
            $response->found = (int)$result->TotalCount;
            
            if($response->found < $max) {
                $max = $response->found;
            }
            
            foreach($result->Results->JobSearchResult as $r) {
                $canAdd = true;

                if($added >= $max) {
                    $response->complete = true;
                    break;
                }

                $noRecord = new Daq_Validate_Db_NoRecordExists("Wpjb_Model_CareerBuilderLog", "did");
                if(!$noRecord->isValid((string)$r->DID)) {
                    $canAdd = false;
                }

                if($canAdd) {
                    $job = $builder->job((string)$r->DID);
                }

                if($canAdd && $job!==null) {
                    $added++;
                    self::_insertJob($job);
                } else {
                    // @todo: log
                }
            }
        } catch(Exception $e) {
            $response->error = $e->getMessage();
            $response->isError = true;
            die(json_encode($response));
        }

        if($added >= $max) {
            $response->complete = true;
        }

        $response->added = $added;
        $response->max = $max;
        die(json_encode($response));
    }

    protected static function _insertJob($job)
    {
        $request = Daq_Request::getInstance();
        $category = new Wpjb_Model_Category($request->post("category_id"));

        $sTime = strtotime(date("Y-m-d H:i:s"));
        $eTime = strtotime($job->Job->EndDate);
        $visible = (int)(($eTime-$sTime)/(24*3600));

        $jobTypeId = self::_getJobTypeId((string)$job->Job->EmploymentType);

        $import = new Wpjb_Model_Job();
        $import->company_name = (string)$job->Job->Company;
        $import->company_website = (string)$job->Job->ApplyURL;
        $import->company_email = "";
        $import->company_logo_ext = "";

        $import->job_category = $category->getId();
        $import->job_type = $jobTypeId;
        $import->job_source = 3;

        $country = Wpjb_List_Country::getByAlpha2((string)$job->Job->LocationCountry);
        $import->job_country = $country['code'];
        $import->job_state = (string)$job->Job->LocationState;
        $import->job_zip_code = (string)$job->Job->LocationPostalCode;
        $import->job_location = (string)$job->Job->LocationMetroCity;
        $import->job_limit_to_country = 0;

        $import->job_title = (string)$job->Job->JobTitle;
        $import->job_slug = self::_getUniqueSlug((string)$job->Job->JobTitle);
        $import->job_description = html_entity_decode((string)$job->Job->JobDescription, ENT_NOQUOTES, "UTF-8");

        $import->job_visible = $visible;
        $import->job_created_at = date("Y-m-d H:i:s");
        $import->job_modified_at = date("Y-m-d H:i:s");
        $import->job_expires_at = date("Y-m-d H:i:s", strtotime("now +$visible days"));

        $import->is_approved = 1;
        $import->is_active = 1;
        $import->is_filled = 0;

        $import->payment_sum = 0;
        $import->payment_paid = 0;
        $import->payment_currency = 0;
        $import->payment_discount = 0;
        $import->save();

        $log = new Wpjb_Model_CareerBuilderLog();
        $log->did = $job->Job->DID;
        $log->save();
        
    }
    
    protected static function _insertIndeedJob($job)
    {
        $request = Daq_Request::getInstance();
        $category = new Wpjb_Model_Category($request->post("category_id"));

        $sTime = strtotime(date("Y-m-d H:i:s"));
        $eTime = strtotime("now +30 day");
        $visible = (int)(($eTime-$sTime)/(24*3600));

        if(count(explode(",", (string)$job->jobType)) > 0) {
            $type = explode(",", (string)$job->jobType);
            $jobTypeId = self::_getJobTypeId($type[0]);
        } else {
            $jobTypeId = self::_getJobTypeId((string)$job->jobType);
        }

        $import = new Wpjb_Model_Job();
        $import->company_name = (string)$job->company;
        $import->company_website = (string)$job->url;
        $import->company_email = "";
        $import->company_logo_ext = "";

        $import->job_category = $category->getId();
        $import->job_type = $jobTypeId;
        $import->job_source = 3;

        $country = Wpjb_List_Country::getByAlpha2((string)$job->country);
        $import->job_country = $country['code'];
        $import->job_state = (string)$job->state;
        $import->job_zip_code =  "";
        $import->job_location = (string)$job->city;
        $import->job_limit_to_country = 0;

        $import->job_title = (string)$job->jobtitle;
        $import->job_slug = self::_getUniqueSlug((string)$job->jobtitle);
        $import->job_description = html_entity_decode((string)$job->snippet, ENT_NOQUOTES, "UTF-8");

        $import->job_visible = $visible;
        $import->job_created_at = date("Y-m-d H:i:s");
        $import->job_modified_at = date("Y-m-d H:i:s");
        $import->job_expires_at = date("Y-m-d H:i:s", strtotime("now +$visible days"));

        $import->is_approved = 1;
        $import->is_active = 1;
        $import->is_filled = 0;

        $import->payment_sum = 0;
        $import->payment_paid = 0;
        $import->payment_currency = 0;
        $import->payment_discount = 0;
        $import->save();

        /*
        $log = new Wpjb_Model_CareerBuilderLog();
        $log->did = $job->Job->DID;
        $log->save();
         *
         */

    }
    
    protected static function _getUniqueSlug($title)
    {
        $slug = sanitize_title_with_dashes($title);
        $newSlug = $slug;
        $isUnique = true;

        $query = new Daq_Db_Query();
        $query->select("t.job_slug")
            ->from("Wpjb_Model_Job t")
            ->where("(t.job_slug = ?", $newSlug)
            ->orWhere("t.job_slug LIKE ? )", $newSlug."%");

        $list = array();
        $c = 0;
        foreach($query->fetchAll() as $q) {
            $list[] = $q->t__job_slug;
            $c++;
        }

        if($c > 0) {
            $isUnique = false;
            $i = 1;
            do {
                $i++;
                $newSlug = $slug."-".$i;
                if(!in_array($newSlug, $list)) {
                    $isUnique = true;
                }
            } while(!$isUnique);
        }

        return $newSlug;
    }

    protected static function _getJobTypeId($title)
    {
        $slug = sanitize_title_with_dashes($title);
        $query = new Daq_Db_Query();
        $result = $query->select("*")
            ->from("Wpjb_Model_JobType t")
            ->where("t.title LIKE ?", "%".$title."%")
            ->orWhere("t.slug LIKE ?", "%".$slug."%")
            ->execute();

        if(count($result)>0) {
            $jobType = $result[0];
            return $jobType->getId();
        } else {
            $jobType = new Wpjb_Model_JobType();
            $jobType->title = $title;
            $jobType->slug = $slug;
            $jobType->save();
            return $jobType->getId();
        }
    }
}

?>
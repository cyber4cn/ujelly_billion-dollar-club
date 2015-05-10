<?php
/**
 * Description of JobSearch
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_JobSearch extends Daq_Db_OrmAbstract
{
    protected $_name = "wpjb_job_search";
    
    protected function _init()
    {

    }

    public static function createFrom(Wpjb_Model_Job $job)
    {
        $query = new Daq_Db_Query();
        $object = $query->select()
            ->from(__CLASS__." t")
            ->where("job_id = ?", $job->getId())
            ->limit(1)
            ->execute();

        if(empty($object)) {
            $object = new self;
        } else {
            $object = $object[0];
        }

        $country = Wpjb_List_Country::getByCode($job->job_country);

        $location = array(
            $country['iso2'],
            $country['iso3'],
            $country['name'],
            $job->job_state,
            $job->job_location,
            $job->job_zip_code
        );

        $object->job_id = $job->getId();
        $object->title = $job->job_title;
        $object->description = strip_tags($job->job_description);
        $object->company = $job->company_name;
        $object->location = join(" ", $location);
        $object->save();
    }
    
    public static function search($params)
    {
        $category = null;
        $type = null;
        $posted = null;
        $query = null;
        $field = array();
        $location = null;
        $page = null;
        $count = null;
        $order = null;
        $sort = null;
        
        extract($params);
        $select = Wpjb_Model_Job::activeSelect();
        
        if(isset($is_featured)) {
            $select->where("t1.is_featured = 1");
        }
        
        if(isset($employer_id)) {
            $select->where("t1.employer_id IN(?)", $employer_id);
        }
        
        if(isset($country)) {
            $select->where("t1.job_country = ?", $country);
        }
        
        if(is_array($category)) {
            $category = array_map("intval", $category);
            $select->join("t1.category t2", "t2.id IN (".join(",",$category).")");
        } elseif(!empty($category)) {
            $select->join("t1.category t2", "t2.id = ".(int)$category);
        } else {
            $select->join("t1.category t2");
        }

        if(is_array($type)) {
            $type = array_map("intval", $type);
            $select->join("t1.type t3", "t3.id IN (".join(",",$type).")");
        } elseif(!empty($type)) {
            $select->join("t1.type t3", "t3.id=".(int)$type);
        } else {
            $select->join("t1.type t3");
        }

        $days = $posted;
        if($days == 1) {
            $time = date("Y-m-d");
            $select->where("DATE(job_created_at) = ?", date("Y-m-d"));
        } elseif($days == 2) {
            $time = date("Y-m-d", strtotime("yesterday"));
            $select->where("DATE(job_created_at) = ?", date("Y-m-d", strtotime("now -1 day")));
        } elseif(is_numeric($days)) {
            $select->where("job_created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)", (int)$days);
        }
        
        if(is_array($field)) {
            foreach($field as $k => $v) {
                $k = intval($k);
                $v = trim($v);
                if($k<1 || empty($v)) {
                    continue;
                }
                $custom = new Wpjb_Model_AdditionalField($k);
                if($custom->field_for != 1) {
                    continue;
                }
                
                $q = new Daq_Db_Query();
                $q->select("COUNT(*) AS c");
                $q->from("Wpjb_Model_FieldValue tf$k");
                $q->where("tf$k.job_id=t1.id");
                if($custom->type == 3 || $custom->type == 4) {
                    $q->where("tf$k.value = ?", $v);
                } else {
                    $q->where("tf$k.value LIKE ?", "%$v%");
                }
                $select->where("($q)>0");
            }
        }
        
        $searchString = $search = $query;
        $q = "MATCH(t4.title, t4.description, t4.location, t4.company)";
        $q.= "AGAINST (? IN BOOLEAN MODE)";

        $select->select("COUNT(*) AS `cnt`");
        $itemsFound = 0;
        
        if($searchString && strlen($searchString)<=3) {
            $select->join("t1.search t4");
            $select->where("(t4.title LIKE ?", '%'.$searchString.'%');
            $select->orWhere("t4.description LIKE ?)", '%'.$searchString.'%');
            $itemsFound = $select->fetchColumn();
            $search = false;

        } elseif($searchString) {

            foreach(array(1, 2, 3) as $t) {
                
                $test = clone $select;
                $test->join("t1.search t4");
                if($t == 1) {
                    $test->where(str_replace("?", '\'"'.mysql_real_escape_string($search).'"\'', $q));
                } elseif($t == 2) {
                    $test->where($q, "+".  str_replace(" ", " +", $search));
                } else {
                    $test->where($q, $search);
                }

                $itemsFound = $test->fetchColumn();
                if($itemsFound>0) {
                    break;
                }

            }
            
        } else {
            $itemsFound = $select->fetchColumn();
        }

        if($search) {
            $select->join("t1.search t4");
            if($t == 1) {
                $select->where(str_replace("?", '\'"'.mysql_real_escape_string($search).'"\'', $q));
            } elseif($t == 2) {
                $select->where($q, "+".  str_replace(" ", " +", $search));
            } else {
                $select->where($q, $search);
            }
        }

        if($searchString && $location) {
            $select->where("t4.location LIKE ?", "%$location%");
        } elseif($location) {
            $select->join("t1.search t4");
            $select->where("t4.location LIKE ?", "%$location%");
        }
        
        $select->select("*");
        
        if($page && $count) {
            $select->limitPage($page, $count);
        }
        
        $ord = array("id", "job_created_at", "job_title");
        
        if(!in_array($order, $ord)) {
            $order = null;
        }
        if($sort != "desc") {
            $sort = "asc";
        } 
        if($order) {
            $select->order("t1.is_featured DESC, t1.$order $sort");
        }
        
        $jobList = $select->execute();
        
        $response = new stdClass;
        $response->job = $jobList;
        $response->page = $page;
        $response->perPage = $count;
        $response->count = count($jobList);
        $response->total = $itemsFound;
        
        $link = wpjb_link_to("feed_custom");
        $link2 = wpjb_link_to("search");
        $p2 = $params;
        unset($p2["page"]);
        unset($p2["count"]);
        $q2 = http_build_query($p2);
        $glue = "?";
        if(stripos($link, "?")) {
            $glue = "&";
        }
        $response->url = new stdClass;
        $response->url->feed = $link.$glue.$q2;
        $response->url->search = $link2.$glue.$q2;
        
        return $response;
    }
}

?>
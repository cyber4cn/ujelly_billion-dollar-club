<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResumeSearch
 *
 * @author greg
 */
class Wpjb_Model_ResumeSearch 
{
    public static function search($query, $category, $degree, $experience, $posted, $count, $page)
    {
        $select = new Daq_Db_Query();
        $select->select()
            ->from("Wpjb_Model_Resume t1")
            ->join("t1.users t2")
            ->where("is_active = 1")
            ->order("updated_at DESC");

        if(Wpjb_Project::getInstance()->conf("cv_approval") == 1) {
            $select->where("is_approved = ?", Wpjb_Model_Resume::RESUME_APPROVED);
        }
        
        if($query) {
            $search = $query;
            $q = "MATCH(title, headline, experience, education)";
            $q.= "AGAINST (? IN BOOLEAN MODE)";
            $select->where($q, $search);
        }
        
        if(is_array($category)) {
            $category = array_map("intval", $category);
            $select->where("category_id IN (?)", join(",", $category));
        } elseif($category) {
            $select->where("category_id = ?", $category);
        }

        
        if(is_array($degree)) {
            $degree = array_map("intval", $degree);
            $select->where("category_id IN (?)", join(",", $degree));
        } elseif($degree) {
            $select->where("degree = ?", $degree);
        }
        
        if(is_array($experience)) {
            $experience = array_map("intval", $experience);
            $select->where("category_id IN (?)", join(",", $experience));
        } elseif($experience) {
            $select->where("years_experience = ?", $experience);
        }

        if($posted) {
            $days = posted;

            if($days == 1) {
                $time = date("Y-m-d");
                $select->where("DATE(updated_at) = ?", date("Y-m-d"));
            } elseif($days == 2) {
                $time = date("Y-m-d", strtotime("yesterday"));
                $select->where("DATE(updated_at) = ?", date("Y-m-d", strtotime("now -1 day")));
            } else {
                $select->where("updated_at >= DATE_SUB(NOW(), INTERVAL ? DAY)", (int)$days);
            }
        }
        
        $itemsFound = $select->select("COUNT(*) AS cnt")->fetchColumn();
        
        $select->select("*");
        if($count>0) {
            $select->limitPage($page, $count);
        }
        $list = $select->execute();
        
        $response = new stdClass;
        $response->resume = $list;
        $response->page = (int)$page;
        $response->perPage = (int)$count;
        $response->count = count($list);
        $response->total = (int)$itemsFound;
        
        return $response;
    }
}

?>

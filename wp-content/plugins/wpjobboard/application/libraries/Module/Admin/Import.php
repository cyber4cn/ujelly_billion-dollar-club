<?php
/**
 * Description of Import
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Import extends Wpjb_Controller_Admin
{
    public function init()
    {

    }
    
    public function indexAction()
    {
        
    }

    public function careerbuilderAction()
    {
        $query = new Daq_Db_Query();
        $this->view->category = $query->select("*")
            ->from("Wpjb_Model_Category t")
            ->execute();
    }
    
    public function indeedAction()
    {
        $query = new Daq_Db_Query();
        $this->view->category = $query->select("*")
            ->from("Wpjb_Model_Category t")
            ->execute();
        
        $isConf = Wpjb_Project::getInstance()->getConfig("indeed_publisher");
        if(strlen($isConf)>0 && is_numeric($isConf)) {
            $this->view->isConf = true;
        } else {
            $this->view->isConf = false;
        }
    }
    
    public function xmlAction()
    {
        $element = new Daq_Form_Element_File("file", Daq_Form_Element::TYPE_FILE);
        $element->isRequired(true);
        
        $request = Daq_Request::getInstance();
        
        if($this->isPost() && $element->validate()) {
            $file = $_FILES["file"]["tmp_name"];
            $content = file_get_contents($file);
            $xml = simplexml_load_string($content);
            $i = 0;
           
            foreach ($xml->job as $job) {
                $this->_import($job);
                $i++;
            }
            
            $m = str_replace("{x}", $i, __("Jobs imported: {x}."));
            $this->view->_flash->addInfo($m);
        }
    }
    
    protected function _import($xml)
    {
        $id = null;
        if($xml->id > 0) {
            $id = (int)$xml->id;
        }
        
        $job = new Wpjb_Model_Job($id);
        $job->company_name = (string)$xml->company_name;
        $job->company_email = (string)$xml->company_email;
        $job->company_website = (string)$xml->company_website;
        
        $job->job_title = (string)$xml->job_title;
        $job->job_description = (string)$xml->job_description;
        $job->job_slug = $this->_getUniqueSlug($job->job_title);
        
        if(strlen($xml->company_logo_ext)>=3) {
            $job->company_logo_ext = (string)$xml->company_logo_ext;
            $logo = base64_decode((string)$xml->company_logo);
        }
        
        $job->job_category = $this->_getCategoryId($xml->category);
        $job->job_type = $this->_getJobTypeId($xml->job_type);
        
        $c = Wpjb_List_Country::getByAlpha2((string)$xml->job_country);
        
        $job->job_country = $c["code"];
        $job->job_state = (string)$xml->job_state;
        $job->job_zip_code = (string)$xml->job_zip_code;
        $job->job_location = (string)$xml->job_location;
        
        $job->job_created_at = (string)$xml->job_created_at;
        if(!(string)$xml->job_modified_at) {
            $job->job_modified_at = (string)$xml->job_modified_at;
        } else {
            $job->job_modified_at = (string)$xml->job_created_at;
        }
        $job->job_visible = (int)$xml->job_visible;
        
        $stt = "{$job->job_created_at} +{$job->job_visible} DAYS";
        $job->job_expires_at = date("Y-m-d H:i:s", strtotime($stt));
        
        $job->is_approved = (int)$xml->is_approved;
        $job->is_active = (int)$xml->is_approved;
        $job->is_featured = (int)$xml->is_featured;
        $job->is_filled = (int)$xml->is_filled;
        
        $job->payment_sum = (float)$xml->payment_sum;
        $job->payment_paid = (float)$xml->payment_paid;
        $job->payment_currency = (float)$xml->payment_currency;
        $job->payment_discount = (float)$xml->payment_discount;
        
        $job->save();
        
        if($logo) {
            $baseDir = Wpjb_Project::getInstance()->getProjectBaseDir();
            $baseDir = "/environment/images/job_".$job->getId().".".$job->company_logo_ext;
            file_put_contents($baseDir, $file);
        }
        
    }
    
    protected function _getJobTypeId($type)
    {
        $title = (string)$type->title;
        $slug = (string)$type->slug;
        $color = (string)$type->color;
        if(strlen($slug)<1) {
            $slug = sanitize_title_with_dashes($title);
        }
        
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
            $jobType->color = $color;
            $jobType->save();
            return $jobType->getId();
        }
    }
    
    protected function _getCategoryId($category)
    {
        $title = (string)$category->title;
        $slug = (string)$category->slug;
        if(strlen($slug)<1) {
            $slug = sanitize_title_with_dashes($title);
        }
        
        $query = new Daq_Db_Query();
        $result = $query->select("*")
            ->from("Wpjb_Model_Category t")
            ->where("t.title LIKE ?", "%".$title."%")
            ->orWhere("t.slug LIKE ?", "%".$slug."%")
            ->execute();

        if(count($result)>0) {
            $category = $result[0];
            return $category->getId();
        } else {
            $category = new Wpjb_Model_Category;
            $category->title = $title;
            $category->slug = $slug;
            $category->save();
            return $category->getId();
        }
    }

    protected function _getUniqueSlug($title)
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
}

?>
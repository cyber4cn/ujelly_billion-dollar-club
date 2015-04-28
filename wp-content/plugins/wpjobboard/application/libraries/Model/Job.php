<?php
/**
 * Description of Job
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_Job extends Daq_Db_OrmAbstract
{
    const GEO_UNSET = 0;
    const GEO_MISSING = 1;
    const GEO_FOUND = 2;
    
    protected $_name = "wpjb_job";

    protected $_approve = false;

    protected $_fields = null;

    protected $_textareas = null;

    protected function _init()
    {
        $this->_reference["category"] = array(
            "localId" => "job_category",
            "foreign" => "Wpjb_Model_Category",
            "foreignId" => "id",
            "type" => "ONE_TO_ONE"
        );
        $this->_reference["type"] = array(
            "localId" => "job_type",
            "foreign" => "Wpjb_Model_JobType",
            "foreignId" => "id",
            "type" => "ONE_TO_ONE"
        );
        $this->_reference["payment"] = array(
            "localId" => "id",
            "foreign" => "Wpjb_Model_Payment",
            "foreignId" => "object_id",
            "type" => "ONE_TO_ONE",
            "with" => "object_type = 1"
        );
        $this->_reference["search"] = array(
            "localId" => "id",
            "foreign" => "Wpjb_Model_JobSearch",
            "foreignId" => "job_id",
            "type" => "ONE_TO_ONE"
        );
        $this->_reference["employer"] = array(
            "localId" => "employer_id",
            "foreign" => "Wpjb_Model_Employer",
            "foreignId" => "id",
            "type" => "ONE_TO_ONE"
        );
    }

    public function allToArray()
    {
        $arr = parent::toArray();

        $query = new Daq_Db_Query();
        $opt = $query->select()->from("Wpjb_Model_FieldOption t")->execute();
        $list = array();
        foreach($opt as $o) {
            $list[$o->value] = $o->id;
        }

        $query = new Daq_Db_Query();
        $result = $query->select("*")->from("Wpjb_Model_AdditionalField t1")
            ->join("t1.value t2", "t2.job_id=".$this->getId())
            ->where("is_active=1")
            ->execute();

        foreach($result as $obj) {
            if($obj->type == Daq_Form_Element::TYPE_SELECT) {
                $val = $list[$obj->getValue()->value];
            } else {
                $val = $obj->getValue()->value;
            }

            $arr['field_'.$obj->getId()] = $val;
        }

        return $arr;
    }

    /**
     * Returns additional field
     *
     * @param int $id
     * @return Wpjb_Model_FieldValue
     * @throws Exception If field with given id does not exist
     */
    public function getFieldById($id)
    {
        if(!$this->_fields || !$this->_textareas) {
            $this->_loadAdditionalFields();
        }

        foreach($this->_fields as $field) {
            if($field->field_id == $id) {
                return $field;
            }
        }

        foreach($this->_textareas as $field) {
            if($field->field_id == $id) {
                return $field;
            }
        }

        throw new Exception("Field identified by ID: $id does not exist.");
    }
    
    public function getFieldValue($id)
    {
        try {
            $field = $this->getFieldById($id);
            return $field->value;
        } catch(Exception $e) {
            return null;
        }
    }

    public function getFields()
    {
        if($this->_fields == null) {
            $this->_loadAdditionalFields();
        }
        return $this->_fields;
    }

    public function getNonEmptyFields()
    {
        $fields = $this->getFields();
        $fArr = array();
        foreach($fields as $field) {
            /* @var $field Wpjb_Model_FieldValue */
            $value = trim($field->getTextValue());
            if(!empty($value)) {
                $fArr[] = $field;
            }
        }
        return $fArr;
    }

    public function getTextareas()
    {
        if($this->_textareas == null) {
            $this->_loadAdditionalFields();
        }
        return $this->_textareas;
    }

    public function getNonEmptyTextareas()
    {
        $textareas = $this->getTextareas();
        $fArr = array();
        foreach($textareas as $field) {
            /* @var $field Wpjb_Model_FieldValue */
            $value = trim($field->value);
            if(!empty($value)) {
                $fArr[] = $field;
            }
        }
        return $fArr;
    }

    public function _loadAdditionalFields()
    {
        $query = new Daq_Db_Query();
        $fields = $query->select("*")
            ->from("Wpjb_Model_FieldValue t")
            ->join("t.field t3")
            ->where("t3.field_for = 1")
            ->where("t3.is_active = 1")
            ->where("t.job_id = ?", $this->getId())
            ->execute();

        $this->_fields = array();
        $this->_textareas = array();

        foreach($fields as $field) {
            if($field->getField()->type != Daq_Form_Element::TYPE_TEXTAREA) {
                $this->_fields[] = $field;
            } else {
                $this->_textareas[] = $field;
            }
        }
    }

    public function set($key, $value)
    {
        if($key == "is_approved" && $value==1 && $this->_trackChanges && $this->is_approved != 1) {
            $this->_approve = true;
        }
        parent::set($key, $value);
    }

    public function save()
    {
        $isNew = true;
        if($this->getId()) {
            $isNew = false;
        }
        
        $m1 = (bool)$this->_fields["job_country"]["modified"];
        $m2 = (bool)$this->_fields["job_state"]["modified"];
        $m3 = (bool)$this->_fields["job_zip_code"]["modified"];
        $m4 = (bool)$this->_fields["job_location"]["modified"];
        if($m1 || $m2 || $m3 || $m4) {
            // reset geolocation
            $this->geo_status = self::GEO_UNSET;
            $this->geo_longitude = 0;
            $this->geo_latitude = 0;
        }
        
        $id = parent::save();
        
        if($isNew) {
            Wpjb_Utility_Messanger::send(1, $this);
        }

        if($id && $this->_approve) {
            $this->_approve();
            $this->_approve = false;
        }

        Wpjb_Model_JobSearch::createFrom($this);

        $employer = new Wpjb_Model_Employer($this->employer_id);
        if($employer->getId() > 0 && $isNew) {
            $employer->jobs_posted++;
            $employer->save();
        }

        Wpjb_Project::scheduleEvent();

        return $id;
    }

    private function _approve()
    {
        if($this->job_source == 3) {
            // do not redistribute imported jobs
            return;
        }

        try {
            if($this->job_source == 1) {
                if($this->payment_amount > 0) {
                    Wpjb_Utility_Messanger::send(4, $this);
                } else {
                    Wpjb_Utility_Messanger::send(3, $this);
                }
            }

            $this->_useCouponCode();

            // Send alerts
            $query = new Daq_Db_Query();
            $result = $query->select()->from("Wpjb_Model_Alert t")
                ->where("is_active = 1")
                ->where("LOCATE(keyword, ?)>0", $this->job_title)
                ->limit(100)
                ->execute();

            foreach($result as $r) {
                $param = array("hash" => md5($r->id.$r->email));
                $url = Wpjb_Project::getInstance()->router()->linkTo("alertdelete", $r, $param);
                $append = array(
                    'alert_keyword' => $r->keyword,
                    'alert_email' => $r->email,
                    'alert_unsubscribe_url' => Wpjb_Project::getInstance()->getUrl()."/".$url
                );
                Wpjb_Utility_Messanger::send(7, $this, $append);
            }
            
            if(Wpjb_Project::getInstance()->conf("posting_tweet")) {
                Wpjb_Service_Twitter::tweet($this);
            }
        } catch(Exception $e) {
            //echo $e->getMessage();
        }
    }

    protected function _useCouponCode()
    {
        if($this->discount_id < 1) {
            return;
        }

        $discount = new Wpjb_Model_Discount($this->discount_id);
        if(!$this->id) {
            return;
        }

        $discount->used++;
        $discount->save();
    }

    public function deleteImage()
    {
        if($this->hasImage()) {
            $file = $this->getImagePath();
            if(file_exists($file)) {
                unlink($file);
            }
            $this->company_logo_ext = "";
        }
    }

    public function getImageUrl()
    {
        if($this->hasImage()) {
            $url = site_url();
            $url.= "/wp-content/plugins/wpjobboard";
            $url.= Wpjb_List_Path::getRawPath("user_images");
            $url.= "/job_".$this->getId().".".$this->company_logo_ext;
            return $url;
        }
        return null;
    }

    public function getImagePath()
    {
        if($this->hasImage()) {
            $url = Wpjb_List_Path::getPath("user_images");
            $url.= "/job_".$this->getId().".".$this->company_logo_ext;
            return $url;
        }
        return null;
    }

    public function expiresAt($dateOnly = false)
    {
        if($this->job_visible == 0) {
            return null;
        }

        $created = strtotime($this->job_created_at." +".$this->job_visible." DAYS");

        if($dateOnly) {
            return date("Y-m-d H:i:s", $created);
        } else {
            return date("Y-m-d", $created);
        }
    }

    public function isFree()
    {
        if($this->payment_sum == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isNew()
    {
        $past = strtotime($this->job_created_at);
        $now = strtotime(date("Y-m-d H:i:s"));

        $config = Wpjb_Project::getInstance()->conf("front_marked_as_new", 7);
        if($now-$past < 24*3600*$config) {
            return true;
        } else {
            return false;
        }
    }

    public function paymentAmount()
    {
        if($this->payment_sum == 0) {
            return null;
        }

        $curr = Wpjb_List_Currency::getCurrencySymbol($this->payment_currency);
        return $curr.$this->payment_sum;
    }

    public function paymentPaid()
    {
        if($this->payment_sum == 0) {
            return null;
        }

        $curr = Wpjb_List_Currency::getCurrencySymbol($this->payment_currency);
        return $curr.$this->payment_paid;
    }

    public function paymentDiscount()
    {
        if($this->payment_sum == 0) {
            return null;
        }

        $curr = Wpjb_List_Currency::getCurrencySymbol($this->payment_currency);
        return $curr.$this->payment_discount;
    }

    public function paymentCurrency()
    {
        return Wpjb_List_Currency::getCurrencySymbol($this->payment_currency);
    }

    public function listingPrice()
    {
        $price = $this->payment_sum+$this->payment_discount;
        $curr = Wpjb_List_Currency::getCurrencySymbol($this->payment_currency);
        return $curr.number_format($price, 2);
    }

    public function hasImage()
    {
        if(strlen($this->company_logo_ext)>0) {
            return true;
        } else {
            return false;
        }
    }

    public function locationToString()
    {
        $arr = array();
        $country = Wpjb_List_Country::getByCode($this->job_country);
        $country = trim($country['name']);

        if(strlen(trim($this->job_location))>0) {
            $arr[] = $this->job_location;
        }

        if($this->job_country == 840 && strlen(trim($this->job_state))>0) {
            $arr[] = $this->job_state;
        } else if(strlen($country)>0) {
            $arr[] = $country;
        }

        return (implode(", ", $arr));
    }

    public function delete()
    {
        $this->deleteImage();

        $query = new Daq_Db_Query();
        $object = $query->select()
            ->from("Wpjb_Model_JobSearch t")
            ->where("t.job_id = ?", $this->getId())
            ->limit(1)
            ->execute();

        if(!empty($object)) {
            $object[0]->delete();
        }

        $employer = new Wpjb_Model_Employer($this->employer_id);
        if($employer->getId() > 0) {
            $employer->jobs_posted--;
            $employer->save();
        }

        $result = parent::delete();
        
        Wpjb_Project::scheduleEvent();
        
        return $result;
    }
    
    public function expired()
    {
        if(strtotime($this->job_expires_at)>time()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Returns default query for searching for active jobs.
     *
     * @param $joined bool Return joined tables (categories, types) as well
     * @return Daq_Db_Query
     */
    public static function activeSelect($joined = true)
    {
        $query = new Daq_Db_Query();
        $query = $query->select("*")
            ->from("Wpjb_Model_Job t1")
            ->where("t1.is_active = 1")
            ->where("t1.job_expires_at >= ?", date("Y-m-d 23:59:59"))
            ->order("t1.is_featured DESC, t1.job_created_at DESC");

        if(Wpjb_Project::getInstance()->conf("front_hide_filled")) {
            $query->where("is_filled = 0");
        }
        
        return $query;
    }

    public static function find($keyword, $categoryId, $typeId)
    {
        $select = self::activeSelect();
        if(!empty($keyword)) {

        }
    }
    
    protected function _locate($asyncSave = false)
    {
        $country = Wpjb_List_Country::getByCode($this->job_country);
        $country = trim($country['name']);
        
        $addr = array(
            $this->job_location,
            $this->job_zip_code,
            $this->job_state,
            $country
        );
        
        $query = http_build_query(array(
            "address" => join(", ", $addr),
            "sensor" => "false"
        ));
        $url = "http://maps.googleapis.com/maps/api/geocode/json?".$query;
        
        $response = wp_remote_get($url);
        if($response instanceof WP_Error) {
            $geo = null;
        } else {
            $geo = json_decode($response["body"]);
        }
        
        if(!$geo || $geo->status != "OK") {
            $this->geo_status = self::GEO_MISSING;
            $this->geo_latitude = 0;
            $this->geo_longitude = 0;
        } elseif($geo->status == "OK") {
            $this->geo_status = self::GEO_FOUND;
            $this->geo_latitude  = $geo->results[0]->geometry->location->lat;
            $this->geo_longitude = $geo->results[0]->geometry->location->lng;
        } 
        
        if($this->id > 0 && $asyncSave) {
            $job = new Wpjb_Model_Job($this->id);
            $job->geo_status = $this->geo_status;
            $job->geo_latitude = $this->geo_latitude;
            $job->geo_longitude = $this->geo_longitude;
            $job->_saveGeo();
        }
    }
    
    /**
     * Returns geolocation parameters for the job
     * 
     * @return stdClass 
     */
    public function getGeo()
    {
        if($this->geo_status == self::GEO_UNSET) {
            $this->_locate(true); 
        }
        
        if($this->geo_status == self::GEO_FOUND) {
            $response = new stdClass;
            $response->lat = $this->geo_latitude;
            $response->lng = $this->geo_longitude;
            $response->lnglat = $response->lat.",".$response->lng;
            return $response;
        } else {
            return null;
        }
    }
    
    protected function _saveGeo()
    {
        parent::save();
    }
}

?>

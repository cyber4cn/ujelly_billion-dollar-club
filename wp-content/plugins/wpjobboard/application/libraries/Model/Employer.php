<?php
/**
 * Description of Employer
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_Employer extends Daq_Db_OrmAbstract
{
    const GEO_UNSET = 0;
    const GEO_MISSING = 1;
    const GEO_FOUND = 2;
    
    const ACCOUNT_FULL_ACCESS = 4;
    const ACCOUNT_DECLINED = 3;
    const ACCOUNT_REQUEST = 2;
    const ACCOUNT_ACTIVE = 1;
    const ACCOUNT_INACTIVE = 0;

    protected $_name = "wpjb_employer";

    protected static $_current = null;

    protected function _init()
    {
        $this->_reference["users"] = array(
            "localId" => "user_id",
            "foreign" => "Wpjb_Model_User",
            "foreignId" => "ID",
            "type" => "ONE_TO_ONE"
        );
        $this->_reference["usermeta"] = array(
			"localId" => "user_id",
			"foreign" => "Wpjb_Model_UserMeta",
			"foreignId" => "user_id",
			"type" => "ONE_TO_ONE"
        );

    }

    public function hasActiveProfile()
    {
        if($this->jobs_posted == 0) {
            return false;
        }

        if(!$this->is_active) {
            return false;
        }

        if(!$this->is_public) {
            return false;
        }

        return true;
    }

    /**
     * Returns currently loggedin user employer object
     *
     * @return Wpjb_Model_Employer
     */
    public static function current()
    {
        if(self::$_current instanceof self) {
            return self::$_current;
        }

        $current_user = wp_get_current_user();
        
        if($current_user->ID < 1) {
            return new self;
        }

        $query = new Daq_Db_Query();
        $object = $query->select()->from(__CLASS__." t")
            ->where("user_id = ?", $current_user->ID)
            ->limit(1)
            ->execute();

        if($object[0]) {
            self::$_current = $object[0];
            return self::$_current;
        }

        // quick create
        $object = new self();
        $object->user_id = $current_user->ID;
        $object->company_name = "";
        $object->company_website = "";
        $object->company_info = "";
        $object->company_logo_ext = "";
        $object->company_location = "";
        $object->is_public = 0;
        $object->is_active = self::ACCOUNT_ACTIVE;
        $object->save();

        self::$_current = $object;

        return $object;
    }

    private function _defaultAccess()
    {
        return self::ACCOUNT_ACTIVE;
    }
    
    public function hasImage()
    {
        if(strlen($this->company_logo_ext)>0) {
            return true;
        } else {
            return false;
        }
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
            $url.= Wpjb_List_Path::getRawPath("company_logo");
            $url.= "/logo_".$this->getId().".".$this->company_logo_ext;
            return $url;
        }
        return null;
    }

    public function getImagePath()
    {
        if($this->hasImage()) {
            $url = Wpjb_List_Path::getPath("company_logo");
            $url.= "/logo_".$this->getId().".".$this->company_logo_ext;
            return $url;
        }
        return null;
    }

    public function delete()
    {
        $this->deleteImage();
        parent::delete();
    }

    public function addAccess($days)
    {
        $activeUntil = $this->access_until;
        $activeUntil = strtotime($activeUntil);

        if($activeUntil<time()) {
            $activeUntil = time();
        }

        $extend = $days*3600*24;

        $this->access_until = date("Y-m-d H:i:s", $activeUntil+$extend);
    }

    public function isEmployer()
    {
        if($this->user_id < 1) {
            return false;
        }
        $isE = get_user_meta($this->user_id, "is_employer");

        return (bool)$isE;
    }

    public function isActive()
    {
        $isActive = $this->is_active;

        if($isActive == self::ACCOUNT_ACTIVE) {
            return true;
        }

        if($isActive == self::ACCOUNT_FULL_ACCESS) {
            return true;
        }

        return false;
    }
    
    public function isVisible()
    {
        if(!$this->is_public) {
            return false;
        }

        if(!$this->is_active) {
            return false;
        }

        if(!$this->jobs_posted) {
            return false;
        }


        return true;
    }
    
    public function save()
    {
        $m1 = (bool)$this->_fields["company_country"]["modified"];
        $m2 = (bool)$this->_fields["company_state"]["modified"];
        $m3 = (bool)$this->_fields["company_zip_code"]["modified"];
        $m4 = (bool)$this->_fields["company_location"]["modified"];
        if($m1 || $m2 || $m3 || $m4) {
            // reset geolocation
            $this->geo_status = self::GEO_UNSET;
            $this->geo_longitude = 0;
            $this->geo_latitude = 0;
        }
        
        return parent::save();
    }
    
    protected function _locate($asyncSave = false)
    {
        $country = Wpjb_List_Country::getByCode($this->company_country);
        $country = trim($country['name']);
        
        $addr = array(
            $this->company_location,
            $this->company_zip_code,
            $this->company_state,
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
            $object = new self($this->id);
            $object->geo_status = $this->geo_status;
            $object->geo_latitude = $this->geo_latitude;
            $object->geo_longitude = $this->geo_longitude;
            $object->_saveGeo();
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
    
    public function locationToString()
    {
        $arr = array();
        $country = Wpjb_List_Country::getByCode($this->company_country);
        $country = trim($country['name']);

        if(strlen(trim($this->company_location))>0) {
            $arr[] = $this->company_location;
        }

        if($this->company_country == 840 && strlen(trim($this->company_state))>0) {
            $arr[] = $this->company_state;
        } else if(strlen($country)>0) {
            $arr[] = $country;
        }

        return (implode(", ", $arr));
    }
}

?>

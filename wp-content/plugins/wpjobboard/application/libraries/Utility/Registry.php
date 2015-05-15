<?php
/**
 * Description of Registry
 *
 * @author greg
 * @package 
 */

class Wpjb_Utility_Registry
{
    private static $_registry = array();

    public static function set($key, $value)
    {
        self::$_registry[$key] = $value;
    }

    public static function get($key)
    {
        if(self::has($key)) {
            return self::$_registry[$key];
        } else {
            return null;
        }
    }

    public static function has($key)
    {
        if(isset(self::$_registry[$key])) {
            return true;
        } else {
            return false;
        }
    }

    public static function getJobTypes()
    {
        if(self::has("_job_types")) {
            return self::get("_job_types");
        }

        $query = new Daq_Db_Query();
        $result = $query->select("*")->from("Wpjb_Model_JobType t")->execute();

        self::set("_job_types", $result);

        return $result;
    }

    public static function getCategories()
    {
        if(self::has("_job_categories")) {
            return self::get("_job_categories");
        }

        $query = new Daq_Db_Query();
        $result = $query->select("*")
            ->from("Wpjb_Model_Category t")
            ->order("t.title ASC")
            ->execute();

        self::set("_job_categories", $result);

        return $result;
    }
}

?>
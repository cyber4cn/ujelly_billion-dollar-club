<?php
/**
 * Description of Request
 *
 * @author greg
 * @package 
 */

class Daq_Request
{
    private static $_instance = null;

    private $_post = null;

    private $_get = null;

    private $_file = null;

    private function __construct()
    {
        // __CLASS__ will have single instance only because WordPress is fucked!
    }

    public static function stripSlashesRecursive($data)
    {
        foreach($data as $k => $v) {
            if(is_array($v)) {
                $data[$k] = self::stripSlashesRecursive($v);
            } else {
                $data[$k] = stripslashes($v);
            }
        }
        return $data;
    }

    /**
     *
     * @return Daq_Request
     */
    public static function getInstance()
    {
        if(self::$_instance === null) {
            self::$_instance = new self;
            if(get_magic_quotes_gpc() || get_magic_quotes_runtime()) {
                self::$_instance->_post = self::stripSlashesRecursive($_POST);
                self::$_instance->_get = self::stripSlashesRecursive($_GET);
                self::$_instance->_file = $_FILES;
            } else {
                self::$_instance->_post = $_POST;
                self::$_instance->_get = $_GET;
                self::$_instance->_file = $_FILES;
            }
        }

        return self::$_instance;
    }

    public function get($key, $default = null)
    {
        if(isset($this->_get[$key])) {
            return $this->_get[$key];
        }

        return $default;
    }

    public function post($key, $default = null)
    {
        if(isset($this->_post[$key])) {
            return $this->_post[$key];
        }

        return $default;
    }

    public function file($key, $default = null)
    {
        if(isset($this->_file[$key])) {
            return $this->_file[$key];
        }

        return $default;
    }

    public function getParam($key, $default = "")
    {
        if($this->get($key, false) !== false) {
            return $this->get($key);
        }
        if($this->post($key, false) !== false) {
            return $this->post($key);
        }

        return $default;
    }

    public function getAll()
    {
        return $this->_post;
    }

    public function addParam($arr, $key, $value)
    {
        if($arr == "GET") {
            $this->_get[$key] = $value;
        } else {
            $this->_post[$key] = $value;
        }
    }

    public function session($key, $default = null)
    {
        if(is_null($_SESSION)) {
            session_start();
        }

        if(isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
        } else {
            $value = $default;
        }

        if(get_magic_quotes_gpc() || get_magic_quotes_runtime()) {
            if(is_array($value)) {
                return self::stripSlashesRecursive($value);
            } else {
                return stripslashes($value);
            }
        } else {
            return $value;
        }
    }

    public function setSessionParam($key, $value)
    {
        if(is_null($_SESSION)) {
            session_start();
        }
        
        $_SESSION[$key] = $value;
    }
}

?>
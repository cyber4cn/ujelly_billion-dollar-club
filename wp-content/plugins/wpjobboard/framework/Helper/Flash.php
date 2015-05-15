<?php
/**
 * Description of Flash
 *
 * @author greg
 * @package
 */

class Daq_Helper_Flash
{
    private $_ns = null;

    private $_save = true;

    private $_info = array();

    private $_error = array();

    public function __construct($namespace = null)
    {
        $this->_ns = $namespace;
        $this->_load();
    }

    protected function _load()
    {
        if(!$this->_ns) {
            return;
        }
        if(!isset($_SESSION) || !session_id()) {
            session_start();
        }

        if(isset($_SESSION["daq.flash"][$this->_ns]) && !empty($_SESSION["daq.flash"][$this->_ns])) {
            //print_r($_SESSION["daq.flash"]);die;
            $this->_info = array_unique($_SESSION["daq.flash"][$this->_ns]["info"]);
            $this->_error = array_unique($_SESSION["daq.flash"][$this->_ns]["error"]);
            $_SESSION["daq.flash"][$this->_ns] = null;
        }
    }

    public function addInfo($info)
    {
        $this->_info[] = $info;
    }

    public function getInfo()
    {
        return array_unique($this->_info);
    }

    public function addError($error)
    {
        $this->_error[] = $error;
    }

    public function getError()
    {
        return array_unique($this->_error);
    }

    public function __destruct()
    {
        $this->save();
    }

    public function dispose()
    {
        $this->_save = false;
    }

    public function save()
    {
        if(!$this->_ns || !$this->_save) {
            return;
        }
        if(is_null($_SESSION)) {
            session_start();
        }

        if(!isset($_SESSION["daq.flash"])) {
            $_SESSION["daq.flash"] = array();
        }

        if(!empty($this->_info) && !empty($this->_info)) {
            $_SESSION["daq.flash"][$this->_ns] = array(
                "info" => $this->_info,
                "error" => $this->_error
            );
        } else {
            $_SESSION["daq.flash"][$this->_ns] = null;
        }

    }
}

?>
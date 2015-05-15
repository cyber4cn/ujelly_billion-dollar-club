<?php
/**
 * Description of File
 *
 * @author greg
 * @package 
 */

class Daq_Form_Element_File extends Daq_Form_Element
{
    protected $_destination = null;

    public function setDestination($dest)
    {
        $this->_destination = $dest;
    }

    public function getExt()
    {
        if(!is_array($this->_value)) {
            return "";
        }
        if(stripos($this->_value['name'], ".") === false) {
            return "";
        }

        $part = explode(".", $this->_value['name']);
        return strtolower($part[count($part)-1]);
    }

    public function fileSent()
    {
        if(is_array($this->_value) && $this->_value['size']>0) {
            return true;
        } else {
            return false;
        }
    }

    public function upload($newFileName = null)
    {
        if($this->_destination === null) {
            return;
        }

        $tmpPath = $this->_value['tmp_name'];
        $newPath = rtrim($this->_destination, "/")."/";
        if($newFileName) {
            $fileName = $newFileName;
        } else {
            $fileName = $this->_value['name'];
        }
        move_uploaded_file($tmpPath, $newPath.$fileName);

        return $newPath.$fileName;
    }

}

?>
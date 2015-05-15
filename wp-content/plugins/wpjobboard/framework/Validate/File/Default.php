<?php
/**
 * Description of Default
 *
 * @author greg
 * @package 
 */

class Daq_Validate_File_Default
    extends Daq_Validate_Abstract implements Daq_Validate_Interface
{
    protected $_required = false;
    
    public function isValid($value)
    {
        if(!$this->_required && $value['size'] == 0) {
            return true;
        }

        switch ($value['error']) {
            case UPLOAD_ERR_OK:
                return true;
            case UPLOAD_ERR_INI_SIZE:
                $this->setError(__('The uploaded file exceeds the upload_max_filesize directive in php.ini', DAQ_DOMAIN));
                return false;
            case UPLOAD_ERR_FORM_SIZE:
                $this->setError(__('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', DAQ_DOMAIN));
                return false;
            case UPLOAD_ERR_PARTIAL:
                $this->setError(__('The uploaded file was only partially uploaded', DAQ_DOMAIN));
                return false;
            case UPLOAD_ERR_NO_FILE:
                $this->setError(__('No file was uploaded', DAQ_DOMAIN));
                return false;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->setError(__('Missing a temporary folder', DAQ_DOMAIN));
                return false;
            case UPLOAD_ERR_CANT_WRITE:
                $this->setError(__('Failed to write file to disk', DAQ_DOMAIN));
                return false;
            case UPLOAD_ERR_EXTENSION:
                $this->setError(__('File upload stopped by extension', DAQ_DOMAIN));
                return false;
            default:
                $this->setError(__('Unknown upload error', DAQ_DOMAIN));
                return false;
        }

    }
}

?>
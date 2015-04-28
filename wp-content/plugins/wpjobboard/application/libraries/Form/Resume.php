<?php
/**
 * Description of Resume
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Resume extends Wpjb_Form_Admin_Resume
{
    public static $mode = 2;

    public function init()
    {
        parent::init();
        $this->removeElement("is_approved");
    }
    
    public function save()
    {
        if(Wpjb_Project::getInstance()->conf("cv_approval")==1) {
            $e = new Daq_Form_Element("is_approved");
            $e->setValue(Wpjb_Model_Resume::RESUME_PENDING);
            $this->addElement($e);
        }

        $e = new Daq_Form_Element("updated_at");
        $e->setValue(date("Y-m-d H:i:s"));
        $this->addElement($e);
        
        parent::save();
        
        if(Wpjb_Project::getInstance()->conf("cv_approval")==1) {
            $url = rtrim(site_url(), "/");
            $url.= "/wp-admin/admin.php?page=wpjb/resumes&action=edit/id/";
            $url.= $this->getObject()->id;
            
            $mail = new Wpjb_Utility_Message(11);
            $mail->setParams($this->getObject()->toArray());
            $mail->setParam("resume_admin_url", $url);
            $mail->setTo($mail->getTemplate()->mail_from);
            $mail->send();
        }
    }

}

?>
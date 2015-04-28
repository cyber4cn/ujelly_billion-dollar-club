<?php
/**
 * Description of Email
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_Admin_Email extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_Email";

    public function __construct($id = null)
    {
        parent::__construct($id);
        if($id<1) {
            throw new Exception("Email template identified as $id does not exist.");
        }
    }

    public function init()
    {
        $e = new Daq_Form_Element("id", Daq_Form_Element::TYPE_HIDDEN);
        $e->setRequired(true);
        $e->setValue($this->_object->id);
        $e->addFilter(new Daq_Filter_Int());
        $e->addValidator(new Daq_Validate_Db_RecordExists($this->_model, "id"));
        $this->addElement($e);

        $e = new Daq_Form_Element("mail_from");
        $e->setRequired(true);
        $e->setValue($this->_object->mail_from);
        $e->setLabel(__("Email From", WPJB_DOMAIN));
        $e->setHint(__("This is also email address where email is sent if email is sent to Admin.", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_Email());
        $this->addElement($e);

        $e = new Daq_Form_Element("mail_title");
        $e->setRequired(true);
        $e->setValue($this->_object->mail_title);
        $e->setLabel(__("Email Title", WPJB_DOMAIN));
        $e->addValidator(new Daq_Validate_StringLength(1, 120));
        $this->addElement($e);
        
        $e = new Daq_Form_Element("mail_body", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setRequired(true);
        $e->setValue($this->_object->mail_body);
        $e->setLabel(__("Email Body", WPJB_DOMAIN));
        $e->setHint(__("Do NOT use html tags in the email body.", WPJB_DOMAIN));
        $this->addElement($e);

        apply_filters("wpja_form_init_email", $this);
    }
}

?>
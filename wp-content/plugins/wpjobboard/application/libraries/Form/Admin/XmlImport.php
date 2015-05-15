<?php

/**
 * Description of ${name}
 *
 * @author ${user}
 * @package 
 */
class Wpjb_Form_Admin_XmlImport extends Daq_Form_Abstract
{
    public function init()
    {
        $e = new Daq_Form_Element("file", Daq_Form_Element::TYPE_FILE);
        $e->isRequired(true);
        
        $this->addElement($e);
    }
}
?>

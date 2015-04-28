<?php
/**
 * Description of 320
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_322 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.2.2";
    }

    public function execute()
    {
        $this->_sql($this->getVersion());

        $e1 = new Wpjb_Model_Email(1);
        $e8 = new Wpjb_Model_Email(8);

        $e8->mail_from = $e1->mail_from;
        $e8->save();
    }
}

?>
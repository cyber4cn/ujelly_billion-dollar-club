<?php
/**
 * Description of 340
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_342 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.4.2";
    }

    public function execute()
    {
        $this->_sql($this->getVersion());
    }
}

?>
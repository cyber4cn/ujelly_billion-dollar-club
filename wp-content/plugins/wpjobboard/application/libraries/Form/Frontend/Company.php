<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Company
 *
 * @author greg
 */
class Wpjb_Form_Frontend_Company extends Wpjb_Form_Admin_Company
{
    protected $_mode = 2;
    
    public function init()
    {
        parent::init();
        $this->removeElement("is_active");
    }
}
?>

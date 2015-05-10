<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cash
 *
 * @author greg
 */
class Wpjb_Payment_Cash // implements Wpjb_Payment_Interface 
{
    //put your code here
    public function __construct(Wpjb_Model_Payment $data = null) {
        
    }
    public function getEngine() {
        return "Cash";
    }
    public function getTitle() {
        return __("Cash", WPJB_DOMAIN);
        
    }
    public function processTransaction(array $data) {
        
    }
    public function render() {
        
    }
}

?>

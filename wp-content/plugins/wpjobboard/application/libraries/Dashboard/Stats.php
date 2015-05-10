<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stats
 *
 * @author greg
 */
class Wpjb_Dashboard_Stats 
{
    public static function render()
    {
        $list = new Daq_Db_Query();
        $list->select("t.payment_currency as curr");
        $list->from("Wpjb_Model_Payment t");
        $list->where("payment_paid > 0");
        $list->group("payment_currency");
        $result = $list->fetchAll();
        $curr = array();
        foreach($result as $r) {
            $c = Wpjb_List_Currency::getCurrency($r->curr);
            $curr[$r->curr] = $c["name"];
        }
        
        $view = Wpjb_Project::getInstance()->getAdmin()->getView();
        /* @var $view  Daq_View */
        $view->currency = $curr;
        $view->render("dashboard/stats.php");
    }
}

?>

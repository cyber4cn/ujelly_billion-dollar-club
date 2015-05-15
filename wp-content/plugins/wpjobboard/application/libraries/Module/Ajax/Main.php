<?php
/**
 * Description of Main
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Ajax_Main
{
    public function slugifyAction()
    {
        $list = array("job" => 1, "type" => 1, "category" => 1);

        $id = Daq_Request::getInstance()->post("id");
        $title = Daq_Request::getInstance()->post("title");
        $model = Daq_Request::getInstance()->post("object");

        if(!isset($list[$model])) {
            die;
        }

        die(Wpjb_Utility_Slug::generate($model, $title, $id));
    }

    public function cleanupAction()
    {
        $db = Daq_Db::getInstance()->getDb();
        // SELECT * FROM `wpjb_employer` LEFT JOIN `wp_users` on `user_id`=`wp_users`.`ID` WHERE `wp_users`.`ID` IS NULL

        // cleanup dirs: apply, tmp
    }
}

?>
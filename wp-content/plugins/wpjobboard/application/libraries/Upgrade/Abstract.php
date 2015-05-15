<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author greg
 */
abstract class Wpjb_Upgrade_Abstract
{
    abstract public function getVersion();

    abstract public function execute();

    public function canRun()
    {
        if(version_compare($this->getVersion(), Wpjb_Project::VERSION) === 1) {
            return false;
        } else {
            return true;
        }
    }

    protected function _sql($version)
    {
        $file = Wpjb_List_Path::getPath("install") . "/install-".$version.".sql";
        $queries = explode("; --", file_get_contents($file));

        $db = Daq_Db::getInstance();
        $wpdb = $db->getDb();

        foreach($queries as $query) {
            $wpdb->query($query);
        }
    }
}
?>

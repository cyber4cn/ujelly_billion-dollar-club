<?php
/**
 * Description of 350
 *
 * @author greg
 * @package
 */


class Wpjb_Upgrade_350 extends Wpjb_Upgrade_Abstract
{
    public function getVersion()
    {
        return "3.5.0";
    }

    public function execute()
    {
        $this->_sql($this->getVersion());
        
        $project = Wpjb_Project::getInstance();
        $project->setConfigParam("show_maps", true);
        $project->saveConfig();
        
        foreach(array("frontend", "resumes") as $sc) {
            $app = Wpjb_Project::getInstance()->getApplication($sc);
            wp_update_post(array(
                "ID" => $app->getPage()->ID,
                "post_content" => $app->getOption("shortcode")
            ));
        }
        
    }
}

?>
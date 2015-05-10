<?php
/**
 * Description of AdvancedSearch
 *
 * @author greg
 * @package 
 */

class Wpjb_Form_AdvancedSearch extends Daq_Form_Abstract
{
    public function init()
    {
        global $wp_rewrite;

        if(!$wp_rewrite->using_permalinks()) {
            $e = new Daq_Form_Element("job_board", Daq_Form_Element::TYPE_HIDDEN);
            $e->setValue("find");
            $this->addElement($e);

            $e = new Daq_Form_Element("page_id", Daq_Form_Element::TYPE_HIDDEN);
            $e->setValue(Wpjb_Project::getInstance()->conf("link_jobs"));
            $this->addElement($e);
        }

        $e = new Daq_Form_Element("query");
        $e->setLabel(__("Search", WPJB_DOMAIN));
        $e->setValue(__("keyword, location, company ...", WPJB_DOMAIN));
        $e->addClass("wpjb-auto-clear");
        $this->addElement($e, "search");
        
        $e = new Daq_Form_Element("type", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Job Type", WPJB_DOMAIN));
        $e->addOption(null, null, " ");
        foreach(Wpjb_Utility_Registry::getJobTypes() as $obj) {
            $e->addOption($obj->id, $obj->id, $obj->title);
        }
        if(count(Wpjb_Utility_Registry::getJobTypes()) > 0) {
            $this->addElement($e, "search");
        }

        $e = new Daq_Form_Element("category", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Job Category", WPJB_DOMAIN));
        $e->addOption(null, null, " ");
        foreach(Wpjb_Utility_Registry::getCategories() as $obj) {
            $e->addOption($obj->id, $obj->id, $obj->title);
        }
        if(count(Wpjb_Utility_Registry::getCategories()) > 0) {
            $this->addElement($e, "search");
        }

        $e = new Daq_Form_Element("posted", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Posted", WPJB_DOMAIN));
        $e->addOption(null, null, " ");
        $e->addOption(1, 1, __("Today", WPJB_DOMAIN));
        $e->addOption(2, 2, __("Yesterday", WPJB_DOMAIN));
        $e->addOption(7, 7, __("Less then 7 days ago", WPJB_DOMAIN));
        $e->addOption(30, 30, __("Less then 30 days ago", WPJB_DOMAIN));
        $this->addElement($e, "search");

        apply_filters("wpjb_form_init_search", $this);

    }
}

?>
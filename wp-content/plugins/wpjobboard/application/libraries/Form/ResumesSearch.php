<?php
/**
 * Description of AdvancedSearch
 *
 * @author greg
 * @package
 */

class Wpjb_Form_ResumesSearch extends Daq_Form_Abstract
{
    public function init()
    {
        global $wp_rewrite;

        if(!$wp_rewrite->using_permalinks()) {
            $e = new Daq_Form_Element("job_resumes", Daq_Form_Element::TYPE_HIDDEN);
            $e->setValue("find");
            $this->addElement($e);
            
            $e = new Daq_Form_Element("page_id", Daq_Form_Element::TYPE_HIDDEN);
            $e->setValue(Wpjb_Project::getInstance()->conf("link_resumes"));
            $this->addElement($e);
        }

        $e = new Daq_Form_Element("query");
        $e->setLabel(__("Search", WPJB_DOMAIN));
        $e->setValue(__("title, experience, education ...", WPJB_DOMAIN));
        $e->addClass("wpjb-auto-clear");
        $this->addElement($e, "search");

        $e = new Daq_Form_Element("degree", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Degree", WPJB_DOMAIN));
        foreach(Wpjb_Form_Admin_Resume::getDegrees() as $k => $v) {
            $e->addOption($k, $k, $v);
        }
        $this->addElement($e, "search");
        
        $e = new Daq_Form_Element("experience", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Years of Experience", WPJB_DOMAIN));
        foreach(Wpjb_Form_Admin_Resume::getExperience() as $k => $v) {
            $e->addOption($k, $k, $v);
        }
        $this->addElement($e, "search");

        $e = new Daq_Form_Element("category", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Category", WPJB_DOMAIN));
        $e->addOption(null, null, " ");
        foreach(Wpjb_Utility_Registry::getCategories() as $obj) {
            $e->addOption($obj->id, $obj->id, $obj->title);
        }
        if(count(Wpjb_Utility_Registry::getCategories()) > 0) {
            $this->addElement($e, "search");
        }

        $e = new Daq_Form_Element("posted", Daq_Form_Element::TYPE_SELECT);
        $e->setLabel(__("Last updated", WPJB_DOMAIN));
        $e->addOption(null, null, " ");
        $e->addOption(1, 1, __("Today", WPJB_DOMAIN));
        $e->addOption(2, 2, __("Yesterday", WPJB_DOMAIN));
        $e->addOption(7, 7, __("Less than 7 days ago", WPJB_DOMAIN));
        $e->addOption(30, 30, __("Less than 30 days ago", WPJB_DOMAIN));
        $this->addElement($e, "search");

        apply_filters("wpjr_form_init_search", $this);

    }
}

?>
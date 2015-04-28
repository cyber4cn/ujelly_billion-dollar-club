<?php
/**
 * Description of Listing
 *
 * @author greg
 * @package 
 */

class Wpjb_Module_Admin_Listing extends Wpjb_Controller_Admin
{
    public function init()
    {
       $this->_virtual = array(
            "editAction" => array(
                "form" => "Wpjb_Form_Admin_Listing",
                "info" => __("Form saved.", WPJB_DOMAIN),
                "error" => __("There are errors in your form.", WPJB_DOMAIN)
            ),
            "_delete" => array(
                "model" => "Wpjb_Model_Listing",
                "info" => __("Listing deleted.", WPJB_DOMAIN),
                "error" => __("Listing could not be deleted.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "delete" => array(
                    "success" => __("Number of deleted listings: {success}", WPJB_DOMAIN)
                ),
                "activate" => array(
                    "success" => __("Number of activated listings: {success}", WPJB_DOMAIN)
                ),
                "deactivate" => array(
                    "success" => __("Number of deactivated listings: {success}", WPJB_DOMAIN)
                )
            ),
            "_multiDelete" => array(
                "model" => "Wpjb_Model_Listing"
            )
        );
    }

    public function indexAction()
    {
        $this->_delete();
        $this->_multi();
        
        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $perPage = $this->_getPerPage();

        $query = new Daq_Db_Query();
        $this->view->data = $query->select("t.*")
            ->from("Wpjb_Model_Listing t")
            ->limitPage($page, $perPage)
            ->execute();

        $query = new Daq_Db_Query();
        $total = $query->select("COUNT(*) AS total")
            ->from("Wpjb_Model_Listing")
            ->limit(1)
            ->fetchColumn();

        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);
    }

    protected function _multiActivate($id)
    {
        $object = new Wpjb_Model_Listing($id);
        $object->is_active = 1;
        $object->save();
        return true;
    }

    protected function _multiDeactivate($id)
    {
        $object = new Wpjb_Model_Listing($id);
        $object->is_active = 0;
        $object->save();
        return true;
    }

}

?>
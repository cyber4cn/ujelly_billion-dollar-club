<?php
/**
 * Description of Payment
 *
 * @author greg
 * @package
 */

class Wpjb_Module_Admin_Payment extends Wpjb_Controller_Admin
{
    public function init()
    {

    }

    public function indexAction()
    {
        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $id = null;
        if($this->_request->post("id")) {
            $id = (int)$this->_request->post("id", 1);
        }

        $this->view->id = $id;
        $perPage = $this->_getPerPage();

        $query = new Daq_Db_Query();
        $query = $query->select("t.*, t2.*")
            ->from("Wpjb_Model_Payment t")
            ->joinLeft("t.user t2")
            ->where("made_at > '0000-00-00'")
            ->limitPage($page, $perPage);

        if($id > 0) {
            $query->where("t.id = ?", $id);
        }
        $this->view->data = $query->execute();

        $query = new Daq_Db_Query();
        $total = $query->select("COUNT(*) AS total")
            ->from("Wpjb_Model_Payment t")
            ->joinLeft("t.user t2")
            ->where("made_at > '0000-00-00'")
            ->limit(1);
        
        if($id > 0) {
            $query->where("t.id = ?", $id);
        }
        $total = $total->fetchColumn();

        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);
    }



}

?>
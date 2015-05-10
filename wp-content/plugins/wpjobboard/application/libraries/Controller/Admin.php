<?php
/**
 * Description of Admin
 *
 * @author greg
 * @package 
 */

class Wpjb_Controller_Admin extends Daq_Controller_Abstract
{
    protected $_virtual = array();

    protected $_perPage = 20;

    protected function _getPerPage()
    {
        return $this->_perPage;
    }

    protected function _addInfo($info)
    {
        $this->view->_flash->addInfo($info);
    }

    protected function _addError($error)
    {
        $this->view->_flash->addError($error);
    }

    public function editAction()
    {
        extract($this->_virtual[__FUNCTION__]);

        $form = new $form($this->_request->getParam("id"));
        if($this->isPost()) {
            $isValid = $form->isValid($this->_request->getAll());
            if($isValid) {
                $this->_addInfo($info);
                $form->save();
            } else {
                $this->_addError($error);
            }
        }

        $this->view->form = $form;
    }
    
    protected function _delete()
    {
        extract($this->_virtual[__FUNCTION__]);
        
        if($this->isPost() && $this->hasParam("delete")) {
            $id = $this->_request->post("id", 0);
            try {
                $model = new $model($id);
                $model->delete();
                $this->_addInfo($info);
            } catch(Exception $e) {
                $this->_addError($e->getMessage());
                // @todo: logging
            }
        }
    }

    protected function _multi()
    {
        extract($this->_virtual[__FUNCTION__]);
        $inArray = array_keys($this->_virtual[__FUNCTION__]);
        $action = $this->_request->post("action");

        $inArray = new Daq_Validate_InArray($inArray);
        $inArray = $inArray->isValid($action);
        $idList = $this->_request->post("item", array());

        $success = 0;
        $fail = 0;

        if($inArray && count($idList)>0) {
            foreach($idList as $id) {
                $func = "_multi".ucfirst($action);
                if($this->$func($id)) {
                    $success++;
                } else {
                    $fail++;
                }
            }

            $msg = $this->_virtual[__FUNCTION__][$action]['success'];
            $repl = array($success, $fail);
            $find = array("{success}", "{fail}");
            $compiled = str_replace($find, $repl, $msg);
            $this->_addInfo($compiled);
        }
    }

    protected function _multiDelete($id)
    {
        extract($this->_virtual[__FUNCTION__]);
        
        try {
            $model = new $model($id);
            $model->delete();
            return true;
        } catch(Exception $e) {
            // log error
            return false;
        }
    }

    //protected function _multiModify()
}

?>
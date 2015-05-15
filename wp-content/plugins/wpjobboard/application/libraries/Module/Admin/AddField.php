<?php
/**
 * Description of Listing
 *
 * @author greg
 * @package
 */

class Wpjb_Module_Admin_AddField extends Wpjb_Controller_Admin
{
    public function init()
    {
       $this->_virtual = array(
            "_delete" => array(
                "model" => "Wpjb_Model_AdditionalField",
                "info" => __("Additional Field deleted.", WPJB_DOMAIN),
                "error" => __("Additional Field could not be deleted.", WPJB_DOMAIN)
            ),
            "_multi" => array(
                "delete" => array(
                    "success" => __("Number of deleted additional fields: {success}", WPJB_DOMAIN)
                ),
                "activate" => array(
                    "success" => __("Number of activated additional fields: {success}", WPJB_DOMAIN)
                ),
                "deactivate" => array(
                    "success" => __("Number of deactivated additional fields: {success}", WPJB_DOMAIN)
                )
            ),
            "_multiDelete" => array(
                "model" => "Wpjb_Model_AdditionalField"
            )
        );
    }

    public function indexAction()
    {
        $this->_delete();
        $this->_multi();

        $page = $this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $perPage = $this->_getPerPage();

        $query = new Daq_Db_Query();
        $this->view->data = $query->select("t.*")
            ->from("Wpjb_Model_AdditionalField t")
            ->limitPage($page, $perPage)
            ->execute();

        $query = new Daq_Db_Query();
        $total = $query->select("COUNT(*) AS total")
            ->from("Wpjb_Model_AdditionalField")
            ->limit(1)
            ->fetchColumn();

        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);
    }

    protected function _multiActivate($id)
    {
        $object = new Wpjb_Model_AdditionalField($id);
        $object->is_active = 1;
        $object->save();
        return true;
    }

    protected function _multiDeactivate($id)
    {
        $object = new Wpjb_Model_AdditionalField($id);
        $object->is_active = 0;
        $object->save();
        return true;
    }

    public function editAction()
    {
        $form = new Wpjb_Form_Admin_AdditionalField($this->_request->getParam("id"));
        $object = $form->getObject();
        $oldType = $object->type;

        if($this->isPost()) {
            $isValid = $form->isValid($this->_request->getAll());
            if($isValid) {
                $this->_addInfo(__("Form saved.", WPJB_DOMAIN));
                $form->save();
                if($this->_request->getParam("type") == 4) {
                    $id = $form->getObject()->getId();
                    $opt = $this->_request->getParam("option");
                    $this->_saveOptions($id, $opt);
                }

                if($oldType == 4 && $this->_request->getParam("type") != 4) {
                    $temp = new Wpjb_Model_FieldOption;
                    $table = $temp->tableName();
                    Daq_Db::getInstance()->delete($table, "field_id=".$object->getId());
                }
            } else {
                $this->_addError(__("There are errors in your form.", WPJB_DOMAIN));
            }
        }

        $this->view->option = "{}";
        if($object->getId() > 0) {
            $query = new Daq_Db_Query();
            $optionList = $query->select("t.*")
                ->from("Wpjb_Model_FieldOption t")
                ->where("field_id = ?", $object->getId())
                ->execute();

            $json = array();
            foreach($optionList as $option) {
                $obj = new stdClass;
                $obj->id = $option->id;
                $obj->value = $option->value;
                $json[] = $obj;
            }
            $this->view->option = json_encode($json);
        }

        $this->view->typeValue = $object->type;
        $this->view->form = $form;
    }

    protected function _saveOptions($fId, array $option)
    {
		$list = new Daq_Db_Query();
		$list->select("*");
		$list->from("Wpjb_Model_FieldOption t");
		$list->where("field_id = ?", $fId);
		$list = $list->execute();
		$arr = array();
		foreach($list as $opt) {
			$arr[$opt->id] = $opt->id;
		}
		
        foreach($option as $key => $value) {
            list($x, $id) = explode("_", $key);
            $field = new Wpjb_Model_FieldOption($id);
            $field->field_id = $fId;
            $field->value = $value;
            $field->save();
            unset($arr[$id]);
        }
        
        foreach($arr as $id) {
			$field = new Wpjb_Model_FieldOption($id);
			$field->delete();
		}
    }

}

?>

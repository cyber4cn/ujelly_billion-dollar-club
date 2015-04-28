<?php
/**
 * Description of ObjectAbstract
 *
 * @author greg
 * @package 
 */

abstract class Daq_Form_ObjectAbstract extends Daq_Form_Abstract
{
    protected $_model = null;

    protected $_object = null;

    public function __construct($id = null, $exclude = true)
    {
        if($this->_model === null) {
            throw new Exception('$this->_model is null');
        }
        $model = $this->_model;
        
        $this->_object = new $model($id);
        parent::__construct($exclude);
    }

    public function save()
    {
        $varList = $this->getValues();
        foreach($this->_object->getFieldNames() as $f) {
            if(isset($varList[$f])) {
                $this->_object->$f = $varList[$f];
            }
        }

        $this->_object->save();
        $this->reinit();
    }

    public function reinit()
    {
        $id = $this->_object->getId();

        $model = $this->_model;
        $this->_field = array();
        $this->_object = new $model($id);
        $this->_group = array();
        $this->_defaultScheme = null;
        $this->_modifiedScheme = null;
        $this->_object = new $model($id);

        $this->init();

        if($this->_modifiedScheme) {
            $this->_defaultScheme = $this->getScheme();
            $this->modifyScheme($this->_excludeHidden);
        }
    }

    /**
     *
     * @return Daq_Db_OrmAbstract
     */
    public function getObject()
    {
        return $this->_object;
    }
}

?>
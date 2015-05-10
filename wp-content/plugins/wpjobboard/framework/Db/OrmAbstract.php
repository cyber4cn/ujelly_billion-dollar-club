<?php
/**
 * Description of OrmAbstract
 *
 * @author greg
 * @package 
 */


abstract class Daq_Db_OrmAbstract
{
    protected $_reference = array();

    protected $_field = array();

    protected $_trackChanges = true;

    protected $_primary = null;

    protected $_loaded = array();

    public $helper = array();

    protected abstract function _init();

    public function __construct($id = null)
    {
        $this->_init();

        foreach(Daq_Db::getInstance()->describeTable($this->_name) as $row) {
            $this->_field[$row->Field] = array();
            if($row->Key == "PRI") {
                $this->_primary = $row->Field;
            }
        }

        if($id !== null) {
            $this->_load($id);
        }
        $this->_postInit();

        if(!$this->_name) {
            throw new Exception('$_name field is missing');
        }
    }

    protected function _load($id)
    {
        $wp = Daq_Db::getInstance()->getDb();
        $q = "SELECT * FROM ".$this->tableName()." WHERE ".$this->_primary."=".(int)$id;
        $result = $wp->get_row($q, ARRAY_A);
        if($result === null) {
            return null;
        }
        
        $this->fromArray($result);
    }

    protected function _postInit()
    {
        foreach($this->_field as $key => $arr) {
            $arr['modified'] = false;
            $this->_field[$key] = $arr;
        }
    }

    public function fromArray(array $arr)
    {
        $this->_trackChanges = false;
        foreach($arr as $key => $value) {
            $this->set($key, $value);
        }
        $this->_trackChanges = true;
    }

    public function tableName()
    {
        return $this->_name;
    }

    public function getReference($key)
    {
        if(!isset($this->_reference[$key])) {
            throw new Exception("Unknown reference: $key");
        }

        return $this->_reference[$key];
    }

    public function getReferences()
    {
        return $this->_reference;
    }

    public function getFields()
    {
        return $this->_field;
    }

    public function getFieldNames()
    {
        return array_keys($this->_field);
    }

    public function toArray()
    {
        $arr = array();
        foreach($this->_field as $k => $f) {
            $arr[$k] = $f['value'];
        }
        return $arr;
    }

    public function set($key, $value)
    {
        if(!isset($this->_field[$key])) {
            throw new Exception("Key [$key] does not exist.");
        }

        $this->_field[$key]['value'] = $value;

        if($this->_trackChanges) {
            $this->_field[$key]['modified'] = true;
        }
    }

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    public function get($key)
    {
        if(isset($this->_field[$key]['value'])) {
            return $this->_field[$key]['value'];
        } else {
            return null;
        }
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function getId()
    {
        if(isset($this->_field[$this->_primary]['value'])) {
            return (int)$this->_field[$this->_primary]['value'];
        }
        return 0;
    }

    public function save()
    {
        $toSave = array();
        foreach($this->_field as $key => $value) {
            if($value['modified']) {
                $toSave[$key] = $value['value'];
            }
        }

        $table = $this->tableName();
        $wp = Daq_Db::getInstance()->getDb();
        if($this->getId() > 0) {
            $wp->update($table, $toSave, array($this->_primary => $this->getId()));
            return $this->getId();
        } else {
            $wp->insert($table, $toSave);
            $this->set($this->_primary, $wp->insert_id);
            return $wp->insert_id;
        }

    }

    public function delete()
    {
        Daq_Db::getInstance()->delete($this->tableName(), "id=".$this->getId());
        if(mysql_errno() > 0) {
            throw new Daq_Db_Exception();
        }
        return true;
    }

    public function addRef($object) 
    {
        $class = get_class($object);
        foreach($this->_reference as $key => $value) {
            if($value['foreign'] == $class) {
                $c1 = $value['localId'];
                $c2 = $value['foreignId'];
                if($object->getId() < 1) {
                    $object->set($c2, $this->get($c1));
                    $this->_loaded[$class] = $object;
                    return;
                }
                if($this->get($c1, -1) == $object->get($c2, -2)) {
                    $this->_loaded[$class] = $object;
                    return;
                }
            }
        }

        throw new Exception("Reference to $class does not exist.");
    }

    public function __call($method, $param = array())
    {
        $call = str_replace("get", "", strtolower($method));
        foreach($this->_reference as $key => $value) {
            if($key == $call) {
                if(!isset($this->_loaded[$value['foreign']])) {
                    if(isset($param[0]) && $param[0] == true) {
                        $class = $value['foreign'];
                        $local = $value['localId'];
                        
                        $query = new Daq_Db_Query();
                        $query->select()
                            ->from($class." t")
                            ->where($value['foreignId']." = ?", $this->$local);

                        if(isset($value['with'])) {
                            $query->where($value['with']);
                        }

                        $result = $query->execute();
                        $this->_loaded[$value['foreign']] = new $class;
                        if(!empty($result)) {
                            $this->_loaded[$value['foreign']] = $result[0];
                        }
                    } else {
                        throw new Exception("Object {$value['foreign']} not loaded for class ".__CLASS__);
                    }
                }
                return $this->_loaded[$value['foreign']];
            }
        }
        throw new Exception("Method $method does not exist for class ".__CLASS__);
    }

}


?>
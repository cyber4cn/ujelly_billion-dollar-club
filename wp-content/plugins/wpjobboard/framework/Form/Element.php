<?php
/**
 * Description of Element
 *
 * @author greg
 * @package 
 */

class Daq_Form_Element
{
    const TYPE_TEXT = 1;
    const TYPE_RADIO = 2;
    const TYPE_CHECKBOX = 3;
    const TYPE_SELECT = 4;
    const TYPE_FILE = 5;
    const TYPE_TEXTAREA = 6;
    const TYPE_HIDDEN = 7;
    const TYPE_PASSWORD = 8;

    protected $_validator = array();

    protected $_filter = array();

    protected $_name = "";

    protected $_value = null;

    protected $_type = null;

    protected $_errors = array();

    protected $_hasErrors = null;

    protected $_required = false;

    protected $_label = null;

    protected $_hint = null;

    protected $_option = array();

    protected $_visible = true;
    
    protected $_css = array();
    
    protected $_renderer = null;

    public function __construct($name, $type = self::TYPE_TEXT)
    {
        $this->_name = $name;
        $this->_type = $type;
    }

    public function isMultiOption()
    {
        switch($this->_type) {
            case self::TYPE_RADIO:
            case self::TYPE_CHECKBOX:
            case self::TYPE_SELECT:
                return true;
            default:
                return false;
        }
    }

    public function getTypeTag()
    {
        switch($this->_type) {
            case self::TYPE_TEXT: return "input-text";
            case self::TYPE_RADIO: return "input-radio";
            case self::TYPE_CHECKBOX: return "input-checkbox";
            case self::TYPE_SELECT: return "input-file";
            case self::TYPE_FILE: return "input-select-one";
            case self::TYPE_TEXTAREA: return "input-textarea";
            case self::TYPE_HIDDEN: return "input-hidden";
            case self::TYPE_PASSWORD: return "input-password";
        }
        
    }

    /**
     * Check if element is visible
     *
     * @return bool
     */
    public function isVisible()
    {
        return (bool)$this->_visible;
    }

    /**
     * Sets element visibility
     *
     * @param bool $visible
     */
    public function setVisible($visible)
    {
        $this->_visible = (bool)$visible;
    }

    public function addOption($key, $value, $desc)
    {
        if(!$this->isMultiOption()) {
            throw new Exception("Input cannot have multi options");
        }
        $this->_option[] = array("key"=>$key, "value"=>$value, "desc"=>$desc);
    }

    public function getOptions()
    {
        return $this->_option;
    }

    public function addValidator(Daq_Validate_Interface $validator)
    {
        $this->_validator[] = $validator;
        return $this;
    }

    public function addFilter(Daq_Filter_Interface $filter)
    {
        $this->_filter[] = $filter;
        return $this;
    }

    public function setValue($value)
    {
        $this->_value = $value;
    }

    public function validate()
    {
        $value = $this->_value;
        $this->_hasErrors = false;

        if($this instanceof Daq_Form_Element_File) {
            $isEmpty = $value["size"] == 0;
        } elseif($this->isMultiOption()) {
            foreach($this->_filter as $filter) {
                $value = $filter->filter($value);
            }
            $isEmpty = is_null($value);
        } else {
            $isEmpty = empty($value);
        }

        if($isEmpty) {
            if(!$this->_required) {
                return true;
            } else {
                $this->addValidator(new Daq_Validate_Required);
            }
        }

        foreach($this->_filter as $filter) {
            $value = $filter->filter($value);
        }
        $this->_value = $value;

        foreach($this->_validator as $validator) {
            $isValid = $validator->isValid($value);
            if(!$isValid) {
                $this->_hasErrors = true;
                $this->_errors = $validator->getErrors();
            }
        }

        return !$this->_hasErrors;
    }

    public function pushError($error)
    {
        $this->_errors[] = $error;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function hasErrors()
    {
        return (bool)count($this->_errors);
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function setRequired($bool)
    {
        $this->_required = $bool;
    }

    public function isRequired()
    {
        return $this->_required;
    }

    public function getLabel()
    {
        return $this->_label;
    }

    public function setLabel($label)
    {
        $this->_label = $label;
    }

    public function getHint()
    {
        return $this->_hint;
    }

    public function hasHint()
    {
        if($this->_hint === null) {
            return false;
        }
        return true;
    }

    public function setHint($hint)
    {
        $this->_hint = $hint;
    }

    public function getType()
    {
        return $this->_type;
    }
    
    public function addClass($class)
    {
        $this->_css[] = $class;
    }
    
    public function hasClass($class)
    {
        return in_array($class, $this->_css);
    }
    
    public function getClasses($toString = true)
    {
        if($toString) {
            return join(" ", $this->_css);
        } else {
            return $this->_css;
        }
    }
    
    public function hasRenderer()
    {
        return !is_null($this->_renderer);
    }
    
    public function setRenderer($renderer)
    {
        if(!is_callable($renderer)) {
            throw new Exception("Given argument is not a valid callback");
        }
        
        $this->_renderer = $renderer;
    }
    
    public function unsetRenderer()
    {
        $this->_renderer = null;
    }
    
    public function getRenderer($options = array())
    {
        return $this->_renderer;
    }
    
}


?>
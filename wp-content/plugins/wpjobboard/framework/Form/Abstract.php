<?php
/**
 * Description of Element
 *
 * @author greg
 * @package
 */

abstract class Daq_Form_Abstract
{
    protected $_field = array();

    protected $_errors = array();

    protected $_renderer = null;

    protected $_group = array();

    protected $_defaultScheme = null;

    protected $_modifiedScheme = null;

    protected $_excludeHidden = true;
    
    protected $_css = array();

    public function __construct($excludeHidden = true)
    {
        $this->_renderer = new Daq_Form_AdminRenderer;
        $this->_excludeHidden = $excludeHidden;
        $this->init();

        if($this->_modifiedScheme) {
            $this->_defaultScheme = $this->getScheme();
            $this->modifyScheme($this->_excludeHidden);
        }
    }

    public function addElement(Daq_Form_Element $field, $group = null)
    {
        $this->_field[$field->getName()] = $field;

        if($group !== null) {
            if(!is_array($this->_group[$group])) {
                $this->addGroup($group);
            }
            $this->_group[$group]["element"][] = $field->getName();
        }
    }

    public function addGroup($key, $title = "", $order = 0)
    {
        $this->_group[$key] = array("title"=>$title, "element"=>array());
    }

    public function hasElement($name)
    {
        return array_key_exists($name, $this->_field);
    }

    public function getElement($name)
    {
        return $this->_field[$name];
    }

    /**
     * Return all form elements
     *
     * @return array
     */
    public function getElements()
    {
        return $this->_field;
    }

    public function removeElement($name)
    {
        if(isset($this->_field[$name])) {
            unset($this->_field[$name]);

            foreach($this->_group as $key => $group) {
                $k = array_search($name, (array)$group["element"]);
                if($k !== false) {
                    unset($this->_group[$key]["element"][$k]);
                }
            }
        }
    }

    /**
     * Returns all form groups
     *
     * @return array
     */
    public function getGroups()
    {
        return $this->_group;
    }
    
    /**
     * Returns all groups that have at least one element
     * 
     * @return array
     */
    public function getNonEmptyGroups()
    {
        $groups = array();
        foreach($this->getGroups() as $k => $g) {
            
            $ng = new stdClass;
            $ng->name = $k;
            $ng->legend = $g["title"];
            $ng->element = array();
            
            foreach($g["element"] as $key => $field) {
                $f = $this->getElement($field);
                if($f->getType() != Daq_Form_Element::TYPE_HIDDEN) {
                    $ng->element[$key] = $f;
                }
            }
            
            if(!empty($ng->element)) {
                $groups[] = $ng;
            }
        }

        return $groups;
    }

    /**
     * Returns list of fields that belong to this group
     *
     * @param string $group
     * @return array
     */
    public function getGroup($group)
    {
        return $this->_group[$group]["element"];
    }

    /**
     * Return group title
     *
     * @param string $group
     * @return string
     */
    public function getGroupTitle($group)
    {
        return $this->_group[$group]["title"];
    }

    /**
     * Sets group title
     *
     * @param string $group
     * @param string $title
     * @throws Exception If group identified by $group varialbe does not exist
     */
    public function setGroupTitle($group, $title)
    {
        if(!isset($this->_group[$group])) {
            throw new Exception("Group [$group] does not exist.");
        }
        $this->_group[$group]["title"] = $title;
    }

    /**
     * Validates the form
     *
     * @param array $values
     * @return boolean
     */
    public function isValid(array $values)
    {
        $isValid = true;
        $file = array();
        foreach($this->_field as $field)
        {
            $value = null;
            if(isset($values[$field->getName()])) {
                $value = $values[$field->getName()];
            }

            if($field->getType() == Daq_Form_Element::TYPE_FILE) {
                if(isset($_FILES[$field->getName()])) {
                    $field->setValue($_FILES[$field->getName()]);
                }
            } else {
                $field->setValue($value);
            }

            if(!$field->validate()) {
                $isValid = false;
                $this->_errors[$field->getName()] = array();
                foreach($field->getErrors() as $error) {
                    $this->_errors[$field->getName()][] = $error;
                }
            }
        }
        return $isValid;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function hasErrors()
    {
        return (bool)count($this->_errors);
    }

    public function getValues()
    {
        $arr = array();
        foreach($this->_field as $field) {
            $arr[$field->getName()] = $field->getValue();
        }
        return $arr;
    }

    public function render($render = null)
    {
        if(is_string($render)) {
            $render = array($render);
        }
        if(!is_array($render)) {
            $render = $this->_field;
        } else {
            $rList = $render;
            $render = array();
            foreach($rList as $r) {
                $render[$r] = $this->getElement($r);
            }
        }

        $html = "";
        foreach($render as $field) {
            if(!$field instanceof Daq_Form_Element) {
                $html .= $field;
            } elseif($field->getType() === Daq_Form_Element::TYPE_HIDDEN) {
                $html .= $this->_renderer->renderTag($field);
            } else {
                $html .= $this->_renderer->render($field);
            }
        }

        return $html;
    }

    public function renderGroup($group)
    {
        if(isset($this->_group[$group])) {
            return $this->render($this->_group[$group]["element"]);
        }

        return null;
    }

    public function renderHidden()
    {
        $html = "";
        foreach($this->_field as $field) {
            if($field->getType() === Daq_Form_Element::TYPE_HIDDEN) {
                $html .= $this->_renderer->renderTag($field);
            } 
        }
        return $html;
    }

    public function setRenderer($renderer)
    {
        $this->_renderer = $renderer;
    }

    public function getRenderer()
    {
        return $this->_renderer;
    }

    public function getScheme()
    {
        $scheme = array();
        foreach($this->_group as $k => $group) {
            $scheme[$k] = array(
                "title" => $group["title"],
                "element" => array()
            );

            foreach($group["element"] as $element) {
                $e = $this->getElement($element);
                $scheme[$k]["element"][$element] = array(
                    "name" => $element,
                    "label" => $e->getLabel(),
                    "hint" => $e->getHint(),
                    "required" => $e->isRequired(),
                    "visible" => $e->isVisible()
                );
            }
        }

        return $scheme;
    }

    public function getDefaultScheme()
    {
        return $this->_defaultScheme;
    }

    public function modifyScheme($excludeHidden = true)
    {
        $scheme = $this->getFinalScheme();
        $this->_group = $scheme;

        foreach($scheme as $key => $group) {
            $this->_group[$key]["element"] = array();
            if(!is_array($group["element"])) {
                continue;
            }
            foreach($group["element"] as $e) {

                $name = $e["name"];
                $label = $e["label"];
                $hint = $e["hint"];
                $required = $e["required"];
                $visible = $e["visible"];

                if(!$this->hasElement($name)) {
                    continue;
                }

                $this->getElement($name)->setVisible($visible);
                $this->getElement($name)->setRequired($required);
                $this->getElement($name)->setLabel($label);
                $this->getElement($name)->setHint($hint);
                
                if($visible || !$excludeHidden) {
                    $this->_group[$key]["element"][] = $name;
                } else {
                    $this->removeElement($name);
                }
            }
        }
    }

    public function getFinalScheme()
    {
        $default = $this->getDefaultScheme();
        $modified = $this->_modifiedScheme;

        if(!is_array($modified)) {
            return $default;
        }

        $names = array();
        foreach($modified as $group => $sch) {
            if(!is_array($sch["element"])) {
                continue;
            }

            foreach($sch["element"] as $name => $el) {
                $name = $el["name"];
                if(!$this->hasElement($name)) {
                    unset($modified[$group]["element"][$name]);
                } else {
                    $names[] = $name;
                }
            }
        }

        foreach($default as $group => $sch) {
            foreach($sch["element"] as $name => $el) {

                if(!in_array($name, $names) && $this->hasElement($name)) {
                    $field = $this->getElement($name);
                    $modified[$group]["element"][$name] = array(
                        "name" => $name,
                        "label" => $field->getLabel(),
                        "hint" => $field->getHint(),
                        "required" => $field->isRequired(),
                        "visible" => $field->isVisible()
                    );
                }

            }
        }

        foreach($modified as $group => $sh) {
            if(!isset($modified[$group]["title"])) {
                $modified[$group]["title"] = $default[$group]["title"];
            }
        }

        return $modified;
    }

    public function setModifiedScheme($scheme = null)
    {
        $this->_modifiedScheme = $scheme;
    }

    public function getModifiedScheme()
    {
        return $this->_modifiedScheme;
    }

    abstract function init();
}

?>
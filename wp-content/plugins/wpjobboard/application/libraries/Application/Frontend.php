<?php
/**
 * Description of Frontend
 *
 * @author greg
 * @package 
 */

class Wpjb_Application_Frontend extends Daq_Application_FrontAbstract
{
    public function getProject() 
    {
        return Wpjb_Project::getInstance();
    }
    
    public function dispatch($path)
    {
        $path = rtrim($path, "/")."/";
        $route = $this->getRouter()->match($path);
        apply_filters("wpjb_dispatched", $route);
        $result = $this->_dispatch($route);
        $result = apply_filters("wpjb_select_template", $result);
        $this->_postDispatch($result, "wpjb_flash");
    }
}

?>
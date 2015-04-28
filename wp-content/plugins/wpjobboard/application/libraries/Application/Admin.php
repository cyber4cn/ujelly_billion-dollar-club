<?php
/**
 * Description of Admin
 *
 * @author greg
 * @package 
 */

class Wpjb_Application_Admin extends Daq_Application_Abstract
{

    public function dispatch($path)
    {
        $path = rtrim($path, "/")."/";
        $route = $this->getRouter()->match($path);
        foreach($route['param'] as $k => $v) {
            Daq_Request::getInstance()->addParam("GET", $k, $v);
        }

        $index = $route['module']."/".$route['action'];

        $ctrl = rtrim($this->_controller, "*").ucfirst($route['module']);
        $action = $route['action']."Action";

        if(!class_exists($ctrl)) {
            throw new Exception("Module [$ctrl] does not exist");
        }
        $controller = new $ctrl;

        if(Wpjb_Utility_Seal::check()) {
            Wpjb_Upgrade_Manager::upgrade();
        }

        $info = wp_get_current_user();
        $isAdmin = true;
        if(!isset($info->wp_capabilities) || !$info->wp_capabilities['administrator']) {
            $isAdmin = false;
        }

        $this->_view->slot("is_admin", $isAdmin);

        if(!method_exists($controller, $action)) {
            throw new Exception("Method [$action] does not exist for controller [$ctrl]");
        }
        
        $controller->setView($this->_view);
        $controller->init();
        $controller->$action();
        $controller->view->render($index.".php");

    }
}

?>
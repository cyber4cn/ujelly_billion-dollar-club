<?php
/**
 * Description of ProjectAbstract
 *
 * @author greg
 * @package 
 */

abstract class Daq_ProjectAbstract
{
    const REWRITE_PATTERN = "/(.*)";
    
    protected $_application = array();

    /**
     * Path to directory containing user widgets
     * 
     * @var array
     */
    protected $_widgetPath = null;

    /**
     * Path to plugin main directory
     *
     * @var string
     */
    protected $_baseDir = null;
    
    /**
     * List of application paths
     *
     * @var array
     */
    protected $_path = array();

    /**
     * Array of environment variables
     *
     * @var array
     */
    private $_env = array();
    
    /**
     * URL
     *
     * @var string
     */
    public $url = null;
    
    public $text = null;
    
    public $placeHolder = null;
    
    private $_config = null;
    
    public $title = null;
   
    
    /**
     * Returns instance of project
     */
    abstract public static function getInstance();

    /**
     * Register hooks and filters
     */
    abstract public function run();

    /**
     * Adds application to the list of registered applications
     *
     * @param string $key Application name
     * @param Daq_Application $application Object
     */
    public function addApplication($key, Daq_Application_Abstract $application)
    {
        $this->_application[$key] = $application;
    }

    /**
     * Returns registered application by key
     *
     * @param string $key
     * @return Daq_Application
     */
    public function getApplication($key)
    {
        return $this->_application[$key];
    }

    /**
     * Registers widgets from given directory.
     *
     * It's good practice to load user widgets before default widgets because
     * it gives users opportunity to overwrite default widgets.
     *
     * @param string $dir Path to widgets directory
     */
    public function addUserWidgets($widget)
    {
        $this->_widgetPath = $widget;
    }

    /**
     * Sets path to plugin main directory
     *
     * @param string $dir
     */
    public function setBaseDir($dir)
    {
        $this->_baseDir = $dir;
    }

    /**
     * Returns base path, ie path to the plugin main directory
     *
     * @return string
     */
    public function getBaseDir()
    {
        return $this->_baseDir;
    }
    
    /**
     * Sets environment variable
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function env($key, $default = null)
    {
        if(isset($this->_env[$key])) {
            return $this->_env[$key];
        }

        return $default;
    }

    /**
     * Returns environment variable
     *
     * @param string $key
     * @param mixed $value 
     */
    public function setEnv($key, $value)
    {
        $this->_env[$key] = $value;
    }
    
    /**
     * Returns project base path
     *
     * @return string
     */
    public function getProjectBaseDir()
    {
        return $this->_baseDir;
    }

    /**
     * Sets blog URL
     *
     * @deprecated Use get_bloginfo("url") instead
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function getUrl($app = "frontend")
    {
        return $this->getApplication($app)->getUrl();
    }

    public function conf($param = null, $default = null)
    {
        return $this->getConfig($param, $default);
    }
    
    /**
     * Returns router for selected application or for frontend
     * application if no param is specified.
     *
     * @param string $app Router for application
     * @return Daq_Router
     */
    public function router($app = "frontend")
    {
        return $this->getApplication($app)->getRouter();
    }

    public function media()
    {
        $dir = $this->env("directory");
        $dir = site_url()."/wp-content/plugins/$dir/templates/";

        return $dir;
    }

    public function getConfig($param = null, $default = null)
    {
        $config = $this->_config;

        if($config === null) {
            $config = get_option($this->env("config_key"));
            $this->_config = $config;
        }

        if($config === false) {
            $config = array();
            add_option($this->env("config_key"), $config);
        }

        if($param === null) {
            return $config;
        }

        if(isset($config[$param]) && !empty($config[$param])) {
            return $config[$param];
        } else {
            return $default;
        }
    }

    public function setConfigParam($param, $value)
    {
        $config = $this->getConfig();
        $config[$param] = $value;
        $this->_config = $config;
    }

    public function saveConfig()
    {
        update_option($this->env("config_key"), $this->getConfig());
    }
    
    /**
     * Initiates project: widgets, AJAX actions, activation and deactivation hooks
     * 
     * @return void
     */
    public function _init()
    {
        $d = $this->getBaseDir();
        $cp = $this->env("prefix_class");
        $pr = $this->env("prefix");
        $directory = $this->env("directory");
        foreach((array)glob($d."/application/libraries/Module/Ajax/*.php") as $ajax) {
            $ctrl = basename($ajax, ".php");
            $ajaxClass = "{$cp}_Module_Ajax_".$ctrl;
            $ctrl = strtolower($ctrl);
            foreach(get_class_methods($ajaxClass) as $method) {
                if(substr($method, -6) == "Action") {
                    $m = substr($method, 0, -6);
                    add_action("wp_ajax_{$pr}_".$ctrl."_".$m, array($ajaxClass, $method));
                }
            }
        }
        foreach((array)glob($d."/application/libraries/Module/AjaxNopriv/*.php") as $ajax) {
            $ctrl = basename($ajax, ".php");
            $ajaxClass = "{$cp}_Module_AjaxNopriv_".$ctrl;
            $ctrl = strtolower($ctrl);
            foreach(get_class_methods($ajaxClass) as $method) {
                if(substr($method, -6) == "Action") {
                    $m = substr($method, 0, -6);
                    add_action("wp_ajax_{$pr}_".$ctrl."_".$m, array($ajaxClass, $method));
                    add_action("wp_ajax_nopriv_{$pr}_".$ctrl."_".$m, array($ajaxClass, $method));
                }
            }
        }
        
        add_action("widgets_init", array($this, "widgetsInit"));
        add_filter("sidebars_widgets", array($this, "widgets"));
        
        register_activation_hook("$directory/index.php", array($this,"install"));
        register_deactivation_hook("$directory/index.php", array($this,"deactivate"));
    }
    
    public function widgetsInit()
    {
        $d = $this->getBaseDir();
        $cp = $this->env("prefix_class");
        foreach((array)glob($d."/application/libraries/Widget/*.php") as $widget) {
            $widgetClass = "{$cp}_Widget_".basename($widget, ".php");
            if(class_exists($widgetClass)) {
                $widget = new $widgetClass($this->env("template_base")."/widget");
                if($widget instanceof WP_Widget) {
                    register_widget($widgetClass);
                } 
            }
        }
    }
    
    /**
     * Returns array of non-admin applications
     *
     * @return array
     */
    protected function _apps()
    {
        $apps = array();
        foreach($this->_application as $a) {
            if(!$a->isAdmin()) {
                $apps[] = $a;
            }
        }
        
        return $apps;
    }
    
    public function widgets($widgets)
    {

        if(is_admin()) {
            return $widgets;
        }

        if(defined("WP_ADMIN") && WP_ADMIN === true) {
            return $widgets;
        }

        $prefix = $this->env("prefix");

        foreach($this->_apps() as $app) {
            if($app->isDispatched()) {
                return $widgets;
            }
        }

        // running on blog
        $pLen = strlen($prefix)+1;
        foreach($widgets as &$sb) {
            if(!is_array($sb)) {
                continue;
            }
            foreach($sb as &$name) {
                if(strlen($name)>$pLen && substr($name, 0, $pLen) == $prefix."-") {
                    $opt = explode("-", $name);
                    $i = array_pop($opt);
                    $option = get_option("widget_".join("-", $opt), new stdClass());
                    $option = $option[$i];
                    if(isset($option["hide"]) && $option["hide"] == 1) {
                        $name = null;
                    }
                }
            }
        }

        return $widgets;
    }
    
    public function loadPaths(array $paths)
    {
        $this->_path = $paths;
    }
    
    public function path($key)
    {
        return $this->getProjectBaseDir().$this->_path[$key];
    }

    public function pathRaw($key)
    {
        return $this->_path[$key];
    }

    public function redirectCanonical($url)
    {
        if(get_option("show_on_front") != "page") {
            return $url;
        }

        $front = get_option("page_on_front");

        foreach($this->_apps() as $app) {
            $id = $app->getPage()->ID;
            if($front == $id && is_page($id)) {
                return false;
            }
        }

        return $url;
    }
    
    /**
     *
     * @return Daq_Application
     */
    public function getAdmin()
    {
        if(!isset($this->_application["admin"])) {
            throw new Exception("Admin application not set.");
        }

        return $this->_application['admin'];
    }

    public function dispatch()
    {
        $action = "";
        if(isset($_GET['action'])) {
            $action = $_GET['action'];
        }

        $path = trim($_GET['page'], "/")."/".trim($action, "/");
        $path = substr($path, strlen($this->env("prefix"))+1);
        
        $admin = $this->getAdmin();
        $admin->dispatch($path);
    }
    
    public function execute($content)
    {
        global $wp;

        foreach($this->_apps() as $app) {
            /* @var $app Daq_Application */
            $id = $this->conf($app->getOption("link_name"));
            
            if(!is_page($id)) {
                continue;
            }
            
            add_action('wp_head', array($this, "canonicalUrl"), 1);
            ob_start();

            try {
                $opt = $app->getOption("query_var");
                $qv = "";
                if(isset($wp->query_vars[$opt])) {
                    $qv = $wp->query_vars[$opt];
                }
                
                $app->dispatch(ltrim($qv, "/"));
                remove_all_filters("comments_template");
                add_filter("comments_template", array($this, "commentsTemplate"));
                

            } catch(Exception $e) {
                //print_r($e);die;
                $t404 = get_404_template();
                if(is_file($t404)) {
                    include_once get_404_template();
                    exit;
                }
            }

            $this->text = ob_get_clean();
        }
        
    }
    
    public function theContent($content)
    {
        foreach($this->_apps() as $app) {
            $linkName = $app->getOption("link_name");
            $id = $this->conf($linkName);
            if(is_page($id)) {
               if (post_password_required($id)) {
                   return get_the_password_form();
               } else {
                   $shortcode = $app->getOption("shortcode");
                   return str_replace($shortcode, $this->text, $content);
               }
            }
        }

        return $content;
    }
    
    public function commentsTemplate()
    {
        return $this->path("templates")."/blank.php";
    }

    public function queryVars( $qvars )
    {
        foreach($this->_apps() as $app) {
            $qvars[] = $app->getOption("query_var");
        }
        return $qvars;
    }
    
    public function canonicalUrl()
    {
        $url = $this->env("canonical", null);
        remove_action('wp_head','rel_canonical');
        if ($url) {
            echo '<link rel="canonical" href="'.$url.'"/>'."\n";
        }
    }

    public function injectTitle($title)
    {
        if(!is_null($this->title)) {
            return $this->title;
        }

        return $title;
    }

    public function theTitle($title, $id = null)
    {
        if(!in_the_loop() || is_null($id)) {
            return $title;
        }

        foreach($this->_apps() as $app) {
            $linkName = $app->getOption("link_name");
            $linkId = $this->conf($linkName);
            if(is_page($linkId) && $id==$linkId && $this->title) {
                $title = "  ".$this->title."  ";
                $this->title = null;
                return $title;
            }
        }
        
        return $title;
    }

    public function rewrite($rules)
    {
        global $wp_rewrite;
        
        $newrules = array();
        $struct = $wp_rewrite->get_page_permastruct();
        
        foreach($this->_apps() as $app) {
            $page = $app->getPage();
            $url  = str_replace('%pagename%', get_page_uri($page), $struct);
            $pattern = $url.self::REWRITE_PATTERN;
            $opt = $app->getOption("query_var");
            $newrules[$pattern] = 'index.php?page_id='.$page->ID.'&'.$opt.'=$matches[1]';
        }

        return $newrules + $rules;

    }
    
    public function shutdown()
    {
        foreach($this->_apps() as $app) {
            $app->getView()->_flash->dispose();
        }
    }
}
?>

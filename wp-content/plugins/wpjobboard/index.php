<?php
/*
Plugin Name: WPJobBoard
Plugin URI: http://wpjobboard.net/
Description: Plugin adds to blog functionality of a job board.
Author: Grzegorz Winiarski
Version: 3.5.3
Author URI: http://wpjobboard.net
*/

if(defined("WPJB_DOMAIN")) {
    return;
}

if(version_compare(PHP_VERSION, "5.1.6", "<")) {
    die("<b>Cannot activate:</b> WPJobBoard requires at least PHP 5.1.6, your PHP version is ".PHP_VERSION);
}

define("WPJB_DOMAIN", "wp-job-board-locale");
$basepath = dirname(__FILE__);

if(is_file($basepath."/overload.php")) {
    include_once $basepath."/overload.php";
}

if(!class_exists("Daq_Loader")) {
    require_once $basepath."/framework/Loader.php";
}

Daq_Loader::registerFramework($basepath."/framework");
Daq_Loader::registerAutoloader();

$request = Daq_Request::getInstance();
$db = Daq_Db::getInstance();
$db->setDb($wpdb);

$wpjbIni = Daq_Config::parseIni($basepath."/application/config/project.ini");
$wpjbPaths = Daq_Config::parseIni($basepath."/application/config/paths.ini");
Daq_Loader::registerLibrary($wpjbIni["prefix_class"], $basepath."/application/libraries");

$wpjb = Wpjb_Project::getInstance();
$wpjb->loadPaths($wpjbPaths);
$wpjb->setUrl(rtrim(get_bloginfo("url"), "/"));
$wpjb->setBaseDir($basepath);

foreach($wpjbIni as $wpjbk => $wpjbv) {
    $wpjb->setEnv($wpjbk, $wpjbv);
}

Daq_Helper::registerAll();

$routes = Daq_Config::parseIni(
    $wpjb->path("app_config")."/frontend-routes.ini",
    $wpjb->path("user_config")."/frontend-routes.ini",
    true
);
$wpjbbase = $wpjb->path("templates")."/";
include_once $wpjbbase."functions.php";

$wpjb->setEnv("template_base", $wpjbbase);

$view = new Daq_View();
$view->addDir("TEMPLATEPATH/job-board/job-board");
$view->addDir($wpjbbase."job-board");
$view->addHelper("flash", new Daq_Helper_Flash("frontend"));
$app = new Wpjb_Application_Frontend;
$app->setRouter(new Daq_Router($routes));
$app->setController("Wpjb_Module_Frontend_*");
$app->setView($view);
$app->setLog(new Daq_Log($wpjb->path("logs"), "error-front.txt", "debug-front.txt"));
$app->addOption("link_name", "link_jobs");
$app->addOption("query_var", "job_board");
$app->addOption("shortcode", "[wpjobboard-jobs]");

if(file_exists($wpjbbase."functions.php")) {
    include_once $wpjbbase."functions.php";
}

$routes = Daq_Config::parseIni(
    $wpjb->path("app_config")."/resumes-routes.ini",
    $wpjb->path("user_config")."/resumes-routes.ini",
    true
);

$view = new Daq_View();
$view->addDir("TEMPLATEPATH/job-board/resumes");
$view->addDir($wpjbbase."resumes");
$view->addHelper("flash", new Daq_Helper_Flash("resumes"));
$res = new Wpjb_Application_Resumes();
$res->setRouter(new Daq_Router($routes));
$res->setController("Wpjb_Module_Resumes_*");
$res->setView($view);
$res->setLog(new Daq_Log($wpjb->path("logs"), "error-resumes.txt", "debug-resumes.txt"));
$res->addOption("link_name", "link_resumes");
$res->addOption("query_var", "job_resumes");
$res->addOption("shortcode", "[wpjobboard-resumes]");

$routes = Daq_Config::parseIni(
    $wpjb->path("app_config")."/admin-routes.ini",
    $wpjb->path("user_config")."/admin-routes.ini",
    true
);

$view = new Daq_View($basepath.$wpjb->pathRaw("admin_views"));
$view->addHelper("url", new Daq_Helper_AdminUrl());
$view->addHelper("flash", new Daq_Helper_Flash());
$view->addHelper("html", new Daq_Helper_Html());
$admin = new Wpjb_Application_Admin;
$admin->isAdmin(true);
$admin->setRouter(new Daq_Router($routes));
$admin->setLog(new Daq_Log($wpjb->path("logs"), "error-admin.txt", "debug-admin.txt"));
$admin->setController("Wpjb_Module_Admin_*");
$admin->setView($view);

$wpjb->addApplication("frontend", $app);
$wpjb->addApplication("resumes", $res);
$wpjb->addApplication("admin", $admin);

$wpjb->addUserWidgets($basepath."/widgets/*.php");

$wpjb->run();

function wpjb_event_counter()
{
    Wpjb_Project::scheduleEvent();
}

?>

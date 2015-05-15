<?php

ob_start();

header("Content-type: text/html; charset=utf-8");
define("WP_JOB_BOARD", true);

require_once '../wp-load.php';

if (!session_id()) {
    session_start();
}

if(isset($_GET['page'])) {
    $path = ltrim($_GET['page'], "/");
} elseif(isset($_SERVER['ORIG_PATH_INFO'])) {
    $path = ltrim($_SERVER['ORIG_PATH_INFO'], "/");
    if(stripos($path, "index.php")!==false) {
        $path = "";
    }
} else {
    $path = ltrim($_SERVER['PATH_INFO'], "/");
    if(stripos($path, "index.php")!==false) {
        $path = "";
    }
}

try {
    Wpjb_Project::getInstance()
        ->getApplication("frontend")
        ->dispatch($path);
} catch(Exception $e) {
    include get_404_template();
}

ob_end_flush();

?>
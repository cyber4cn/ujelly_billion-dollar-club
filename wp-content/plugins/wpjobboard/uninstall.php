<?php
/* 
 * WPJobBoard uninstaller
 */

global $wpdb;

if(!defined("WP_UNINSTALL_PLUGIN")) {
    return;
}

$file = dirname(__FILE__)."/application/install/uninstall.sql";
$file = file_get_contents($file);

foreach(explode("; --", $file) as $sql) {
    $wpdb->query($sql);
}

$optArr = array(
    'wpjb_recentlyviewed', 'wpjb_featuredjobs', 'wpjb_alerts', 'wpjb_jobboardmenu',
    'wpjb_categories', 'wpjb_feeds', 'wpjb_jobtypes', 'wpjb_recentjobs',
    'wpjb_searchjobs', 'wpjb_config'
);
foreach($optArr as $option) {
    delete_option($option);
}

?>

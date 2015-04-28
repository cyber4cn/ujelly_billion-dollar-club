<?php
/**
 * @package   ldd_directory_lite
 * @author    LDD Web Design <info@lddwebdesign.com>
 * @license   GPL-2.0+
 * @link      http://lddwebdesign.com
 * @copyright 2014 LDD Consulting, Inc
 *
 * @wordpress-plugin
 * Plugin Name:       LDD Business Directory
 * Plugin URI:        http://wordpress.org/plugins/ldd-business-directory
 * Description:       Powerful and simple to use, add a directory of business or other organizations to your web site.
 * Version:           1.4.1
 * Author:            LDD Web Design
 * Author URI:        http://www.lddwebdesign.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


/**
 * Kudo's to Tom McFarlin for the following, which can be found in full @ https://github.com/tommcfarlin/directory-upgrade-notification )
 */

class LDD_Directory_Upgrade_Notice {

    public function __construct() {

        add_action( 'admin_head', array( $this, 'add_scripts' ) );

        if( false == get_option( 'hide_directory_upgrade_notice' ) )
            add_action( 'admin_notices', array( $this, 'display_notice' ) );

        add_action( 'wp_ajax_hide_admin_notification', array( $this, 'hide_notice' ) );

    }

    public function add_scripts() {
        echo '<script>(function(e){"use strict";e(function(){e("#dismiss-directory-notice").length>0&&e("#dismiss-directory-notice").click(function(t){t.preventDefault();e.post(ajaxurl,{action:"hide_admin_notification",nonce:e.trim(e("#directory-upgrade-nononce").text())},function(t){"1"===t?e("#directory-upgrade-notification").fadeOut("slow"):e("#directory-upgrade-notification").removeClass("updated").addClass("error")})})})})(jQuery);</script>';
    }

    public function display_notice() {

        $screen = get_current_screen();
        if ( 'business_directory' != $screen->parent_base )
            return;

        $dir = dirname( __FILE__ );
        $lite_plugin = substr( $dir, 0, strrpos( $dir, '/' ) ) . '/ldd-directory-lite/ldd-directory-lite.php';

        $upgrade = '';
        if ( current_user_can('install_plugins') && !file_exists( $lite_plugin ) ) {
            $url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=ldd-directory-lite' ), 'install-plugin_ldd-directory-lite' );
            $upgrade = sprintf( '<a href="%s" style="font-weight: 700">Install LDD Directory Lite</a> | ', $url );
        }

        $html = '<div id="directory-upgrade-notification" class="updated">';
        $html .= '<p style="font-size:120%;font-weight:700;">LDD Business Directory is now LDD Directory Lite!</p>';
        $html .= '<p style="font-weight:700;">Future development of this project has moved to <a href="' .$url . '" title="View the plugin on WordPress.org">LDD Directory Lite</a> ' . ' <br>';
        $html .= 'Please be aware that this plugin is still in beta! If you choose to test it during the beta, you will still be able to revert back to the original plugin at any time.</p>';
        $html .= '<p style="font-size:102%;">' . $upgrade . ' If you do not wish to update, you can <a href="javascript:;" id="dismiss-directory-notice" style="font-weight: 700">dismiss this notice</a>.</p>';
        $html .= '<span id="directory-upgrade-nononce" class="hidden">' . wp_create_nonce( 'directory-upgrade-nononce' ) . '</span>';
        $html .= '</div>';

        echo $html;
    }

    public function hide_notice() {
        if( wp_verify_nonce( $_REQUEST['nonce'], 'directory-upgrade-nononce' ) ) {
            if( update_option( 'hide_directory_upgrade_notice', true ) )
                die( '1' );
            else
                die( '0' );
        }
    }

}


new LDD_Directory_Upgrade_Notice;

register_activation_hook( __FILE__, 'lddbd_install' );


add_action( 'init', 'lddbd_register_scripts' );

function lddbd_register_scripts() {
   wp_register_style( 'lddbd', plugins_url( 'styles.css', __FILE__ ), array(), '1.4.0' );
}

global $wpdb;
global $main_table_name, $doc_table_name, $cat_table_name;

$main_table_name = $wpdb->prefix . "lddbusinessdirectory";
$doc_table_name = $wpdb->prefix . "lddbusinessdirectory_docs";
$cat_table_name = $wpdb->prefix . "lddbusinessdirectory_cats";

				
// Installation function for LDD Business Directory plugin. Sets up the tables in the database for main, documents, and categories.
function lddbd_install() {
	global $main_table_name, $doc_table_name, $cat_table_name;
	
	// Creates the table that contains all the primary information regarding each business.
	$main_table = "CREATE TABLE $main_table_name (
	id BIGINT(20) NOT NULL AUTO_INCREMENT,
	createDate datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	updateDate datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	name TINYTEXT NOT NULL,
	description TEXT NOT NULL,
	categories TEXT NOT NULL,
	address_street TEXT NOT NULL,
	address_city TEXT NOT NULL,
	address_state TEXT,
	address_zip CHAR(15),
	address_country TEXT NOT NULL,
	phone CHAR(15) NOT NULL,
	fax CHAR(15),
	email VARCHAR(55) DEFAULT '' NOT NULL,
	contact tinytext NOT NULL,
	url VARCHAR(55) DEFAULT '' NOT NULL,
	facebook VARCHAR(256),
	twitter VARCHAR(256),
	linkedin VARCHAR(256),
	promo ENUM('true', 'false') NOT NULL,
	promoDescription text DEFAULT '',
	logo VARCHAR(256) DEFAULT '' NOT NULL,
	login text NOT NULL,
	password VARCHAR(64) NOT NULL,
	approved ENUM('true', 'false') NOT NULL,
	other_info TEXT,
	UNIQUE KEY id (id)
	);";
	
	// Creates the table that contains documentation/descriptions.
	$doc_table = "CREATE TABLE $doc_table_name (
	doc_id BIGINT(20) NOT NULL AUTO_INCREMENT,
	bus_id BIGINT(20) NOT NULL,
	doc_path VARCHAR(256) NOT NULL,
	doc_name TINYTEXT NOT NULL,
	doc_description LONGTEXT,
	PRIMARY KEY  (doc_id),
	FOREIGN KEY (bus_id) REFERENCES $main_table_name(id)
	);";
	
	// Creates the table that contains a listing of all the categories.
	$cat_table = "CREATE TABLE $cat_table_name(
	id BIGINT(20) NOT NULL AUTO_INCREMENT,
	name TINYTEXT NOT NULL,
	count BIGINT(20) NOT NULL,
	PRIMARY KEY  (id)
	);";

	/*
	* Loads the file necessary for the function dbDelta()to work.
	* dbDelta(): examines the current table structure, compares it to the desired table structure,
	* and either adds or modifies the table as necessary.
	*/
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($main_table);
   dbDelta($doc_table);
   dbDelta($cat_table);
 }





require_once( 'lddbd_settings.php' );
require_once( 'lddbd_backend-display.php' );
require_once( 'lddbd_display.php' );

add_shortcode( 'business_directory', 'display_business_directory' );

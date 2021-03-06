<?php
/**
 * @package WTAB-Importer
 */
/*
Plugin Name: Importer
Plugin URI: https://github.com/webtechandbiz/WTAB-Importer
Description: simplify complex import issues
Version: 0.1
Author: https://github.com/webtechandbiz
Author URI: https://github.com/webtechandbiz
License: MIT - https://opensource.org/licenses/mit-license.php
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

global $admin__log_folder_path;
global $admin__imported_folder_path;
global $admin__import_key;

//# Setup
$wtab_pnl_admin_folder_salt = 'pagibrebob';
$wtab_pnl_admin_functions_folder_salt = 'stogidrawr';
$admin__import_key = array('table' => 'wp_posts', 'field' => 'post_title');

//# Paths
$admin__folder_path = plugin_dir_path( __FILE__ ).'admin-'.$wtab_pnl_admin_folder_salt.'/';
$admin_functions__folder_path = $admin__folder_path.'-functions-'.$wtab_pnl_admin_functions_folder_salt.'/';
$admin__log_folder_path = $admin__folder_path.'logs-'.$wtab_pnl_admin_functions_folder_salt.'/';
$admin__imported_folder_path = $admin__folder_path.'data-'.$wtab_pnl_admin_functions_folder_salt.'/';

// # URLs
$wtab_pnl__url = plugin_dir_url(__FILE__);
$wtab_pnl_admin__url = $wtab_pnl__url.'admin-'.$wtab_pnl_admin_folder_salt.'/';
$wtab_pnl_admin_public_html__url = $wtab_pnl_admin__url.'public_html/';
$wtab_pnl__css_url = $wtab_pnl_admin_public_html__url.'css/wtab_pnl_css.css';
$wtab_pnl__js_url = $wtab_pnl_admin_public_html__url.'js/wtab_pnl_js.js';

//#Includes
include($admin_functions__folder_path.'-functions.php');

include($admin_functions__folder_path.'-functions-importer.php');
include($admin_functions__folder_path.'-functions-importer-read.php');
include($admin_functions__folder_path.'-functions-importer-read-xml.php');
include($admin_functions__folder_path.'-functions-importer-read-csv.php');
include($admin_functions__folder_path.'-functions-importer-save.php');
include($admin_functions__folder_path.'-functions-importer-test-the-importer.php');

include($admin_functions__folder_path.'-functions-menu.php');
include($admin_functions__folder_path.'-functions-menu-panel-cover.php');
include($admin_functions__folder_path.'-functions-menu-panel-form.php');

//# Admin style + js
add_action(
    'admin_enqueue_scripts', function() use ($wtab_pnl__css_url, $wtab_pnl__js_url) {
        wp_enqueue_style( 'wtab_pnl_url', $wtab_pnl__css_url );
        wp_enqueue_script( 'wtab_pnl_js_url', $wtab_pnl__js_url);
    }
);

//# Add the menu
add_action('admin_menu', 'droswavosw_create_menu');

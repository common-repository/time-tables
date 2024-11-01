<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codoplex.com
 * @since             1.0.2
 * @package           codott
 *
 * @wordpress-plugin
 * Plugin Name:       Time Tables
 * Plugin URI:        https://codoplex.com
 * Description:       A time table management plugin developed for universities, schools, colleges, academies or any other type of institutes.
 * Version:           1.0.2
 * Author:            Junaid Hassan
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       codott
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
 
if ( ! defined( 'CODOTT_BASE_FILE' ) )
    define( 'CODOTT_BASE_FILE', __FILE__ );
if ( ! defined( 'CODOTT_BASE_DIR' ) )
    define( 'CODOTT_BASE_DIR', dirname( CODOTT_BASE_FILE ) );
if ( ! defined( 'CODOTT_PLUGIN_URL' ) )
    define( 'CODOTT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

global $codott_plugin_name;
$codott_plugin_name = 'codott';

global $codott_plugin_version;
$codott_plugin_version = '1.0';

/**
 * The code that runs during plugin activation.
 */
function activate_codott() {

}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_codott() {
    
}

register_activation_hook( __FILE__, 'activate_codott' );
register_deactivation_hook( __FILE__, 'deactivate_codott' );

/*Plugin Menu Handling*/

require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/menu_pages.php');
 
add_action('admin_menu', 'codott_admin_actions');

/*Table Removal After Uninstalling the plugin*/

register_uninstall_hook('uninstall.php', '');

/*Register custom post types*/

require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/time_tables.php');
require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/teacher_time_tables.php');
require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/class_time_tables.php');

/*Manage plugin scripts and styles*/
function codott_scripts_styles()
{
    wp_register_style( 'codott_styles', plugins_url( '/css/codott_styles.css', __FILE__ ) );
    wp_enqueue_style( 'codott_styles' );
}
add_action( 'wp_enqueue_scripts', 'codott_scripts_styles' );

/*translations*/
add_action('plugins_loaded', 'codott_load_textdomain');
function codott_load_textdomain() {
    load_plugin_textdomain( 'codott', false, CODOTT_BASE_DIR . '/lang/' );
}
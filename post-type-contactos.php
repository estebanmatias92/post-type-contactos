<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   Post_Type_Contactos
 * @author    Matias Esteban <estebanmatias92@gmail.com>
 * @license   MIT License
 * @link      http://example.com
 * @copyright 2013 Matias Esteban
 *
 * @wordpress-plugin
 * Plugin Name: Post Type Contactos
 * Plugin URI:  TODO
 * Description: TODO
 * Version:     0.1.0
 * Author:      TODO
 * Author URI:  TODO
 * Text Domain: post_type_contactos-locale
 * License:     MIT License
 * License URI: http://opensource.org/licenses/MIT
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define root path of this plugin
if ( ! defined( 'PTC_PLUGIN_ROOT' ) ) {
	define( 'PTC_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'PTC_PLUGIN_URL' ) ) {
	define( 'PTC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Includes
require_once( plugin_dir_path( __FILE__ ) . 'class-post-type-contactos.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'Post_Type_Contactos', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Post_Type_Contactos', 'deactivate' ) );

// Plugin class instance
Post_Type_Contactos::get_instance();

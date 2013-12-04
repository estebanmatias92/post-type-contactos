<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Post_Type_Contactos
 * @author    Matias Esteban <estebanmatias92@gmail.com>
 * @license   MIT License
 * @link      http://example.com
 * @copyright 2013 Matias Esteban
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Includes
require_once( plugin_dir_path( __FILE__ ) . 'class-post-type-contactos.php' );

// Fire desactivate funtion and uninstall function
register_deactivation_hook( __FILE__, array( 'Post_Type_Contactos', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'Post_Type_Contactos', 'uninstall' ) );

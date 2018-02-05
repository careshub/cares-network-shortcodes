<?php
/**
 * @package CARES_Network_Shortcodes
 * @wordpress-plugin
 * Plugin Name:       CARES Network Shortcodes
 * Version:           1.0.0
 * Description:       Gathers some utility shortcodes for use on CARES Network sites.
 * Author:            dcavins
 * Text Domain:       cares-network-shortcodes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/careshub/
 * @copyright 2018 CARES, University of Missouri
 */

namespace CARES_Network_Shortcodes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

$basepath = plugin_dir_path( __FILE__ );

// The main file
require_once( $basepath . 'public/public.php' );

/**
 * Helper function.
 * @return Fully-qualified URI to the root of the plugin.
 */
function get_plugin_base_uri() {
	return plugin_dir_url( __FILE__ );
}

/**
 * Helper function.
 * @return Fully-qualified URI to the root of the plugin.
 */
function get_plugin_base_path() {
	return trailingslashit( dirname( __FILE__ ) );
}

function get_plugin_slug() {
	return 'cares-network-shortcodes';
}

/**
 * Helper function.
 * @TODO: Update this when you update the plugin's version above.
 *
 * @return string Current version of plugin.
 */
function get_plugin_version() {
	return '1.0.0';
}

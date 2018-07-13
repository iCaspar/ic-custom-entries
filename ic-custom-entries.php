<?php
/**
 * iC Custom Entries Plugin
 *
 * @package         ICaspar\CustomEntries
 * @author          Caspar Green
 * @license         GPL-3.0+
 * @link            https://www.iCasparWebDevelopment.com/
 *
 * @wordpress-plugin
 * Plugin Name:     iCaspar Custom Entries
 * Plugin URI:      https://www.iCasparWebDevelopment.com/
 * Description:     Custom Post Types, Taxonomies and closely related considerations.
 * Version:         1.0.0
 * Author:          Caspar Green
 * Author URI:      https://caspar.green/
 * Text Domain:     ic-custom-entries
 * Requires WP:     4.9
 * Requires PHP:    7.2
 */

namespace ICaspar\CustomEntries;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This file requires WordPress to work properly.' );
}

if ( ! version_compare( $GLOBALS['wp_version'], '4.9', '>=' ) ||
     ! version_compare( phpversion(), '7.2', '>=' ) ) {
	return;
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\launch' );
/**
 * Launch the plugin.
 *
 * @since 1.0.0
 *
 * @return void
 */
function launch() {
	require_once( __DIR__ . '/vendor/autoload.php' );

	$custom_entries = new Main( __FILE__ );
	$custom_entries->init();
}

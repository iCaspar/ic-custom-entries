<?php
/**
 * Caspar Master WordPress Plugin
 *
 * @package         IC Hub
 * @author          Caspar Green
 * @license         GPL-3.0+
 * @link            https://www.iCasparWebDevelopment.com/
 *
 * @wordpress-plugin
 * Plugin Name:     iCaspar Hub Plugin
 * Plugin URI:      https://www.iCasparWebDevelopment.com/
 * Description:     WordPress Customizations
 * Version:         0.0.1
 * Author:          Caspar Green
 * Author URI:      https://caspar.green/
 * Text Domain:     icaspar
 * Requires WP:     4.7
 * Requires PHP:    5.6
 */

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 3
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

namespace ICaspar\WPHub;

// Oh no you di'n't
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Oops! Something went wrong.' );
}

if ( version_compare( $GLOBALS['wp_version'], '4.7', '>' ) ) {
	require_once( __DIR__ . '/vendor/autoload.php' );
	init();
}

/**
 * Initialize the plugin.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init() {
	init_constants();

	register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );

	add_action( 'plugins_loaded', __NAMESPACE__ . '\launch', 20 );
}

/**
 * Initialize plugin constants.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_constants() {
	define( 'ICASPAR_HUB_FILE', __FILE__ );
	define( 'ICASPAR_HUB_DIR', plugin_dir_path( __FILE__ ) );
	define( 'ICASPAR_HUB_CONFIG_DIR', ICASPAR_HUB_DIR . 'config/' );

	$plugin = get_file_data( __FILE__, [
		'name'        => 'Plugin Name',
		'version'     => 'Version',
		'text_domain' => 'Text Domain',
	] );

	define( 'ICASPAR_HUB_NAME', $plugin['name'] );
	define( 'ICASPAR_HUB_VERSION', $plugin['version'] );
	define( 'ICASPAR_HUB_TEXT_DOMAIN', $plugin['text_domain'] );

	$plugin_url = plugin_dir_url( __FILE__ );
	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}
	define( 'ICASPAR_HUB_URL', $plugin_url );
	define( 'ICASPAR_HUB_ASSETS_URL', ICASPAR_HUB_URL . 'dist/' );
}

/**
 * Launch the plugin.
 *
 * @since 1.0.0
 *
 * @return void
 */
function launch() {
	new Hub( include ICASPAR_HUB_CONFIG_DIR . 'config.php' );
}

/**
 * Clean up and store deactivated state.
 *
 * @since 1.0.0
 *
 * @return void
 */
function deactivate() {
	flush_rewrite_rules();
	update_option( 'ic_hub_active', false );
}
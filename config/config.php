<?php
/**
 * config.php
 *
 * Configuration file for Hub.
 *
 * @since 1.0.0
 */

return [
	'cpts'       => include ICASPAR_HUB_CONFIG_DIR . 'cpts.php',
	'taxonomies' => include ICASPAR_HUB_CONFIG_DIR . 'taxonomies.php',
	'metaboxes'  => include ICASPAR_HUB_CONFIG_DIR . 'metaboxes.php',
	'widgets'    => include ICASPAR_HUB_CONFIG_DIR . 'widgets.php',
	'scripts'    => include ICASPAR_HUB_CONFIG_DIR . 'scripts.php',
];
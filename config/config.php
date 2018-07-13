<?php
/**
 * config.php
 *
 * Configuration file for Hub.
 *
 * @since 1.0.0
 */

return [
	'cpts'       => include $config_dir . 'cpts.php',
	'taxonomies' => include $config_dir . 'taxonomies.php',
	'metaboxes'  => include $config_dir . 'metaboxes.php',
	'widgets'    => include $config_dir . 'widgets.php',
	'scripts'    => include $config_dir . 'scripts.php',
];
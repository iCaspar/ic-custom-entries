<?php
/**
 * config.php
 *
 * Configuration file for Hub.
 *
 * @since 1.0.0
 */

return [
	'post-types' => include $config_dir . 'post-types.php',
	'taxonomies' => include $config_dir . 'taxonomies.php',
	'metaboxes'  => include $config_dir . 'metaboxes.php',
	'widgets'    => include $config_dir . 'widgets.php',
	'scripts'    => include $config_dir . 'scripts.php',
];
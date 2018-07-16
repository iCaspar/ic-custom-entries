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
	'tax-images' => include $config_dir . 'tax-images.php',
	'metaboxes'  => include $config_dir . 'metaboxes.php',
	'widgets'    => include $config_dir . 'widgets.php',
];
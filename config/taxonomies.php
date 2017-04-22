<?php
/**
 * taxonomies.php
 *
 * Configuration data for custom taxonomies.
 *
 * @since 1.0.0
 */

return [

	'project-category' => [
		'post_type'           => 'project',
		'taxonomy_nice_names' => [
			'singular' => _x( 'Project Category', 'singular taxonomy name', ICASPAR_HUB_TEXT_DOMAIN ),
			'plural'   => _x( 'Project Categories', 'plural taxonomy name', ICASPAR_HUB_TEXT_DOMAIN ),
		],
		'rewrite'             => [
			'slug'         => 'project-category',
			'hierarchical' => true,
		],
		'args'                => [
			'show_in_nav_menus' => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
		],
		'initial_term' => 'General Project',
	],

	'project-tag' => [
		'post_type'           => 'project',
		'taxonomy_nice_names' => [
			'singular' => _x( 'Project Tag', 'singular taxonomy name', ICASPAR_HUB_TEXT_DOMAIN ),
			'plural'   => _x( 'Project Tags', 'plural taxonomy name', ICASPAR_HUB_TEXT_DOMAIN ),
		],
		'rewrite'             => [
			'slug' => 'project-tag',
		],
		'args'                => [
			'show_in_nav_menus' => true,
			'show_admin_column' => true,
		],
	]

];
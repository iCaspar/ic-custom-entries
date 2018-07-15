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
		'post_type'           => 'portfolio',
		'slug'                => 'project-category',
		'taxonomy_names' => [
			'singular' => _x( 'Project Category', 'singular taxonomy name', 'ic-custom-entries' ),
			'plural'   => _x( 'Project Categories', 'plural taxonomy name', 'ic-custom-entries' ),
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
		'initial_term'        => 'General Project',
	],

	'project-tag' => [
		'post_type'           => 'portfolio',
		'slug'                => 'project-tag',
		'taxonomy_names' => [
			'singular' => _x( 'Project Tag', 'singular taxonomy name', 'ic-custom-entries' ),
			'plural'   => _x( 'Project Tags', 'plural taxonomy name', 'ic-custom-entries' ),
		],
		'args'                => [
			'show_in_nav_menus' => true,
			'show_admin_column' => true,
		],
	],
];

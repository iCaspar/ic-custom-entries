<?php
/**
 * Configuration for custom post types.
 *
 * @since 1.0.0
 */

return [
	'portfolio'   => [
		'post_type_names'   => array(
			'singular' => _x( 'Project', 'singular post type name', 'ic-custom-entries' ),
			'plural'   => _x( 'Projects', 'plural post type name', 'ic-custom-entries' ),
			'name' => _x( 'Portfolio', 'post type main mabel', 'ic-custom-entries' ),
		),
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
		),
		'slug'              => 'portfolio',
		'title_placeholder' => __( 'Enter project name here' , 'ic-custom-entries' ),
		'args'              => array(
			'public'            => true,
			'description'       => _x( 'Portfolio project', 'custom post type description', 'ic-custom-entries' ),
			'menu_position'     => 20,
			'menu_icon'         => 'dashicons-book-alt',
			'show_in_nav_menus' => false,
			'has_archive'       => true,
		),
	],

	'spotlight' => [
		'post_type_names'   => array(
			'singular' => _x( 'Spotlight', 'singular post type name', 'ic-custom-entries' ),
			'plural'   => _x( 'Spotlights', 'plural post type name', 'ic-custom-entries' ),
		),
		'slug'              => 'spotlight',
		'args'              => array(
			'public'            => true,
			'description'       => _x( 'Spotlight', 'custom post type description', 'ic-custom-entries' ),
			'menu_position'     => 21,
			'menu_icon'         => 'dashicons-megaphone',
			'show_in_nav_menus' => true,
			'has_archive'       => true,
		),
	],
];

<?php
/**
 * cpts.php
 *
 * Configuration for custom post types.
 *
 * @since 1.0.0
 */

return [
	'project'   => [
		'post_type_names'   => array(
			'singular' => _x( 'Project', 'singular post type name', ICASPAR_HUB_TEXT_DOMAIN ),
			'plural'   => _x( 'Projects', 'plural post type name', ICASPAR_HUB_TEXT_DOMAIN ),
			'label' => _x( 'Portfolio', 'post type main mabel', ICASPAR_HUB_TEXT_DOMAIN ),
		),
		'excluded_supports' => array(
			'author',
			'trackbacks',
			'custom-fields',
			'comments',
			'post-formats',
			'genesis-scripts',
			'genesis-layouts',
			'genesis-rel-author',
		),
		'slug'              => 'portfolio',
		'title_placeholder' => __( 'Enter project name here' , ICASPAR_HUB_TEXT_DOMAIN ),
		'args'              => array(
			'public'            => true,
			'description'       => _x( 'Portfolio project', 'custom post type description', ICASPAR_HUB_TEXT_DOMAIN ),
			'menu_position'     => 20,
			'menu_icon'         => 'dashicons-book-alt',
			'show_in_nav_menus' => false,
			'has_archive'       => true,
		),
	],
/*
	'njifma_fm_spotlight' => [
		'post_type_names'   => array(
			'singular' => _x( 'FM Spotlight', 'singular post type name', ICASPAR_HUB_TEXT_DOMAIN ),
			'plural'   => _x( 'FM Spotlights', 'plural post type name', ICASPAR_HUB_TEXT_DOMAIN ),
		),
		'excluded_supports' => array(
			'trackbacks',
			'custom-fields',
			'post-formats',
			'genesis-seo',
			'genesis-scripts',
			'genesis-layouts',
			'genesis-rel-author',
		),
		'slug'              => 'fm-spotlight',
		'args'              => array(
			'public'            => true,
			'description'       => _x( 'FM Spotlight', 'custom post type description', ICASPAR_HUB_TEXT_DOMAIN ),
			'menu_position'     => 20,
			'menu_icon'         => 'dashicons-megaphone',
			'show_in_nav_menus' => true,
			'has_archive'       => true,
		),
	], */
];
<?php
/**
 * metaboxes.php
 *
 * Configuration for metaboxes.
 *
 * @since 1.0.0
 */

return [
	'affiliate-link' => [
		'slug'       => 'affiliate_link',
		'title'      => __( 'Organization Website URL', 'ic-custom-entries' ),
		'type'       => 'UrlBox',
		'post_types' => [ 'portfolio' ],
		'meta_key'   => 'portolio_affiliate_url',
		'location'   => 'normal'
	],

	'affiliate-address' => [
		'slug'  => 'affiliate_address',
		'title' => __( 'Organization Address', 'ic-custom-entries' ),
		'type'       => 'TextAreaBox',
		'post_types' => [ 'portfolio' ],
		'meta_key'   => 'portfolio_affiliate_address',
		'location'   => 'normal'
	],

	'affiliate-phone' => [
		'slug' => 'affiliate_phone',
		'title' => __( 'Organization Phone', 'ic-custom-entries' ),
		'type'       => 'PhoneBox',
		'post_types' => [ 'portfolio' ],
		'meta_key'   => 'portfolio_affiliate_phone',
		'location'   => 'normal'
	],

	'affiliate-fax' => [
		'slug' => 'affiliate_fax',
		'title' => __( 'Organization Fax', 'ic-custom-entries' ),
		'type'       => 'PhoneBox',
		'post_types' => [ 'portfolio' ],
		'meta_key'   => 'portfolio_affiliate_fax',
		'location'   => 'normal'
	],

	'affiliate-contact' => [
		'slug' => 'affiliate_contact',
		'title' => __( 'Organization Contact Name', 'ic-custom-entries' ),
		'type'       => 'TextBox',
		'post_types' => [ 'portfolio' ],
		'meta_key'   => 'portfolio_affiliate_contact',
		'location'   => 'normal'
	],

	'affiliate-email' => [
		'slug' => 'affiliate_email',
		'title' => __( 'Organization Contact Email', 'ic-custom-entries' ),
		'type'       => 'EmailBox',
		'post_types' => [ 'portfolio' ],
		'meta_key'   => 'portfolio_affiliate_contact_email',
		'location'   => 'normal'
	],
];

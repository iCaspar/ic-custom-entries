<?php
/**
 * metaboxes.php
 *
 * Configuration for metaboxes.
 *
 * @since 1.0.0
 */

return [
	[
		'slug'       => 'affiliate_link',
		'title'      => __( 'Organization Website URL', 'ic-custom-entries' ),
		'type'       => 'UrlBox',
		'post_types' => [ 'njifma_affiliates' ],
		'meta_key'   => 'njifma_affiliate_url',
		'location'   => 'normal'
	],

	[
		'slug'  => 'affiliate_address',
		'title' => __( 'Organization Address', 'ic-custom-entries' ),
		'type'       => 'TextAreaBox',
		'post_types' => [ 'njifma_affiliates' ],
		'meta_key'   => 'njifma_affiliate_address',
		'location'   => 'normal'
	],

	[
		'slug' => 'affiliate_phone',
		'title' => __( 'Organization Phone', 'ic-custom-entries' ),
		'type'       => 'PhoneBox',
		'post_types' => [ 'njifma_affiliates' ],
		'meta_key'   => 'njifma_affiliate_phone',
		'location'   => 'normal'
	],

	[
		'slug' => 'affiliate_fax',
		'title' => __( 'Organization Fax', 'ic-custom-entries' ),
		'type'       => 'PhoneBox',
		'post_types' => [ 'njifma_affiliates' ],
		'meta_key'   => 'njifma_affiliate_fax',
		'location'   => 'normal'
	],

	[
		'slug' => 'affiliate_contact',
		'title' => __( 'Organization Contact Name', 'ic-custom-entries' ),
		'type'       => 'TextBox',
		'post_types' => [ 'njifma_affiliates' ],
		'meta_key'   => 'njifma_affiliate_contact',
		'location'   => 'normal'
	],

	[
		'slug' => 'affiliate_email',
		'title' => __( 'Organization Contact Email', 'ic-custom-entries' ),
		'type'       => 'EmailBox',
		'post_types' => [ 'njifma_affiliates' ],
		'meta_key'   => 'njifma_affiliate_contact_email',
		'location'   => 'normal'
	],

];
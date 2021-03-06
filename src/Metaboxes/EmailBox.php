<?php
/**
 * EmailBox class.
 *
 * @package ICaspar\CustomEntries\Metaboxes
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Metaboxes;

use WP_Post;

/**
 * Class EmailBox
 *
 * @package ICaspar\CustomEntries\Metaboxes
 *
 * @since 1.0.0
 */
class EmailBox extends MetaboxBase {

	/**
	 * Render the metabox.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post
	 *
	 * @return void
	 */
	public function render_metabox( WP_Post $post ) {
		$view   = 'views/emailbox.php';
		$stored = $this->get_stored_meta( $post, $this->meta_key );

		wp_nonce_field( $this->slug . '_save', $this->slug . '_nonce' );

		include $view;
	}

	/**
	 * Validate the input
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $input
	 *
	 * @return string
	 */
	protected function validate( $input ) {
		return sanitize_email( $input );
	}
}

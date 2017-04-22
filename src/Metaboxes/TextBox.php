<?php
namespace ICaspar\WPHub\Metaboxes;

/**
 * Class TextBox
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\Metaboxes
 */
class TextBox extends MetaboxBase {

	/**
	 * Render the metabox.
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Post $post
	 *
	 * @return void
	 */
	public function render_metabox( \WP_Post $post ) {
		$view   = 'views/textbox.php';
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
		return sanitize_text_field( $input );
	}
}
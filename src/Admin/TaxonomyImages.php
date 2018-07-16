<?php
/**
 * TaxonomyImages class
 *
 * @package ICaspar\CustomEntries\Admin
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Admin;

use ICaspar\CustomEntries\Utilities\Assets;
use \WP_Term;

/**
 * Class TaxonomyImages
 *
 * @package ICaspar\CustomEntries\Admin
 *
 * @since 1.0.0
 */
class TaxonomyImages {

	/**
	 * @var Assets Assets Utility Class.
	 */
	protected $assets;

	/**
	 * @var array List of Taxonomies using images.
	 */
	protected $taxonomies = [];

	/**
	 * TaxonomyImages constructor.
	 *
	 * @param Assets $assets
	 * @param array $taxonomies
	 */
	public function __construct( Assets $assets, array $taxonomies ) {
		$this->assets     = $assets;
		$this->taxonomies = $taxonomies;
	}

	public function init(): void {
		foreach ( $this->taxonomies as $taxonomy ) {
			add_action( $taxonomy . '_add_form_fields', [ $this, 'do_add_texonomy_image_field' ] );
			add_action( $taxonomy . '_edit_form_fields', [ $this, 'do_edit_texonomy_image_field' ] );
		}

		add_action( 'edit_term', [ $this, 'save_taxonomy_image' ] );
		add_action( 'create_term', [ $this, 'save_taxonomy_image' ] );
	}

	/**
	 * Callback to render a taxonomy image field on the Add Taxomomy screen.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function do_add_texonomy_image_field(): void {
		$field_html = __DIR__ . '/views/add-taxonomy-field.php';

		$this->render_taxonomy_image_field( $field_html );
	}

	/**
	 * Callback to render a taxonomy image field on the Edit Taxonomy screen.
	 *
	 * @since 1.0.0
	 *
	 * @param $taxonomy WP_Term
	 *
	 * @return void
	 */
	public function do_edit_texonomy_image_field( WP_Term $taxonomy ): void {
		$field_html = __DIR__ . '/views/edit-taxonomy-field.php';
		$field_url  = $this->get_taxonomy_image_url( $taxonomy->term_id );

		$this->render_taxonomy_image_field( $field_html, $field_url );
		}

	/**
	 * Get the taxonomy term image url.
	 *
	 * @since 1.0.0
	 *
	 * @param int $term_id
	 *
	 * @return string The URL or empty string if not set.
	 */
	protected function get_taxonomy_image_url( int $term_id = 0 ): string {
		if ( ! $term_id ) {
			return '';
		}

		$taxonomy_image_url = get_term_meta( $term_id, 'term-image', true );

		return $taxonomy_image_url ?: '';
	}

	/**
	 * Render a taxonomy image field.
	 *
	 * @since 1.0.0
	 *
	 * @param string $field_html The field HTML to render.
	 * @param string $field_url (Optional) The image URL.
	 *
	 * @return void
	 */
	protected function render_taxonomy_image_field( string $field_html, ?string $field_url = '' ): void {
		$image_url = $field_url ?: $this->assets->get_image_url('taxonomy-image-placeholder.png');

		wp_enqueue_media();
		$this->assets->enqueue_script( 'tax-image-uploader', 'tax-image-uploader.js', [ 'jquery' ] );
		wp_localize_script( 'tax-image-uploader',
			'tax_img_data',
			[ 'tax_placeholder_url' => $this->assets->get_image_url( 'taxonomy-image-placeholder.png' ) ] );

		include $field_html;
	}

	/**
	 * Callback to save a taxonomy image.
	 *
	 * @since 1.0.0
	 *
	 * @param int $term_id The term ID for which to save the image.
	 *
	 * @return void
	 */
	public function save_taxonomy_image( int $term_id ): void {
		if ( ! $_POST['taxonomy_image'] ) {
			return;
		}

		update_term_meta( $term_id, 'term-image', esc_url_raw( $_POST['taxonomy_image'] ) );
	}
}

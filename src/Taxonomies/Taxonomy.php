<?php
/**
 * Taxonomy class.
 *
 * @package ICaspar\CustomEntries\Taxonomies
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Taxonomies;

use ICaspar\CustomEntries\Utilities\Helpers;

/**
 * Class Taxonomy
 *
 * @since 1.0.0
 *
 * @package ICaspar\CustomEntries\Taxonomies
 */
class Taxonomy {

	/**
	 * @var array Taxonomies data.
	 *
	 * @since 1.0.0
	 */
	protected $config = [];

	/**
	 * Taxonomy constructor.
	 *
	 * @param array $config
	 */
	public function __construct( array $config ) {
		$this->config = $config;
	}

	/**
	 * Initialize the taxonomy.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init(): void {
		add_action( 'init', [ $this, 'register' ] );
	}

	/**
	 * Callback to register the taxonomy.
	 *
	 * @hooked init
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void {
		if ( ! $this->is_valid_config() ) {
			return;
		}

		$this->build_taxonomy_args();
		register_taxonomy( $this->config['slug'], $this->config['post_type'], $this->config['args'] );

		if ( isset( $config['initial_term'] ) ) {
			wp_insert_term( $this->config['initial_term'], $this->config['slug'] );
		}
	}

	/**
	 * Check that the taxonomy config is valid.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function is_valid_config(): bool {
		if ( ! isset( $this->config['slug'] ) ) {
			return false;
		}

		$this->config['slug'] = $this->sanitize_taxonomy_name( $this->config['slug'] );

		if ( ! $this->config['slug'] ) {
			return false;
		}

		if ( ! isset( $this->config['post_type'] ) ) {
			return false;
		}

		if ( ! $this->is_valid_post_type( $this->config['post_type'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Insure a clean, unique taxonomy name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Taxonomy name (slug).
	 *
	 * @return string Sanitized taxonomy name or empty string if the name is a duplicate.
	 */
	protected function sanitize_taxonomy_name( string $name ) {
		$name = sanitize_key( $name );

		if ( in_array( $name, get_taxonomies() ) ) {
			return '';
		}

		return $name;
	}

	/**
	 * Checks whether the post type(s) to be associated with the taxonomy is (are) registered.
	 *
	 * @param string|array $post_type Post type(s) to be associated with the taxonomy.
	 *
	 * @return bool
	 */
	function is_valid_post_type( $post_type ) {
		return in_array( $post_type, get_post_types() );
	}

	/**
	 * Build custom taxonomy arguments array.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function build_taxonomy_args() {
		$this->build_labels();
		$this->build_rewrites();
	}

	/**
	 * Build the taxonomy labels.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function build_labels() {
		if ( ! Helpers::isSettingPresentAsArray( $this->config, 'taxonomy_names' ) ) {
			return;
		}

		$singular = isset( $this->config['taxonomy_names']['singular'] )
			? $this->config['taxonomy_names']['singular']
			: false;
		$plural   = isset( $this->config['taxonomy_names']['plural'] )
			? $this->config['taxonomy_names']['plural']
			: false;

		if ( ! $singular || ! $plural ) {
			return;
		}

		$this->config['args']['labels'] = [
			'name'                       => $plural,
			'singular_name'              => $singular,
			'all_items'                  => sprintf( '%s %s', __( 'All', 'ic-custom-entries' ), $plural ),
			'edit_item'                  => sprintf( '%s %s', __( 'Edit', 'ic-custom-entries' ), $singular ),
			'view_item'                  => sprintf( '%s %s', __( 'View', 'ic-custom-entries' ), $singular ),
			'update_item'                => sprintf( '%s %s', __( 'Update', 'ic-custom-entries' ), $singular ),
			'add_new_item'               => sprintf( '%s %s', __( 'Add New', 'ic-custom-entries' ), $singular ),
			'new_item_name'              => sprintf( '%s %s', __( 'New Name for', 'ic-custom-entries' ), $singular ),
			'search_items'               => sprintf( '%s %s', __( 'Search', 'ic-custom-entries' ), $plural ),
			'popular_items'              => sprintf( '%s %s', __( 'Popular' ), $plural ),
			'separate_items_with_commas' => sprintf( '%s %s %s', __( 'Separate', 'ic-custom-entries' ), $plural, __( 'with commas', 'ic-custom-entries' ) ),
			'add_or_remove_items'        => sprintf( '%s %s', __( 'Add or remove', 'ic-custom-entries' ), $plural ),
			'choose_from_most_used'      => sprintf( '%s %s', __( 'Choose from most used', 'ic-custom-entries' ), $plural ),
			'not_found'                  => sprintf( '%s $s', $singular, _x( 'not found.', 'taxonomy term not found', 'ic-custom-entries' ) ),
		];
	}

	/**
	 * Build the taxonomy rewrite array.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function build_rewrites(): void {
		if ( Helpers::isSettingPresentAsArray( $this->config, 'rewrite' ) ) {
			$this->config['args']['rewrite'] = $this->config['rewrite'];
		}
	}
}

<?php
namespace ICaspar\WPHub\Taxonomies;

class Taxonomies {

	protected $config;

	public function __construct( array $config ) {
		$this->config = $config;
	}

	public function register_taxonomies() {
		foreach ( $this->config as $taxonomy => $config ) {
			$this->register_taxonomy( $taxonomy, $config );
		}
	}

	public function register_taxonomy( $taxonomy, array $config ) {
		$name = $this->sanitize_taxonomy_name( $taxonomy );

		if ( ! $name ) {
			return;
		}

		if ( ! $this->is_valid_post_type( $config['post_type'] ) ) {
			return;
		}

		$args = $this->build_taxonomy_args( $config );

		register_taxonomy( $name, $config['post_type'], $args );

		if ( isset( $config['initial_term'] ) ) {
			wp_insert_term( $config['initial_term'], $name );
		}
	}

	private function sanitize_taxonomy_name( $name ) {
		$name = sanitize_key( $name );

		if ( in_array( $name, get_taxonomies() ) ) {
			return false;
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
	 * @param array $config Taxonomy configuration data.
	 *
	 * @return array
	 */
	private function build_taxonomy_args( array $config ) {
		if ( isset( $config['taxonomy_nice_names'] ) && is_array( $config['taxonomy_nice_names'] ) ) {
			$args['labels'] = $this->build_labels( $config['taxonomy_nice_names'] );
		}

		if ( isset( $config['rewrite'] ) && is_array( $config['rewrite'] ) ) {
			$args['rewrite'] = $config['rewrite'];
		}

		return array_merge( $args, $config['args'] );
	}

	private function build_labels( array $taxonomy_names ) {
		$singular = $taxonomy_names['singular'];
		$plural   = $taxonomy_names['plural'];

		if ( ! $singular || ! $plural ) {
			return [];
		}

		return [
			'name'                       => $plural,
			'singular_name'              => $singular,
			'all_items'                  => sprintf( '%s %s', __( 'All', ICASPAR_HUB_TEXT_DOMAIN ), $plural ),
			'edit_item'                  => sprintf( '%s %s', __( 'Edit', ICASPAR_HUB_TEXT_DOMAIN ), $singular ),
			'view_item'                  => sprintf( '%s %s', __( 'View', ICASPAR_HUB_TEXT_DOMAIN ), $singular ),
			'update_item'                => sprintf( '%s %s', __( 'Update', ICASPAR_HUB_TEXT_DOMAIN ), $singular ),
			'add_new_item'               => sprintf( '%s %s', __( 'Add New', ICASPAR_HUB_TEXT_DOMAIN ), $singular ),
			'new_item_name'              => sprintf( '%s %s', __( 'New Name for', ICASPAR_HUB_TEXT_DOMAIN ), $singular ),
			'search_items'               => sprintf( '%s %s', __( 'Search', ICASPAR_HUB_TEXT_DOMAIN ), $plural ),
			'popular_items'              => sprintf( '%s %s', __( 'Popular' ), $plural ),
			'separate_items_with_commas' => sprintf( '%s %s %s', __( 'Separate', ICASPAR_HUB_TEXT_DOMAIN ), $plural, __( 'with commas', ICASPAR_HUB_TEXT_DOMAIN ) ),
			'add_or_remove_items'        => sprintf( '%s %s', __( 'Add or remove', ICASPAR_HUB_TEXT_DOMAIN ), $plural ),
			'choose_from_most_used'      => sprintf( '%s %s', __( 'Choose from most used', ICASPAR_HUB_TEXT_DOMAIN ), $plural ),
			'not_found'                  => sprintf( '%s $s', $singular, _x( 'not found.', 'taxonomy term not found', ICASPAR_HUB_TEXT_DOMAIN ) )
		];
	}

}
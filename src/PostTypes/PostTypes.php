<?php
namespace ICaspar\WPHub\PostTypes;

/**
 * Class Post_Types
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\PostTypes
 */
class PostTypes {

	/**
	 * Custom post types data.
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * Title placeholders.
	 *
	 * @var array
	 */
	protected $title_placeholders = [];

	/**
	 * Post_Types constructor.
	 *
	 * @param array $config Post type configuration data.
	 */
	public function __construct( array $config) {
		$this->config = $config;
	}

	/**
	 * Register all the custom post types.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_post_types() {
		foreach ( $this->config as $post_type => $config ) {
			$this->register_custom_post_type( $post_type, $config );

			if( array_key_exists( 'title_placeholder', $config ) ) {
				$this->title_placeholders[ $post_type ] = $config['title_placeholder'];
			}
		}
	}

	/**
	 * Register a single custom post type
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Name of the post type to register.
	 * @param array $config Configuration data for the post type.
	 *
	 * @return void
	 */
	public function register_custom_post_type( $post_type, array $config ) {
		$name = $this->sanitize_post_type_name( $post_type );

		if ( ! $name ) {
			return;
		}

		$args = $this->build_post_type_args( $config );

		register_post_type( $name, $args );
	}

	/**
	 * Unregister a custom post type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type Post type to unregister.
	 *
	 * @return void
	 */
	public function unregister_custom_post_type( $post_type ) {
		if ( array_key_exists( $post_type, $this->config ) ) {
			unregister_post_type( $post_type );
		}
	}

	/**
	 * Customize the title placeholder for custom post types.
	 *
	 * @since 1.0.0
	 *
	 * @param string $title The default placeholder text.
	 *
	 * @return string
	 */
	public function change_title_placeholder( $title ) {
		$screen = get_current_screen();

		if ( array_key_exists( $screen->post_type, $this->title_placeholders ) ) {
			$title = $this->title_placeholders[$screen->post_type];
		}

		return $title;
	}

	/**
	 * Insure a clean, unique post type name.
	 *
	 * @param string $name Post type name.
	 *
	 * @return string|bool Sanitized post type name or false if name is a duplicate.
	 */
	private function sanitize_post_type_name( $name ) {
		$name = sanitize_key( $name );

		if ( in_array( $name, get_post_types() ) ) {
			return false;
		}

		return $name;
	}

	/**
	 * Build custom post type arguments array.
	 *
	 * @param array $config Post type configuration data.
	 *
	 * @return array
	 */

	private function build_post_type_args( array $config ) {
		$args = [];

		if ( isset( $config['post_type_names'] ) && is_array( $config['post_type_names'] ) ) {
			$args['labels'] = $this->build_labels( $config['post_type_names'] );
		}

		if ( isset( $config['excluded_supports'] ) && is_array( $config['excluded_supports'] ) ) {
			$args['supports'] = $this->build_supports( $config['excluded_supports'] );
		}

		if ( isset( $config['slug'] ) ) {
			$args['rewrite'] = $this->build_rewrite( $config['slug'] );
		}

		return array_merge( $args, $config['args'] );
	}

	/**
	 * Build a set of labels for a custom post type.
	 *
	 * @param array $post_type_names Singular and plural custom post type names.
	 *
	 * @return array Custom Post Type labels.
	 */
	private function build_labels( array $post_type_names ) {
		$singular = $post_type_names['singular'];
		$plural   = $post_type_names['plural'];
		$name = isset( $post_type_names['label'] ) ? $post_type_names['label'] : $plural;

		if ( ! $singular || ! $plural ) {
			return [];
		}

		return [
			'name'                  => $name,
			'singular_name'         => $singular,
			'add_new'               => sprintf( '%s %s', __( 'Add New', 'ic-custom-entries' ), $singular ),
			'add_new_item'          => sprintf( '%s %s', __( 'Add New', 'ic-custom-entries' ), $singular ),
			'edit_item'             => sprintf( '%s %s', __( 'Edit', 'ic-custom-entries' ), $singular ),
			'new_item'              => sprintf( '%s %s', __( 'New', 'ic-custom-entries' ), $singular ),
			'view_item'             => sprintf( '%s %s', __( 'View', 'ic-custom-entries' ), $singular ),
			'search_items'          => sprintf( '%s %s', __( 'Search', 'ic-custom-entries' ), $plural ),
			'all_items'             => sprintf( '%s %s', __( 'All', 'ic-custom-entries' ), $plural ),
			'archives'              => sprintf( '%s %s', $singular, __( 'Archives', 'ic-custom-entries' ) ),
			'insert_into_item'      => sprintf( '%s %s', __( 'Insert into', 'ic-custom-entries' ), $singular ),
			'uploaded_to_this_item' => sprintf( '%s %s', __( 'Upload to this', 'ic-custom-entries' ), $singular ),
			'filter_items_list'     => $plural,
			'items_list_navigation' => $plural,
			'items_list'            => $plural,
		];
	}

	/**
	 * Remove unwanted post type supports from a support type.
	 *
	 * @param array $excluded_supports Post type supports to be excluded.
	 *
	 * @return mixed
	 */
	private function build_supports( array $excluded_supports ) {
		$supports = array_keys( get_all_post_type_supports( 'post' ) );

		$supports = array_filter( $supports, function ( $support_type ) use ( $excluded_supports ) {
			return ! in_array( $support_type, $excluded_supports );
		} );

		return $supports;
	}

	/**
	 * Build a sanitized rewrite array for a custom post type.
	 *
	 * @param string $slug Rewrite slug given by user.
	 *
	 * @return array Rewrite array for a custom post type.
	 */
	private function build_rewrite( $slug ) {
		if ( ! $slug ) {
			return [];
		}

		$clean_slug = sanitize_title( $slug );

		return [ 'slug' => $clean_slug ];
	}

}
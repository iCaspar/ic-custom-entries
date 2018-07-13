<?php
/**
 * PostType class.
 *
 * @package ICaspar\CustomEntries\PostTypes
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\PostTypes;

use ICaspar\CustomEntries\Utilities\Helpers;

/**
 * Class PostType
 *
 * @since 1.0.0
 *
 * @package ICaspar\CustomEntries\PostTypes
 */
class PostType {

	/**
	 * @var array Custom post types data.
	 *
	 * @since 1.0.0
	 */
	protected $config = [];

	/**
	 * Post_Types constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param array $config Post type configuration data.
	 */
	public function __construct( array $config ) {
		$this->config = $config;
	}

	/**
	 * Initialize the post type.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init(): void {
		add_action( 'init', [ $this, 'register' ] );
		add_filter( 'enter_title_here', [ $this, 'change_title_placeholder' ] );
	}

	/**
	 * Callback to register the post type.
	 *
	 * @hooked init.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register(): void {
		$this->config['slug'] = $this->sanitize_post_type_name( $this->config['slug'] );

		if ( ! $this->config['slug'] ) {
			return;
		}

		$this->build_post_type_args();
		register_post_type( $this->config['slug'], $this->config['args'] );
	}

	/**
	 * Insure a clean, unique post type name.
	 *
	 * @param string $name Post type name.
	 *
	 * @return string Sanitized post type name or empty string if name is a duplicate.
	 */
	protected function sanitize_post_type_name( string $name ): string {
		$name = sanitize_key( $name );

		if ( in_array( $name, get_post_types() ) ) {
			return '';
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

	private function build_post_type_args() {
		$this->build_labels();
		$this->build_supports();
		$this->build_rewrite();
	}

	/**
	 * Build the post type labels.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	private function build_labels(): void {
		if ( ! Helpers::isSettingPresentAsArray( $this->config, 'post_type_names' ) ) {
			return;
		}

		$singular = isset( $this->config['post_type_names']['singular'] )
			? $this->config['post_type_names']['singular']
			: false;
		$plural   = isset( $this->config['post_type_names']['plural'] )
			? $this->config['post_type_names']['plural']
			: false;
		$name     = isset( $this->config['post_type_names']['name'] )
			? $this->config['post_type_names']['name']
			: $plural;

		if ( ! $singular || ! $plural ) {
			return;
		}

		$this->config['args']['labels'] = [
			'name'                  => $name,
			'singular_name'         => $singular,
			'add_new'               => sprintf( ' % s % s', __( 'Add New', '' ), $singular ),
			'add_new_item'          => sprintf( ' % s % s', __( 'Add New', 'ic-custom-entries' ), $singular ),
			'edit_item'             => sprintf( ' % s % s', __( 'Edit', 'ic-custom-entries' ), $singular ),
			'new_item'              => sprintf( ' % s % s', __( 'New', 'ic-custom-entries' ), $singular ),
			'view_item'             => sprintf( ' % s % s', __( 'View', 'ic-custom-entries' ), $singular ),
			'search_items'          => sprintf( ' % s % s', __( 'Search', 'ic-custom-entries' ), $plural ),
			'all_items'             => sprintf( ' % s % s', __( 'All', 'ic-custom-entries' ), $plural ),
			'archives'              => sprintf( ' % s % s', $singular, __( 'Archives', 'ic-custom-entries' ) ),
			'insert_into_item'      => sprintf( ' % s % s', __( 'Insert into', 'ic-custom-entries' ), $singular ),
			'uploaded_to_this_item' => sprintf( ' % s % s', __( 'Upload to this', 'ic-custom-entries' ), $singular ),
			'filter_items_list'     => $plural,
			'items_list_navigation' => $plural,
			'items_list'            => $plural,
			'not_found'             => sprintf( ' %s %s %s',
				__( 'No', 'ic-custom-entries' ),
				$plural,
				__( 'found', 'ic-custom-entries' )
			),
		];
	}

	/**
	 * Build the post type supports.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function build_supports(): void {
		if ( ! Helpers::isSettingPresentAsArray( $this->config, 'supports' ) ) {
			$this->config['args']['supports'] = array_keys( get_all_post_type_supports( 'post' ) );
		} else {
			$this->config['args']['supports'] = $this->config['supports'];
		}
	}

	/**
	 * Build a rewrite array for the post type.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function build_rewrite(): void {
		$this->config['args']['rewrite'] = [ 'slug' => $this->config['slug'] ];
	}

	/**
	 * Customize the title placeholder for custom post types.
	 *
	 * @since 1.0.0
	 *
	 * @param string $title The default placeholder text.
	 *
	 * @return string New Placeholder text, if set.
	 */
	public function change_title_placeholder( $title ): string {
		$screen = get_current_screen();

		if ( $this->config['slug'] != $screen->post_type || ! isset( $this->config['title_placeholder']) ) {
			return $title;
		}

		return esc_attr( $this->config['title_placeholder'] );
	}
}

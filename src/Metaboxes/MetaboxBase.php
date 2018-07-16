<?php
/**
 * MetaboxBase class.
 *
 * @package ICaspar\CustomEntries\Metaboxes
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Metaboxes;

use WP_Post;

/**
 * Class MetaboxBase
 *
 * @since 1.0.0
 *
 * @package ICaspar\CustomEntries\Metaboxes
 */
abstract class MetaboxBase {

	/**
	 * Metabox slug.
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * Metabox Title.
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Post types associated with the metabox.
	 *
	 * @var array
	 */
	protected $post_types;

	/**
	 * The metadata key name.
	 *
	 * @var string
	 */
	protected $meta_key;

	/**
	 * Context on the post page metabox placement.
	 *
	 * @var string
	 */
	protected $location;

	/**
	 * Priority for metabox display.
	 *
	 * @var string
	 */
	protected $priority;

	/**
	 * Description.
	 *
	 * @var array|null
	 */
	protected $args;

	/**
	 * MetaboxBase constructor.
	 *
	 * @param array $args Metabox configuration.
	 */
	public function __construct( array $args ) {
		if ( ! $this->is_valid_config( $args ) ) {
			return;
		}

		$this->slug       = $args['slug'];
		$this->title      = $args['title'];
		$this->post_types = $args['post_types'];
		$this->meta_key   = $args['meta_key'];
		$this->location   = isset( $args['location'] ) ? $args['location'] : 'normal';
		$this->priority   = isset( $args['priority'] ) ? $args['priority'] : 'default';
		$this->args       = isset( $args['args'] ) ? $args['args'] : null;
	}

	/**
	 * Check whether a metabox config array is valid.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The metabox configuration
	 *
	 * @return bool Whether the configuration array is valid.
	 */
	protected function is_valid_config( array $args ): bool {
		$required = [ 'slug', 'title', 'post_types', 'meta_key' ];

		foreach ( $required as $key ) {
			if ( ! array_key_exists( $key, $args ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Initialize the metabox.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'load-post.php', [ $this, 'register' ] );
		add_action( 'load-post-new.php', [ $this, 'register' ] );
	}

	/**
	 * Register the metabox to post types.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'add_meta_boxes', [ $this, 'add_metabox' ] );

		foreach ( $this->post_types as $post_type ) {
			add_action( 'save_post_' . $post_type, [ $this, 'save_meta' ], 10, 2 );
		}
	}

	/**
	 * Add the metabox to the post page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_metabox() {
		add_meta_box(
			$this->slug,
			$this->title,
			[ $this, 'render_metabox' ],
			$this->post_types,
			$this->location,
			$this->priority,
			$this->args
		);
	}

	/**
	 * Render the metabox HTML on the page.
	 *
	 * @since 1.0.0
	 **
	 *
	 * @param \WP_Post $post The current post object.
	 */
	public abstract function render_metabox( WP_Post $post );

	/**
	 * Get the stored meta of a post by its meta key name.
	 *
	 * @param \WP_Post $post The post associated with desired meta.
	 * @param string $field Key of the desired meta.
	 *
	 * @return string Stored meta value
	 */
	protected function get_stored_meta( \WP_Post $post, $field ) {
		$stored_meta = get_post_meta( $post->ID );

		return ! empty( $stored_meta[ $field ] )
			? $stored_meta[ $field ][0]
			: '';
	}

	/**
	 * Save the meta.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The current post ID.
	 * @param \WP_Post $post The current post object.
	 *
	 * @return void
	 */
	public function save_meta( $post_id, \WP_Post $post ) {
		if ( ! $this->is_ok_to_save( $post_id, $post ) ) {
			return;
		}

		if ( isset( $_POST[ $this->meta_key ] ) ) {
			$input = $this->validate( $_POST[ $this->meta_key ] );
			update_post_meta( $post_id, $this->meta_key, $input );
		}
	}

	/**
	 * Check whether a meta save request is legit.
	 *
	 * @param int $post_id The current post ID.
	 * @param \WP_Post $post The current Post object.
	 *
	 * @return bool
	 */
	protected function is_ok_to_save( $post_id, \WP_Post $post ) {
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );

		if ( $is_autosave || $is_revision || ! $this->is_valid_nonce() ) {
			return false;
		}

		$post_type = get_post_type_object( $post->post_type );

		return current_user_can( $post_type->cap->edit_post, $post_id );
	}

	/**
	 * Check for a valid nonce.
	 * @return bool
	 */
	protected function is_valid_nonce() {
		if ( isset( $_POST[ $this->slug . '_nonce' ] ) ) {
			return wp_verify_nonce( $_POST[ $this->slug . '_nonce' ], $this->slug . '_save' );
		}

		return false;
	}

	/**
	 * Validate the input.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $input User data.
	 *
	 * @return mixed
	 */
	protected abstract function validate( $input );
}

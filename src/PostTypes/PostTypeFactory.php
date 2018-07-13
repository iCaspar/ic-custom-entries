<?php
/**
 * PostTypeFactory class.
 *
 * @package ICaspar\CustomEntries\PostTypes
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\PostTypes;

/**
 * Class PostTypeFactory
 *
 * @package ICaspar\CustomEntries\PostTypes
 *
 * @since 1.0.0
 */
class PostTypeFactory {

	protected $config = [];

	/**
	 * PostTypeFactory constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param array $post_types_config
	 */
	public function __construct( array $post_types_config ) {
		$this->config = $post_types_config;
	}

	/**
	 * Make an array of registered PostTypes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $post_types_config Configuration for PostTypes to be made.
	 *
	 * @return array PostTypes made.
	 */
	public function make( array $post_types_config = [] ): array {
		$post_types = [];

		if ( empty( $post_types_config ) ) {
			$post_types_config = $this->config;
		}

		foreach ( $post_types_config as $post_type => $config ) {
			$post_types[$post_type] = $this->build( $config );
			$post_types[$post_type]->init();
		}

		return $post_types;
	}

	/**
	 * Build a single PostType instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $config PostType configuration.
	 *
	 * @return PostType
	 */
	public function build( array $config ): PostType {
		return new PostType( $config );
	}
}

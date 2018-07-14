<?php
/**
 * CustomEntryFactory class.
 *
 * @package ICaspar\CustomEntries\Factories
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Factories;

use ICaspar\CustomEntries\PostTypes\PostType;
use ICaspar\CustomEntries\Taxonomies\Taxonomy;
use UnexpectedValueException;

/**
 * Class CustomEntryFactory
 *
 * @package ICaspar\CustomEntries\Factories
 *
 * @since 1.0.0
 */
class CustomEntryFactory {

	/**
	 * CustomEntryFactory constructor.
	 */
	public function __construct() {
	}

	/**
	 * Make an array of registered Factories.
	 *
	 * @since 1.0.0
	 *
	 * @throws UnexpectedValueException
	 *
	 * @param array $config Configuration for Custom Entries to be made.
	 * @param string $entity_type (Optional) 'post_type' or 'taxonomy'. Defaults to 'post-type'.
	 *
	 * @return array Custom Entry objects made.
	 */
	public function make( array $config, string $entity_type = 'post_type' ): array {
		if ( ! in_array( $entity_type, [ 'post_type', 'taxonomy' ] ) ) {
			throw new UnexpectedValueException( 'Entity type must be "post_type" or "taxonomy".' );
		}

		$build_type = 'build_' . $entity_type;
		$entries    = [];

		foreach ( $config as $entry_name => $entry_config ) {
			$entries[ $entry_name ] = $this->$build_type( $entry_config );
			$entries[ $entry_name ]->init();
		}

		return $entries;
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
	public function build_post_type( array $config ): PostType {
		return new PostType( $config );
	}

	/**
	 * Build a single Taxonomy instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $config Taxonomy configuration.
	 *
	 * @return Taxonomy
	 */
	public function build_taxonomy( array $config ): Taxonomy {
		return new Taxonomy( $config );
	}
}

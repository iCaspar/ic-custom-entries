<?php
/**
 * MetaboxFactory class.
 *
 * @package ICaspar\CustomEntries\Factories
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Factories;


/**
 * Class MetaboxFactory
 *
 * @package ICaspar\CustomEntries\Factories
 *
 * @since 1.0.0
 */
class MetaboxFactory {

	protected $metabox_namespace = 'ICaspar\\CustomEntries\\Metaboxes\\';

	/**
	 * Make an array of regitered metaboxes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $config Configuration for metaboxes to be made.
	 *
	 * @return array Metaboxes made.
	 */
	public function make( array $config ): array {
		$metaboxes = [];

		foreach ( $config as $metabox_name => $metabox_config ) {
			$metabox_class = $this->metabox_namespace . $metabox_config['type'];

			if ( class_exists( $metabox_class ) ) {
				$metaboxes[ $metabox_name ] = new $metabox_class( $metabox_config );
				$metaboxes[ $metabox_name ]->init();
			}
		}

		return $metaboxes;
	}
}

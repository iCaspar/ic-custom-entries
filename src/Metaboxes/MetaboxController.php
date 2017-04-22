<?php
namespace ICaspar\WPHub\Metaboxes;

/**
 * Class MetaboxController
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\Metaboxes
 */
class MetaboxController {

	/**
	 * Metabox configuration data.
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * MetaboxController constructor.
	 *
	 * @param array $config
	 */
	public function __construct( array $config ) {
		$this->config = $config;
	}

	/**
	 * Initialize all the boxes.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		foreach ( $this->config as $metabox ) {
			$class = __NAMESPACE__ . '\\' . $metabox['type'];
			if ( class_exists( $class ) ) {
				$box = new $class( $metabox );
				$box->init_metabox();
			}
		}
	}
}
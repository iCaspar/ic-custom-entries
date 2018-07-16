<?php
/**
 * Assets class
 *
 * @package ICaspar\CustomEntries\Utilities
 *
 * @since 1.0.0
 */

namespace ICaspar\CustomEntries\Utilities;

/**
 * Class Assets
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\Utils
 */
class Assets {

	/**
	 * @var string The base URL for plugin assets.
	 */
	protected $assets_url = '';

	protected $version = '';

	protected $dev_mode = false;

	/**
	 * Assets constructor.
	 *
	 * @param string $plugin_url
	 * @param string $version
	 */
	public function __construct( string $plugin_url, string $version ) {
		$this->assets_url = $plugin_url . 'assets/';
		$this->version = $version;
		$this->dev_mode   = Helpers::is_development_mode();
	}

	/**
	 * Enqueue a plugin asset.
	 *
	 * @since 1.0.0
	 *
	 * @param string $handle Unique Script handle (slug)
	 * @param string $script_name File name of the script to enqueue.
	 * @param array $deps An array of dependencies.
	 *
	 * @return void
	 */
	public function enqueue_script( string $handle, string $script_name, array $deps = [] ): void {
		if ( ! $this->dev_mode ) {
			$asset_name = str_replace( ['.js', '.css'], ['.min.js', '.min.css' ], $script_name );
		}

		$handle = sanitize_key( $handle );

		wp_enqueue_script(
			$handle,
			$this->assets_url . 'js/' . $script_name,
			$deps,
			$this->version,
			true
		);
	}

	/**
	 * Get the URL for an image asset
	 *
	 * @since 1.0.0
	 *
	 * @param string $image_filename Filename of image to get.
	 *
	 * @return string The image URL.
	 */
	public function get_image_url( string $image_filename ): string {
		return $this->assets_url . 'images/' . $image_filename;
	}
}

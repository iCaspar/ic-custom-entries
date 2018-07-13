<?php
namespace ICaspar\WPHub\Utils;

/**
 * Class Scripts
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\Utils
 */
class Scripts {

	protected $config;

	/**
	 * Scripts constructor.
	 *
	 * @param array $config Configuration for scripts
	 */
	public function __construct( array $config = [] ) {
		$this->config = $config;
	}

	/**
	 * Add a script.
	 *
	 * @since 1.0.0
	 *
	 * @param array $script_args Arguments for the script.
	 *
	 * @return void
	 */
	public function add_script( array $script_args ) {
		$this->config[] = $script_args;
	}

	public function register_scripts() {
		foreach ( $this->config as $script ) {
			wp_register_script(
				$script['handle'],
				ICASPAR_HUB_ASSETS_URL . $script['file'],
				$script['deps'],
				ICASPAR_HUB_VERSION,
				$script['footer']
			);
		}
	}
}
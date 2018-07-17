<?php
/**
 * Main class.
 *
 * Root Class for iC Custom Entries
 */

namespace ICaspar\CustomEntries;

use ICaspar\CustomEntries\Admin\TaxonomyImages;
use ICaspar\CustomEntries\Factories\CustomEntryFactory;
use ICaspar\CustomEntries\Factories\MetaboxFactory;
use ICaspar\CustomEntries\Utilities\ActivationActions;
use ICaspar\CustomEntries\Utilities\Assets;
use ICaspar\CustomEntries\Utilities\Helpers;
use ICaspar\WPHub\Admin\SocialMedia;
use ICaspar\WPHub\Widgets\Widgets;

/**
 * Main Plugin class.
 *
 * @since 1.0.0
 *
 * @package ICaspar\CustomEntries
 */
class Main {

	/**
	 * @var string The plugin's root file.
	 *
	 * @since 1.0.0
	 */
	protected $plugin_file = '';

	/**
	 * @var string The plugin's version.
	 *
	 * @since 1.0.0
	 */
	protected $version = '';

	/**
	 * @var string The plugin's base directory.
	 */
	protected $plugin_dir = '';
	/**
	 * @var string The plugin's base url.
	 *
	 * @since 1.0.0
	 */
	protected $plugin_url = '';

	/**
	 * @var array The plugin's configuration settings.
	 *
	 * @since 1.0.0
	 */
	protected $config = [];

	/**
	 * Description.
	 *
	 * @var Widgets
	 */
	protected $widgets;

	/**
	 * Social Media Settings object.
	 *
	 * @var SocialMedia
	 */
	protected $social_settings;

	/**
	 * Main constructor.
	 *
	 * @param string $plugin_file The plugin's root file.
	 */
	public function __construct( string $plugin_file ) {
		$this->plugin_file = $plugin_file;
		$this->set_version();
		$this->set_plugin_directory();
		$this->set_plugin_url();
		$this->set_config();
	}

	/**
	 * Set the plugin version.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function set_version(): void {
		$data = get_file_data( $this->plugin_file, [ 'version' => 'Version' ] );

		$this->version = $data['version'];
	}

	protected function set_plugin_directory(): void {
		$this->plugin_dir = plugin_dir_path( $this->plugin_file );
	}

	/**
	 * Set the plugin's base url.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function set_plugin_url(): void {
		$plugin_url = plugin_dir_url( $this->plugin_file );

		if ( is_ssl() ) {
			$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
		}

		$this->plugin_url = $plugin_url;
	}

	/**
	 * Set the plugin configuration from the config file.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function set_config(): void {
		$config_dir = plugin_dir_path( $this->plugin_file ) . 'config/';
		$config     = include $config_dir . 'config.php';

		$this->config = $config ?: [];
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init(): void {
		$this->set_activation_status_actions();
		$this->init_post_types();
		$this->init_taxonomies();
		$this->init_taxonomy_images();

		if( is_admin() ) {
			$this->init_metaboxes();
		}
	}

	/**
	 * Set activation status actions
	 *
	 * @since
	 *
	 * @return void
	 */
	protected function set_activation_status_actions(): void {
		register_deactivation_hook( $this->plugin_file, [ ActivationActions::class, 'deactivate' ] );

		if ( is_admin() ) {
			add_action( 'admin_init', [ ActivationActions::class, 'maybe_flush_rewrites' ] );
		}
	}

	/**
	 * Initialize post types.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function init_post_types(): void {
		if ( ! Helpers::isSettingPresentAsArray( $this->config, 'post-types' ) ) {
			return;
		}

		/**
		 * Filter the Post Types Configuration.
		 *
		 * @since 1.0.0
		 *
		 * @param array $config An associative array of post type names and configurations to register.
		 */
		$config  = apply_filters( 'ic_post_types_config', $this->config['post-types'] );
		$factory = new CustomEntryFactory();
		$factory->make( $config );
	}

	/**
	 * Initialize taxonomies.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function init_taxonomies(): void {
		if ( ! Helpers::isSettingPresentAsArray( $this->config, 'taxonomies' ) ) {
			return;
		}

		/**
		 * Filter the Taxonomies Configuration.
		 *
		 * @since 1.0.0
		 *
		 * @param array $config An associative array of taxonomy names and configurations to register.
		 */
		$config  = apply_filters( 'ic_taxonomies_config', $this->config['taxonomies'] );
		$factory = new CustomEntryFactory();
		$factory->make( $config, 'taxonomy' );
	}

	/**
	 * Initialize taxonomy featured images.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function init_taxonomy_images(): void {
		if ( ! Helpers::isSettingPresentAsArray( $this->config, 'tax-images' ) ) {
			return;
		}

		$taxonomy_images = new TaxonomyImages( new Assets( $this->plugin_url, $this->version ), $this->config['tax-images'] );
		$taxonomy_images->init();
	}

	protected function init_metaboxes(): void {
		if ( ! Helpers::isSettingPresentAsArray( $this->config, 'metaboxes' ) ) {
			return;
		}

		$config = apply_filters( 'ic_metaboxes_config', $this->config['metaboxes']);
		$factory = new MetaboxFactory();
		$factory->make( $config );
	}
}

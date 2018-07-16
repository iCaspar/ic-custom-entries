<?php
/**
 * Main class.
 *
 * Root Class for iC Custom Entries
 */

namespace ICaspar\CustomEntries;

use ICaspar\CustomEntries\Admin\TaxonomyImages;
use ICaspar\CustomEntries\Factories\CustomEntryFactory;
use ICaspar\CustomEntries\Utilities\ActivationActions;
use ICaspar\CustomEntries\Utilities\Assets;
use ICaspar\CustomEntries\Utilities\Helpers;
use ICaspar\WPHub\Admin\SocialMedia;
use ICaspar\WPHub\Metaboxes\MetaboxController;
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
	 * Plugin Metabox Controller object.
	 *
	 * @var MetaboxController
	 */
	protected $metaboxes;

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
		$this->set_url();
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

	/**
	 * Set the plugin's base url.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function set_url(): void {
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

	/**
	 * Setup the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
//	private function setup() {
//		if ( array_key_exists( 'widgets', $this->config ) && ! empty( $this->config['widgets'] ) ) {
//			$this->widgets = new Widgets( $this->config['widgets'] );
//			add_action( 'widgets_init', [ $this->widgets, 'register_widgets' ] );
//		}
//
//		if ( is_admin() ) {
//
//			if ( array_key_exists( 'metaboxes', $this->config ) && ! empty( $this->config['metaboxes'] ) ) {
//				$this->metaboxes = new MetaboxController( $this->config['metaboxes'] );
//				$this->metaboxes->init();
//			}
//
//			$page_excerpts = new Admin\PageExcerpts();
//			add_action( 'init', [$page_excerpts, 'add_excerpt_support_to_pages'] );
//		}


	/**
	 * Add custom image sizes.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
//	public function image_sizes() {
//		add_image_size( 'custom-news', 325, 325, true );
//		add_image_size( 'sponsor-panel-logo', 500, 250, true );
//	}
}
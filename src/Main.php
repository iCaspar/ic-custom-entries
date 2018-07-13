<?php
/**
 * Main class.
 *
 * Root Class for iC Custom Entries
 */

namespace ICaspar\CustomEntries;

use ICaspar\CustomEntries\Utilities\ActivationActions;
use ICaspar\WPHub\Admin\SocialMedia;
use ICaspar\WPHub\Metaboxes\MetaboxController;
use ICaspar\WPHub\PostTypes\PostTypes;
use ICaspar\WPHub\Taxonomies\Taxonomies;
use ICaspar\WPHub\Utils\Scripts;
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
	 * Plugin PostTypes object.
	 *
	 * @var PostTypes
	 */
	protected $post_types;

	/**
	 * Plugin Taxonomies object.
	 *
	 * @var Taxonomies
	 */
	protected $taxonomies;

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
	 * @since 1.0.0
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
	 * Setup the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
//	private function setup() {
//		if ( array_key_exists( 'cpts', $this->config ) && ! empty( $this->config['cpts'] ) ) {
//			$this->post_types = new PostTypes( $this->config['cpts'] );
//			add_action( 'init', [ $this->post_types, 'register_post_types' ] );
//			add_filter( 'enter_title_here', [ $this->post_types, 'change_title_placeholder' ] );
//		}
//
//		if ( array_key_exists( 'taxonomies', $this->config ) && ! empty( $this->config['taxonomies'] ) ) {
//			$this->taxonomies = new Taxonomies( $this->config['taxonomies'] );
//			add_action( 'init', [ $this->taxonomies, 'register_taxonomies' ] );
//		}
//
//		if ( array_key_exists( 'widgets', $this->config ) && ! empty( $this->config['widgets'] ) ) {
//			$this->widgets = new Widgets( $this->config['widgets'] );
//			add_action( 'widgets_init', [ $this->widgets, 'register_widgets' ] );
//		}
//
//		if ( array_key_exists( 'scripts', $this->config ) && ! empty( $this->config['scripts'] ) ) {
//			$this->scripts = new Scripts( $this->config['scripts'] );
//			add_action( 'init', [ $this->scripts, 'register_scripts' ] );
//		}
//
//		if ( is_admin() ) {
//
//			if ( array_key_exists( 'metaboxes', $this->config ) && ! empty( $this->config['metaboxes'] ) ) {
//				$this->metaboxes = new MetaboxController( $this->config['metaboxes'] );
//				$this->metaboxes->init();
//			}
//
//			$this->social_settings = new SocialMedia();
//
//			$page_excerpts = new Admin\PageExcerpts();
//			add_action( 'init', [$page_excerpts, 'add_excerpt_support_to_pages'] );
//		}

//		$this->init_hooks();
//	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
//	private function init_hooks() {
//		add_action( 'init', [ $this, 'image_sizes' ] );
//	}

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
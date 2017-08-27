<?php
namespace ICaspar\WPHub;

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
 * @package ICaspar\WPHub
 */
class Hub {
	/**
	 * The plugin's configuration settings.
	 *
	 * @var array
	 */
	protected $config;

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
	 * Hub constructor.
	 *
	 * This is called on the plugins_loaded hook, priority 20.
	 * The dcllc_hub_loaded filter provides access to the plugin object.
	 *
	 * @param array $config Plugin configuration.
	 * @param bool $testing (optional)
	 */
	public function __construct( array $config, $testing = false ) {
		if ( $testing ) {
			$this->dump_plugin_constants();

			return;
		}

		$this->config = $config;

		$this->setup();

		// Let's allow future generations to modify any of this.
		apply_filters( 'dcllc_hub_loaded', $this );
	}

	/**
	 * Setup the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function setup() {
		if ( array_key_exists( 'cpts', $this->config ) && ! empty( $this->config['cpts'] ) ) {
			$this->post_types = new PostTypes( $this->config['cpts'] );
			add_action( 'init', [ $this->post_types, 'register_post_types' ] );
			add_filter( 'enter_title_here', [ $this->post_types, 'change_title_placeholder' ] );
		}

		if ( array_key_exists( 'taxonomies', $this->config ) && ! empty( $this->config['taxonomies'] ) ) {
			$this->taxonomies = new Taxonomies( $this->config['taxonomies'] );
			add_action( 'init', [ $this->taxonomies, 'register_taxonomies' ] );
		}

		if ( array_key_exists( 'widgets', $this->config ) && ! empty( $this->config['widgets'] ) ) {
			$this->widgets = new Widgets( $this->config['widgets'] );
			add_action( 'widgets_init', [ $this->widgets, 'register_widgets' ] );
		}

		if ( array_key_exists( 'scripts', $this->config ) && ! empty( $this->config['scripts'] ) ) {
			$this->scripts = new Scripts( $this->config['scripts'] );
			add_action( 'init', [ $this->scripts, 'register_scripts' ] );
		}

		if ( is_admin() ) {

			if ( array_key_exists( 'metaboxes', $this->config ) && ! empty( $this->config['metaboxes'] ) ) {
				$this->metaboxes = new MetaboxController( $this->config['metaboxes'] );
				$this->metaboxes->init();
			}

			$this->social_settings = new SocialMedia();

			add_action( 'init', ['ICaspar\WPHub\Admin\PageExcerpts', 'add_excerpt_support_to_pages'] );
		}


		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'init', [ $this, 'image_sizes' ] );

		if ( is_admin() ) {
			add_action( 'admin_init', [ $this, 'maybe_flush_rewrites' ] );
		}
	}

	/**
	 * Flush rewrite rules if plugin has not yet been activated.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function maybe_flush_rewrites() {
		if ( false == get_option( 'ic_hub_active' ) ) {
			flush_rewrite_rules();
			update_option( 'ic_hub_active', true );
		}
	}

	/**
	 * Add custom image sizes.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function image_sizes() {
		add_image_size( 'custom-news', 325, 325, true );
		add_image_size( 'sponsor-panel-logo', 500, 250, true );
	}

	/**
	 * Dump the plugin's constants (for testing).
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function dump_plugin_constants() {
		d( 'I am Hub!' );
		d( ICASPAR_HUB_FILE );
		d( ICASPAR_HUB_DIR );
		d( ICASPAR_HUB_CONFIG_DIR );
		d( ICASPAR_HUB_NAME );
		d( ICASPAR_HUB_VERSION );
		d( ICASPAR_HUB_TEXT_DOMAIN );
		d( ICASPAR_HUB_URL );
		d( ICASPAR_HUB_ASSETS_URL );
	}
}
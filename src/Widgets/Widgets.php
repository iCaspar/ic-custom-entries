<?php
namespace ICaspar\WPHub\Widgets;

/**
 * Class Widgets
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\Widgets
 */
class Widgets {

	/**
	 * List of custom widget classes.
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * Widgets constructor.
	 *
	 * @param array $config Widget class configuration.
	 */
	public function __construct( array $config ) {
		$this->config = $config;
	}

	/**
	 * Add a widget to the custom widget list.
	 *
	 * @since 1.0.0
	 *
	 * @param string $widget Fully qualified classname of the widget to add.
	 *
	 * @return void
	 */
	public function add( $widget ) {
		$this->config[] = $widget;
	}

	/**
	 * Remove a custom widget from the widget list.
	 *
	 * @since 1.0.0
	 *
	 * @param string $widget Fully qualified class name of widget to remove.
	 *
	 * @return bool True if successful.
	 */
	public function remove( $widget ) {
		if ( ! in_array( $widget, $this->config ) ) {
			return false;
		}
		unset ( $this->config[ array_search( $widget, $this->config ) ] );

		return true;
	}

	/**
	 * Register all the custom widgets.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_widgets() {
		foreach ( $this->config as $widget ) {
			register_widget( $widget );
		}
	}
}
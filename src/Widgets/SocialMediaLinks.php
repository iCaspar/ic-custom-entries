<?php
namespace ICaspar\WPHub\Widgets;

/**
 * Class SocialMediaLinks
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\Widgets
 */
class SocialMediaLinks extends \WP_Widget {

	/**
	 * Default widget settings.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Supported Media icon classes.
	 *
	 * @var array
	 */
	protected $supported_media = [
		'facebook' => 'fa-facebook-official',
		'twitter'  => 'fa-twitter',
		'linkedin' => 'fa-linkedin-square',
	];

	/**
	 * Sponsor Panels Widget constructor.
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'social-media-links-widget',
			'description' => __( 'Displays Linked Social Media Icons', ICASPAR_HUB_TEXT_DOMAIN )
		);

		$this->defaults = array(
			'title'              => __( 'Social Media', ICASPAR_HUB_TEXT_DOMAIN ),
			'open_in_new_window' => false,
		);

		parent::__construct( 'social-media-links-widget', __( 'Social Media Icons Widget', ICASPAR_HUB_TEXT_DOMAIN ), $widget_options );
	}

	/**
	 * Display the widget settings form in the WordPress admin.
	 *
	 * @param array $instance
	 *
	 * @return string
	 */
	public function form( $instance ) {
		$instance  = wp_parse_args( $instance, $this->defaults );
		$form_html = __DIR__ . '/views/social-media-links-widget-form.php';

		include $form_html;
	}

	/**
	 * Update a widget instance with sanitized user info.
	 *
	 * @param array $new_instance Newly submitted user input.
	 * @param array $old_instance Previously set widget settings.
	 *
	 * @return array Sanitized new settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$safe_instance['title']              = sanitize_text_field( $new_instance['title'] );
		$safe_instance['open_in_new_window'] = $new_instance['open_in_new_window'] ? 1 : 0;

		return $safe_instance;
	}

	/**
	 * Display the widget output on the front end.
	 *
	 * @param array $args WP Widget arguments.
	 * @param array $instance Settings for this widget instance.
	 */
	public function widget( $args, $instance ) {
		$instance       = wp_parse_args( $instance, $this->defaults );
		$open_in_window = $instance['open_in_new_window'] ? '1' : '0';

		echo $args['before_widget'];

		echo $this->get_social_media_icon_links( $open_in_window );

		echo $args['after_widget'];
	}


	/**
	 * Gets social media icon links as html.
	 *
	 * @param bool $open_new_window Whether to open links in a new window/tab.
	 *
	 * @since 1.0.0
	 *
	 * @return string The HTML links.
	 */
	protected function get_social_media_icon_links( $open_new_window ) {
		$html = '<ul class="social-icons">';

		if ( $media_links = get_option( 'dcllc-social-media' ) ) {
			foreach ( $media_links as $media => $url ) {
				$html .= $this->build_icon_link( $media, $url, $open_new_window );
			}
		}

		$html .= '</ul>';

		return $html;
	}

	/**
	 * Builds a social media icon link.
	 *
	 * @since 1.0.0
	 *
	 * @param string $media The media service name.
	 * @param string $url A URL.
	 * @param bool $open_new_window Whether to open links in a new window/tab.
	 *
	 * @return string Html for a link.
	 */
	protected function build_icon_link( $media, $url, $open_new_window ) {
		$target = $open_new_window ? 'target="_blank"' : '';

		if ( array_key_exists( $media, $this->supported_media ) ) {
			return sprintf( '<li><a %1$s class="social-media-link" href="%2$s"><span class="fa %3$s" aria-hidden="true"></span>%4$s</a></li>',
				$target,
				esc_url( $url ),
				$this->supported_media[$media],
				$media );
		}

		return '';
	}
}
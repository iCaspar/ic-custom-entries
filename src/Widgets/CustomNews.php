<?php
namespace ICaspar\WPHub\Widgets;

class CustomNews extends \WP_Widget {

	/**
	 * Custom News Widget constructor.
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'custom-news-widget',
			'description' => __( 'Custom recent news with clickable excerpts', ICASPAR_HUB_TEXT_DOMAIN )
		);

		$this->defaults = array(
			'title'  => __( 'News', ICASPAR_HUB_TEXT_DOMAIN ),
			'number' => 4,
		);

		parent::__construct( 'custom-news-widget', __( 'Custom News Widget', ICASPAR_HUB_TEXT_DOMAIN ), $widget_options );
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
		$form_html = __DIR__ . '/views/custom-news-widget-form.php';

		include $form_html;
	}

	/**
	 * Update a widget instance with sanitized user info.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$safe_instance['title']  = sanitize_text_field( $new_instance['title'] );
		$safe_instance['number'] = (int) $new_instance['number'];

		return $safe_instance;
	}

	/**
	 * Display the widget output on the front end.
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$instance   = wp_parse_args( $instance, $this->defaults );
		$query_args = $this->get_query_args( $instance['number'] );

		$query = new \WP_Query( $query_args );

		if ( $query->have_posts() ) {
			include __DIR__ . '/views/custom-news-widget-start.php';

			while ( $query->have_posts() ) {
				$query->the_post();

				include __DIR__ . '/views/custom-news-widget-item.php';

				if ( ( $query->current_post + 1 ) != $query->post_count ) {
					echo '<hr>';
				}
			}

			include __DIR__ . '/views/custom-news-widget-end.php';
		}

		wp_enqueue_script( 'custom-news-widget' );
		wp_reset_postdata();
	}

	/**
	 * Build an array of arguments for a custom testimonial query.
	 *
	 * @param int number Number of testimonials to show.
	 *
	 * @return array
	 */
	protected function get_query_args( $number ) {
		if ( $number < 0 ) {
			$number = '-1';
		}

		$args = array(
			'posts_per_page' => (int) $number
		);

		return $args;
	}
}
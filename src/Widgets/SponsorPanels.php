<?php
namespace ICaspar\WPHub\Widgets;

/**
 * Class SponsorPanels
 *
 * @since 1.0.0
 *
 * @package ICaspar\WPHub\Widgets
 */
class SponsorPanels extends \WP_Widget {

	/**
	 * Valid sponsor levels.
	 *
	 * @var array
	 */
	protected $levels;

	/**
	 * Sponsor Panels Widget constructor.
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'sponsor-panels-widget',
			'description' => __( 'Display Sponsors', ICASPAR_HUB_TEXT_DOMAIN )
		);

		$this->defaults = array(
			'title'         => __( 'Sponsors', ICASPAR_HUB_TEXT_DOMAIN ),
			'sponsor_level' => 'gold',
			'number'        => 2,
		);

		$this->levels = [
			'gold'   => __( 'Gold', ICASPAR_HUB_TEXT_DOMAIN ),
			'silver' => __( 'Silver', ICASPAR_HUB_TEXT_DOMAIN ),
			'bronze' => __( 'Bronze', ICASPAR_HUB_TEXT_DOMAIN ),
		];

		parent::__construct( 'sponsor-panels-widget', __( 'Sponsor Panels Widget', ICASPAR_HUB_TEXT_DOMAIN ), $widget_options );
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
		$form_html = __DIR__ . '/views/sponsor-panels-widget-form.php';

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
		$safe_instance['title']         = sanitize_text_field( $new_instance['title'] );

		return $safe_instance;
	}

	/**
	 * Display the widget output on the front end.
	 *
	 * @param array $args WP Widget arguments.
	 * @param array $instance Settings for this widget instance.
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		include __DIR__ . '/views/sponsor-panels-widget-start.php';

		foreach ( $this->levels as $level => $label ) {
			echo '<h3 class="sponsor-level">' . $label . '</h3>';

			$query_args = $this->get_query_args( $level == 'gold' ? 2 : 4, $level );

			$query = new \WP_Query( $query_args );

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {
					$query->the_post();

					include __DIR__ . '/views/sponsor-panels-widget-item.php';
				}

			}

			//	wp_enqueue_script( 'sponsor-panels-widget' );
			wp_reset_postdata();
		}

		include __DIR__ . '/views/sponsor-panels-widget-end.php';
	}

	/**
	 * Build an array of arguments for a custom testimonial query.
	 *
	 * @param int $number Number of testimonials to show.
	 * @param string $level Sponsor Level Category
	 *
	 * @return array
	 */
	protected function get_query_args( $number, $level ) {

		$args = array(
			'posts_per_page' => (int) $number,
			'post_type'      => 'njifma_affiliates',
			'tax_query'      => [
				'relation' => 'AND',
				[
					'taxonomy' => 'njifma_affiliates_category',
					'field'    => 'slug',
					'terms'    => [ 'sponsor' ],
				],
				[
					'taxonomy' => 'njifma_affiliates_category',
					'field'    => 'slug',
					'terms'    => [ $level ],
				]
			],
		);

		return $args;
	}

	/**
	 * Sanitize sponsor level input.
	 *
	 * @since 1.0.0
	 *
	 * @param string $input Raw input
	 *
	 * @return string
	 */
	protected function sanitize_sponsor_level( $input ) {
		return in_array( $input, $this->valid_levels ) ? $input : '';
	}
}
<?php
/**
 * custom-news-widget-start.php
 *
 * Opening HTML for a custom news widget.
 *
 * @since 1.0.0
 */
?>

<?php echo $args['before_widget']; ?>

<?php if ( ! empty( $instance['title'] ) ): ?>
	<?php echo $args['before_title'] . esc_html( $instance['title'] ); ?>
    <a class="custom-news-widget-link" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">view all news</a>
	<?php echo $args['after_title']; ?>
<?php endif; ?>

<div class="custom-news-container">
    <div class="custom-news-list">
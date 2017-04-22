<?php
/**
 * sponsor-panels-widget-start.php
 *
 * Opening HTML for a sponsor panels widget.
 *
 * @since 1.0.0
 */
?>

<?php echo $args['before_widget']; ?>

<?php if ( ! empty( $instance['title'] ) ): ?>
	<?php echo $args['before_title'] . esc_html( $instance['title'] ); ?>
    <a class="sponsor-panels-widget-link" href="<?php echo home_url( 'njifma-affiliates-category/sponsor' ); ?>">view
        all sponsors</a>
	<?php echo $args['after_title']; ?>
<?php endif; ?>

<div class="sponsor-panels-container">
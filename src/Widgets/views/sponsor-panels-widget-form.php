<?php
/**
 * sponsor-panels-widget-form.php
 *
 * HTML for the custom news widget news item.
 *
 * @since 1.0.0
 */
?>

<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title: ', 'ic-custom-entries' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
	       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
	       value="<?php echo esc_attr( $instance['title'] ); ?>">
</p>
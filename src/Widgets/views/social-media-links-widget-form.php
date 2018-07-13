<?php
/**
 * social-media-links-widget-form.php
 *
 * HTML for the social media widget admin form.
 *
 * @since 1.0.0
 */
?>

<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title: (Does not appear on widget. Admin only.) ', 'ic-custom-entries' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
           name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
           value="<?php echo esc_attr( $instance['title'] ); ?>">
</p>

<p>
    <label for="<?php echo $this->get_field_id( 'open_in_new_window' ); ?>"><?php _e( 'Check to open links in a new window: ', 'ic-custom-entries' ); ?></label><br/>
    <input class="checkbox" type="checkbox" <?php checked( true, $instance['open_in_new_window'] ); ?>
           id="<?php echo $this->get_field_id( 'open_in_new_window' ); ?>"
           name="<?php echo $this->get_field_name( 'open_in_new_window' ); ?>">
</p>
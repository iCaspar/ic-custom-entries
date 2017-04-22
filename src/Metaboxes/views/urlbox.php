<?php
/**
 * urlbox.php
 *
 * HTML for a url custom metabox.
 *
 * @since 1.0.0
 */
?>
<input class="widefat" type="url"
       name="<?php echo $this->meta_key; ?>" id="<?php echo $this->meta_key; ?>"
       value="<?php echo esc_url( $stored ); ?>"/>
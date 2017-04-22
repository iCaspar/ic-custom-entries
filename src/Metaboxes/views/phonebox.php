<?php
/**
 * phonebox.php
 *
 * HTML for a phone custom metabox.
 *
 * @since 1.0.0
 */
?>
<input class="widefat" type="tel"
       name="<?php echo $this->meta_key; ?>" id="<?php echo $this->meta_key; ?>"
       value="<?php echo esc_html( $stored ); ?>"/>
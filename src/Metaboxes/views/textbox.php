<?php
/**
 * textbox.php
 *
 * HTML for a text custom metabox.
 *
 * @since 1.0.0
 */
?>
<input class="widefat" type="text"
       name="<?php echo $this->meta_key; ?>" id="<?php echo $this->meta_key; ?>"
       value="<?php echo esc_html( $stored ); ?>"/>
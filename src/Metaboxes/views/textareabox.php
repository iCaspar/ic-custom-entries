<?php
/**
 * textareabox.php
 *
 * HTML for a text area custom metabox.
 *
 * @since 1.0.0
 */
?>
<textarea name="<?php echo $this->meta_key; ?>" id="<?php echo $this->meta_key; ?>"
          rows="3" cols="50"><?php echo esc_html( $stored ); ?></textarea>
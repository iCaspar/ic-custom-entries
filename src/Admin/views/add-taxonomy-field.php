<?php
/**
 * HTML for taxonomy input on add taxonomy pages.
 *
 * @since 1.0.0
 */
?>

<div class="form-field">
    <label for="taxonomy_image"><?php _e( 'Image', 'ic-custom-entries' ); ?></label>
    <img class="taxonomy-image" src="<?php echo esc_url( $image_url ); ?>"/><br/>
    <input type="text" name="taxonomy_image" class="taxonomy-image-field" value=""/>
    <br/>
    <button class="upload_taxonomy_image_button button button-primary"><?php _e( 'Upload/Add image', 'ic-custom-entries' ); ?></button>
    <button class="remove_taxonomy_image_button button button-secondary"><?php _e( 'Remove image', 'ic-custom-entries' ); ?></button>
</div>
<?php
/**
 * HTML for taxonomy input on edit taxonomy pages.
 *
 * @since 1.0.0
 */
?>
<tr class="form-field">
    <th scope="row" valign="top"><label for="taxonomy_image"><?php _e( 'Image', 'ic-custom-entries' ); ?></label></th>
    <td>
        <img class="taxonomy-image" src="<?php echo esc_url($image_url); ?>"/><br/>
        <input type="text" name="taxonomy_image" class="taxonomy-image-field" value="<?php echo esc_url( $field_url ); ?>"/><br/>
        <button class="upload_taxonomy_image_button button button-primary"><?php _e( 'Upload/Add image', 'ic-custom-entries' ); ?></button>
        <button class="remove_taxonomy_image_button button button-secondary"><?php _e( 'Remove image', 'ic-custom-entries' ); ?></button>
    </td>
</tr>
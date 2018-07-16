;(function ($, window, document) {

    'use strict';

    const upload_button = $('.upload_taxonomy_image_button');
    const upload_remove_button = $('.remove_taxonomy_image_button');
    const inline_edit_field = $('.editinline');
    const tax_image_placeholder = tax_img_data.tax_placeholder_url;

    function init() {
        upload_button.click(function (event) {
            event.preventDefault();
            let frame;

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media();
            frame.on('select', function () {
                let attachment = frame.state().get('selection').first();
                frame.close();

                if (upload_button.parent().prev().children().hasClass('tax_list')) {
                    upload_button.parent().prev().children().val(attachment.attributes.url);
                    upload_button.parent().prev().prev().children().attr('src', attachment.attributes.url);
                }
                else {
                    $('.taxonomy-image-field').val(attachment.attributes.url);
                    $('.taxonomy-image').attr('src', attachment.attributes.url);
                }
            });

            frame.open();
        });

        upload_remove_button.click(function (event) {
            event.preventDefault();
            $('.taxonomy-image').attr('src', tax_image_placeholder);
            $('.taxonomy-image-field').val('');
            $(this).parent().siblings('.title').children('img').attr('src', tax_image_placeholder);
            $('.inline-edit-col :input[name="taxonomy_image"]').val('');
            return false;
        });


        inline_edit_field.click(function () {
            let tax_id = $(this).parents('tr').attr('id').substr(4),
                thumb = $('#tag-' + tax_id + ' .thumb img').attr('src');

            if (thumb !== tax_image_placeholder) {
                $('.inline-edit-col :input[name="taxonomy_image"]').val(thumb);
            } else {
                $('.inline-edit-col :input[name="taxonomy_image"]').val('');
            }

            $('.inline-edit-col .title img').attr('src', thumb);
        });
    }

    $(document).ready(function () {
        init();
    });

})(jQuery, window, document);

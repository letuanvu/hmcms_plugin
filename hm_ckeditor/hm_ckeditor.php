<?php
/*
Plugin Name: CKEditor;
Description: Thay thế bộ soạn thảo thành CKEditor;
Version: 1.0;
Version Number: 1;
*/

/** dùng hook filter thay class của ckeditor vào textarea */

register_filter('input_editor_input', 'change_ckeditor_class');

function change_ckeditor_class($field_array)
{

    $field_array['addClass'] = 'ckeditor';
    return $field_array;

}

/** dùng hook action thêm js vào đầu trang admin cp */

register_action('hm_admin_head', 'add_ckeditor_js');

function add_ckeditor_js()
{

    ?>
    <!-- CKEditor Plugin -->
    <script type="text/javascript" src="<?php echo PLUGIN_URI; ?>hm_ckeditor/ckeditor/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.use_media_file_insert', function () {
                var file_id = $('#file_id').val();
                var file_src = $('#file_src').val();
                var use_media_file = $(this).attr('use_media_file');
                var img = '';
                img = '<img src="' + file_src + '" />';
                CKEDITOR.instances[use_media_file].insertHtml(img);
            });
            $(document).on('click', 'button[type=submit]', function () {
                for (instance in CKEDITOR.instances)
                    CKEDITOR.instances[instance].updateElement();
            });
        });
    </script>
    <!-- END CKEditor Plugin -->
    <?php

}

?>
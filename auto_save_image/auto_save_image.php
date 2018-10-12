<?php
/*
Plugin Name: Lưu ảnh tự động;
Description: Tự động tải các ảnh trong nội dung bài về thư viện;
Version: 1.0;
Version Number: 1;
*/

/** tạo thư mục save ảnh */
$args = [
    'group_name' => 'Auto Save',
    'group_parent' => 0,
];
if (!isset_media_group($args)) {

    $group_data = add_media_group($args);
    $group_data = json_decode($group_data, true);
    $group_id = $group_data['id'];

    $args = [
        'section' => 'auto_save_image',
        'key' => 'auto_save_dir_id',
        'value' => $group_id,
    ];
    set_option($args);

} else {

    $group_id = 0;

    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $group_name = $args['group_name'];
    $group_parent = $args['group_parent'];
    $folder = sanitize_title($group_name);

    $tableName = DB_PREFIX . 'media_groups';
    $whereArray = ['folder' => MySQL::SQLValue($folder), 'parent' => MySQL::SQLValue(0, MySQL::SQLVALUE_NUMBER)];
    $hmdb->SelectRows($tableName, $whereArray);

    $num_rows = $hmdb->RowCount();
    if ($num_rows != 0) {
        $row = $hmdb->Row();
        $group_id = $row->id;
    }

    $args = [
        'section' => 'auto_save_image',
        'key' => 'auto_save_dir_id',
        'value' => $group_id,
    ];
    set_option($args);

}


register_filter('content_ajax_add_input_post', 'save_images');
function save_images($input_post)
{

    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $folder = 'auto-save';

    foreach ($input_post as $post_key => $post_val) {

        $dom = new domDocument;
        @$dom->loadHTML($post_val);
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
            $image_src = $image->getAttribute('src');
            $parse = parse_url($image_src);
            $image_src_host = $parse['host'];
            $file_name = basename($image_src);

            if ($image_src_host != $_SERVER['SERVER_NAME']) {

                if (!file_exists(BASEPATH . HM_CONTENT_DIR . '/uploads/' . $folder . '/tmp/')) {
                    mkdir(BASEPATH . HM_CONTENT_DIR . '/uploads/' . $folder . '/tmp/', 0777);
                }

                $dir_dest = BASEPATH . HM_CONTENT_DIR . '/uploads/' . $folder;
                $saved_file = BASEPATH . HM_CONTENT_DIR . '/uploads/' . $folder . '/tmp/' . $file_name;

                $ch = curl_init($image_src);
                $fp = fopen($saved_file, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);

                /** upload file */
                if (file_exists($saved_file)) {

                    $content = [];
                    $handle = new Upload($saved_file, LANG);

                    if ($handle->uploaded) {
                        $handle->Process($dir_dest);
                        if ($handle->processed) {

                            /** upload thành công, lưu database thông số file */
                            $file_is_image = 'false';
                            $file_info = [];

                            $file_info['file_src_name'] = $handle->file_src_name;
                            $file_info['file_src_name_body'] = $handle->file_src_name_body;
                            $file_info['file_src_name_ext'] = $handle->file_src_name_ext;
                            $file_info['file_src_mime'] = $handle->file_src_mime;
                            $file_info['file_src_size'] = $handle->file_src_size;
                            $file_info['file_dst_name'] = $handle->file_dst_name;
                            $file_info['file_dst_name_body'] = $handle->file_dst_name_body;
                            $file_info['file_dst_name_ext'] = $handle->file_dst_name_ext;

                            $file_info['file_is_image'] = $handle->file_is_image;

                            $file_name = $file_info['file_src_name'];

                            if ($file_info['file_is_image'] == true) {

                                $file_is_image = 'true';
                                $file_info['image_src_x'] = $handle->image_src_x;
                                $file_info['image_src_y'] = $handle->image_src_y;
                                $file_info['image_src_bits'] = $handle->image_src_bits;
                                $file_info['image_src_pixels'] = $handle->image_src_pixels;
                                $file_info['image_src_type'] = $handle->image_src_type;
                                $file_info['image_dst_x'] = $handle->image_dst_x;
                                $file_info['image_dst_y'] = $handle->image_dst_y;
                                $file_info['image_dst_type'] = $handle->image_dst_type;

                                $handle->image_resize = true;
                                $handle->image_ratio_crop = true;
                                $handle->image_y = 512;
                                $handle->image_x = 512;
                                $handle->Process($dir_dest);
                                $file_info['thumbnail'] = $handle->file_dst_name;

                            }

                            $file_info = hm_json_encode($file_info);
                            $tableName = DB_PREFIX . 'media';

                            $media_group = get_option(['section' => 'auto_save_image', 'key' => 'auto_save_dir_id']);

                            $values["media_group_id"] = MySQL::SQLValue($media_group, MySQL::SQLVALUE_NUMBER);
                            $values["file_info"] = MySQL::SQLValue($file_info);
                            $values["file_name"] = MySQL::SQLValue($file_name);
                            $values["file_folder"] = MySQL::SQLValue($folder);
                            $values["file_is_image"] = MySQL::SQLValue($file_is_image);
                            $insert_id = $hmdb->InsertRow($tableName, $values);

                            unset($values);

                            /** replace link ảnh ngoài thành link ảnh đã upload */
                            $image_src_seved = get_file_url($insert_id);
                            $post_val = str_replace($image_src, $image_src_seved, $post_val);
                            $input_post[$post_key] = $post_val;

                            $status = 'success';
                            $content[] = $insert_id;

                        } else {
                            $status = 'error';
                            $content[] = $file_name . ' : ' . $handle->error;
                        }
                    } else {
                        $status = 'error';
                        $content[] = $file_name . ' : ' . $handle->error;
                    }

                }

                /** xóa file tmp */
                unlink($saved_file);

            }
        }

    }
    return $input_post;
}


?>
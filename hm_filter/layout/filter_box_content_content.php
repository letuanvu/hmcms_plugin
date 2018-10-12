<div class="row">
    <div class="ajax_filter_content">
        <?php
        $action = hm_get('action');
        if ($action == 'edit') {
            $id = hm_get('id');
            $data = content_data_by_id($id);
            $data_content = $data['content'];
            $key = $data_content->key;
        } else {
            $key = hm_get('key');
        }
        ajaxfilter_filter_content($key);
        ?>
    </div>
</div>

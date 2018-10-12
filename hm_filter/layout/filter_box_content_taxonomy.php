<div class="row">
    <div class="ajax_filter_content">
        <?php
        $action = hm_get('action');
        $id = hm_get('id');
        if ($action == 'edit') {
            $taxonomy = get_con_val(['name' => 'taxonomy', 'id' => $id]);
            $taxonomy = json_decode($taxonomy, true);
            if (is_array($taxonomy)) {
                foreach ($taxonomy as $taxonomy_id) {
                    ajaxfilter_filter_content($taxonomy_id);
                }
            }
        }
        ?>
    </div>
</div>

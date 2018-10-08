<?php
/** connect db */
$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

/** asset */
register_action('after_hm_head', 'hm_comment_asset');
function hm_comment_asset()
{
    echo '<script src="' . PLUGIN_URI . 'hm_comment/asset/hm_comment.js"></script>';
    echo '<link href="' . PLUGIN_URI . 'hm_comment/asset/hm_comment.css" rel="stylesheet" type="text/css" />';
}

/** add comment url */
register_request('add_comment', 'add_comment', ['name' => 'add_comment', 'menu' => false]);
function add_comment()
{
    global $hmdb;
    $object_id = intval(hm_post('object_id'));
    $parent_id = intval(hm_post('parent_id'));
    $vote_value = intval(hm_post('vote_value', 5));
    $object_type = hm_post('object_type', 'content');
    $user_role = 0;
    if (is_admin_login()) {
        $user_role = $_SESSION['admin_user']['user_role'];
    }

    $default_status = get_option([
        'section' => 'hm_comment',
        'key' => 'default_status',
        'default_value' => 'pending'
    ]);
    $tableName = DB_PREFIX . "comment";
    $values = [
        'object_id' => MySQL::SQLValue($object_id, MySQL::SQLVALUE_NUMBER),
        'object_type' => MySQL::SQLValue($object_type),
        'parent_id' => MySQL::SQLValue($parent_id, MySQL::SQLVALUE_NUMBER),
        'status' => MySQL::SQLValue($default_status),
        'vote_value' => MySQL::SQLValue($vote_value),
        'like' => MySQL::SQLValue(0, MySQL::SQLVALUE_NUMBER),
        'un_like' => MySQL::SQLValue(0, MySQL::SQLVALUE_NUMBER),
        'created' => MySQL::SQLValue(time(), MySQL::SQLVALUE_NUMBER),
        'user_role' => MySQL::SQLValue($user_role),
        'updated' => MySQL::SQLValue(time(), MySQL::SQLVALUE_NUMBER),
    ];
    $comment_id = $hmdb->InsertRow($tableName, $values);
    if (is_numeric($comment_id)) {
        $input_post = $_POST;
        unset($input_post['object_id']);
        unset($input_post['parent_id']);
        foreach ($input_post as $post_key => $post_val) {
            if (is_array($post_val)) {
                $post_val = hm_json_encode($post_val);
            }
            $tableName = DB_PREFIX . 'field';
            $values = [
                'name' => MySQL::SQLValue($post_key),
                'val' => MySQL::SQLValue($post_val),
                'object_id' => MySQL::SQLValue($comment_id, MySQL::SQLVALUE_NUMBER),
                'object_type' => MySQL::SQLValue('comment'),
            ];
            $hmdb->InsertRow($tableName, $values);
        }
        switch ($default_status) {
            case 'public':
                $message = get_option(['section' => 'hm_comment', 'key' => 'public_comment_submit_noti']);
                break;
            case 'hidden':
                $message = get_option(['section' => 'hm_comment', 'key' => 'hidden_comment_submit_noti']);
                break;
            default:
                $message = '';
        }
        $return_mes = [
            'status' => 'success',
            'message' => $message
        ];
    } else {
        $return_mes = [
            'status' => 'error',
            'message' => get_option(['section' => 'hm_comment', 'key' => 'error_comment_submit_noti']),
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($return_mes);
}

/** load comment url */
register_request('load_comment', 'load_comment', ['name' => 'load_comment', 'menu' => false]);
function load_comment()
{
    $data = load_comment_sub(0);
    header('Content-Type: application/json');
    echo json_encode($data);
}

function load_comment_sub($parent_id = 0)
{
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $object_id = hm_get('object_id');
    $page = hm_get('page');
    $data = [];
    $tableName = DB_PREFIX . "comment";
    $sql = "SELECT * FROM " . $tableName . " WHERE `status` = 'public' AND `parent_id` = " . $parent_id . " AND `object_id` = '" . $object_id . "' ORDER BY `created` DESC";
    $hmdb->Query($sql);
    if ($hmdb->HasRecords()) {
        while ($row = $hmdb->RowArray()) {
            $cmt_fields = get_comment_fields($row['id']);
            $this_cmt_field = [];
            foreach ($cmt_fields as $cmt_field) {
                $this_cmt_field[$cmt_field->name] = $cmt_field->val;
            }
            $row['created'] = date(DATETIME_FORMAT, $row['created']);
            $row['updated'] = date(DATETIME_FORMAT, $row['updated']);
            if ($row['user_role'] != 0) {
                $row['user_role_label'] = 'Quản trị viên';
            }
            $row['vote_value_html'] = '';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $row['vote_value']) {
                    $class = "start_vote start_vote_gold";
                } else {
                    $class = "start_vote start_vote_gray";
                }
                $row['vote_value_html'] = $row['vote_value_html'] . '<span class="' . $class . '"></span>';
            }
            $data[] = [
                'comment' => $row,
                'comment_fields' => $this_cmt_field,
                'comment_sub' => load_comment_sub($row['id'])
            ];
        }
    }
    return $data;
}


/** display comment form */
function comment_form()
{
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_comment/layout/comment_form.php');
}

/** display comment list */
function comment_list()
{
    hm_include(BASEPATH . '/' . HM_PLUGIN_DIR . '/hm_comment/layout/comment_list.php');
}

/** content rate ratio */
function get_content_cmt_rate($object_id, $round = true)
{
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $hmdb->table(DB_PREFIX . "comment");
    $hmdb->where(['status' => 'public', 'object_id' => $object_id]);
    $total_vote = $hmdb->count();

    $hmdb->table(DB_PREFIX . "comment");
    $hmdb->where(['status' => 'public', 'object_id' => $object_id]);
    $hmdb->column('vote_value');
    $sum = $hmdb->sum();
    if ($round == true) {
        $ratio = round($sum / $total_vote);
    } else {
        $ratio = $sum / $total_vote;
    }
    return $ratio;
}

/** content rate count */
function get_cmts($object_id)
{
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $hmdb->table(DB_PREFIX . "comment");
    $hmdb->where(['status' => 'public', 'object_id' => $object_id]);
    $rows = $hmdb->select();
    $result = ['5' => 0, '4' => 0, '3' => 0, '2' => 0, '1' => 0];
    foreach ($rows as $row) {
        $vote_value = $row->vote_value;
        $result[$vote_value] = $result[$vote_value] + 1;
    }
    return $result;
}

/** content rate count */
function get_cmt_count($object_id)
{
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $hmdb->table(DB_PREFIX . "comment");
    $hmdb->where(['status' => 'public', 'object_id' => $object_id]);
    $total_vote = $hmdb->count();
    return $total_vote;
}

?>

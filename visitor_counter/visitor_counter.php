<?php
/*
Plugin Name: Bộ đếm truy cập;
Description: Tạo bộ đếm truy cập cho website;
Version: 1.0;
Version Number: 1;
*/


register_action('load_theme', 'visitor_counter_log');
function visitor_counter_log()
{
    /** Lưu session */
    $ip = hm_ip();
    $time = time();
    $agent = hm_agent();
    $session_id = session_id();
    $hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);
    $minute = date('i', $time);

    if (!isset($_SESSION['visitor_counter'][$session_id . '_' . $minute])) {

        $_SESSION['visitor_counter'][$session_id . '_' . $minute] = $time;

        $allow = ['minute', 'hour', 'day', 'month', 'year', 'total'];
        foreach ($allow as $time_log) {

            switch ($time_log) {
                case 'minute':
                    $key = date('i', $time);
                    break;
                case 'hour':
                    $key = date('H', $time);
                    break;
                case 'day':
                    $key = date('d', $time);
                    break;
                case 'month':
                    $key = date('m', $time);
                    break;
                case 'year':
                    $key = date('Y', $time);
                    break;
                case 'total':
                    $key = 'total';
                    break;
            }

            $args = [
                'section' => 'visitor_counter_' . $time_log,
                'key' => $key,
                'default_value' => '0',
            ];
            $val = get_option($args);
            if (!is_numeric($val)) {
                $val = 0;
            }
            $newval = $val + 1;
            $args = [
                'section' => 'visitor_counter_' . $time_log,
                'key' => $key,
                'value' => $newval,
            ];
            set_option($args);
            if (is_numeric($key) AND $key > 0) {
                $tableName = DB_PREFIX . 'option';
                $hmdb->Query("DELETE FROM `" . $tableName . "` WHERE `section` = 'visitor_counter_" . $time_log . "' AND `key` < " . $key);
            }

        }

    }
}


function vc_online()
{
    $time = time();
    $key = date('i', $time);
    $args = [
        'section' => 'visitor_counter_minute',
        'key' => $key,
        'default_value' => '0',
    ];
    $val = get_option($args);
    if (!is_numeric($val)) {
        $val = 0;
    }
    return $val;
}

function vc_visitor($time_log)
{
    $time = time();
    $allow = ['minute', 'hour', 'day', 'month', 'year', 'total'];
    if (in_array($time_log, $allow)) {

        switch ($time_log) {
            case 'minute':
                $key = date('i', $time);
                break;
            case 'hour':
                $key = date('H', $time);
                break;
            case 'day':
                $key = date('d', $time);
                break;
            case 'month':
                $key = date('m', $time);
                break;
            case 'year':
                $key = date('Y', $time);
                break;
            case 'total':
                $key = 'total';
                break;
        }

        $args = [
            'section' => 'visitor_counter_' . $time_log,
            'key' => $key,
            'default_value' => '0',
        ];
        $val = get_option($args);
        if (!is_numeric($val)) {
            $val = 0;
        }
        return $val;
    } else {
        return null;
    }
}

/** Tạo block bộ đếm cơ bản */
function BlockVisitorCounter($block_id)
{
    $block_name = get_blo_val(['name' => 'block_name', 'id' => $block_id]);
    echo '<div class="box">
				<div class="box_title">
					' . $block_name . '
				</div>
				<div class="box_content">
					<ul class="web_counter">
						<li><span>Số người online:</span> ' . vc_online() . '</li>
						<li><span>Truy cập trong hôm nay:</span> ' . vc_visitor('day') . '</li>
						<li><span>Truy cập trong tháng này:</span> ' . vc_visitor('month') . '</li>
						<li><span>Truy cập trong năm nay:</span> ' . vc_visitor('year') . '</li>
						<li><span>Tổng số lượt truy cập:</span> ' . vc_visitor('total') . '</li>
					</ul>
				</div>
			</div>';
}

function BlockVisitorCounterRename($block_id)
{
    $block_name = get_blo_val(['name' => 'block_name', 'id' => $block_id]);
    if ($block_name != '') {
        return $block_name;
    } else {
        return 'Thống kê';
    }
}

$args = [
    'name' => 'BlockVisitorCounter',
    'nice_name' => _('Thống kê truy cập'),
    'input' => [
        [
            'nice_name' => 'Tên khối',
            'name' => 'block_name',
            'input_type' => 'text',
            'required' => true,
        ],
    ],
    'function' => 'BlockVisitorCounter',
    'box_val_name' => 'BlockVisitorCounterRename',
];
register_block($args); 

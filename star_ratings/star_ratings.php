<?php
/*
Plugin Name: Star ratings;
Description: Tạo bộ bình chọn bằng ngôi sao trên web;
Version: 1.0;
Version Number: 1;
*/


function star_ratings()
{
    $id = get_id();
    if (is_content()) {
        $name = get_primary_con_val($id);
        $option = 'content_' . $id;
    } else if (is_taxonomy()) {
        $name = get_primary_tax_val($id);
        $option = 'taxonomy_' . $id;
    }
    $total_vote = get_option([
        'section' => 'star_ratings',
        'default_value' => 0,
        'key' => $option . '_total',
    ]);
    $number_vote = get_option([
        'section' => 'star_ratings',
        'default_value' => 0,
        'key' => $option . '_number',
    ]);
    hm_include(
        BASEPATH . HM_PLUGIN_DIR . '/star_ratings/layout/star.php',
        [
            'id' => $id,
            'name' => $name,
            'option' => $option,
            'total_vote' => $total_vote,
            'number_vote' => $number_vote,
        ]
    );
}


register_action('before_hm_footer', 'star_ratings_display_asset');
function star_ratings_display_asset()
{
    echo '<!-- Plugin Star ratings -->' . "\n\r";
    echo '<link rel="stylesheet" type="text/css" href="' . BASE_URL . HM_PLUGIN_DIR . '/star_ratings/asset/star.css">' . "\n\r";
    echo '<script>var star_ratings_base = "' . BASE_URL . '";</script>' . "\n\r";
    echo '<script src="' . BASE_URL . HM_PLUGIN_DIR . '/star_ratings/asset/star.js" charset="UTF-8"></script>' . "\n\r";
}


/** Tạo trang ajax lưu vote */
register_request('hm_star_ratings_ajax', 'hm_star_ratings_ajax', ['name' => 'Star Ratings Ajax', 'menu' => false]);
function hm_star_ratings_ajax()
{
    $vote = hm_post('vote');
    $option = hm_post('option');
    $id = hm_post('id');
    $name = hm_post('name');

    if (!isset($_SESSION['star_ratings'][$option])) {

        $total_vote = get_option([
            'section' => 'star_ratings',
            'default_value' => 0,
            'key' => $option . '_total',
        ]);

        $number_vote = get_option([
            'section' => 'star_ratings',
            'default_value' => 0,
            'key' => $option . '_number',
        ]);

        if (is_numeric($vote)) {
            set_option([
                'section' => 'star_ratings',
                'value' => ($total_vote + $vote),
                'key' => $option . '_total',
            ]);

            set_option([
                'section' => 'star_ratings',
                'value' => ($number_vote + 1),
                'key' => $option . '_number',
            ]);
        }

        $_SESSION['star_ratings'][$option] = ($total_vote + $vote) / ($number_vote + 1);

        hm_include(
            BASEPATH . HM_PLUGIN_DIR . '/star_ratings/layout/star.php',
            [
                'id' => $id,
                'name' => $name,
                'option' => $option,
                'total_vote' => ($total_vote + $vote),
                'number_vote' => ($number_vote + 1),
            ]
        );

    } else {
        echo 1;
        exit();
    }

}


?>

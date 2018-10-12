<?php
header("Content-Type: text/plain");
echo get_option(['section' => 'hm_seo', 'key' => 'robots', 'default_value' => '']);
?>
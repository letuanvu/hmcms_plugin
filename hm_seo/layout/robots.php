<?php
header("Content-Type: text/plain");
echo get_option(array('section'=>'hm_seo','key'=>'robots','default_value'=>''));
?>
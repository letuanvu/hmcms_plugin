<?php
$cache_dir = BASEPATH . HM_CONTENT_DIR . '/uploads/simple_cache';
$dh = opendir($cache_dir);
while (false !== ($filename = readdir($dh))) {
    if (
        $filename != 'index.html' AND
        $filename != '.htaccess' AND
        $filename != '.' AND
        $filename != '..'
    ) {
        unlink($cache_dir . '/' . $filename);
        echo '<p>Remove: ' . $filename . '</p>';
    }
}
?>
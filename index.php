<?php

namespace Admin_Ajax;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

if (!class_exists('\Admin_Ajax\No_Thank_You')) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-success is-dismissible">
        <p>admin-ajax.php, no thank you! is missing autoload files</p>
    </div>';
    });
}

new No_Thank_You;

if (is_admin()) {
    new Admin;
}

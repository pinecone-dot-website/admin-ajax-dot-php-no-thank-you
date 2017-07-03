<?php

namespace Admin_Ajax;

if (!function_exists('Admin_Ajax\version')) {
    require __DIR__.'/autoload.php';
}
    
new No_Thank_You;

if (is_admin()) {
    new Admin;
}

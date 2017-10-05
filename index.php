<?php

namespace Admin_Ajax;

if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require __DIR__.'/vendor/autoload.php';
}
    
new No_Thank_You;

if (is_admin()) {
    new Admin;
}

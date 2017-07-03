<?php

namespace Admin_Ajax;

/**
*   PSR-4
*   @todo detect if composer autoload is being used
*   @param string
*/
function autoload($class)
{
    if (strpos($class, __NAMESPACE__) !== 0) {
        return;
    }
  
    $file = __DIR__ .'/lib/'. str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
}
spl_autoload_register( __NAMESPACE__.'\autoload' );

require_once __DIR__.'/functions.php';

new No_Thank_You;

if (is_admin()) {
    new Admin;
}

/**
*
*/
function wp_ajax_test()
{
    $response = array(
        'post' => $_POST
    );

    wp_send_json( $response );
}
add_action( 'wp_ajax_admin-ajax-test', __NAMESPACE__.'\wp_ajax_test' );

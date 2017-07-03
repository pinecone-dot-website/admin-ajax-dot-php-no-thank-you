<?php

namespace Admin_Ajax;

/**
*   render a page into wherever
*   @param string
*   @param object|array
*/
function render($_template, $vars = array())
{
    $_template_file = sprintf( '%s/views/%s.php', __DIR__, $_template );
    
    if (!file_exists($_template_file)) {
        return "<div>template missing: $_template</div>";
    }
        
    extract( (array) $vars, EXTR_SKIP );
    
    ob_start();
    require $_template_file;
    $html = ob_get_contents();
    ob_end_clean();
    
    return $html;
}

/**
*
*   @return string
*/
function version()
{
    $data = get_plugin_data( __DIR__.'/_plugin.php' );
    return $data['Version'];
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
//add_action( 'wp_ajax_nopriv_admin-ajax-test', __NAMESPACE__.'\wp_ajax_test' );

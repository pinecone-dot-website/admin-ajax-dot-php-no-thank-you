<?php

namespace Admin_Ajax_No_Thank_You;

/**
*
*/
function rest_api_init()
{
    register_rest_route( 'wp/v2', '/admin-ajax', array(
        'methods' => 'GET',
        'callback' => __NAMESPACE__.'\rest_api_callback',
    ) );
}
add_action( 'rest_api_init', __NAMESPACE__.'\rest_api_init' );

/**
*
*/
function rest_api_callback()
{
    require ABSPATH.'/wp-admin/admin-ajax.php';
    exit();
}

/**
*   attached to `admin_url` filter
*   replace /wp-admin/admin-ajax.php with /ajax/
*   @param string
*   @param string
*   @param int
*   @return string
*/
function rewrite_ajax_admin_url($url, $path, $blog_id)
{
    if ($path == 'admin-ajax.php') {
        $url = get_site_url( $blog_id, '/ajax/' );
    }

    return $url;
}
add_filter( 'admin_url', __NAMESPACE__.'\rewrite_ajax_admin_url', 10, 3 );

/**
*   attached to `pre_get_posts` for request to /ajax/ to be intercepted and include admin-ajax.php
*   @param WP_Query
*   @return WP_Query
*/
function rewrite_ajax_pre_get_posts($wp_query)
{
    if ($wp_query->is_main_query() && $wp_query->get('admin_ajax_no_thank_you')) {
        require ABSPATH.'/wp-admin/admin-ajax.php';
        exit();
    }

    return $wp_query;
}
add_filter( 'pre_get_posts', __NAMESPACE__.'\rewrite_ajax_pre_get_posts', 1, 1 );

/**
*   attached to `query_vars` filter to register `admin_ajax_no_thank_you`
*   @param array
*   @return array
*/
function rewrite_ajax_query_vars($qv)
{
    array_push( $qv, 'admin_ajax_no_thank_you' );

    return $qv;
}
add_filter( 'query_vars', __NAMESPACE__.'\rewrite_ajax_query_vars', 10, 1 );

/**
*   attatched to `root_rewrite_rules` to register rewrite rule for /ajax/
*   @param array
*   @return array
*/
function rewrite_ajax_root_rewrite_rules($rules)
{
    $rules['ajax/?$'] = 'index.php?&admin_ajax_no_thank_you=1';

    return $rules;
}
add_filter( 'root_rewrite_rules', __NAMESPACE__.'\rewrite_ajax_root_rewrite_rules', 10, 1 );

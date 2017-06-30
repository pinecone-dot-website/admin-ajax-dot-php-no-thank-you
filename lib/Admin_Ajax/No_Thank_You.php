<?php

namespace Admin_Ajax;

class No_Thank_You{
    public function __construct(){
        add_filter( 'admin_url', array($this, 'rewrite_ajax_admin_url'), 10, 3 );
        add_action( 'rest_api_init', array($this, 'rest_api_init') );
        add_filter( 'pre_get_posts', array($this, 'rewrite_ajax_pre_get_posts'), 1, 1 );
        add_filter( 'query_vars', array($this, 'rewrite_ajax_query_vars'), 10, 1 );
        add_filter( 'root_rewrite_rules', array($this, 'rewrite_ajax_root_rewrite_rules'), 10, 1 );
    }

    /**
    *   requires the wp core file and dies
    */
    public function require_admin_ajax()
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
    public function rewrite_ajax_admin_url($url, $path, $blog_id)
    {
        if ($path == 'admin-ajax.php') {
            $url = get_site_url( $blog_id, '/ajax/' );
        }

        return $url;
    }

    /**
    *   attached to `pre_get_posts` for request to /ajax/ to be intercepted and include admin-ajax.php
    *   @param WP_Query
    *   @return WP_Query
    */
    public function rewrite_ajax_pre_get_posts($wp_query)
    {
        if ($wp_query->is_main_query() && $wp_query->get('admin_ajax_no_thank_you')) {
            $this->require_admin_ajax();
        }

        return $wp_query;
    }

    /**
    *   attatched to `root_rewrite_rules` to register rewrite rule for /ajax/
    *   @param array
    *   @return array
    */
    public function rewrite_ajax_root_rewrite_rules($rules)
    {
        $rules['ajax/?$'] = 'index.php?&admin_ajax_no_thank_you=1';

        return $rules;
    }

    /**
    *   attached to `query_vars` filter to register `admin_ajax_no_thank_you`
    *   @param array
    *   @return array
    */
    public function rewrite_ajax_query_vars($qv)
    {
        array_push( $qv, 'admin_ajax_no_thank_you' );

        return $qv;
    }

    /**
    *   @todo check class WP_REST_Server constants for permissions in `methods` argument
    *   https://github.com/WP-API/WP-API/blob/ab446e34462bfb0bbfb593505962a843ded21d29/lib/infrastructure/class-wp-rest-server.php#L17-L34
    */
    public function rest_api_init()
    {
        register_rest_route( 'wp/v2', '/admin-ajax', array(
            'methods' => 'GET, POST',
            'callback' => array($this, 'require_admin_ajax'),
        ) );
    }
    
}

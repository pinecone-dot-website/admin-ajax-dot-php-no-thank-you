<?php

namespace Admin_Ajax;

class No_Thank_You
{
    protected static $settings;

    public function __construct()
    {
        self::load_settings();
        
        add_filter( 'admin_url', array($this, 'rewrite_ajax_admin_url'), 10, 3 );
        add_action( 'rest_api_init', array($this, 'rest_api_init') );
        add_filter( 'pre_get_posts', array($this, 'rewrite_ajax_pre_get_posts'), 1, 1 );
        add_filter( 'query_vars', array($this, 'rewrite_ajax_query_vars'), 10, 1 );
        add_filter( 'root_rewrite_rules', array($this, 'rewrite_ajax_root_rewrite_rules'), 10, 1 );
    }

    /**
    *
    *   @return array
    */
    public static function get_settings()
    {
        return self::$settings;
    }

    /**
    *
    *   @return string
    */
    public static function get_endpoint_rest($blog_id = null)
    {
        return get_rest_url( $blog_id, self::$settings['endpoint']['rest-api'] );
    }

    /**
    *
    *   @return string
    */
    public static function get_endpoint_rewrite($blog_id = null)
    {
        $rewrite = trim( self::$settings['endpoint']['rewrite'] );
        return get_home_url( $blog_id, sprintf('/%s/', $rewrite) );
    }

    /**
    *
    */
    public static function load_settings()
    {
        $defaults = array(
            'default' => '',
            'enabled' => array(),
            'endpoint' => array(
                'rewrite' => 'ajax',
                'rest-api' => 'wp/v2/admin-ajax'
            )
        );

        $settings = get_option( 'admin_ajax_no_thank_you', array() );
        
        self::$settings = array_merge( $defaults, $settings );
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
    *   replace /wp-admin/admin-ajax.php with rewrite
    *   @param string
    *   @param string
    *   @param int
    *   @return string
    */
    public function rewrite_ajax_admin_url($url, $path, $blog_id)
    {
        if ($path != 'admin-ajax.php') {
            return $url;
        }
        
        if ((self::$settings['default'] == 'rest-api') && in_array('rest-api', self::$settings['enabled'])) {
            $url = self::get_endpoint_rest( $blog_id );
        } elseif ((self::$settings['default'] == 'rewrite') && in_array('rewrite', self::$settings['enabled'])) {
            $url = self::get_endpoint_rewrite( $blog_id );
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
    *   attatched to `root_rewrite_rules` to register rewrite rule for /ajax/ or custom
    *   @param array
    *   @return array
    */
    public function rewrite_ajax_root_rewrite_rules($rules)
    {
        $rewrite = trim( self::$settings['endpoint']['rewrite'], '/' );
        
        if ($rewrite && in_array('rewrite', self::$settings['enabled'])) {
            $rules[$rewrite.'/?$'] = 'index.php?&admin_ajax_no_thank_you=1';
        }

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

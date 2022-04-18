<?php

namespace Admin_Ajax;

class No_Thank_You
{
    protected static $settings;

    public function __construct()
    {
        self::load_settings();

        add_filter('admin_url', [$this, 'rewrite_ajax_admin_url'], 10, 3);
        add_action('rest_api_init', [$this, 'rest_api_init']);
        add_filter('pre_get_posts', [$this, 'rewrite_ajax_pre_get_posts'], 1, 1);
        add_filter('query_vars', [$this, 'rewrite_ajax_query_vars'], 10, 1);
        add_filter('root_rewrite_rules', [$this, 'rewrite_ajax_root_rewrite_rules'], 10, 1);

        // testing
        add_action('wp_ajax_admin-ajax-test', [$this, 'wp_ajax_test']);
        //add_action( 'wp_ajax_nopriv_admin-ajax-test', [$this, 'wp_ajax_test'] );
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
        $url = get_rest_url($blog_id, self::$settings['endpoint']['rest-api']);
        $url = add_query_arg([
            '_wpnonce' => wp_create_nonce('wp_rest')
        ], $url);

        return $url;
    }

    /**
     *
     *   @return string
     */
    public static function get_endpoint_rewrite($blog_id = null)
    {
        $rewrite = trim(self::$settings['endpoint']['rewrite']);
        return get_home_url($blog_id, sprintf('/%s/', $rewrite));
    }

    /**
     *
     */
    public static function load_settings()
    {
        $defaults = [
            'default' => '',
            'enabled' => [],
            'endpoint' => [
                'rewrite' => 'ajax',
                'rest-api' => 'wp/v2/admin-ajax'
            ]
        ];

        $settings = get_option('admin_ajax_no_thank_you', []);

        self::$settings = array_merge($defaults, $settings);
    }

    /**
     *   requires the wp core file and dies
     */
    public function require_admin_ajax()
    {
        require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';
        $GLOBALS['current_screen'] = \WP_Screen::get('no-thank-you');

        require ABSPATH . '/wp-admin/admin-ajax.php';
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
        if (\stripos($path, 'admin-ajax.php') !== 0) {
            return $url;
        }

        $parsed = \parse_url($url);

        if ((self::$settings['default'] == 'rest-api') && in_array('rest-api', self::$settings['enabled'])) {
            $url = self::get_endpoint_rest($blog_id);
        } elseif ((self::$settings['default'] == 'rewrite') && in_array('rewrite', self::$settings['enabled'])) {
            $url = self::get_endpoint_rewrite($blog_id);
        }

        if (!empty($parsed['query'])) {
            parse_str($parsed['query'], $query_vars);
            $url = add_query_arg($query_vars, $url);
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
        $rewrite = trim(self::$settings['endpoint']['rewrite'], '/');

        if ($rewrite && in_array('rewrite', self::$settings['enabled'])) {
            $rules[$rewrite . '/?$'] = 'index.php?&admin_ajax_no_thank_you=1';
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
        array_push($qv, 'admin_ajax_no_thank_you');

        return $qv;
    }

    /**
     *   @todo check class WP_REST_Server constants for permissions in `methods` argument
     *   https://github.com/WP-API/WP-API/blob/ab446e34462bfb0bbfb593505962a843ded21d29/lib/infrastructure/class-wp-rest-server.php#L17-L34
     */
    public function rest_api_init()
    {
        $endpoint = array_filter(explode('/', self::$settings['endpoint']['rest-api']));
        if (count($endpoint) < 3) {
            return;
        }

        $namespace = implode('/', array_slice($endpoint, 0, 2));
        $route = implode('/', array_slice($endpoint, 2));

        register_rest_route($namespace, $route, [
            'methods' => 'GET, POST',
            'callback' => [$this, 'require_admin_ajax'],
        ]);
    }

    /**
     *   returns post data in json
     *   used for testing wp-admin/options-general.php?page=admin-ajax.php-no-thank-you
     */
    function wp_ajax_test()
    {
        $response = [
            'post' => $_POST
        ];

        wp_send_json($response);
    }
}

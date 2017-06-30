<?php

namespace Admin_Ajax;

class Admin
{
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_filter( 'plugin_action_links_admin-ajax-dot-php-no-thank-you/_plugin.php', array($this, 'plugin_action_links') );
    }

    /**
    *   setup page and settings
    *   add link to settings page under 'Settings' admin sidebar
    *   attached to `admin_menu` action
    */
    public function admin_menu()
    {
        add_options_page(
            'admin-ajax.php Settings',
            'admin-ajax.php Settings',
            'manage_options',
            'admin-ajax.php-no-thank-you',
            array($this, 'render_main')
        );

        add_settings_section(
            'admin_ajax_no_thank_you_settings_section',
            '',    // subhead
            array($this,'description'),
            'admin_ajax_no_thank_you'
        );

        add_settings_field(
            'admin_ajax_no_thank_you-endpoints',
            'Endpoints',
            array($this, 'render_enabled'),
            'admin_ajax_no_thank_you',
            'admin_ajax_no_thank_you_settings_section'
        );

        register_setting( 'admin_ajax_no_thank_you', 'admin_ajax_no_thank_you', array($this,'save_setting') );
    }

    /**
    *
    *   @param array
    *   @return
    */
    public function description($args)
    {
    }

    /**
    *   add direct link to 'Settings' in plugins table - plugins.php
    *   attached to 'plugin_action_links_dbug/dbug.php' action
    *   @param array
    *   @return array
    */
    public function plugin_action_links($links)
    {
        $settings_link = '<a href="options-general.php?page=admin-ajax.php-no-thank-you">Settings</a>';
        array_unshift( $links, $settings_link );

        return $links;
    }

    /**
    *
    */
    public function render_enabled()
    {
        $settings = No_Thank_You::get_settings();
       
        echo render( 'admin/options-general-enabled', array(
            'endpoints' => array(
                'rest' => No_Thank_You::get_endpoint_rest(),
                'rewrite' => No_Thank_You::get_endpoint_rewrite()
            ),
            'settings' => $settings
        ) );
    }

    /**
    *
    */
    public function render_main()
    {
        wp_enqueue_script( 'taxonomy-taxi', plugins_url('public/admin/options-general.js', dirname(__DIR__)), array(), version(), 'all' );
        echo render( 'admin/options-general' );
    }

    /**
    *
    *   @param array
    *   @return array
    */
    public function save_setting($form_data)
    {
        $form_data['endpoint'] = array_map( function ($val) {
            return trim( $val, '/' );
        }, $form_data['endpoint'] );
        
        //ddbug($form_data);
        
        add_action( 'shutdown', function () {
            No_Thank_You::settings_load();
            flush_rewrite_rules( false );
        } );

        return $form_data;
    }
}

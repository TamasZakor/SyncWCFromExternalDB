<?php
/**
 * @package SyncWCFromExtDB
 */
/*
Plugin Name: Sync WC From Ext DB
Plugin URI: http://example.com/plugin
Description: This plugin help to connecting for external database.
Version: 1.0.0
Author: Thomas "Elabrobyte" Zakor
Author URI: http://example.com
License: GPLv2 or later
Text Domain: sync_wc_from_ext_db-plugin
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.

Copyright 2005-2015 Automatic, Inc.
*/

defined ( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!');

if ( !class_exists( 'SyncWCFromExtDB') ) {

    class SyncWCFromExtDB
    {

        public $plugin;

        function __construct() {
            $this->plugin = plugin_basename(__FILE__);
        }

        function register() {
            // hook custom css on admin side
            add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );

            // hook custom css on fron-end side
            require_once plugin_dir_path(__FILE__) . 'functions/update-stock-ajax.php';
            add_action( 'wp_ajax_sync_wc_from_ext_db_ajax_call', 'sync_wc_from_ext_db_ajax_call');
            add_action( 'wp_ajax_nopriv_sync_wc_from_ext_db_ajax_call', 'sync_wc_from_ext_db_ajax_call' );
            add_action( 'wp_enqueue_scripts', array($this, 'front_end_enqueue') );

            add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
            add_action( 'admin_menu', array( $this, 'add_admin_subpages' ) );

            // Add external db data
            require_once plugin_dir_path(__FILE__) . 'functions/save-ext-db-data.php';
            add_action ( 'admin_post_add_connection_form_submit', 'sync_wc_from_ext_db_page_save_to_db');

            // Update external db data
            require_once plugin_dir_path(__FILE__) . 'functions/update-connection-list-db.php';
            add_action ( 'admin_post_update_active_connection_form_submit', 'sync_wc_from_ext_db_activate_connection_list_db');
            add_action ( 'admin_post_update_connection_form_submit', 'sync_wc_from_ext_db_update_connection_list_db');
            add_action ( 'admin_post_delete_connection_form_submit', 'sync_wc_from_ext_db_delete_connection_list_db');

            //Call product sync on single product page
            require_once plugin_dir_path(__FILE__) . 'functions/update-wc-product-db.php';
            add_action( 'woocommerce_before_single_product', 'sync_wc_from_ext_db_check_requirement', 10, 0 );
            add_action( 'woocommerce_before_cart', 'sync_wc_from_ext_db_check_requirement', 10, 0 );
            add_action( 'woocommerce_before_shop_loop', 'sync_wc_from_ext_db_check_requirement', 10, 0 );
            add_action( 'woocommerce_before_checkout_form_cart_notices', 'sync_wc_from_ext_db_check_requirement', 10, 0 );
            add_action( 'woocommerce_before_checkout_form', 'sync_wc_from_ext_db_check_requirement', 10, 0 );

            // send mail after order product(s)
            require_once plugin_dir_path(__FILE__) . 'functions/send-mail-after-order.php';
            add_action('woocommerce_thankyou', 'sync_wc_from_ext_db_send_mail_after_order');
            // Plugin menu-> settings menulink
            //add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link') );
        }

        /*public function settings_link( $links ) {
            $settings_link = '<a href="options-general.php?page=sync_wc_from_ext_db">Settings</a>';
            array_push( $links, $settings_link );
            return $links;
        }*/

        function activate() {
            require_once plugin_dir_path(__FILE__) . 'inc/sync-wc-from-ext-db-activate.php';
            SyncWCFromExtDBActivate::activate();
        }

        public function add_admin_pages() {
            $page_title = 'Sync WC from Ext DB Plugin';
            $menu_title = 'Sync WC';
            $capability = 'manage_options';
            $menu_slug  = 'sync_wc_from_ext_db';
            $function   = array( $this, 'admin_index');
            $icon_url   = 'dashicons-store';
            $position   = 110;
            add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        }

        public function add_admin_subpages() {
            add_submenu_page('sync_wc_from_ext_db',
                             'Database list',
                             'Database list',
                             'manage_options',
                             'sync_wc_from_ext_db_list',
                              array( $this, 'admin_subpage_index')
                             );
        }

        public function admin_index() {
            require_once plugin_dir_path(__FILE__) . 'templates/sync-wc-from-ext-db-admin.php';
            sync_wc_from_ext_db_page();

        }

        public function admin_subpage_index() {
            require_once plugin_dir_path(__FILE__) . 'functions/edit-connection-db-list.php';
            sync_wc_from_ext_db_connection_list();
        }

        function enqueue() {
            // enqueeu all our scripts
            wp_enqueue_style( 'sync_wc_from_ext_db_admin_style', plugins_url( '/assests/admin-styles.css', __FILE__ ), array(), null, false );
            wp_enqueue_script( 'sync_wc_from_ext_db_admin_script', plugins_url( '/assests/admin-scripts.js', __FILE__ ), array( 'jquery' ), false, false );
        }

        function front_end_enqueue() {
            // enqueeu all our scripts
            wp_enqueue_script( 'frontend-ajax', plugins_url( '/assests/sync_wc_from_ext_db_frontend_script.js', __FILE__ ), array('jquery'), false, false );
            wp_localize_script( 'frontend-ajax', 'sync_wc_from_ext_db_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        }
    }

    if ( class_exists( 'SyncWCFromExtDB' ) ) {
        $SyncWCFromExtDB = new SyncWCFromExtDB();
        $SyncWCFromExtDB->register();
    }

    // activation
    register_activation_hook( __FILE__, array( $SyncWCFromExtDB, 'activate') );

    // deactivation
    require_once plugin_dir_path(__FILE__) . 'inc/sync-wc-from-ext-db-deactivate.php';
    register_deactivation_hook( __FILE__, array( 'SyncWCFromExtDBDeactivate', 'deactivate') );

    // uninstall
    register_uninstall_hook( __FILE__, array( 'SyncWCFromExtDBDeactivate', 'uninstall') );

    require_once plugin_dir_path(__FILE__) . 'functions/create-db.php';
}

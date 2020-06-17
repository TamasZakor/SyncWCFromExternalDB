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
            //add_action( 'wp_enqueue_scripts', array($this, 'enqueue') );

            add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
            add_action( 'admin_menu', array( $this, 'add_admin_subpages' ) );
            
            require_once plugin_dir_path(__FILE__) . 'functions/save-ext-db-data.php';
            add_action ( 'admin_post_custom_form_submit', 'sync_wc_from_ext_db_page_save_to_db');

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
            require_once plugin_dir_path(__FILE__) . 'functions/edit-db-list.php';
            sync_wc_from_ext_db_connection_list();
        }

        function enqueue() {
            // enqueeu all our scripts
            wp_enqueue_style( 'myPluginstyle', plugins_url( '/assests/admin-styles.css', __FILE__ ), false, '1.0.0' );
            wp_enqueue_script( 'myPluginstyle', plugins_url( '/assests/admin-scripts.js', __FILE__ ), false, '1.0.0' );
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

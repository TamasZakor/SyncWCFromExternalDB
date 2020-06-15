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
Text Domain: sync_wc_from_ext_db
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
        public function register() {
            // hook custom css on admin side
            add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );

            // hook custom css on fron-end side
            //add_action( 'wp_enqueue_scripts', array($this, 'enqueue') );
        }

        function activate() {
            require_once plugin_dir_path(__FILE__) . 'inc/sync-wc-from-ext-db-activate.php';
            SyncWCFromExtDBActivate::activate();
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
    register_uninstall_hook( __FILE__, 'uninstall_sync_wc_from_ext_db' );

    require_once plugin_dir_path(__FILE__) . 'functions/create-db.php';
    require_once plugin_dir_path(__FILE__) . 'inc/sync-wc-from-ext-db-admin.php';
}

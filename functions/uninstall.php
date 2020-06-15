<?php
/**
* @package SyncWCFromExtDB
*/

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

function uninstall_sync_wc_from_ext_db() {
    global $wpdb;
    $tablename = $wpdb->prefix . 'externaldbdata';
    $sql = 'DROP TABLE IF EXISTS' . $tablename . ';';
    $wpdb->query($sql);
}

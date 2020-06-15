<?php
/**
* @package SyncWCFromExtDB
*/

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) )  {
    die;
}

global $wpdb;
$tablename = $wpdb->prefix . 'externaldbdata';
$sql = 'DROP TABLE IF EXISTS ' . $tablename . ';';
$wpdb->query($sql);

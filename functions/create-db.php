<?php
/**
* @package SyncWCFromExtDB
*/

global $wpdb;

$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'externalDBdata';

$sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name .'(
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    host varchar(55) NOT NULL,
    username varchar(55) NOT NULL,
    pw varchar(55) NOT NULL,
    table_name varchar(55) NOT NULL,
    PRIMARY KEY (id)
    ) ' . $charset_collate . '; ';

require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta ($sql);
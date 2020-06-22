<?php
/**
* @package SyncWCFromExtDB
*/

global $wpdb;

$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'externalDBdata';

$sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name .'(
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    sql_type varchar(55) NOT NULL,
    host varchar(55) NOT NULL,
    username varchar(55) NOT NULL,
    pw varchar(55) NOT NULL,
    db_name varchar(55) NOT NULL,
    table_name varchar(55) NOT NULL,
    product_column_name varchar(55) NOT NULL,
    product_stock_column_name varchar(55) NOT NULL,
    active varchar(55) DEFAULT "no",
    PRIMARY KEY (id)
    ) ' . $charset_collate . '; ';

require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta ($sql);

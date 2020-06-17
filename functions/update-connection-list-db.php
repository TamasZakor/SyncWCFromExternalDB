<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_update_connection_list_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'externalDBdata';
    $wpdb->update(
        $wpdb->prefix . 'externalDBdata',
        array( 'sql_type' => $_POST['dbtype'],
               'host' => $_POST['dbhost'],
               'username' =>$_POST['dbusername'],
               'pw' => $_POST['dbpassw'],
               'db_name' => $_POST['dbname'],
               'table_name' => $_POST['dbtablename'],
               'product_column_name' => $_POST['dbproductssku'],
               'product_stock_column_name' => $_POST['dbproductsstock']
         ),
        array( 'id' => $_POST['id'] )
    );

    wp_redirect(admin_url('admin.php?page=sync_wc_from_ext_db_list'));
}

function sync_wc_from_ext_db_delete_connection_list_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'externalDBdata';
    $wpdb->delete ( $table_name, array ('id' => $_POST['id'] ) );
    wp_redirect(admin_url('admin.php?page=sync_wc_from_ext_db_list'));
}
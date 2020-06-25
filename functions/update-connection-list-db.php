<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_update_connection_list_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'externaldbdata';
    $wpdb->update(
        $wpdb->prefix . 'externaldbdata',
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
    $table_name = $wpdb->prefix . 'externaldbdata';
    $wpdb->delete ( $table_name, array ('id' => $_POST['id'] ) );
    wp_redirect(admin_url('admin.php?page=sync_wc_from_ext_db_list'));
}

function sync_wc_from_ext_db_activate_connection_list_db() {
    global $wpdb;
    $is_active = $wpdb->get_results( 'SELECT active FROM ' . $wpdb->prefix . 'externalDBdata WHERE id = ' . $_POST['id'] );

    foreach ( $is_active as $row ) {
        var_dump( $row );
        if ( $row->active == "no" ) {
            $wpdb->update( $wpdb->prefix . 'externaldbdata', array( 'active' => 'yes' ), array( 'id' => $_POST['id'] ), array( '%s') );
            $wpdb->query( $wpdb->prepare ('UPDATE ' . $wpdb->prefix . 'externalDBdata' . ' SET active = %s WHERE id NOT LIKE ' . $_POST['id'] , 'no' ) );
        } else if ( $row->active == "yes" ) {
            $wpdb->update( $wpdb->prefix . 'externaldbdata', array( 'active' => 'no' ), array( 'id' => $_POST['id'] ), array( '%s') );
        }
    }
    wp_redirect(admin_url('admin.php?page=sync_wc_from_ext_db_list'));
}
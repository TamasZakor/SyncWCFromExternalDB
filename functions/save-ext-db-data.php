<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_page_save_to_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'externalDBdata';
    $wpdb->insert(
        $table_name,
        array(
            'sql_type' => $_POST['dbtype'],
            'host' => $_POST['dbhost'],
            'username' =>$_POST['dbusername'],
            'pw' => $_POST['dbpassw'],
            'db_name' => $_POST['dbname'],
            'table_name' => $_POST['dbtablename'],
            'product_column_name' => $_POST['dbproductssku'],
            'product_stock_column_name' => $_POST['dbproductsstock']
        )
    );
    
    wp_redirect(admin_url('admin.php?page=sync_wc_from_ext_db'));
}

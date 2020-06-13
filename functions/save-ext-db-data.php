<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_page_save_to_db() {
    global $wpdb;
    print_r($_POST);
    
    $table_name = $wpdb->prefix . 'externalDBdata';
    $wpdb->insert(
        $table_name,
        array(
            'host' => $_POST['dbhost'],
            'username' =>$_POST['dbusername'],
            'pw' => $_POST['dbpassw'],
            'table_name' => $_POST['dbtablename']
        )
    );
    
    print('Update succesful!');
    wp_redirect(admin_url('admin.php?page=sync_wc_from_ext_db'));
}
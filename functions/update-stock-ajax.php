<?php

function sync_wc_from_ext_db_ajax_call() {
    if ( isset($_POST['product_id'] ) ) {
        global $wpdb;
        $result = $wpdb->get_results( 'SELECT stock_quantity FROM ' . $wpdb->prefix . 'wc_product_meta_lookup WHERE product_id =' . intval( $_POST['product_id'] ) );
        echo json_encode($result[0]);
        
    }
    die;
}
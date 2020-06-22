<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_check_requirement() {
if ( class_exists( 'Woocommerce' ) ) {
        sync_wc_from_ext_db_query_product_stock_from_extern_db();
        add_action( 'woocommerce_single_product_summary', 'sync_wc_from_ext_db_shop_display_skus', 11 );
    } else {
        echo 'Woocommerce does not installed!';
        die;
    }
}

function sync_wc_from_ext_db_query_product_stock_from_extern_db() {
    global $wpdb;
    $result = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'externaldbdata WHERE active LIKE "yes"' );
    if ( $result) {
        if ( $result[0]->sql_type == "mysql" ) {
            $conn = mysqli_connect($result[0]->host, $result[0]->username, $result[0]->pw, $result[0]->db_name);
            if ( ! $conn) {
                die("Can't connect to external mysql db!</br>");
            }

            $sql = 'SELECT ' . $result[0]->product_column_name . ', '  . $result[0]->product_stock_column_name . ' FROM ' . $result[0]->table_name .';';
            $query = $conn->query($sql);
            $conn->close();
            if ( $query->num_rows > 0) {
                while ( $row = $query->fetch_assoc() ) {
                    $wpdb->update(
                        $wpdb->prefix . 'wc_product_meta_lookup',
                        array( 'stock_quantity' => $row['product_stock'] ),
                        array( 'sku' => $row['product_sku'] )
                    );
                    $product_id = $wpdb->get_results( 'SELECT post_id FROM ' . $wpdb->prefix . 'postmeta WHERE meta_value = "' . $row['product_sku'] .'";' );
                    $wpdb->update(
                        $wpdb->prefix . 'postmeta',
                        array( 'meta_value' => $row['product_stock'] ),
                        array( 'meta_key' => '_stock' , 'post_id' => $product_id[0]->post_id )
                    );

                }
            } else {
                echo "Could not query any data!";
            }
        } else if ( $result[0]->sql_type == "mssql" ) {
            $servername = $result[0]->host;
            $connectioninfo = array( "Database" =>  $result[0]->db_name, "UID" => $result[0]->username, "PWD" => $result[0]->pw );
            $conn = sqlsrv_connect( $servername, $connectioninfo );
            if ( $conn === false ) {
                die( print_r( sqlsrv_errors(), true ) );
            }

            $sql = 'SELECT ' . $result[0]->product_column_name . ', '  . $result[0]->product_stock_column_name . ' FROM ' . $result[0]->table_name .';';
            $query = sqlsrv_query( $conn, $sql);

            if ( !$query ) {
                echo "Error in statement execution.<br>\n";
                die( print_r( sqlsrv_errors(), true));
            }

            while ( $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_NUMERIC ) ) {
                $wpdb->update(
                    $wpdb->prefix . 'wc_product_meta_lookup',
                    array( 'stock_quantity' => $row[1] ),
                    array( 'sku' => $row[0] )
                );
                $product_id = $wpdb->get_results( 'SELECT post_id FROM ' . $wpdb->prefix . 'postmeta WHERE meta_value = "' . $row[0] .'";' );
                $wpdb->update(
                    $wpdb->prefix . 'postmeta',
                    array( 'meta_value' => $row[1] ),
                    array( 'meta_key' => '_stock' , 'post_id' => $product_id[0]->post_id )
                );
            }
            sqlsrv_free_stmt( $query );
            sqlsrv_close( $conn);
        }
    }
}

function sync_wc_from_ext_db_shop_display_skus() {
    global $product;
    if ( $product->get_stock_quantity() ) { // if manage stock is enabled
        $link = admin_url('admin-ajax.php?action=sync_wc_from_ext_db_ajax_call&product_id='. $product->get_id());
        echo '<a id="refresh_product" data-product_id="' .$product->get_id() . '" href="'. $link . '" style="display:none;"> Update </a>';
    }
}


<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_query_from_extern_db() {
    global $wpdb;
    $result = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'externalDBdata WHERE id=1' );
    if ( $result[0]->sql_type == "mysql" ) {
        $conn = mysqli_connect($result[0]->host, $result[0]->username, $result[0]->pw, $result[0]->db_name);
        if ( ! $conn) {
            die("Can't connect to external db!</br>");
        } else {
            echo "connect to external db!</br>";
        }

        $sql = 'SELECT ' . $result[0]->product_column_name . ', '  . $result[0]->product_stock_column_name . ' FROM ' . $result[0]->table_name .';';
        $query = $conn->query($sql);
        if ( $query->num_rows > 0) {
            while ( $row = $query->fetch_assoc() ) {
                $wpdb->update(
                    $wpdb->prefix . 'wc_product_meta_lookup',
                    array( 'stock_quantity' => $row['product_stock'] ),
                    array( 'sku' => $row['product_sku'] )
                );
            }
        } else {
            echo "Could not query any data!";
        }
    }
}

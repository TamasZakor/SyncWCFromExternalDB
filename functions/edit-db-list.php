<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_connection_list() {
    global $wpdb;
    $result = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'externalDBdata' );
    $html = '<div id="connection_list_page"><h1>Connection list</h1>';
    $html .= '<table>
               <tr>
                 <th>SQL type</th>
                 <th>Server host</th>
                 <th>Username</th>
                 <th>Password</th>
                 <th>Table name</th>
                 <th>Product column name</th>
                 <th>Product stock column name</th>
                 <th>Operation</th>
               </tr>';
    foreach ( $result as $row) {
        $html .= '<tr>
                    <td>' . $row->sql_type .'</td>
                    <td>' . $row->host .'</td>
                    <td>' . $row->username .'</td>
                    <td>' . $row->pw .'</td>
                    <td>' . $row->table_name .'</td>
                    <td>' . $row->product_column_name .'</td>
                    <td>' . $row->product_stock_column_name .'</td>
                    <td>' . $row->id .'</td>
                </tr>';
    }

    $html .= '</table></div>';

    print($html);

    require_once plugin_dir_path(__FILE__) . 'update-db.php';
    if ( class_exists( 'Woocommerce' ) ) {
        sync_wc_from_ext_db_query_from_extern_db();
    } else {
        echo 'Woocommerce does not installed!';
        die;
    }
}

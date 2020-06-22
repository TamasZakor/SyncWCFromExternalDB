<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_connection_list() {
    global $wpdb;
    $result = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'externalDBdata' );
    $html = '<div id="connection_list_page"><h1>Connection list</h1>';
    $html .= '<table class="research">
                <tbody>
                    <tr>
                        <th>SQL type</th>
                        <th>Server host</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Database name</th>
                        <th>Table name</th>
                        <th>Product column name</th>
                        <th>Product stock column name</th>
                        <th colspan="2">Action</th>
                        <th>Active</th>
                    </tr>';
    foreach ( $result as $row) {
        $html .=   '<tr class="accordion">
                        <td>' . $row->sql_type .'</td>
                        <td>' . $row->host .'</td>
                        <td>' . $row->username .'</td>
                        <td>' . $row->pw .'</td>
                        <td>' . $row->db_name .'</td>
                        <td>' . $row->table_name .'</td>
                        <td>' . $row->product_column_name .'</td>
                        <td>' . $row->product_stock_column_name .'</td>
                        <td colspan="2"><button type="button" class="select_connection" id="edit_connection-' . $row->id .'">Edit</button></td>
                        <td>';
                        if ( $row->active == "no" ) {
                            $html .=  'Disable';
                        } else {
                            $html .=  'Enable';
                        }
        $html .=        '</td>
                    </tr>
                    <tr class="fold" id="hidden-' . $row->id .'">
                        <form id="ext_data_form" name="ext_data_form" method="POST" action="' . esc_attr('admin-post.php') . '">
                            <td>
                            <select name="dbtype" id="dbtype">
                                <option value="mysql"';
                                if ( $row->sql_type == "mysql" ) {
                                    $html .=  'selected';
                                } else {
                                    $html .=  '';
                                } 
        $html .=           '>MySQL</option>
                            <option value="mssql"';
                            if ( $row->sql_type == "mssql" ) {
                                $html .=  'selected';
                            } else {
                                $html .=  '';
                            } 
        $html .=           '>MSSQL</option>
                            </select>
                            </td>
                            <td>
                            <input type="text" id="dbhost" name="dbhost" value="' . $row->host .'">
                            </td>
                            <td>
                            <input type="text" id="dbusername" name="dbusername" value="' . $row->username .'">
                            </td>
                            <td>
                            <input type="text" id="dbpassw" name="dbpassw" value="' . $row->pw .'">
                            </td>
                            <td>
                            <input type="text" id="dbname" name="dbname" value="' . $row->db_name .'">
                            </td>
                            <td>
                            <input type="text" id="dbtablename" name="dbtablename" value="' . $row->table_name .'">
                            </td>
                            <td>
                            <input type="text" id="dbproductssku" name="dbproductssku" value="' . $row->product_column_name .'">
                            </td>
                            <td>
                            <input type="text" id="dbproductsstock" name="dbproductsstock" value="' . $row->product_stock_column_name .'">
                            </td>
                            <td>
                            <input type="hidden" id="dbproductsstock" name="id" value="' . $row->id .'">
                            <input type="hidden" id="dbsubmit" name="action" value="update_connection_form_submit">
                            <input id="update" type="submit" value="Update">
                            </td>
                        </form>
                        <form id="ext_data_form" name="ext_data_form" method="POST" action="' . esc_attr('admin-post.php') . '">
                            <td>
                                <input type="hidden" id="dbproductsstock" name="id" value="' . $row->id .'">
                                <input type="hidden" id="dbsubmit" name="action" value="delete_connection_form_submit">
                                <input id="delete" type="submit" value="Delete">
                            </td>
                        </form>
                        <form id="ext_data_form" name="ext_data_form" method="POST" action="' . esc_attr('admin-post.php') . '">
                            <td>
                                <input type="hidden" id="dbactive" name="id" value="' . $row->id .'">
                                <input type="hidden" id="dbactive" name="action" value="update_active_connection_form_submit">
                                <input id="activate" type="submit" value="';
                                if ( $row->active == "yes" ) {
                                    $html .=  'Disable';
                                } else {
                                    $html .=  'Enable';
                                }
    $html .=                    '">
                            </td>
                        </form>
                    </tr>';
    }

    $html .= '      </tbody>
                </table>
              </div>';
    print($html);
}

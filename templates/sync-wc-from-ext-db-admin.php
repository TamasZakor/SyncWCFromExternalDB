<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_page() {
    $admin_page = '<h1 id="H1-admin">
                     <p>Synchronize Woocommerce product stock with extern databasa</p>
                   </h1>';
    $admin_page .= '<div>
                        <form id="ext_data_form" name="ext_data_form" method="POST" action="' . esc_attr('admin-post.php') . '">
                            <label for="dbtype">Database type:</label><br>
                            <select name="dbtype" id="dbtype">
                                <option value="mysql">MySQL</option>
                                <option value="mssql">MSsQL</option>
                            </select><br><br>
                            <label for="dbhost">Database host:</label><br>
                            <input type="text" id="dbhost" name="dbhost"><br><br>
                            <label for="dbusername">Database username:</label><br>
                            <input type="text" id="dbusername" name="dbusername"><br><br>
                            <label for="dbpassw">Database password:</label><br>
                            <input type="text" id="dbpassw" name="dbpassw"><br><br>
                            <label for="dbname">Database name:</label><br>
                            <input type="text" id="dbname" name="dbname"><br><br>
                            <label for="dbtablename">Database table name:</label><br>
                            <input type="text" id="dbtablename" name="dbtablename"><br><br>
                            <label for="dbproductssku">Database product column name:</label><br>
                            <input type="text" id="dbproductssku" name="dbproductssku"><br><br>
                            <label for="dbproductsstock">Database product stock column name:</label><br>
                            <input type="text" id="dbproductsstock" name="dbproductsstock"><br><br>
                            <input name="action" type="hidden" value="custom_form_submit">
                            <input id="submit" type="submit" value="Submit">
                        </form>
                    </div>';

    print($admin_page);
}

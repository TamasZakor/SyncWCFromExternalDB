<?php
/**
* @package SyncWCFromExtDB
*/
require_once plugin_dir_path(__FILE__) . '../functions/save-ext-db-data.php';

add_action( 'admin_menu', 'sync_wc_from_ext_db_menu' );
function sync_wc_from_ext_db_menu() {
    $page_title = 'Sync WC from Ext DB';
    $menu_title = 'Sync WC';
    $capability = 'manage_options';
    $menu_slug  = 'sync_wc_from_ext_db';
    $function   = 'sync_wc_from_ext_db_page';
    $icon_url   = 'dashicons-media-code';
    $position   = 4;
    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}
//save-ext-db-data.php
function sync_wc_from_ext_db_page () {
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

add_action ( 'admin_post_custom_form_submit' , 'sync_wc_from_ext_db_page_save_to_db');
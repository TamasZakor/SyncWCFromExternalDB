<?php
/**
* @package SyncWCFromExtDB
*/

function sync_wc_from_ext_db_send_mail_after_order($order_id)
{
    // Get an instance of the WC_Order object
    $order = wc_get_order( $order_id );
    $body = "Order id      : " . $order_id .'<br>'; // The Product ID

    foreach ($order->get_items() as $item_id => $item ) {
        $body .= "Product id    : " . $item->get_product_id().'<br>'; // The Product ID
        $body .= "Variation id  : " . $item->get_variation_id().'<br>'; // The variation ID
        $body .= "Quantity      : " . $item->get_quantity().'<br>'; // Line item quantity
        $body .= "Subtotal price: " . $item->get_subtotal().'<br>'; // Line item subtotal
        $body .= "Total pricve  : " . $item->get_total().'<br>'; // Line item total
    }
    var_dump ( $body );
    $to = 'elabrobyte@gmail.com';
    $subject = 'Order: ' . $order_id;
    $headers = array('Content-Type: text/html; charset=UTF-8');

    wp_mail( $to, $subject, $body, $headers );
}
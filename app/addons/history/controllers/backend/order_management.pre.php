<?php

use Tygh\Tygh;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

Tygh::$app['session']['cart'] = isset(Tygh::$app['session']['cart']) ? Tygh::$app['session']['cart'] : array();
$cart = & Tygh::$app['session']['cart'];

Tygh::$app['session']['customer_auth'] = isset(Tygh::$app['session']['customer_auth']) ? Tygh::$app['session']['customer_auth'] : array();
$customer_auth = & Tygh::$app['session']['customer_auth'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'place_order') {
        
        $order_id =  $cart['order_id'];
        $order_full_info_old = fn_get_order_info($order_id);
        $data_old = [];
        $data_new = [];
        $products = [];
        $shipping_ids = [];
        
        // shipping change 

        if (!empty($order_full_info_old['shipping'])) {
            foreach ($order_full_info_old['shipping'] as $shipping) {
                $shipping_ids[] = $shipping['shipping_id'];
            }
        }

        if (!empty(array_diff_assoc($_REQUEST['shipping_ids'], $shipping_ids))) {
            $data_old['shipping_ids'] = $shipping_ids;
            $data_new['shipping_ids'] = $_REQUEST['shipping_ids'];
        }
        
        // payment method change 

        if ($order_full_info_old['payment_id'] != $_REQUEST['payment_id']) {
            $data_old['payment_id'] = $order_full_info_old['payment_id'];
            $data_new['payment_id'] = $_REQUEST['payment_id'];
        }

        // payment info change 
        
        if (!empty(array_diff_assoc($_REQUEST['payment_info'], $order_full_info_old['payment_info']))) {
            $data_old['payment_info'] = $order_full_info_old['payment_info'];
            $data_new['payment_info'] = $_REQUEST['payment_info'];
        }

        // order status change 

        if ($order_full_info_old['status'] !== $_REQUEST['order_status']) {
            $data_old['status'] = $order_full_info_old['status'];
            $data_new['status'] = $_REQUEST['order_status'];
        }

        // order products change 

        foreach ($order_full_info_old['products'] as $key => $product) {
            $product_options = [];
            foreach ($product['extra']['product_options'] as $key_option => $option) {
                $product_options[$key_option] = $option;
            }
            $item['stored_price'] = $product['extra']['stored_price'];
            $item['price'] = (float) $product['price'];
            $item['product_id'] = $product['product_id'];
            $item['amount'] = $product['amount'];
            $item['object_id'] = $product['item_id'];
            $item['product_options'] = $product_options;
            $products[$product['item_id']] = $item;
        }

        $cart_products = $_REQUEST['cart_products'];
        foreach ($cart_products as $key => $product) {
            $cart_products[$key]['price'] = (float) $product['price'];
        }

        if (!empty(array_diff_assoc(array_map('serialize', $cart_products), array_map('serialize', $products)))) {
           $data_old['product'] = $products;
           $data_new['product'] = $cart_products;
        } else {
            $diff = [];
            foreach ($products as $key => $product) {
                if(!empty(array_diff_assoc(array_map('serialize', $cart_products[$key]), array_map('serialize', $product)))) {
                    $diff[]= $product;
                };
            }
            
            if (!empty($diff)) {
                $data_old['product'] = $products;
                $data_new['product'] = $cart_products;
            }
        }

        if (!empty($data_old) && !empty($data_new)) {
            $date = new DateTime();
            
            $order_history_data = [
                'order_id'   => $order_id,
                'data_old'   => json_encode($data_old),
                'data_new'   => json_encode($data_new),
                'user_id'    => $customer_auth['user_id'],
                'updated_at' => $date->getTimestamp()
            ];
            fn_test_save_order_history_data($order_history_data);
            
        }
    }
}    
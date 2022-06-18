<?php

use Tygh\Tygh;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'place_order') {
        $cart = & Tygh::$app['session']['cart'];
        $customer_auth = & Tygh::$app['session']['customer_auth'];
        $order_id =  $cart['order_id'];
        $order_full_info_old = fn_get_order_info($order_id);

        $products = [];
        foreach ($order_full_info_old['products'] as $key => $product) {
            $product_options = [];
            foreach ($product['extra']['product_options'] as $key => $option) {
                $product_options[$option['option_id']] = $option['value']; 
            }
            $item['stored_price'] = $product['extra']['stored_price'];
            $item['price'] = (float) $product['price'];
            $item['product_id'] = $product['product_id'];
            $item['amount'] = $product['amount'];
            $item['object_id'] = $product['item_id'];
            $item['product_options'] = $product_options;
            $products[$product['item_id']] = $item;
        }
        
        if (!empty(array_diff_assoc(array_map('serialize', $_REQUEST['cart_products']), array_map('serialize', $products)))) {
            $date = new DateTime();
            
            $order_history_data = [
                'order_id'   => $order_id,
                'data_old'   => json_encode($products),
                'data_new'   => json_encode($_REQUEST['cart_products']),
                'user_id'    => $customer_auth['user_id'],
                'updated_at' => $date->getTimestamp()
            ];
            fn_test_save_order_history_data($order_history_data);
            
        } else {
            $diff = [];
            foreach ($products as $key => $product) {
                if(!empty(array_diff_assoc(array_map('serialize', $_REQUEST['cart_products'][$key]), array_map('serialize', $product)))) {
                    $diff += $product; 
                };
            }
            
            if (!empty($diff)) {
                $date = new DateTime();
                $order_history_data = [
                    'order_id'   => $order_id,
                    'data_old'   => json_encode($products),
                    'data_new'   => json_encode($_REQUEST['cart_products']),
                    'user_id'    => $customer_auth['user_id'],
                    'updated_at' => $date->getTimestamp(),
                ];
                
                fn_test_save_order_history_data($order_history_data);
            }
        }
    }
}    
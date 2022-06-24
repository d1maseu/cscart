<?php

use Tygh\Registry;
use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');

/** @var string $mode */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    return;
}

//$params = $_REQUEST;

if ($mode === 'order_history') {
    $params = $_REQUEST;

    $items_per_page = $params['items_per_page'] ? $params['items_per_page'] : Registry::get('settings.Appearance.admin_elements_per_page');

    [$changed_orders, $params] = fn_test_get_order_history_data($params, $items_per_page);

    if ($changed_orders) {
        foreach ($changed_orders as $order_key => $changed_order) {
            if ($changed_order['data_old']['product']) {
                foreach ($changed_order['data_old']['product'] as $key => $product) {
                    $changed_orders[$order_key]['data_old']['product'][$key]['title'] = db_get_field("SELECT product FROM ?:product_descriptions WHERE product_id = ?i", $product['product_id']);

                    if ($product['product_options']) {
                        $options = [];
                        foreach ($product['product_options'] as $option_key => $option) {
                            $option_title = db_get_field("SELECT option_name FROM ?:product_options_descriptions WHERE option_id = ?i", $option_key);
                            $option_value = db_get_field("SELECT variant_name FROM ?:product_option_variants_descriptions WHERE variant_id = ?i", $option);
                            $options[$option_title] = $option_value;
                        }

                        $changed_orders[$order_key]['data_old']['product'][$key]['options'] = $options;
                    }
                }
            }

            if ($changed_order['data_new']['product']) {
                foreach ($changed_order['data_new']['product'] as $key => $product) {
                    $changed_orders[$order_key]['data_new']['product'][$key]['title'] = db_get_field("SELECT product FROM ?:product_descriptions WHERE product_id = ?i", $product['product_id']);

                    if ($product['product_options']) {
                        $options = [];
                        foreach ($product['product_options'] as $option_key => $option) {
                            $option_title = db_get_field("SELECT option_name FROM ?:product_options_descriptions WHERE option_id = ?i", $option_key);
                            $option_value = db_get_field("SELECT variant_name FROM ?:product_option_variants_descriptions WHERE variant_id = ?i", $option);
                            $options[$option_title] = $option_value;
                        }

                        $changed_orders[$order_key]['data_new']['product'][$key]['options'] = $options;
                    }
                }
            }

            if ($changed_order['data_old']['shipping_ids']) {
                foreach ($changed_order['data_old']['shipping_ids'] as $key => $shipping) {
                    $changed_orders[$order_key]['data_old']['shippings'][$key] = db_get_field("SELECT shipping FROM ?:shipping_descriptions WHERE shipping_id = ?i", $shipping);
                }
            }

            if ($changed_order['data_new']['shipping_ids']) {
                foreach ($changed_order['data_new']['shipping_ids'] as $key => $shipping) {
                    $changed_orders[$order_key]['data_new']['shippings'][$key] = db_get_field("SELECT shipping FROM ?:shipping_descriptions WHERE shipping_id = ?i", $shipping);
                }
            }

            if ($changed_order['data_old']['payment_id']) {
                $changed_orders[$order_key]['data_old']['payment'] = db_get_field("SELECT payment FROM ?:payment_descriptions WHERE payment_id = ?i", $changed_order['data_old']['payment_id']); 
            }

            if ($changed_order['data_new']['payment_id']) {
                $changed_orders[$order_key]['data_new']['payment'] = db_get_field("SELECT payment FROM ?:payment_descriptions WHERE payment_id = ?i", $changed_order['data_new']['payment_id']); 
            }
        }   
    }
    
    Tygh::$app['view']->assign('changed_orders', $changed_orders);   
    Tygh::$app['view']->assign('search', $params);
}

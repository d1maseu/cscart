<?php

use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_test_save_order_history_data($order_history_data)
{
    db_query("INSERT INTO ?:test_order_changes ?e", $order_history_data);

    return true;
}

function fn_test_get_order_history_data($params = [], $items_per_page = 0)
{
    $default_params['items_per_page'] = $items_per_page;
    $default_params['page'] = 1;

    $limit = '';

    $sortings = [
        'order_change_id' => '?:test_order_changes.order_change_id'
    ];

    $sorting = db_sort($params, $sortings, 'position', 'asc');

    if (is_array($params)) {
        $params = array_merge($default_params, $params);
    } else {
        $params = $default_params;
    }
    
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT COUNT(DISTINCT(?:test_order_changes.order_change_id)) FROM ?:test_order_changes");
        $limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
    }

    $changed_orders_list = db_get_hash_array("SELECT ?:test_order_changes.*, ?:users.firstname FROM ?:test_order_changes" . db_quote(' LEFT JOIN ?:users ON ?:test_order_changes.user_id = ?:users.user_id') . " WHERE 1 ?p ?p", 'order_change_id', $sorting, $limit);

    foreach ($changed_orders_list as $key => $order) {
        $changed_orders_list[$key]['data_old'] = json_decode($order['data_old'], true);
        $changed_orders_list[$key]['data_new'] = json_decode($order['data_new'], true);
    }
    
    return [$changed_orders_list, $params];
}
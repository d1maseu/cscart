<?php

use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_test_save_order_history_data($order_history_data)
{
    db_query("INSERT INTO ?:test_order_changes ?e", $order_history_data);

    return true;
}

function fn_test_get_order_history_data()
{

    $changed_orders_list = db_get_array("SELECT ?:test_order_changes.*, ?:users.firstname FROM ?:test_order_changes " . db_quote(' LEFT JOIN ?:users ON ?:test_order_changes.user_id = ?:users.user_id'));

    foreach ($changed_orders_list as $key => $order) {
        $changed_orders_list[$key]['data_old'] = json_decode($order['data_old'], true);
        $changed_orders_list[$key]['data_new'] = json_decode($order['data_new'], true);
    }
    
    return $changed_orders_list;
}
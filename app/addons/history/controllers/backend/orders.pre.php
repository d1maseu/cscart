<?php

use Tygh\Registry;
use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');

/** @var string $mode */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $suffix = '';


    if ($mode == 'update_status') {
        
        $customer_auth = & Tygh::$app['session']['customer_auth'];
        $order_id =  $_REQUEST['id'];;
        $order_full_info_old = fn_get_order_info($order_id);
        $data_old = [];
        $data_new = [];

        
        if ($order_full_info_old['status'] !== $_REQUEST['order_status']) {
            $data_old['status'] = $order_full_info_old['status'];
            $data_new['status'] = $_REQUEST['status'];
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
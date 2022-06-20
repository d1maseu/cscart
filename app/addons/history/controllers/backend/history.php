<?php

use Tygh\Registry;
use Tygh\Shippings\Shippings;
use Tygh\Storage;
use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');

/** @var string $mode */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    return;
}

//$params = $_REQUEST;

if ($mode === 'order_history') {
    $params = $_REQUEST;
    $changed_orders = fn_test_get_order_history_data();
    $items_per_page = 3;
    //$data = [$item_per_page];
    //$params = fn_array_merge($params, $data);
    list($pages, $params) = fn_get_pages($params, $items_per_page);
    Tygh::$app['view']->assign('changed_orders', $changed_orders);   
    Tygh::$app['view']->assign('search', $params);
}




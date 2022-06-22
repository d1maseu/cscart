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

    $items_per_page = $params['items_per_page'] ? $params['items_per_page'] : Registry::get('settings.Appearance.admin_elements_per_page');
    
    list($changed_orders, $params) = fn_test_get_order_history_data($params, $items_per_page);
    
    Tygh::$app['view']->assign('changed_orders', $changed_orders);   
    Tygh::$app['view']->assign('search', $params);
}

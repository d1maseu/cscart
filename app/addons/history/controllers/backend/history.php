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

    $changed_orders = fn_test_get_order_history_data();
    
    Tygh::$app['view']->assign('changed_orders', $changed_orders);   
}




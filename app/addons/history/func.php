<?php

use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_test_save_order_history_data($order_history_data)
{
    db_query("INSERT INTO ?:test_order_changes ?e", $order_history_data);

    return true;
}
<?php

use Tygh\Enum\NotificationSeverity;
use Tygh\Notifications\EventIdProviders\OrderProvider;
use Tygh\Registry;
use Tygh\Shippings\Shippings;
use Tygh\Storage;
use Tygh\Tools\Url;
use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');

/** @var string $mode */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    return;
}

$params = $_REQUEST;

if ($mode === 'order_history') {
    

}




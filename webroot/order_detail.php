<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */
require_once '../lib/config/const.php';

require_once DIR_MODEL . 'function.php';
require_once DIR_MODEL . 'item.php';
require_once DIR_MODEL . 'user.php';
require_once DIR_MODEL . 'order_detail.php';
require_once DIR_MODEL . 'order.php';
{
	session_start();

	$response = array();
	$db = db_connect();

	check_logined($db);

    $order_id = get_get_data('order_id');
    $response['order'] = get_order($db, $order_id);
	$response['order_details'] = order_detail_list($db, $order_id);
	require_once DIR_VIEW . 'order_detail.php';
}

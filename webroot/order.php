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
require_once DIR_MODEL . 'order.php';
{
	session_start();

	$response = array();
	$db = db_connect();

	check_logined($db);


	$response['orders'] = order_list($db, $_SESSION['user']['id']);
	require_once DIR_VIEW . 'order.php';
}


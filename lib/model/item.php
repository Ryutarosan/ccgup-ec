<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */

/**
 * @param PDO $db
 * @param string $name
 * @param string $img
 * @param int $price
 * @param int $stock
 * @param int $status
 * @return number
 */
function item_regist($db, $name, $img, $price, $stock, $status) {
//1.sql文をプレースホルダー を使用する形に書き直す
	$sql = <<<EOD
INSERT INTO items (name, img, price, stock, status, create_date, update_date)
 VALUES (?, ?, ?, ?, ?, NOW(), NOW());
EOD;
//2.$params配列にプレースホルダーにバインドする変数を詰め込む
	$params = array($name, $img, $price, $stock, $status);
	//3.db_updateの際に$paramsを第三引数として渡す
	return db_update($db, $sql, $params);
}

/**
 * @param PDO $db
 * @param int $id
 * @return number
 */
function item_delete($db, $id) {
	$row = item_get($db, $id);

	if (!empty($row)) {
		@unlink(DIR_IMG_FULL . $row['img']);
	}
	$sql = 'DELETE FROM items WHERE id = ?';
	$params = array($id);
	return db_update($db, $sql, $params);
}

/**
 * @param PDO $db
 * @return array
 */
function item_list($db, $is_active_only = true, $order = '') {
	$sql = <<<EOD
 SELECT id, name, price, img, stock, status, create_date, update_date
 FROM items
EOD;
	$params = array();
	if ($is_active_only) {
		$sql .= " WHERE status = ?";
		$params = array(1);
	}
	if ($order === 'recent'){
		$sql .= ' ORDER BY items.create_date DESC';
	}
	if ($order === 'price_asc'){
		$sql .= ' ORDER BY items.price ASC';
	}
	if ($order === 'price_desc'){
		$sql .= ' ORDER BY items.price DESC';
	}
	return db_select($db, $sql, $params);
}

/**
 * @param PDO $db
 * @param int $id
 * @return NULL|mixed
 */
function item_get($db, $id) {
	$sql = <<<EOD
 SELECT id, name, price, img, stock, status, create_date, update_date
 FROM items
 WHERE id = ?
EOD;
	$params = array($id);
	return db_select_one($db, $sql, $params);
}

/**
 *
 * @param PDO $db
 * @param array $cart_items
 * @return boolean
 */
function item_update_stock($db, $id, $stock) {
	$sql = <<<EOD
 UPDATE items
 SET stock = ?, update_date = NOW()
 WHERE id = ?
EOD;
	$params = array($stock, $id);
	return db_update($db, $sql, $params);
}

/**
 *
 * @param PDO $db
 * @param array $cart_items
 * @return boolean
 */
function item_update_saled($db, $id, $amount) {
	$sql = <<<EOD
 UPDATE items
 SET stock = stock - ?, update_date = NOW()
 WHERE id = ?
EOD;
	$params = array($amount, $id);
	return db_update($db, $sql, $params);
}

/**
 *
 * @param PDO $db
 * @param array $cart_items
 * @return boolean
 */
function item_update_status($db, $id, $status) {
	$sql = <<<EOD
 UPDATE items
 SET status = ?, update_date = NOW()
 WHERE id = ?
EOD;
	$params = array($status, $id);
	return db_update($db, $sql, $params);
}

/**
 * @param string $status
 * @return boolean
 */
function item_valid_status($status) {
	return "0" === (string)$status || "1" === (string)$status;
}

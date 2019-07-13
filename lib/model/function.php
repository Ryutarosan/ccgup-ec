<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */

/**
 * @return PDO
 */
function db_connect() {
	$dsn = 'mysql:charset=utf8;dbname=' . DB_NAME . ';host=' . DB_HOST;

	try {
		$db = new PDO($dsn, DB_USER, DB_PASS);
		//エラーが発生したら例外処理を行う
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//プリペアドステートメントのエミュレーションは行わない
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->exec("SET NAMES 'UTF8'");
	} catch (PDOException $e) {
		die('db error: ' . $e->getMessage());
	}

	return $db;
}

/**
 *
 * @param PDO $db
 * @param string $sql
 * @return array
 */
function db_select($db, $sql, $params = array()) {
	//$stmtに$dbが持っているprepare機能で作られた結果（リモコン）を代入する
	$stmt = $db->prepare($sql);
	//リモコン(PDOStatement)を実行する プレースホルダーにした部分に$paramsを当てはめる(バインドする)
	$stmt->execute($params); 
	//$result = $db->query($sql);
	
	// if ($stmt->rowCount() === 0) {
	// 	return array();
	// }
	//リモコンで実行した結果を$rowsに代入する
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

/**
 * @param PDO $db
 * @param string $sql
 * @return NULL|mixed
 */
function db_select_one(PDO $db, $sql, $params = array()) {
	$rows = db_select($db, $sql, $params);
	if (empty($rows)) {
		return null;
	}
	return $rows[0];
}

/**
 *
 * @param PDO $db
 * @param string $sql
 * @return int
 */
function db_update(PDO $db, $sql, $params = array()) {
	$stmt = $db->prepare($sql);
	// foreach($params as $i => $value){
	// 	$stmt->bindValue($i+1, $value,     PDO::PARAM_STR);//文字列	
	// }
	

	return $stmt->execute($params);
}

/**
 *
 * @param mixed $value
 * @return boolean
 */
function is_number($value) {
	if (empty($value)) {
		return false;
	}
	$pattern = '/^[0-9]+$/';
	return (bool)preg_match($pattern, $value);
}

function save_upload_file($dir, $varname, &$errors) {

	if (is_uploaded_file($_FILES[$varname]['tmp_name']) === false) {
		$errors = 'ファイルを選択してください';
		return null;
	}

	$user_file_name = $_FILES[$varname]['name'];

	// 画像の拡張子取得
	$extension = pathinfo($user_file_name, PATHINFO_EXTENSION);

	switch ($extension) {
		case 'jpg':
		case 'jpeg':
		case 'png':
			break;
		default:
			$errors = 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です。';
			return null;
	}

	$save_file_name = '';
	for ($i = 0; $i < 10; $i++) {
		$save_file_name= md5(uniqid(mt_rand(), true)) . '.' . $extension;
		if (!file_exists($dir . $save_file_name)) {
			break;
		}
	}

	// ファイルを移動し保存
	if (move_uploaded_file($_FILES[$varname]['tmp_name'], $dir. $save_file_name) !== TRUE) {
		$errors = 'ファイルアップロードに失敗しました。';
		return null;
	}
	return $save_file_name;
}

/**
 * @param PDO $db
 */
function check_logined($db) {
	if (empty($_SESSION['user'])) {
		header('Location: ./login.php');
		exit;
	}

	require_once DIR_MODEL . 'user.php';

	$user = user_get($db, $_SESSION['user']['id']);
	if (empty($user)) {
		header('Location: ./logout.php');
		exit;
	}
}

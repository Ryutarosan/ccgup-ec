<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */
{
	// CSRF対策にはsessionを利用します
	session_start();
	make_token();
	$message = update();
}

/**
 * getアクセス時のみtokenを発行してsessionに保存
 */
function make_token() {
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		return;
	}

	$token = sha1(uniqid(mt_rand(), true));
	$_SESSION['token'] = $token;
}

/**
 * sessionに保存されたtokenとpost送信されたtokenを比較
 * @return boolean
 */
function check_token() {
	if (empty($_POST['token'])) {
		return false;
	}

	if (empty($_SESSION['token'])) {
		return false;
	}
	//
	return $_SESSION['token'] === $_POST['token'];
}

/**
 * tokenチェックの結果問題なければ更新処理
 * @return string
 */
function update() {
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		return '';
	}
	$var = htmlspecialchars($_POST['var']);
	$token = htmlspecialchars($_POST['token']);
	if (!check_token()) {
		return <<<EOD
<span style="color: red;">tokenエラー</span><br>
var： {$var}<br>
post token： {$token}<br>
session token： {$_SESSION['token']}
EOD;
	}
	return <<<EOD
<span style="color: blue;">更新成功！</span><br>
var： {$var}<br>
post token： {$token}<br>
session token： {$_SESSION['token']}
EOD;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>CSRF対策例</title>
<style>
* {
	color: black;
}

body {
	background-color: white;
}
</style>
</head>
<body>
	<h1>CSRF対策例</h1>
	<h2>CSRF対策例</h2>
	<p>下記の動作を比較してみてください。</p>
	<ul>
		<li>フォームから実行</li>
		<li>CSRFの攻撃ソースが仕込まれている下記サイトにアクセス <br>
		<a href="./csrf.html">悪意あるサイト</a></li>
	</ul>
	<h2>実行結果</h2>
	<p><?php echo $message; ?></p>
	<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
		value: <input type="text" name="var"> 
		<input type="submit" value="submit">
	</form>
</body>
</html>
<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>商品の登録</title>
<link href="./assets/bootstrap/dist/css/bootstrap.min.css"
	rel="stylesheet">
<link rel="stylesheet" href="./assets/css/style.css">
</head>
<body class="admin">
<!-- バーの表示(外部ファイル読み込み) -->
<?php require DIR_VIEW_ELEMENT . 'output_navber.php'; ?>

	<div class="container-fluid px-md-3">
    <!-- 外部ファイル読み込み -->
<?php require DIR_VIEW_ELEMENT . 'output_message.php'; ?>
		<div class="row d-md-none">
			<div class="col-12 alert alert-danger" role="alert">
				このページはスマートフォンには対応していません。 <br>パソコン・タブレットにてご利用ください。
			</div>
		</div>
		<div>
			<section>
				<div class="col-xs-12 col-md-10 offset-md-1">
					<h2>購入明細</h2>
                </div>
                
                <p>注文番号:<?php print h($response['order']['order_id'])?></p>
                <p>購入日時:<?php print h($response['order']['order_datetime'])?></p>
                <p>合計金額:<?php print h($response['order']['total'])?></p>
                
                <?php if ( !empty($response['order_details'])) {?>
				<div class="col-xs-12 col-md-10 offset-md-1 cart-list">
					<div class="row">
						<table class="table">
							<thead>
								<tr>
									<th>商品名</th>
									<th>商品価格</th>
									<th>購入個数</th>
                                    <th>小計</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ( $response['order_details']as $key => $order ) {?>
								<tr
									class="<?php echo h((0 === ($key % 2)) ? 'stripe' : '' ); ?> ">
									<td><?php echo h($order['name'])?></td>
                                    <td><?php echo h($order['price'])?>円</td>
									<td><?php echo h(number_format($order['quantity']))?>個</td>
									<td><?php echo h(number_format($order['price'] * $order['quantity']))?>円</td>
									</td>
								</tr>
<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
<?php }?>
			</section>
		</div>
	</div>
	<!-- /.container -->
	<script src="./assets/js/jquery/1.12.4/jquery.min.js"></script>
	<script src="./assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<script>
        function check() {
            if(window.confirm('削除してよろしいですか？')) {
                return true;
            } else{
                return false;
            }
        }
   </script>
</body>
</html>

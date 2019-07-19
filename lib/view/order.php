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
					<h2>注文履歴の一覧・変更</h2>
				</div>
<?php if ( !empty($response['orders'])) {?>
				<div class="col-xs-12 col-md-10 offset-md-1 cart-list">
					<div class="row">
						<table class="table">
							<thead>
								<tr>
									<th>注文番号</th>
									<th>購入日時</th>
									<th>合計金額</th>
                                    <th>
								</tr>
							</thead>
							<tbody>
<?php foreach ( $response['orders']as $key => $order ) {?>
								<tr
									class="<?php echo h((0 === ($key % 2)) ? 'stripe' : '' ); ?> ">
									<td><?php echo h($order['order_id'])?></td>
                                    <td><?php echo h($order['order_datetime'])?></td>
									<td><?php echo h(number_format($order['total']))?>円</td>
									<td>
                                        <a href="order_detail.php?order_id=<?php echo h($order['order_id'])?>">購入明細へ</a>
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

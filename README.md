# ccgup-ec

## ライセンス

このプロジェクトのコンテンツは、個別にライセンスが定義されていない限り **Creative Commons BY-NC-SA 4.0** にて公開されています。  
[Creative Commons BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja)

## ライセンスのための表記

```
このコンテンツはコードキャンプ株式会社により作成され、Creative Commons BY-NC-SA 4.0により公開されています。
https://codecamp.jp/
```

## 環境準備方法

### git clone

ホストOSで実行します。

```
cd $workspace/ccg/syncs/www/dev.lesson-codecamp.jp
rm -Rf ./webroot
git clone [リポジトリのurl] ./
```

### sqlの実行

ゲストOSにログインして実行します。

```
cd /vagrant/www/dev.lesson-codecamp.jp/lib/schema
mysql -u codecamp_user -p codecamp_db < schema.sql
```

### 設定ファイルの修正

ホストOS上で下記設定ファイルを環境に合わせて修正します。

```
$workspace/ccg/syncs/www/dev.lesson-codecamp.jp/config/const.php
```

## 接続確認

`環境準備方法` が終わりましたら、下記にアクセスして接続確認をしましょう。  
[dev.lesson-codecamp.jp:8080](http://dev.lesson-codecamp.jp:8080)



//追加テーブル
注文履歴テーブル
- 注文番号 1
- 注文日時 7/14 9:40
- ユーザーID 1
CREATE TABLE `codecamp_db`.`orders` ( `order_id` INT NOT NULL AUTO_INCREMENT , `order_datetime` DATETIME NOT NULL , `user_id` INT NOT NULL , PRIMARY KEY (`order_id`)) ENGINE = InnoDB;


購入明細書テーブル
- 購入明細番号 1
- 注文番号 1
- 商品ID 1
- 注文個数 2

- 購入明細番号 2
- 注文番号 1
- 商品ID 2
- 注文個数 3

CREATE TABLE `codecamp_db`.`order_details` ( `order_detail_id` INT NOT NULL AUTO_INCREMENT , `order_id` INT NOT NULL , `item_id` INT NOT NULL , `quantity` INT NOT NULL , PRIMARY KEY (`order_detail_id`)) ENGINE = InnoDB;
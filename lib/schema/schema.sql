/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */

/* デモサイト構築用
-- このコメント内は無視してください
DROP DATABASE IF EXISTS codecamp_ec;
CREATE DATABASE IF NOT EXISTS codecamp_ec DEFAULT CHARACTER SET utf8;

DROP DATABASE IF EXISTS codecamp_secure_ec;
CREATE DATABASE IF NOT EXISTS codecamp_secure_ec DEFAULT CHARACTER SET utf8;

grant all on codecamp_ec.* to 'codecamp'@'localhost';
grant all on codecamp_secure_ec.* to 'codecamp'@'localhost';
*/

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'プライマリーキー',
  login_id varchar(255) not null default '' COMMENT 'ログインID',
  password varchar(255) not null default '' COMMENT 'パスワード',
  is_admin tinyint not null default 0 COMMENT '管理者フラグ 1: 管理者',
  create_date datetime DEFAULT NULL COMMENT 'データ作成日',
  update_date datetime DEFAULT NULL COMMENT 'データ更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'ユーザテーブル';
CREATE UNIQUE INDEX users_login_id ON users (login_id) COMMENT 'UNIQUE KEY ログインID';

DROP TABLE IF EXISTS items;
CREATE TABLE IF NOT EXISTS items (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'プライマリーキー',
  name varchar(255) DEFAULT NULL COMMENT '商品名',
  price int(11) DEFAULT NULL COMMENT '価格',
  img varchar(255) DEFAULT NULL COMMENT '画像ファイル名',
  stock int(11) DEFAULT NULL COMMENT '在庫数',
  status int(11) DEFAULT NULL COMMENT '公開ステータス 0: 非公開 1: 公開',
  create_date datetime DEFAULT NULL COMMENT 'データ作成日',
  update_date datetime DEFAULT NULL COMMENT 'データ更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '商品テーブル';

DROP TABLE IF EXISTS carts;
CREATE TABLE IF NOT EXISTS carts (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'プライマリーキー',
  user_id int(11) NULL COMMENT 'ユーザID',
  item_id int(11) NULL COMMENT '商品ID',
  amount int(11) DEFAULT NULL COMMENT '購入数',
  create_date datetime DEFAULT NULL COMMENT 'データ作成日',
  update_date datetime DEFAULT NULL COMMENT 'データ更新日',
  CONSTRAINT FOREIGN KEY cats_foreign_user_id (user_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT FOREIGN KEY cats_foreign_item_id (item_id) REFERENCES items (id) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'カートテーブル';
CREATE UNIQUE INDEX carts_user_item ON carts (user_id, item_id) COMMENT 'UNIQUE KEY ユーザーID, アイテムID';

INSERT INTO items (id, name, price, img, status, stock, create_date, update_date) VALUES
(1, '白シャツ', 1000, 'p1.png', 1, 10, now(), now()),
(2, '白シャツ２', 1500, 'p2.png', 1, 10, now(), now()),
(3, '黒シャツ', 1000, 'p3.png', 1, 10, now(), now());

INSERT INTO users (id, login_id, password, is_admin, create_date, update_date) VALUES
(1, 'admin', sha1('admin'), 1, now(), now())
, (2, 'user1', sha1('user1'), 0, now(), now())
, (3, 'user2', sha1('user2'), 0, now(), now());

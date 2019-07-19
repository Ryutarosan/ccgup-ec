<?php 
// orderにINSERT文を追加する関数
function add_order($db, $user_id){
    // ordersにINSERT文をかく user_idをプレースホルダに入れる
    $sql = 'INSERT INTO orders (user_id, order_datetime) VALUES (?, now())';
    // プレースホルダに入れた$user_idを配列にし、$paramsに代入
    $params = array($user_id);
    // 返り値はDBの更新
    return db_update($db, $sql, $params);
}

//注文履歴をorder_list関数に
function order_list($db, $user_id){
    // データ参照
    $sql = 'SELECT 
        orders.order_id,
        orders.order_datetime,
        -- 注文時の合計金額
        sum(items.price * order_details.quantity) as total
        FROM
            orders
            -- idの重複している箇所をまとめる
            JOIN
                order_details
            ON
                orders.order_id = order_details.order_id
            JOIN
                items
            ON
                order_details.item_id = items.id
            -- まとめたidをorders.user_idにまとめる
        WHERE
            orders.user_id = ?
            -- 注文履歴に表示する注文番号をグループ化
        GROUP BY
            orders.order_id
            -- 注文履歴に表示する購入日時を古い順
        ORDER BY
            orders.order_datetime ASC';
    $params = array($user_id);
    return db_select($db, $sql, $params);
}

function get_order($db, $order_id){
    // $sql = 'SELECT';
$sql = 'SELECT
        orders.order_id,
        orders.order_datetime,
        -- 注文時の合計金額
        sum(items.price * order_details.quantity) as total
        FROM
            orders
            -- idの重複している箇所をまとめる
            JOIN
                order_details
            ON
                orders.order_id = order_details.order_id
            JOIN
                items
            ON
                order_details.item_id = items.id
            -- まとめたidをorders.user_idにまとめる
        WHERE
            orders.order_id = ?
        GROUP BY
            orders.order_id';
    $params = array($order_id);
    return db_select_one($db, $sql, $params);
}

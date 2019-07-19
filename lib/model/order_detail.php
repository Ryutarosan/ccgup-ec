<?php
function order_detail_list($db, $order_id){
    $sql = 'SELECT 
    items.name,
    items.price,
    order_details.quantity
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
        -- 注文履歴に表示する注文番号をグループ化
    ORDER BY
        orders.order_datetime ASC';
    $params = array($order_id);
    return db_select($db, $sql, $params);
}
function add_order_detail($db, $order_id, $item_id, $quantity){
    $sql = 'INSERT INTO order_details (order_id, item_id, quantity) VALUES (?, ?, ?)';
    $params = array($order_id, $item_id, $quantity);
    return db_update($db, $sql, $params);
}
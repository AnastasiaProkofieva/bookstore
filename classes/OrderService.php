<?php


class OrderService
{

    public function getOrdersList(): array
    {
        $sql = 'SELECT o.order_id,group_concat(book.id) book_ids, group_concat(book.title) book_names, o.amount, o.added_at, o.status FROM `order` o
join bookstore.order_book  on o.order_id = order_book.order_id
join bookstore.book  on book.id = order_book.book_id
group by o.order_id
order by o.added_at desc
';
        $pdo=getPDO();
        $stmt=$pdo->query($sql);
        $resultArr = $stmt->fetchAll();
        $colorizeFunc = function ($status,$color){
            if ($status == 'failed') {
                return "<span style='color: $color'>$status</span>";
            }
            return $status;
        };
//        foreach ($resultArr as &$product){
//
//            $product['status']=$colorizeFunc($product['status'],'red');
//    }
        return array_map (function ($order) use ($colorizeFunc){
            $order['status']= $colorizeFunc($order['status'],'green');
            return $order;

        },  $resultArr);


    }
public function getBookIdByName ($bookIds,$bookNames)
{
    $bookIds = explode(',',$bookIds);
    $bookNames = explode(',',$bookNames);
    return array_combine($bookIds,$bookNames);
}


}
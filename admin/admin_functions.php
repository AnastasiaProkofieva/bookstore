<?php
require '../functions.php';

function getPendingOrders()
{
    $sql = "select COUNT(1) FROM `order` WHERE status='pending'";
    $pdo=getPDO();
    $stmt=$pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_COLUMN);
}
function getTotalEarnings()
{
    $sql = "SELECT SUM(amount) from `order`WHERE status='success'";
    $pdo=getPDO();
    $stmt=$pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_COLUMN);
}
function getEarningsLastMonth()
{
    $sql = "SELECT month(added_at) mnth, sum(amount) totalSum from `order` group by mnth order by mnth desc limit 1";
    $pdo=getPDO();
    $stmt=$pdo->query($sql);
    $mnthTotal=$stmt->fetch(PDO::FETCH_ASSOC);
    return $mnthTotal['totalSum'];
}

function getBestMonthEarnings()
{
    $sql = "SELECT month(added_at) mnth, sum(amount) total from `order` WHERE status='success' group by mnth order by total desc limit 1";
    $pdo=getPDO();
    $stmt=$pdo->query($sql);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $months= [
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
    ];
    return [$months[$row['mnth']-1],$row['total']];
}
function getProductUrl(array $product)// должен быть тип array $book, переделать ордерс
{

    return "/admin/product/edit/{$product['id']}";

}
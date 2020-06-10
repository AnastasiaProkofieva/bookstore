<?php
// HTTP
require 'functions.php';
//var_dump(base64_decode($_POST['data']));

if (!empty($_POST['data'])) {
    session_start();
    list($orderId, $status) = updateOrder($_POST['data']);
    if ($status == 'success') {
        setcookie('cart', '', time() - 60);
    }
    $_SESSION['order_id'] = $orderId;

//    header('Location:/?order_id='.(int) $orderId);
    header('Location:/');
}
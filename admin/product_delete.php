<?php

require 'admin_functions.php';
require '../autoload.php';

$productService = new ProductService();
if (!empty($_GET)){
    $productService->deleteBook($_GET['id']);
}
header('Location:../admin/products.php');
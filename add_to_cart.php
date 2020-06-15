<?php
require 'functions.php';
if (!empty($_POST)){
    addToCart($_POST['id'], $_POST['count']);
}
$book = getBookById($_POST['id']);
$path = getBookUrl($book);
header('Location:' .  $path);
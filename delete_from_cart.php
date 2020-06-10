<?php
require 'functions.php';
if (!empty($_POST)) {
    deleteFromCart($_POST['id']);
    getCartItems();
}
header('Location:/cart.php');
<?php
require 'functions.php';
if (!empty($_POST)){
    addToCart($_POST['id'], $_POST['count']);
}
header('Location:/page.php?id=' . $_POST['id']);
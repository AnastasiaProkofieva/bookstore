<?php
require 'functions.php';
if (!empty($_POST['comment']) && !empty($_POST['id'])){
    addComment($_POST['comment'],$_POST['id']);
}
header("Location:/page.php?id={$_POST['id']}");
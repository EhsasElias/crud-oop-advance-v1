<?php
require 'DB.class.php';

$product = new DB();

if (isset($_GET['id']))
{
    $id = $_GET['id'];

    $product->table('products')->where("id = '$id'")->delete();

    header('Location: index.php');
}

?>
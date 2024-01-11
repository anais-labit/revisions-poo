<?php
require_once 'Product.php';
// require_once 'Category.php';

$product = new Product();
$products = $product->findAll();

var_dump($products);

<?php
require_once 'Product.php';
// require_once 'Category.php';

$product = new Product();
$product = $product->findOneById(4);

var_dump($product);

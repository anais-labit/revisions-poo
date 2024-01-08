<?php
require_once 'Product.php';

$product = new Product();
var_dump($product->getProductWithId(7));

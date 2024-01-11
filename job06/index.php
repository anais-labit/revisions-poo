<?php
// require_once 'Product.php';
require_once 'Category.php';

$category = new Category();
$category->setId(2);
$products = $category->getProducts();

var_dump($products);

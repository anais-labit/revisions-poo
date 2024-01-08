<?php
require_once 'Product.php';

$product1 = new Product(1, 't-shirt', ['https://picsum.photos/200/300'], 1000, 'A beautiful t-shirt', 10, new DateTime(), new DateTime(), 1);
$product2 = new Product();
var_dump($product1);
var_dump($product2);

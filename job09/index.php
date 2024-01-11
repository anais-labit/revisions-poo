<?php
require_once 'Product.php';

$product = new Product(1, 't-shirt', ['https://picsum.photos/200/300'], 1000, 'A beautiful t-shirt', 10, new DateTime(), new DateTime(), 2);

var_dump($product->create());


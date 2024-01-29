<?php
require_once 'Product.php';

$product = new Product(null, 't-shirt', ['https://picsum.photos/200/300'], 10, 't-shirt', 1, new DateTime(), null, 2);

$product->create();

$product->setName('t-shirt 252')->setQuantity(24);

$product->update();

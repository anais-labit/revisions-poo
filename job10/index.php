<?php
require_once 'Product.php';

$product = new Product(1, 'citrons', ['https://picsum.photos/200/300'], 10, 'citrons', 1, new DateTime(), new DateTime(), 2);

var_dump($product->create());

$product->setName('citrons')
    ->setPhotos(['https://www.jaimefruitsetlegumes.ca/fr/aliments/citron/'])
    ->setPrice(4)
    ->setDescription('citrons')
    ->setQuantity(1)
    ->setCreatedAt(new DateTime())
    ->setUpdatedAt(new DateTime())
    ->setCategoryId(2);

$product->update();

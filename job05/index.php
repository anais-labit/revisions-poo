<?php
require_once 'Product.php';

//  $product = new Product();
// var_dump($result = $product->getProductWithId(7));

// var_dump($product->getCategory());

$product_id = 7;
$dbConn = new PDO(
    "mysql:host=localhost;dbname=draft-shop",
    "anais",
    ""
);

$query = "SELECT * FROM product WHERE id = :product_id";
$statement = $dbConn->prepare($query);
$statement->bindParam(':product_id', $product_id);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
// return $result ? $result : [];

var_dump($result);
$photosUrl = json_decode($result['photos']);

$createdAt = getdate($result['createdAt']);
$updatedAt = getdate($result['updatedAt']);
var_dump($photosUrl, $updatedAt, $createdAt);

$product = new Product($result['id'], $result['name'], $photosUrl, $result['price'], $result['description'], $result['quantity'], $createdAt, $updatedAt);
var_dump($product);

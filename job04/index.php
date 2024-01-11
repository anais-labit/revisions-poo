<?php
require_once 'Product.php';

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

$photosUrl = json_decode($result['photos'], true);

$createdAt = new DateTime($result['createdAt']);
$updatedAt = new DateTime($result['updatedAt']);

$product = new Product($result['id'], $result['name'], $photosUrl, $result['price'], $result['description'], $result['quantity'], $createdAt, $updatedAt);
var_dump($product);

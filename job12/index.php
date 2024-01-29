<?php
require_once 'Clothing.php';

$newClothing = new Clothing(
    null,
    'Pull 28',
    ['https://picsum.photos/200/300'],
    30,
    'Pull femme',
    1,
    new DateTime(),
    null,
    1,
    'XL',
    'Rouge',
    'pull',
    10);

$newClothing->create();

$newClothing->setColor('Bleu')->setMaterial_fee(24);

var_dump($newClothing->update());
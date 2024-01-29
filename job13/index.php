<?php
require_once 'Clothing.php';
require_once 'Electronic.php';

$newClothing = new Clothing(
    null,
    'Pull ',
    ['https://picsum.photos/200/300'],
    30,
    'Pull femme',
    1,
    new DateTime(),
    null,
    2,
    'XL',
    'Rouge',
    'pull',
    10
);

$newClothing->create();

$newClothing->setColor('Bleu')->setMaterial_fee(24);

var_dump($newClothing->update());

$newElectronic = new Electronic(
    null,
    'Ordinateur',
    ['https://picsum.photos/200/300'],
    600,
    'Ordinateur portable',
    1,
    new DateTime(),
    null,
    1,
    'Lenovo',
    100
);

$newElectronic->create();

$newElectronic->setBrand('Samsung');

var_dump($newElectronic->update());

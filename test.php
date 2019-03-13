<?php

include_once "Comparator.php";
include_once "vendor/autoload.php";


$bench = new Ubench;

$bench->start();

$test = new Comparator();
$test->check();

$bench->end();

print("Time: " . $bench->getTime() . "\n");

<?php
header('Content-Type: application/json');
include 'autoload.php';
$api = new BreweryApi();
echo $api->getRandomBeer();
die();
?>
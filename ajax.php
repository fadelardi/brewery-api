<?php
header('Content-Type: application/json');
include 'autoload.php';
$api = new BreweryApi();
switch($_GET['type']) {
	case 'brewery':
		echo $api->getRandomBeerFromBrewery($_GET['bid']);
		break;
	case 'beer':
		echo $api->getRandomBeer();
		break;
	default: 
		echo json_encode(['status' => 'failure']);
}
die();
?>
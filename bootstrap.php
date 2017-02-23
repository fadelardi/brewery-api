<?php
session_start();
include 'autoload.php';

$api = new BreweryApi();

$results = false;
$action = isset($_GET['action']) ? $_GET['action'] : false;

switch($action) {
	case 'More from this Brewery':
		$randomBeer = ['data' => ['name' => 'kek', 'description' => 'topkek'] ];
		// $randomBeer = json_decode($api->getRandomBeerFromBrewery($_GET['bid']), true);
		$_SESSION['random_beer'] = $randomBeer;
		$bid = $_GET['bid'];
		break;
	case 'Search':
		$query = $_GET['query'];
		$type = $_GET['type'];
		$results = json_decode($api->search($query, $type), true);
		$randomBeer = $_SESSION['random_beer'];
		break;
	default:
		$randomBeer = ['data' => ['name' => 'kek', 'description' => 'topkek'] ];
		$randomBeer = json_decode($api->getRandomBeer(), true);
		$_SESSION['random_beer'] = $randomBeer;
		$bid = isset($randomBeer['data']['breweries'][0]['id']) ? $randomBeer['data']['breweries'][0]['id'] : 0;
}
?>
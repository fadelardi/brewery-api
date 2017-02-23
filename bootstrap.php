<?php
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$api = new BreweryApi();

$results = false;
$action = isset($_GET['action']) ? $_GET['action'] : false;
die('topkek');
switch($action) {
	case 'More from this Brewery':
		// $randomBeer = ['data' => ['name' => 'kek', 'description' => 'topkek'] ];
		$randomBeer = json_decode($api->getRandomBeerFromBrewery($_GET['bid']), true);
		$bid = $_GET['bid'];
		break;
	case 'Search':
		$query = $_GET['query'];
		$type = $_GET['type'];
		$results = json_decode($api->search($query, $type), true);
	default:
		// $randomBeer = ['data' => ['name' => 'kek', 'description' => 'topkek'] ];
		$randomBeer = json_decode($api->getRandomBeer(), true);
		$bid = isset($randomBeer['data']['breweries'][0]['id']) ? $randomBeer['data']['breweries'][0]['id'] : 0;
}
?>
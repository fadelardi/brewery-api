<?php 
include 'Api.php';

class BreweryApi extends Api
{
	protected $baseUrl = 'http://api.brewerydb.com/v2/';
	const KEY = 'e5ec2463c715bece8e5d129eb14c41e6';
	const RANDOM_BEER_ENDPOINT = 'beer/random';

	public function getRandomBeer()
	{
		return $this->get(self::RANDOM_BEER_ENDPOINT . $this->getKey());
	}

	public function getRandomBeerFromBrewery($bId) 
	{

	}

	public function search()
	{

	}

	private function getKey() {
		return '?key=' . self::KEY;
	}
}
?>
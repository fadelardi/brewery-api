<?php 
include 'Api.php';

class BreweryApi extends Api
{
	protected $baseUrl = 'http://api.brewerydb.com/v2/';
	const KEY = 'e5ec2463c715bece8e5d129eb14c41e6';
	const RANDOM_BEER_ENDPOINT = 'beer/random';
	const BREWERY_BEERS_ENDPOINT = 'brewery/:bid/beers';

	public function getRandomBeer()
	{
		return $this->get(self::RANDOM_BEER_ENDPOINT . $this->getKey());
	}

	public function getRandomBeerFromBrewery($bId) 
	{
		$allBeersFromBrewer = $this->get(str_replace(':bid', $bId, self::BREWERY_BEERS_ENDPOINT) . $this->getKey());
		$allBeersFromBrewer = json_decode($allBeersFromBrewer, true);
		if ($allBeersFromBrewer && $allBeersFromBrewer['status'] == 'success') {
			$totalBeersCount = count($allBeersFromBrewer['data']);
			if ($totalBeersCount <= 0) {
				return json_encode(['status => failure']);
			}
			$randomBeer = rand(0, $totalBeersCount -1);
			$randomBeerResponse = [
				"status" => "success",
				"data" => $allBeersFromBrewer['data'][$randomBeer]
			];
			return json_encode($randomBeerResponse);
		} else {
			return json_encode(['status' => 'failure']);
		}
	}

	public function search($query, $type='')
	{

	}

	private function getKey() {
		return '?key=' . self::KEY;
	}
}
?>
<?php 
/*
	So this is where most of the PHP magic happens.
	Basically: a wrapper for the Brewery API, with some 
	additionaly logic.

	Note that your API key needs to be put in here (I know, 
	why didn't I make a centralized file with this...? Then again,
	it's only one value)
*/
class BreweryApi extends Api
{
	// the url of the Brewery API
	protected $baseUrl = 'http://api.brewerydb.com/v2/';
	// variable used for getRandomBeer, i.e. a loop count
	protected $randomBeerRetryCount = 0;
	/*
		getRandomBeer is a recursive function. And this is 
		the maximum number of times it'll retry to search 
		for a beer that matches the criteria until it gives up
	*/
	const MAX_RETRY_NUMBER = 15;

	const KEY = 'e5ec2463c715bece8e5d129eb14c41e6'; // key #1
	// const KEY = 'eedf1c95079871724da82d9d72e83793'; // key #2
	// And some endpoints...
	const RANDOM_BEER_ENDPOINT = 'beer/random';
	const BREWERY_BEERS_ENDPOINT = 'brewery/:bid/beers';
	const SEARCH_ENDPOINT = 'search';

	// get a random beer
	public function getRandomBeer()
	{
		// the "break" of our potentially infinite loop
		if ($this->randomBeerRetryCount > self::MAX_RETRY_NUMBER) {
			$this->randomBeerRetryCount = 0;
			return json_encode(['status' => 'failure']);
		}

		$res = $this->get(self::RANDOM_BEER_ENDPOINT . $this->getKey() . '&withBreweries=Y&hasLabels=Y');
		$res = json_decode($res, true);
		if ($res && $res['status'] == 'success') {
			$data = $res['data'];
			
			// Here is the recursive logic: if a beer has no description or label, try again
			if (!isset($data['description']) || empty($data['description']) || !isset($data['labels']['icon']) || empty($data['labels']['icon'])) {
				$this->randomBeerRetryCount++;
				return $this->getRandomBeer();
			}
		}

		return json_encode($res);
	}

	/*
		there is no endpoint to this automagically, so in order to get all 
		a random beer from a specific brewery, we have to this manually
	*/
	public function getRandomBeerFromBrewery($bId) 
	{
		// first, let's get ALL the beers from that brewery
		$allBeersFromBrewery = $this->get(str_replace(':bid', $bId, self::BREWERY_BEERS_ENDPOINT) . $this->getKey());
		$allBeersFromBrewery = json_decode($allBeersFromBrewery, true);
		if ($allBeersFromBrewery && $allBeersFromBrewery['status'] == 'success') {
			// next, let's remove all those that don't match the required criteria from the array
			$allBeersFromBrewery['data'] = $this->sanitizeBeerArray($allBeersFromBrewery['data']);
			$totalBeersCount = count($allBeersFromBrewery['data']);
			if ($totalBeersCount > 0) {
				// finally, let's grab a random one
				$randomBeer = rand(0, $totalBeersCount -1);
				$randomBeerResponse = [
					"status" => "success",
					"data" => $allBeersFromBrewery['data'][$randomBeer]
				];

				return json_encode($randomBeerResponse);
			}
		} 
		
		return json_encode(['status' => 'failure']);
	}

	// pretty straightforward, unlike previous methods.
	public function search($query, $type)
	{
		if ($this->validQuery($query) && $this->validType($type)) {
			return $this->get(self::SEARCH_ENDPOINT . $this->getKey() . '&q=' . urlencode($query) . '&type=' . urlencode($type));
		}

		return json_encode(['status' => 'failure']);
	}

	// helper function for getRandomBeerFromBrewery
	private function sanitizeBeerArray($arr) 
	{
		if (!is_array($arr)) return [];
		foreach ($arr as $key => $beer) {
			if (!isset($beer['description']) || empty($beer['description']) || !isset($beer['labels']['icon']) || empty($beer['labels']['icon'])) {
				unset($arr[$key]);
			}
		}
		// unfortunately unset does not remove the index
		return array_values($arr);
	}

	// regex for: letters, numbers, dashes and spaces
	private function validQuery($query)
	{
		return preg_match('/^[A-Za-z0-9-\s]+$/', $query) === 1;
	}

	private function validType($type) {
		$validTypes = ['beer', 'brewery'];
		return in_array($type, $validTypes);
	}

	private function getKey() {
		return '?key=' . self::KEY;
	}
}
?>
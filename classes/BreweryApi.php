<?php 
class BreweryApi extends Api
{
	protected $baseUrl = 'http://api.brewerydb.com/v2/';
	protected $randomBeerRetryCount = 0;
	const MAX_RETRY_NUMBER = 15;
	const KEY = 'e5ec2463c715bece8e5d129eb14c41e6'; // key #1
	// const KEY = 'eedf1c95079871724da82d9d72e83793'; // key #2
	const RANDOM_BEER_ENDPOINT = 'beer/random';
	const BREWERY_BEERS_ENDPOINT = 'brewery/:bid/beers';
	const SEARCH_ENDPOINT = 'search';

	public function getRandomBeer()
	{
		if ($this->randomBeerRetryCount > self::MAX_RETRY_NUMBER) {
			$this->randomBeerRetryCount = 0;
			return json_encode(['status' => 'failure']);
		}

		$res = $this->get(self::RANDOM_BEER_ENDPOINT . $this->getKey() . '&withBreweries=Y&hasLabels=Y');
		$res = json_decode($res, true);
		if ($res && $res['status'] == 'success') {
			$data = $res['data'];
			if (!isset($data['description']) || empty($data['description']) || !isset($data['labels']['icon']) || empty($data['labels']['icon'])) {
				$this->randomBeerRetryCount++;
				return $this->getRandomBeer();
			}
		}

		return json_encode($res);
	}

	public function getRandomBeerFromBrewery($bId) 
	{
		$allBeersFromBrewery = $this->get(str_replace(':bid', $bId, self::BREWERY_BEERS_ENDPOINT) . $this->getKey());
		$allBeersFromBrewery = json_decode($allBeersFromBrewery, true);
		if ($allBeersFromBrewery && $allBeersFromBrewery['status'] == 'success') {
			$allBeersFromBrewery['data'] = $this->sanitizeBeerArray($allBeersFromBrewery['data']);
			$totalBeersCount = count($allBeersFromBrewery['data']);
			if ($totalBeersCount > 0) {
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

	public function search($query, $type)
	{
		if ($this->validQuery($query) && $this->validType($type)) {
			return $this->get(self::SEARCH_ENDPOINT . $this->getKey() . '&q=' . urlencode($query) . '&type=' . urlencode($type));
		}

		return json_encode(['status' => 'failure']);
	}

	private function sanitizeBeerArray($arr) 
	{
		if (!is_array($arr)) return [];
		foreach ($arr as $key => $beer) {
			if (!isset($beer['description']) || empty($beer['description']) || !isset($beer['labels']['icon']) || empty($beer['labels']['icon'])) {
				unset($arr[$key]);
			}
		}
		return array_values($arr);
	}

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
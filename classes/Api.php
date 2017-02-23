<?php
/*
	Base API class. A wrapper for curl as it stands.
*/
class Api
{
	protected $baseUrl;

	public function __construct()
	{
		if (empty($this->baseUrl)) {
			throw new Exception('An URL must be defined for your API');
		}
	}

	public function get($endpoint)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}	

	public function post() 
	{
		/* implement post */
	}	
}
?>
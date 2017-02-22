<?php
class Api
{
	protected $url;

	public function __construct()
	{
		if (empty($this->url)) {
			throw new Exception('An URL must be defined for your API');
		}
	}

	public function get()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
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
<?php
use PHPUnit\Framework\TestCase;

include('classes/BreweryApi.php');

class BreweryApiTest extends TestCase
{
	const VALID_TYPES = ['beer', 'brewery'];
	const VALID_STRINGS = [
			'123test-',
			'23 dsfasdfds',
			'lalalala ',
			'q1 q2 q3'
		];
	const ERROR_RESPONSE = ['status' => 'failure'];

	/*
		According to theory one should not test private/protected methods, and 
		should instead test these method through publicly exposed methods. 
		At the end you'll find a test that adheres to this school of 
		thought. The following tests do quite the opposite. 
	*/
	protected static function getMethod($name) {
		$class = new ReflectionClass('BreweryApi');
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method;
	}

	public function testValidType() {
		$method = self::getMethod('validType');
		$api = new BreweryApi();

		foreach(self::VALID_TYPES as $type) {
			$this->assertTrue($method->invokeArgs($api, [$type]));
		}
	}

	public function testValidQuery() {
		$method = self::getMethod('validQuery');
		$api = new BreweryApi();
	
		foreach(self::VALID_STRINGS as $string) {
			$this->assertTrue($method->invokeArgs($api, [$string]));
		}
	}

	public function testSearch() {
		$api = new BreweryApi();
		$invalidStrings = ['##', '@^%'];
		foreach($invalidStrings as $string) {
			$this->assertEquals($api->search($string, self::VALID_TYPES[0]), json_encode(self::ERROR_RESPONSE));
		}

		$invalidTypes = ['something', 'something-else'];
		foreach($invalidTypes as $type) {
			$this->assertEquals($api->search(self::VALID_STRINGS[0], $type), json_encode(self::ERROR_RESPONSE));
		}

	}
}
?>
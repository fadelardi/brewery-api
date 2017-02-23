<?php
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase 
{
	public function testException() {
		$this->setExpectedException('Exception');
		$this->expectException(new Api());
	}
}
?>
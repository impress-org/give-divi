<?php

use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase {

	public function testTrue() {
		$this->assertEquals( true, true );
	}

	public function testDiviVersion() {
		$this->assertEquals( ET_BUILDER_PLUGIN_VERSION, '4.5.3' );
	}

	public function testGiveVersion() {
		$this->assertEquals( GIVE_VERSION, '2.9.5' );
	}

}

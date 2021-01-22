<?php

use PHPUnit\Framework\TestCase;

final class ShortcodeBuilderHelperTest extends TestCase {

	public function testShortcodeBuilder() {
		// Define reference shortcode
		$shortcode = '[test_shortcode id="1" display_style="onpage" show_title="true" show_goal="true"]';

		$attributes1 = [
			'id'            => 1,
			'display_style' => "onpage",
			'show_title'    => true,
			'show_goal'     => true,
		];

		$attributes2 = [
			'id'            => 1,
			'display_style' => "onpage",
			'show_title'    => true,
			'show_goal'     => false, // different
		];

		$generated1 = generate_shortcode( 'test_shortcode', $attributes1 );
		$generated2 = generate_shortcode( 'test_shortcode', $attributes2 );

		$this->assertEquals( $shortcode, $generated1 );
		$this->assertNotEquals( $shortcode, $generated2 );
	}
}

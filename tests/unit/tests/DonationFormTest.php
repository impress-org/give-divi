<?php

use PHPUnit\Framework\TestCase;
use GiveDivi\Divi\Repositories\Forms;
use GiveDivi\Divi\Modules\DonationForm\Module as DonationFormModule;

final class DonationFormTest extends TestCase {

	public function testShortcodeOutput() {
		$module = new DonationFormModule( new Forms );

		$class  = new \ReflectionClass( $module );
		$method = $class->getMethod( 'render' );

		$attributes = [
			'id'            => 1,
			'display_style' => 'onpage',
			'show_title'    => true,
			'show_goal'     => true,
		];

		// Generate shortcode
		$shortcode = generate_shortcode( 'give_form', $attributes );

		$this->expectOutputString(
			do_shortcode( $shortcode )
		);

		echo $method->invokeArgs( $module, [ $attributes, null, '' ] );
	}

}

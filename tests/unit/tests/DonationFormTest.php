<?php

use PHPUnit\Framework\TestCase;
use GiveDivi\Divi\Repositories\Forms;
use GiveDivi\Divi\Modules\DonationForm\Module as DonationFormModule;

use Give\TestData\Repositories\DonationFormRepository;

final class DonationFormTest extends TestCase {

	public function testShortcodeOutput() {

		// Setup Donation forms
		$donationFormRepository = give( DonationFormRepository::class );

		$forms = [
			[
				'post_title'     => 'Legacy Form',
				'post_name'      => 'legacy-form',
				'post_author'    => 1,
				'post_date'      => date( 'Y-m-d H:i:s' ),
				'donation_goal'  => false,
				'donation_terms' => [],
				'form_template'  => 'legacy',
				'random_amount'  => '10.00',
			],
			[
				'post_title'     => 'Multi-step Form',
				'post_name'      => 'multi-step-form',
				'post_author'    => 1,
				'post_date'      => date( 'Y-m-d H:i:s' ),
				'donation_goal'  => false,
				'donation_terms' => [],
				'form_template'  => 'sequoia',
				'random_amount'  => '20.00',
			],
		];

		foreach ( $forms as $form ) {
			$donationFormRepository->insertDonationForm( $form );
		}

		$module = new DonationFormModule( new Forms );

		$class  = new \ReflectionClass( $module );
		$method = $class->getMethod( 'render' );

		// Get inserted donation forms
		$donationForms = get_posts( [
			'post_type' => 'give_forms',
			'fields'    => 'id'
		] );

		$_SERVER['QUERY_STRING'] = '';

		foreach ( $donationForms as $form ) {
			$attributes = [
				'id'            => $form->ID,
				'display_style' => 'onpage',
				'show_title'    => true,
				'show_goal'     => true,
			];

			$shortcode = sprintf( '[give_form id="%s" display_style="onpage" show_title="true" show_goal="true"]', $form->ID );

			$this->assertEquals(
				do_shortcode( $shortcode ),
				$method->invokeArgs( $module, [ $attributes, null, '' ] )
			);

		}
	}

}

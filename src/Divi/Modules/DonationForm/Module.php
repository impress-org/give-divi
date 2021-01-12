<?php

namespace GiveDivi\Divi\Modules\DonationForm;

class Module extends \ET_Builder_Module {

	public $slug       = 'donation_form';
	public $vb_support = 'on';

	protected $module_credits = [
		'module_uri' => '',
		'author'     => '',
		'author_uri' => '',
	];

	public function init() {
		$this->name = esc_html__( 'Give Donation Form', 'give-divi' );
	}

	public function get_fields() {
		return [
			'donationFormId'      => [
				'label'   => esc_html__( 'Select Donation form', 'give-divi' ),
				'type'    => 'select',
				'options' => $this->getDonationForms(),
			],
			'donationFormFormat'  => [
				'label'   => esc_html__( 'Donation form format', 'give-divi' ),
				'type'    => 'select',
				'options' => $this->getDonationFormFormats(),
				'default' => 'onpage',
			],
			'displayFormTitle'    => [
				'label'   => esc_html__( 'Display form title', 'give-divi' ),
				'type'    => 'yes_no_button',
				'options' => [ 'off', 'on' ],
				'default' => 'on',
			],
			'displayDonationGoal' => [
				'label'   => esc_html__( 'Display Donation goal', 'give-divi' ),
				'type'    => 'yes_no_button',
				'options' => [ 'off', 'on' ],
				'default' => 'on',
			],
		];
	}

	public function render( $attrs, $content = null, $render_slug ) {
		return sprintf( '<h1>%1$s</h1>', $this->props['donationFormId'] );
	}

	/**
	 * Get donation forms
	 *
	 * @return array
	 */
	private function getDonationForms() {
		$forms = [];

		$forms_query = new \Give_Forms_Query(
			[
				'number'      => - 1,
				'post_status' => 'publish',
			]
		);

		$result = $forms_query->get_forms();

		foreach ( $result as $form ) {
			$forms[ $form->ID ] = $form->post_title;
		}

		return $forms;
	}

	private function getDonationFormFormats() {
		return [
			'onpage' => esc_html__( 'Full form', 'give-divi' ),
			'modal'  => esc_html__( 'Modal', 'give-divi' ),
			'reveal' => esc_html__( 'Reveal', 'give-divi' ),
			'button' => esc_html__( 'One Button Launch', 'give-divi' ),
		];
	}
}

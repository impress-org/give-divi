<?php

namespace GiveDivi\Divi\Modules\DonationForm;

class Module extends \ET_Builder_Module {

	public $slug       = 'give_donation_form';
	public $vb_support = 'on';

	protected $module_credits = [
		'module_uri' => '',
		'author'     => 'GiveWp',
		'author_uri' => 'https://givewp.com',
	];

	public function init() {
		$this->name = esc_html__( 'Give Donation Form', 'give-divi' );
	}

	/**
	 * Get module fields
	 *
	 * @return array[]
	 */
	public function get_fields() {
		$donationForms     = $this->getDonationForms();
		$donationFormsKeys = array_map( 'strval', array_keys( $donationForms ) ); // Divi builder module requires array values to be a string

		return [
			'id'           => [
				'label'           => esc_html__( 'Select Donation form', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [ esc_html__( 'Select form', 'give-divi' ) ] + $donationForms,
			],
			'displayStyle' => [
				'label'           => esc_html__( 'Donation form format', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => $this->getDonationFormFormats(),
				'default'         => 'onpage',
				'show_if'         => [
					'id' => $donationFormsKeys,
				],
			],
			'showTitle'    => [
				'label'           => esc_html__( 'Display form title', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
				'show_if'         => [
					'id' => $donationFormsKeys,
				],
			],
			'showGoal'     => [
				'label'           => esc_html__( 'Display Donation goal', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
				'show_if'         => [
					'id' => $donationFormsKeys,
				],
			],
		];
	}

	/**
	 * Render donation form
	 *
	 * @param  array  $attrs
	 * @param  null  $content
	 * @param  string  $render_slug
	 *
	 * @return string|void
	 * @since 1.0.0
	 */
	public function render( $attrs, $content = null, $render_slug ) {
		if ( ! boolval( $attrs['id'] ) ) {
			return;
		}

		$atts = [
			'id'            => $attrs['id'],
			'display_style' => isset( $attrs['displaystyle'] ) ? $attrs['displaystyle'] : 'onpage',
			'show_title'    => isset( $attrs['showtitle'] ) ? filter_var( $attrs['showtitle'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_goal'     => isset( $attrs['showgoal'] ) ? filter_var( $attrs['showgoal'], FILTER_VALIDATE_BOOLEAN ) : true,
		];

		return give_form_shortcode( $atts );
	}

	/**
	 * Get donation forms
	 *
	 * @return array
	 * @since 1.0.0
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

	/**
	 * Get Donation form formats
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function getDonationFormFormats() {
		return [
			'onpage' => esc_html__( 'Full form', 'give-divi' ),
			'modal'  => esc_html__( 'Modal', 'give-divi' ),
			'reveal' => esc_html__( 'Reveal', 'give-divi' ),
			'button' => esc_html__( 'One Button Launch', 'give-divi' ),
		];
	}
}

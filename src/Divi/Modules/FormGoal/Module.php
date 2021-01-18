<?php

namespace GiveDivi\Divi\Modules\FormGoal;

use GiveDivi\Divi\Repositories\Forms;

class Module extends \ET_Builder_Module {
	/**
	 * @var string
	 */
	public $slug;

	/**
	 * @var string
	 */
	public $vb_support;

	/**
	 * @var string[]
	 */
	protected $module_credits;

	/**
	 * @var Forms
	 */
	private $forms;

	/**
	 * Module constructor.
	 *
	 * @param  Forms  $forms
	 */
	public function __construct( Forms $forms ) {
		$this->forms          = $forms;
		$this->slug           = 'give_form_goal';
		$this->vb_support     = 'on';
		$this->module_credits = [
			'module_uri' => '',
			'author'     => 'GiveWp',
			'author_uri' => 'https://givewp.com',
		];

		parent::__construct();
	}

	public function init() {
		$this->name = esc_html__( 'Give Form Goal', 'give-divi' );
	}

	/**
	 * Get module fields
	 *
	 * @return array[]
	 */
	public function get_fields() {
		$donationForms     = $this->forms->getAll();
		$donationFormsKeys = array_map( 'strval', array_keys( $donationForms ) );

		return [
			'id'   => [
				'label'           => esc_html__( 'Select Donation form', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [ esc_html__( 'Select form', 'give-divi' ) ] + $donationForms,
			],
			'text' => [
				'label'           => esc_html__( 'Show text', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
				'show_if'         => [
					'id' => $donationFormsKeys,
				],
			],
			'bar'  => [
				'label'           => esc_html__( 'Show bar', 'give-divi' ),
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
	 * Render form goal
	 *
	 * @param  array  $attrs
	 * @param  null  $content
	 * @param  string  $render_slug
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function render( $attrs, $content = null, $render_slug ) {
		$attributes = [
			'id'        => $attrs['id'],
			'show_text' => isset( $attrs['text'] ) ? filter_var( $attrs['text'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_bar'  => isset( $attrs['bar'] ) ? filter_var( $attrs['bar'], FILTER_VALIDATE_BOOLEAN ) : true,
		];

		return give_goal_shortcode( $attributes );
	}
}

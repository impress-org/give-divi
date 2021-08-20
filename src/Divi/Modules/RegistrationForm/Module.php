<?php

namespace GiveDivi\Divi\Modules\RegistrationForm;

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
		$this->slug           = 'give_registration_form';
		$this->vb_support     = 'on';
		$this->module_credits = [
			'module_uri' => '',
			'author'     => 'GiveWP',
			'author_uri' => 'https://givewp.com',
		];

		parent::__construct();
	}

	public function init() {
		$this->name = esc_html__( 'Give Registration Form', 'give-divi' );
	}

	/**
	 * Get module fields
	 *
	 * @return array[]
	 */
	public function get_fields() {
		return [
			'active'   => [
				'label'           => esc_html__( 'Redirect', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'off',
			],
			'redirect' => [
				'label'           => esc_html__( 'Redirect URL', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
				'show_if'         => [
					'active' => 'on',
				],
			],
		];
	}

	/**
	 * Render Registration form
	 *
	 * @param  array  $attrs
	 * @param  null  $content
	 * @param  string  $render_slug
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function render( $attrs, $content = null, $render_slug ) {
		$redirect = ( isset( $attrs['active'], $attrs['redirect'] ) && boolval( $attrs['active'] ) )
			? esc_url( $attrs['url'] )
			: '';

		return $this->forms->renderRegistrationForm( $redirect );
	}
}

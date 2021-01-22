<?php

namespace GiveDivi\Divi\Modules\DonationReceipt;

use GiveDivi\Divi\Repositories\Donation;

class Module extends \ET_Builder_Module {

	public $slug;
	public $vb_support;

	protected $module_credits;

	/**
	 * @var Donation
	 */
	private $donation;

	/**
	 * Module constructor.
	 *
	 * @param  Donation  $donation
	 */
	public function __construct( Donation $donation ) {
		$this->donation       = $donation;
		$this->slug           = 'give_donation_receipt';
		$this->vb_support     = 'on';
		$this->module_credits = [
			'module_uri' => '',
			'author'     => 'GiveWp',
			'author_uri' => 'https://givewp.com',
		];

		parent::__construct();
	}

	public function init() {
		$this->name = esc_html__( 'Give Donation Receipt', 'give-divi' );
	}

	/**
	 * Get module fields
	 *
	 * @return array[]
	 */
	public function get_fields() {
		return [
			'donation_id'    => [
				'label'           => 'Donation ID',
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => $this->donation->getLastDonationId( get_current_user_id() ),
				'show_if'         => [
					'donor' => 'none', // always hidden
				],
			],
			'pretty_urls'    => [
				'label'           => 'Pretty URLs',
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => ! empty( get_option( 'permalink_structure' ) ) ? 'on' : 'off',
				'show_if'         => [
					'donor' => 'none', // always hidden
				],
			],
			'donor'          => [
				'label'           => esc_html__( 'Display donor', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'price'          => [
				'label'           => esc_html__( 'Display total', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'date'           => [
				'label'           => esc_html__( 'Display date', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'payment_method' => [
				'label'           => esc_html__( 'Display payment method', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'payment_id'     => [
				'label'           => esc_html__( 'Display payment method', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'payment_status' => [
				'label'           => esc_html__( 'Display payment status', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'off',
			],
			'company_name'   => [
				'label'           => esc_html__( 'Display company name', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'off',
			],
			'status_notice'  => [
				'label'           => esc_html__( 'Display status notice', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'error'          => [
				'label'           => esc_html__( 'Error notice text', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => esc_html__( 'You are missing the donation id to view this donation receipt.', 'give-divi' ),
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
		$attributes = [
			'donor'          => isset( $attrs['donor'] ) ? filter_var( $attrs['donor'], FILTER_VALIDATE_BOOLEAN ) : true,
			'price'          => isset( $attrs['price'] ) ? filter_var( $attrs['price'], FILTER_VALIDATE_BOOLEAN ) : true,
			'date'           => isset( $attrs['date'] ) ? filter_var( $attrs['date'], FILTER_VALIDATE_BOOLEAN ) : true,
			'payment_method' => isset( $attrs['payment_method'] ) ? filter_var( $attrs['payment_method'], FILTER_VALIDATE_BOOLEAN ) : true,
			'payment_id'     => isset( $attrs['payment_id'] ) ? filter_var( $attrs['payment_id'], FILTER_VALIDATE_BOOLEAN ) : true,
			'payment_status' => isset( $attrs['payment_status'] ) ? filter_var( $attrs['payment_status'], FILTER_VALIDATE_BOOLEAN ) : false,
			'company_name'   => isset( $attrs['company_name'] ) ? filter_var( $attrs['company_name'], FILTER_VALIDATE_BOOLEAN ) : false,
			'status_notice'  => isset( $attrs['status_notice'] ) ? filter_var( $attrs['status_notice'], FILTER_VALIDATE_BOOLEAN ) : true,
			'error'          => isset( $attrs['error'] ) ? esc_attr( $attrs['error'] ) : '',
		];

		return  give_receipt_shortcode( $attributes );
	}

}

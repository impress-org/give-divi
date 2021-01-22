<?php

namespace GiveDivi\Divi\Modules\SubscriptionsTable;

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
	 * Module constructor.
	 */
	public function __construct() {
		$this->slug           = 'give_subscription_table';
		$this->vb_support     = 'on';
		$this->module_credits = [
			'module_uri' => '',
			'author'     => 'GiveWp',
			'author_uri' => 'https://givewp.com',
		];

		parent::__construct();
	}

	public function init() {
		$this->name = esc_html__( 'Give Subscriptions Table', 'give-divi' );
	}

	/**
	 * Get module fields
	 *
	 * @return array[]
	 */
	public function get_fields() {
		return [
			'show_status'            => [
				'label'           => esc_html__( 'Show Status', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'show_renewal_date'      => [
				'label'           => esc_html__( 'Show Renewal Date', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'show_progress'          => [
				'label'           => esc_html__( 'Show Progress', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'off',
			],
			'show_start_date'        => [
				'label'           => esc_html__( 'Show Start Date', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'off',
			],
			'show_end_date'          => [
				'label'           => esc_html__( 'Show End Date', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'off',
			],
			'subscriptions_per_page' => [
				'label'           => esc_html__( 'Show Subscriptions per page', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '16',
			],
			'pagination_type'        => [
				'label'           => esc_html__( 'Pagination Type', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					'next_and_previous' => esc_html__( 'Displays Previous and Next buttons', 'give-divi' ),
					'numbered'          => esc_html__( 'Displays numbered links to page', 'give-divi' ),
				],
				'default'         => 'next_and_previous',
			],
		];
	}

	/**
	 * Render Subscriptions Table
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
			'show_status'            => isset( $attrs['show_status'] ) ? filter_var( $attrs['show_status'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_renewal_date'      => isset( $attrs['show_renewal_date'] ) ? filter_var( $attrs['show_renewal_date'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_progress'          => isset( $attrs['show_progress'] ) ? filter_var( $attrs['show_progress'], FILTER_VALIDATE_BOOLEAN ) : false,
			'show_start_date'        => isset( $attrs['show_start_date'] ) ? filter_var( $attrs['show_start_date'], FILTER_VALIDATE_BOOLEAN ) : false,
			'show_end_date'          => isset( $attrs['show_end_date'] ) ? filter_var( $attrs['show_end_date'], FILTER_VALIDATE_BOOLEAN ) : false,
			'subscriptions_per_page' => isset( $attrs['subscriptions_per_page'] ) ? (int) $attrs['subscriptions_per_page'] : 16,
			'pagination_type'        => isset( $attrs['pagination_type'] ) ? esc_attr( $attrs['pagination_type'] ) : 'next_and_previous',
		];

		$recurringShortcodes = new \Give_Recurring_Shortcodes();

		return $recurringShortcodes->give_subscriptions( $attributes );
	}
}

<?php

namespace GiveDivi\Divi\Modules\DonorWall;

class Module extends \ET_Builder_Module {

	public $slug       = 'give_donor_wall';
	public $vb_support = 'on';

	protected $module_credits = [
		'module_uri' => '',
		'author'     => 'GiveWp',
		'author_uri' => 'https://givewp.com',
	];

	public function init() {
		$this->name = esc_html__( 'Give Donor wall', 'give-divi' );
	}

	/**
	 * Get module fields
	 *
	 * @return array[]
	 */
	public function get_fields() {
		return [
			'show'          => [
				'label'           => esc_html__( 'Donors per page', 'give-divi' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => [
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				],
				'validate_unit'   => true,
				'default'         => '12',
			],
			'ids'           => [
				'label'           => esc_html__( 'Donor IDs', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
			],
			'form'          => [
				'label'           => esc_html__( 'Form ID', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '0',
			],
			'order'         => [
				'label'           => esc_html__( 'Order By', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					'DESC' => esc_html__( 'Descending', 'give-divi' ),
					'ASC'  => esc_html__( 'Ascending', 'give-divi' ),
				],
				'default'         => 'DESC',
			],
			'orderby'       => [
				'label'           => esc_html__( 'Order', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					'donation_amount' => esc_html__( 'Donation Amount', 'give-divi' ),
					'post_date'       => esc_html__( 'Date Created', 'give-divi' ),
				],
				'default'         => 'donation_amount',
			],
			'columns'       => [
				'label'           => esc_html__( 'Columns', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					'best-fit' => esc_html__( 'Best Fit', 'give-divi' ),
					'1',
					'2',
					'3',
					'4',
				],
				'default'         => 'best-fit',
			],
			'avatarsize'    => [
				'label'           => esc_html__( 'Avatar Size', 'give-divi' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => [
					'min'  => '30',
					'max'  => '120',
					'step' => '1',
				],
				'validate_unit'   => true,
				'default'         => '60',
			],
			'avatar'        => [
				'label'           => esc_html__( 'Show Avatar', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'name'          => [
				'label'           => esc_html__( 'Show Name', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'company'       => [
				'label'           => esc_html__( 'Show Company Name', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'off',
			],
			'total'         => [
				'label'           => esc_html__( 'Show Total', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'time'          => [
				'label'           => esc_html__( 'Show Time', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'comments'      => [
				'label'           => esc_html__( 'Show Comments', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'anonymous'     => [
				'label'           => esc_html__( 'Show Anonymous', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
			],
			'withcomments'  => [
				'label'           => esc_html__( 'Only Donors with Comments', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'off',
			],
			'commentlength' => [
				'label'           => esc_html__( 'Comment Length', 'give-divi' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => [
					'min'  => '30',
					'max'  => '1000',
					'step' => '1',
				],
				'validate_unit'   => true,
				'default'         => '140',
			],
			'readtext'      => [
				'label'           => esc_html__( 'Read More Text', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
			],
			'loadtext'      => [
				'label'           => esc_html__( 'Load More Text', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
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
		$atts = [
			'id'            => $attrs['id'],
			'display_style' => isset( $attrs['style'] ) ? $attrs['style'] : 'onpage',
			'show_title'    => isset( $attrs['title'] ) ? filter_var( $attrs['title'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_goal'     => isset( $attrs['goal'] ) ? filter_var( $attrs['goal'], FILTER_VALIDATE_BOOLEAN ) : true,
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

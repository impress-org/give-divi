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
				'validate_unit'   => false,
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
				'validate_unit'   => false,
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
				'validate_unit'   => false,
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
		$attributes = [
			'donors_per_page'   => isset( $attrs['show'] ) ? (int) $attrs['show'] : 12,
			'form_id'           => isset( $attrs['form'] ) ? (int) $attrs['form'] : 0,
			'ids'               => isset( $attrs['ids'] ) ? $attrs['ids'] : '',
			'columns'           => isset( $attrs['columns'] ) ? $attrs['columns'] : 'best-fit',
			'anonymous'         => isset( $attrs['anonymous'] ) ? filter_var( $attrs['anonymous'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_avatar'       => isset( $attrs['avatar'] ) ? filter_var( $attrs['avatar'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_name'         => isset( $attrs['name'] ) ? filter_var( $attrs['name'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_company_name' => isset( $attrs['company'] ) ? filter_var( $attrs['company'], FILTER_VALIDATE_BOOLEAN ) : false,
			'show_total'        => isset( $attrs['total'] ) ? filter_var( $attrs['total'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_time'         => isset( $attrs['time'] ) ? filter_var( $attrs['time'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_comments'     => isset( $attrs['comments'] ) ? filter_var( $attrs['comments'], FILTER_VALIDATE_BOOLEAN ) : true,
			'comment_length'    => isset( $attrs['commentlength'] ) ? (int) $attrs['commentlength'] : 140,
			'only_comments'     => isset( $attrs['withcomments'] ) ? filter_var( $attrs['withcomments'], FILTER_VALIDATE_BOOLEAN ) : false,
			'readmore_text'     => isset( $attrs['readtext'] ) ? $attrs['readtext'] : esc_html__( 'Read More Text', 'give-divi' ),
			'loadmore_text'     => isset( $attrs['loadtext'] ) ? $attrs['loadtext'] : esc_html__( 'Load More Text', 'give-divi' ),
			'avatar_size'       => isset( $attrs['avatarsize'] ) ? (int) $attrs['avatarsize'] : 60,
			'orderby'           => isset( $attrs['orderby'] ) ? $attrs['orderby'] : 'donation_amount',
			'order'             => isset( $attrs['order'] ) ? $attrs['order'] : 'DESC',
		];

		$donorWall = \Give_Donor_Wall::get_instance();

		return $donorWall->render_shortcode( $attributes );
	}
}

<?php

namespace GiveDivi\Divi\Modules\Totals;

class Module extends \ET_Builder_Module {

	public $slug       = 'give_totals';
	public $vb_support = 'on';

	protected $module_credits = [
		'module_uri' => '',
		'author'     => 'GiveWp',
		'author_uri' => 'https://givewp.com',
	];

	public function init() {
		$this->name = esc_html__( 'Give Totals', 'give-divi' );
	}

	/**
	 * Get module fields
	 *
	 * @return array[]
	 */
	public function get_fields() {
		return [
			'total_goal'   => [
				'label'           => esc_html__( 'Total Goal', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
			],
			'ids'          => [
				'label'           => esc_html__( 'Donation Form IDs', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
			],
			'cats'         => [
				'label'           => esc_html__( 'Categories', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
			],
			'tags'         => [
				'label'           => esc_html__( 'Tags', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
			],
			'message'      => [
				'label'           => esc_html__( 'Message', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
			],
			'link'         => [
				'label'           => esc_html__( 'Link', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
			],
			'link_text'    => [
				'label'           => esc_html__( 'Link Text', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => esc_html__( 'Donate Now', 'give-divi' ),
			],
			'progress_bar' => [
				'label'           => esc_html__( 'Show progress bar', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
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
		$message    = apply_filters(
			'give_totals_message',
			__( 'Hey! We\'ve raised {total} of the {total_goal} we are trying to raise for this campaign!', 'give-divi' )
		);
		$attributes = [
			'total_goal'   => isset( $attrs['total_goal'] ) ? (int) $attrs['total_goal'] : 0,
			'ids'          => isset( $attrs['ids'] ) ? esc_attr( $attrs['ids'] ) : 0,
			'cats'         => isset( $attrs['cats'] ) ? esc_attr( $attrs['cats'] ) : 0,
			'tags'         => isset( $attrs['tags'] ) ? esc_attr( $attrs['tags'] ) : 0,
			'message'      => isset( $attrs['message'] ) ? esc_html( $attrs['message'] ) : $message,
			'link'         => isset( $attrs['link'] ) ? esc_url( $attrs['link'] ) : '',
			'link_text'    => isset( $attrs['link_text'] ) ? esc_html( $attrs['link_text'] ) : esc_html__( 'Donate Now', 'give-divi' ),
			'progress_bar' => isset( $attrs['anonymous'] ) ? filter_var( $attrs['anonymous'], FILTER_VALIDATE_BOOLEAN ) : true,
		];

		return give_totals_shortcode( $attributes );
	}
}

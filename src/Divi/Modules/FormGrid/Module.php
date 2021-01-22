<?php

namespace GiveDivi\Divi\Modules\FormGrid;

class Module extends \ET_Builder_Module {

	public $slug       = 'give_form_grid';
	public $vb_support = 'on';

	protected $module_credits = [
		'module_uri' => '',
		'author'     => 'GiveWp',
		'author_uri' => 'https://givewp.com',
	];

	public function init() {
		$this->name = esc_html__( 'Give Form Grid', 'give-divi' );
	}

	/**
	 * Get module fields
	 *
	 * @return array[]
	 */
	public function get_fields() {
		return [
			'forms_per_page'      => [
				'label'           => esc_html__( 'Forms per page', 'give-divi' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => [
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				],
				'default'         => '12',
				'description'     => esc_html__( 'Shows how many forms will display per page. Pagination controls will be visible if more forms exist', 'give-divi' ),
			],
			'ids'                 => [
				'label'           => esc_html__( 'Form IDs', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
				'description'     => esc_html__( 'Show forms based on ID. By default, all forms appear on the grid. A comma-separated list of form IDs will cause the grid to include only those forms, default “All Forms”', 'give-divi' ),
			],
			'exclude'             => [
				'label'           => esc_html__( 'Exclude Forms by ID', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
				'description'     => esc_html__( 'Exclude one or more forms from the grid. A comma-separated list of form IDs will cause the grid to exclude only those forms.', 'give-divi' ),
			],
			'orderby'             => [
				'label'           => esc_html__( 'Order by', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					'date'             => esc_html__( 'Date', 'give-divi' ),
					'title'            => esc_html__( 'Title', 'give-divi' ),
					'amount_donated'   => esc_html__( 'Amount Donated', 'give-divi' ),
					'number_donations' => esc_html__( 'Number Donations', 'give-divi' ),
					'menu_order'       => esc_html__( 'Menu order', 'give-divi' ),
					'closest_to_goal'  => esc_html__( 'Closest to goal', 'give-divi' ),
				],
				'default'         => 'date',
				'description'     => esc_html__( 'Choose the parameters by which the forms appear.', 'give-divi' ),
			],
			'order'               => [
				'label'           => esc_html__( 'Order', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					'DESC' => esc_html__( 'Descending', 'give-divi' ),
					'ASC'  => esc_html__( 'Ascending', 'give-divi' ),
				],
				'default'         => 'DESC',
				'description'     => esc_html__( 'Choose the order in which the donors appear, according to the Order by choice.', 'give-divi' ),
			],
			'columns'             => [
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
				'description'     => esc_html__( 'Set the number of columns you would like to display in your grid.', 'give-divi' ),
			],
			'cats'                => [
				'label'           => esc_html__( 'Categories', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
				'description'     => esc_html__( 'If you have categories enabled in GiveWP, you can list the category IDs that you want displayed in this grid. A comma-separated list of form category IDs will cause the grid to include only forms from those categories.', 'give-divi' ),
			],
			'tags'                => [
				'label'           => esc_html__( 'Tags', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => '',
				'description'     => esc_html__( 'If you have tags enabled in GiveWP, you can list the category IDs that you want displayed in this grid. A comma-separated list of form tag IDs will cause the grid to include only forms with those tags.', 'give-divi' ),
			],
			'show_title'          => [
				'label'           => esc_html__( 'Show Title', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
				'description'     => esc_html__( 'This enables/disables display of the title in the form.', 'give-divi' ),
			],
			'show_goal'           => [
				'label'           => esc_html__( 'Show Goal', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
				'description'     => esc_html__( 'This shows the progress bar of the forms, if a goal has been enabled in the form.', 'give-divi' ),
			],
			'show_excerpt'        => [
				'label'           => esc_html__( 'Show Excerpt', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
				'description'     => esc_html__( 'This enables/disables display of the form content in the form.', 'give-divi' ),
			],
			'show_featured_image' => [
				'label'           => esc_html__( 'Show Featured Image', 'give-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => [ 'off', 'on' ],
				'default'         => 'on',
				'description'     => esc_html__( 'Choose if the featured image of the form is shown.', 'give-divi' ),
			],
			'image_size'          => [
				'label'           => esc_html__( 'Featured Image Size', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					'small'  => esc_html__( 'Small', 'give-divi' ),
					'medium' => esc_html__( 'Medium', 'give-divi' ),
					'large'  => esc_html__( 'Large', 'give-divi' ),
				],
				'default'         => 'medium',
				'description'     => esc_html__( 'This sets the featured image size used within the card display based on your Media Settings. It will not change the actual card display size itself.', 'give-divi' ),
			],
			'image_height'        => [
				'label'           => esc_html__( 'Featured Image Height', 'give-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => 'auto',
				'description'     => esc_html__( 'Adjust the height of the featured image.', 'give-divi' ),
			],
			'excerpt_length'      => [
				'label'           => esc_html__( 'Excerpt Size', 'give-divi' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => [
					'min'  => '1',
					'max'  => '55',
					'step' => '1',
				],
				'validate_unit'   => true,
				'default'         => '16',
				'description'     => esc_html__( 'You can truncate the exact word-length of the excerpt displayed with this argument.', 'give-divi' ),
			],
			'style'               => [
				'label'           => esc_html__( 'Display Type', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					'modal_reveal' => esc_html__( 'Modal reveal', 'give-divi' ),
					'redirect'     => esc_html__( 'Redirect', 'give-divi' ),
				],
				'default'         => 'modal_reveal',
				'description'     => esc_html__( 'Show form as modal window or redirect to the form page.', 'give-divi' ),
			],
			'status'              => [
				'label'           => esc_html__( 'Status', 'give-divi' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => [
					''       => esc_html__( 'Select status', 'give-divi' ),
					'open'   => esc_html__( 'Open', 'give-divi' ),
					'closed' => esc_html__( 'Closed', 'give-divi' ),
				],
				'default'         => '',
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
			'forms_per_page'      => isset( $attrs['forms_per_page'] ) ? (int) $attrs['forms_per_page'] : 12,
			'ids'                 => isset( $attrs['ids'] ) ? $attrs['ids'] : '',
			'exclude'             => isset( $attrs['exclude'] ) ? $attrs['exclude'] : '',
			'orderby'             => isset( $attrs['orderby'] ) ? $attrs['orderby'] : 'date',
			'order'               => isset( $attrs['order'] ) ? $attrs['order'] : 'DESC',
			'columns'             => isset( $attrs['columns'] ) ? $attrs['columns'] : 'best-fit',
			'cats'                => isset( $attrs['cats'] ) ? $attrs['cats'] : '',
			'tags'                => isset( $attrs['tags'] ) ? $attrs['tags'] : '',
			'show_title'          => isset( $attrs['show_title'] ) ? filter_var( $attrs['show_title'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_goal'           => isset( $attrs['show_goal'] ) ? filter_var( $attrs['show_goal'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_excerpt'        => isset( $attrs['show_excerpt'] ) ? filter_var( $attrs['show_excerpt'], FILTER_VALIDATE_BOOLEAN ) : true,
			'show_featured_image' => isset( $attrs['show_featured_image'] ) ? filter_var( $attrs['show_featured_image'], FILTER_VALIDATE_BOOLEAN ) : false,
			'image_size'          => isset( $attrs['image_size'] ) ? $attrs['image_size'] : 'medium',
			'image_height'        => isset( $attrs['image_height'] ) ? $attrs['image_height'] : 'auto',
			'excerpt_length'      => isset( $attrs['excerpt_length'] ) ? (int) $attrs['excerpt_length'] : 160,
			'style'               => isset( $attrs['style'] ) ? $attrs['style'] : 'modal_reveal',
			'status'              => isset( $attrs['status'] ) ? $attrs['status'] : '',
		];

		return give_form_grid_shortcode( $attributes );
	}
}

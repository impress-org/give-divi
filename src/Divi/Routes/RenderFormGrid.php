<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderFormGrid
 * @package GiveDivi\Divi\Routes
 */
class RenderFormGrid extends Endpoint {

	/** @var string */
	protected $endpoint = 'give-divi/render-form-grid';


	/**
	 * @inheritDoc
	 */
	public function registerRoute() {
		register_rest_route(
			'give-api/v2',
			$this->endpoint,
			[
				[
					'methods'             => 'POST',
					'callback'            => [ $this, 'handleRequest' ],
					'permission_callback' => [ $this, 'permissionsCheck' ],
					'args'                => [
						'forms_per_page'      => [
							'type'     => 'integer',
							'required' => false,
							'default'  => 12,
						],
						'ids'                 => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'exclude'             => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'orderby'             => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'desc',
						],
						'order'               => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'amount',
						],
						'columns'             => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'best-fit',
						],
						'cats'                => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'tags'                => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'show_title'          => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => 'true',
						],
						'show_goal'           => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'show_excerpt'        => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'show_featured_image' => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'image_size'          => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'medium',
						],
						'image_height'        => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'auto',
						],
						'excerpt_length'      => [
							'type'     => 'integer',
							'required' => false,
							'default'  => 16,
						],
						'style'               => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'modal_reveal',
						],
						'status'              => [
							'type'     => 'string',
							'required' => false,
							'default'  => ' ',
						],
					],
				],
				'schema' => [ $this, 'getSchema' ],
			]
		);
	}

	/**
	 * @return array
	 * @since 1.0.0
	 */
	public function getSchema() {
		return [
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'give-divi',
			'type'       => 'object',
			'properties' => [
				'forms_per_page'      => [
					'type'        => 'integer',
					'description' => esc_html__( 'Forms per page', 'give-divi' ),
				],
				'ids'                 => [
					'type'        => 'string',
					'description' => esc_html__( 'Forms IDs', 'give-divi' ),
				],
				'exclude'             => [
					'type'        => 'string',
					'description' => esc_html__( 'Exclude Forms IDs', 'give-divi' ),
				],
				'orderby'             => [
					'type'        => 'string',
					'description' => esc_html__( 'Order By', 'give-divi' ),
				],
				'order'               => [
					'type'        => 'string',
					'description' => esc_html__( 'Order', 'give-divi' ),
				],
				'columns'             => [
					'type'        => 'string',
					'description' => esc_html__( 'Columns', 'give-divi' ),
				],
				'cats'                => [
					'type'        => 'string',
					'description' => esc_html__( 'Categories', 'give-divi' ),
				],
				'tags'                => [
					'type'        => 'string',
					'description' => esc_html__( 'Tags', 'give-divi' ),
				],
				'show_title'          => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Title', 'give-divi' ),
				],
				'show_goal'           => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Goal', 'give-divi' ),
				],
				'show_excerpt'        => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Excerpt', 'give-divi' ),
				],
				'show_featured_image' => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Featured Image', 'give-divi' ),
				],
				'image_size'          => [
					'type'        => 'string',
					'description' => esc_html__( 'Image Size', 'give-divi' ),
				],
				'image_height'        => [
					'type'        => 'string',
					'description' => esc_html__( 'Image Height', 'give-divi' ),
				],
				'excerpt_length'      => [
					'type'        => 'integer',
					'description' => esc_html__( 'Excerpt Length', 'give-divi' ),
				],
				'style'               => [
					'type'        => 'string',
					'description' => esc_html__( 'Display Style', 'give-divi' ),
				],
				'status'              => [
					'type'        => 'string',
					'description' => esc_html__( 'Status', 'give-divi' ),
				],
			],
		];
	}

	/**
	 * @param  WP_REST_Request  $request
	 *
	 * @return WP_REST_Response
	 * @since 1.0.0
	 */
	public function handleRequest( WP_REST_Request $request ) {
		$attributes = [
			'forms_per_page'      => $request->get_param( 'forms_per_page' ),
			'ids'                 => $request->get_param( 'ids' ),
			'exclude'             => $request->get_param( 'exclude' ),
			'orderby'             => $request->get_param( 'orderby' ),
			'order'               => $request->get_param( 'order' ),
			'columns'             => $request->get_param( 'columns' ),
			'cats'                => $request->get_param( 'cats' ),
			'tags'                => $request->get_param( 'tags' ),
			'show_title'          => $request->get_param( 'show_title' ),
			'show_goal'           => $request->get_param( 'show_goal' ),
			'show_excerpt'        => $request->get_param( 'show_excerpt' ),
			'show_featured_image' => $request->get_param( 'show_featured_image' ),
			'image_size'          => $request->get_param( 'image_size' ),
			'image_height'        => $request->get_param( 'image_height' ),
			'excerpt_length'      => $request->get_param( 'excerpt_length' ),
			'style'               => $request->get_param( 'style' ),
			'status'              => $request->get_param( 'status' ),
		];

		return new WP_REST_Response(
			[
				'status'  => true,
				'content' => give_form_grid_shortcode( $attributes ),
				'params'  => $attributes,
			]
		);
	}

}

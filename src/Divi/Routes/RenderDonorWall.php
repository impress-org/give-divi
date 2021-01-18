<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderDonorWall
 * @package GiveDivi\Divi\Routes
 */
class RenderDonorWall extends Endpoint {

	/** @var string */
	protected $endpoint = 'give-divi/render-donor-wall';


	/**
	 * @inheritDoc
	 */
	public function registerRoute() {
		register_rest_route(
			'give-api/v2',
			$this->endpoint,
			[
				[
					'methods'             => 'GET',
					'callback'            => [ $this, 'handleRequest' ],
					'permission_callback' => [ $this, 'permissionsCheck' ],
					'args'                => [
						'show'          => [
							'type'     => 'integer',
							'required' => true,
						],
						'ids'           => [
							'type'     => 'string',
							'required' => false,
						],
						'form'          => [
							'type'     => 'integer',
							'required' => false,
						],
						'orderby'       => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'desc',
						],
						'order'         => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'amount',
						],
						'columns'       => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'best-fit',
						],
						'avatarsize'    => [
							'type'     => 'integer',
							'required' => false,
							'default'  => 60,
						],
						'avatar'        => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'name'          => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'company'       => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => false,
						],
						'total'         => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'time'          => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'comments'      => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'anonymous'     => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'withcomments'  => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => false,
						],
						'commentlength' => [
							'type'     => 'integer',
							'required' => false,
							'default'  => 140,
						],
						'readtext'      => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'Read more',
						],
						'loadtext'      => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'Load more',
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
				'show'          => [
					'type'        => 'integer',
					'description' => esc_html__( 'Donors per page', 'give-divi' ),
				],
				'ids'           => [
					'type'        => 'string',
					'description' => esc_html__( 'Donor IDs', 'give-divi' ),
				],
				'form'          => [
					'type'        => 'integer',
					'description' => esc_html__( 'Form ID', 'give-divi' ),
				],
				'orderby'       => [
					'type'        => 'string',
					'description' => esc_html__( 'Order By', 'give-divi' ),
				],
				'order'         => [
					'type'        => 'string',
					'description' => esc_html__( 'Order', 'give-divi' ),
				],
				'columns'       => [
					'type'        => 'string',
					'description' => esc_html__( 'Columns', 'give-divi' ),
				],
				'avatarsize'    => [
					'type'        => 'string',
					'description' => esc_html__( 'Avatar Size', 'give-divi' ),
				],
				'avatar'        => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Avatar', 'give-divi' ),
				],
				'name'          => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Name', 'give-divi' ),
				],
				'company'       => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Company Name', 'give-divi' ),
				],
				'total'         => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Total', 'give-divi' ),
				],
				'time'          => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Time', 'give-divi' ),
				],
				'comments'      => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Comments', 'give-divi' ),
				],
				'anonymous'     => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Anonymous', 'give-divi' ),
				],
				'withcomments'  => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Only Donors with Comments', 'give-divi' ),
				],
				'commentlength' => [
					'type'        => 'integer',
					'description' => esc_html__( 'Comment Length', 'give-divi' ),
				],
				'readtext'      => [
					'type'        => 'string',
					'description' => esc_html__( 'Read More Text', 'give-divi' ),
				],
				'loadtext'      => [
					'type'        => 'string',
					'description' => esc_html__( 'Load More Text', 'give-divi' ),
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
			'donors_per_page'   => $request->get_param( 'show' ),
			'form_id'           => $request->get_param( 'form' ),
			'ids'               => $request->get_param( 'ids' ),
			'columns'           => $request->get_param( 'columns' ),
			'anonymous'         => $request->get_param( 'anonymous' ),
			'show_avatar'       => $request->get_param( 'avatar' ),
			'show_name'         => $request->get_param( 'name' ),
			'show_company_name' => $request->get_param( 'company' ),
			'show_total'        => $request->get_param( 'total' ),
			'show_time'         => $request->get_param( 'time' ),
			'show_comments'     => $request->get_param( 'comments' ),
			'comment_length'    => $request->get_param( 'commentlength' ),
			'only_comments'     => $request->get_param( 'withcomments' ),
			'readmore_text'     => $request->get_param( 'readtext' ),
			'loadmore_text'     => $request->get_param( 'loadtext' ),
			'avatar_size'       => $request->get_param( 'avatarsize' ),
			'orderby'           => $request->get_param( 'orderby' ),
			'order'             => $request->get_param( 'order' ),
		];

		$donorWall = \Give_Donor_Wall::get_instance();

		return new WP_REST_Response(
			[
				'status'  => true,
				'content' => $donorWall->render_shortcode( $attributes ),
			]
		);
	}

}

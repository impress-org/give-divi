<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderTotals
 * @package GiveDivi\Divi\Routes
 */
class RenderTotals extends Endpoint {

	/** @var string */
	protected $endpoint = 'give-divi/render-totals';


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
						'total_goal'   => [
							'type'     => 'string',
							'required' => false,
						],
						'ids'          => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'cats'         => [
							'type'     => 'string',
							'required' => false,
						],
						'tags'         => [
							'type'     => 'string',
							'required' => false,
						],
						'message'      => [
							'type'     => 'string',
							'required' => false,
						],
						'link'         => [
							'type'     => 'string',
							'required' => false,
						],
						'link_text'    => [
							'type'     => 'string',
							'required' => false,
							'default'  => esc_html__( 'Donate Now', 'give-divi' ),
						],
						'progress_bar' => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
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
				'total_goal'   => [
					'type'        => 'string',
					'description' => esc_html__( 'Total Goal', 'give-divi' ),
				],
				'ids'          => [
					'type'        => 'string',
					'description' => esc_html__( 'Donation Form IDs', 'give-divi' ),
				],
				'cats'         => [
					'type'        => 'string',
					'description' => esc_html__( 'Categories', 'give-divi' ),
				],
				'tags'         => [
					'type'        => 'string',
					'description' => esc_html__( 'Tags', 'give-divi' ),
				],
				'message'      => [
					'type'        => 'string',
					'description' => esc_html__( 'Message', 'give-divi' ),
				],
				'link'         => [
					'type'        => 'string',
					'description' => esc_html__( 'Link', 'give-divi' ),
				],
				'link_text'    => [
					'type'        => 'string',
					'description' => esc_html__( 'Link Text', 'give-divi' ),
				],
				'progress_bar' => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show progress bar', 'give-divi' ),
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
			'total_goal'   => $request->get_param( 'total_goal' ),
			'ids'          => $request->get_param( 'ids' ),
			'cats'         => $request->get_param( 'cats' ),
			'tags'         => $request->get_param( 'tags' ),
			'message'      => $request->get_param( 'message' ),
			'link'         => $request->get_param( 'link' ),
			'link_text'    => $request->get_param( 'link_text' ),
			'progress_bar' => $request->get_param( 'progress_bar' ),
		];

		return new WP_REST_Response(
			[
				'status'  => true,
				'content' => give_totals_shortcode( $attributes ),
			]
		);
	}
}

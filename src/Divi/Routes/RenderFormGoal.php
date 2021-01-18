<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderFormGoal
 * @package GiveDivi\Divi\Routes
 */
class RenderFormGoal extends Endpoint {

	/** @var string */
	protected $endpoint = 'give-divi/render-form-goal';


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
						'id'        => [
							'type'     => 'integer',
							'required' => true,
						],
						'show_text' => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'show_bar'  => [
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
				'id'        => [
					'type'        => 'integer',
					'description' => esc_html__( 'Donation Form id', 'give-divi' ),
				],
				'show_text' => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Goal Text', 'give-divi' ),
				],
				'show_bar'  => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Goal Bar', 'give-divi' ),
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
			'id'        => $request->get_param( 'id' ),
			'show_text' => $request->get_param( 'show_text' ),
			'show_bar'  => $request->get_param( 'show_bar' ),
		];

		return new WP_REST_Response(
			[
				'status'  => true,
				'content' => give_goal_shortcode( $attributes ),
			]
		);
	}

}

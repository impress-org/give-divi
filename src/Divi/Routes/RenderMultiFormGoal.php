<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;
use Give\MultiFormGoals\MultiFormGoal\Shortcode;

/**
 * Class RenderMultiFormGoal
 * @package GiveDivi\Divi\Routes
 */
class RenderMultiFormGoal extends Endpoint {

	/** @var string */
	protected $endpoint = 'give-divi/render-multi-form-goal';


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
						'ids'        => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'tags'       => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'categories' => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'goal'       => [
							'type'     => 'integer',
							'required' => false,
							'default'  => 1000,
						],
						'enddate'    => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
						],
						'color'      => [
							'type'     => 'string',
							'required' => false,
							'default'  => '#28c77b',
						],
						'heading'    => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'Example Heading',
						],
						'image'      => [
							'type'     => 'string',
							'required' => false,
							'default'  => GIVE_PLUGIN_URL . 'assets/dist/images/onboarding-preview-form-image.min.jpg',
						],
						'summary'    => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'This is a summary.',
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
				'ids'        => [
					'type'        => 'string',
					'description' => esc_html__( 'Donation Form IDs', 'give-divi' ),
				],
				'tags'       => [
					'type'        => 'string',
					'description' => esc_html__( 'Tags', 'give-divi' ),
				],
				'categories' => [
					'type'        => 'string',
					'description' => esc_html__( 'Categories', 'give-divi' ),
				],
				'goal'       => [
					'type'        => 'string',
					'description' => esc_html__( 'Goal Amount', 'give-divi' ),
				],
				'enddate'    => [
					'type'        => 'string',
					'description' => esc_html__( 'End Date', 'give-divi' ),
				],
				'color'      => [
					'type'        => 'string',
					'description' => esc_html__( 'Color', 'give-divi' ),
				],
				'heading'    => [
					'type'        => 'string',
					'description' => esc_html__( 'Heading Title', 'give-divi' ),
				],
				'image'      => [
					'type'        => 'string',
					'description' => esc_html__( 'Featured Image of the Card', 'give-divi' ),
				],
				'summary'    => [
					'type'        => 'string',
					'description' => esc_html__( 'Summary', 'give-divi' ),
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
			'ids'        => $request->get_param( 'ids' ),
			'tags'       => $request->get_param( 'tags' ),
			'categories' => $request->get_param( 'categories' ),
			'goal'       => $request->get_param( 'goal' ),
			'enddate'    => $request->get_param( 'enddate' ),
			'heading'    => $request->get_param( 'heading' ),
			'image'      => $request->get_param( 'image' ),
			'summary'    => $request->get_param( 'summary' ),
		];

		$shortcode = new Shortcode();

		return new WP_REST_Response(
			[
				'status'  => true,
				'content' => $shortcode->renderCallback( $attributes ),
			]
		);
	}
}

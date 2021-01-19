<?php

namespace GiveDivi\Divi\Routes;

use GiveDivi\Divi\Repositories\Forms;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderFormGoal
 * @package GiveDivi\Divi\Routes
 */
class RenderRegistrationForm extends Endpoint {

	/** @var string */
	protected $endpoint = 'give-divi/render-registration-form';

	/**
	 * @var Forms
	 */
	private $forms;

	/**
	 * RenderRegistrationForm constructor.
	 *
	 * @param  Forms  $forms
	 */
	public function __construct( Forms $forms ) {
		$this->forms = $forms;
	}

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
						'active'   => [
							'type'     => 'boolean',
							'required' => true,
							'default'  => false,
						],
						'redirect' => [
							'type'     => 'string',
							'required' => false,
							'default'  => '',
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
				'url' => [
					'type'        => 'string',
					'description' => esc_html__( 'Register Redirect URL', 'give-divi' ),
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
		// Redirect url
		$redirect = ( $request->get_param( 'active' ) && ! empty( $request->get_param( 'redirect' ) ) )
			? $request->get_param( 'redirect' )
			: '';

		return new WP_REST_Response(
			[
				'status'  => true,
				'content' => $this->forms->renderRegistrationForm( $redirect ),
			]
		);
	}

}

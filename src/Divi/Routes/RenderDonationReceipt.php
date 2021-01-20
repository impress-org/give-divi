<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderDonationReceipt
 * @package GiveDivi\Divi\Routes
 */
class RenderDonationReceipt extends Endpoint {

	/** @var string */
	protected $endpoint = 'give-divi/render-donation-receipt';

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
						'donor'          => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'price'          => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'date'           => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'payment_method' => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'payment_id'     => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'payment_status' => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => false,
						],
						'company_name'   => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => false,
						],
						'status_notice'  => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'error'          => [
							'type'     => 'string',
							'required' => false,
							'default'  => esc_html__( 'You are missing the donation id to view this donation receipt.', 'give-divi' ),
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
				'donor'          => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Display donor', 'give-divi' ),
				],
				'price'          => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Display total', 'give-divi' ),
				],
				'date'           => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Display date', 'give-divi' ),
				],
				'payment_method' => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Display payment method', 'give-divi' ),
				],
				'payment_id'     => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Display payment id', 'give-divi' ),
				],
				'payment_status' => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Display payment status', 'give-divi' ),
				],
				'company_name'   => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Display company name', 'give-divi' ),
				],
				'status_notice'  => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Display status notice', 'give-divi' ),
				],
				'error'          => [
					'type'        => 'string',
					'description' => esc_html__( 'Error notice text', 'give-divi' ),
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
			'donor'          => $request->get_param( 'donor' ),
			'price'          => $request->get_param( 'price' ),
			'date'           => $request->get_param( 'date' ),
			'payment_method' => $request->get_param( 'payment_method' ),
			'payment_id'     => $request->get_param( 'payment_id' ),
			'payment_status' => $request->get_param( 'payment_status' ),
			'company_name'   => $request->get_param( 'company_name' ),
			'status_notice'  => $request->get_param( 'status_notice' ),
			'error'          => $request->get_param( 'error' ),
		];

		return new WP_REST_Response(
			[
				'status'  => true,
				'content' => give_display_donation_receipt( $attributes ),
			]
		);
	}

}

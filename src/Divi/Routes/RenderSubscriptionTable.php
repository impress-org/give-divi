<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderSubscriptionTable
 * @package GiveDivi\Divi\Routes
 */
class RenderSubscriptionTable extends Endpoint {

	/** @var string */
	protected $endpoint = 'give-divi/render-subscription-table';


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
						'show_status'            => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'show_renewal_date'      => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => true,
						],
						'show_progress'          => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => false,
						],
						'show_start_date'        => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => false,
						],
						'show_end_date'          => [
							'type'     => 'boolean',
							'required' => false,
							'default'  => false,
						],
						'subscriptions_per_page' => [
							'type'     => 'integer',
							'required' => false,
							'default'  => 16,
						],
						'pagination_type'        => [
							'type'     => 'string',
							'required' => false,
							'default'  => 'next_and_previous',
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
				'show_status'            => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Status', 'give-divi' ),
				],
				'show_renewal_date'      => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Renewal Date', 'give-divi' ),
				],
				'show_progress'          => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Progress', 'give-divi' ),
				],
				'show_start_date'        => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show Start Date', 'give-divi' ),
				],
				'show_end_date'          => [
					'type'        => 'boolean',
					'description' => esc_html__( 'Show End Date', 'give-divi' ),
				],
				'subscriptions_per_page' => [
					'type'        => 'integer',
					'description' => esc_html__( 'Show Subscriptions per page', 'give-divi' ),
				],
				'pagination_type'        => [
					'type'        => 'string',
					'description' => esc_html__( 'Pagination Type', 'give-divi' ),
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
			'show_status'            => $request->get_param( 'show_status' ),
			'show_renewal_date'      => $request->get_param( 'show_renewal_date' ),
			'show_progress'          => $request->get_param( 'show_progress' ),
			'show_start_date'        => $request->get_param( 'show_start_date' ),
			'show_end_date'          => $request->get_param( 'show_end_date' ),
			'subscriptions_per_page' => $request->get_param( 'subscriptions_per_page' ),
			'pagination_type'        => $request->get_param( 'pagination_type' ),
		];

		$recurringShortcodes = new \Give_Recurring_Shortcodes();

		return new WP_REST_Response(
			[
				'status'  => true,
				'content' => $recurringShortcodes->give_subscriptions( $attributes ),
			]
		);
	}

}

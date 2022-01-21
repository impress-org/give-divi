<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderDonationHistory
 * @package GiveDivi\Divi\Routes
 */
class RenderDonationHistory extends Endpoint
{

    /** @var string */
    protected $endpoint = 'give-divi/render-donation-history';

    /**
     * @inheritDoc
     */
    public function registerRoute()
    {
        register_rest_route(
            'give-api/v2',
            $this->endpoint,
            [
                [
                    'methods' => 'POST',
                    'callback' => [$this, 'handleRequest'],
                    'permission_callback' => [$this, 'permissionsCheck'],
                    'args' => [
                        'id' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => true,
                        ],
                        'date' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => true,
                        ],
                        'donor' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => false,
                        ],
                        'amount' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => true,
                        ],
                        'status' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => false,
                        ],
                        'payment_method' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => false,
                        ],
                    ],
                ],
                'schema' => [$this, 'getSchema'],
            ]
        );
    }

    /**
     * @since 1.0.0
     * @return array
     */
    public function getSchema()
    {
        return [
            '$schema' => 'http://json-schema.org/draft-04/schema#',
            'title' => 'give-divi',
            'type' => 'object',
            'properties' => [
                'id' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Show Donation ID', 'give-divi'),
                ],
                'date' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Show Date', 'give-divi'),
                ],
                'donor' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Show Donor', 'give-divi'),
                ],
                'amount' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Show Amount', 'give-divi'),
                ],
                'status' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Show Payment Status', 'give-divi'),
                ],
                'payment_method' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Show Payment Method', 'give-divi'),
                ],
            ],
        ];
    }

    /**
     * @since 1.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_REST_Response
     */
    public function handleRequest(WP_REST_Request $request)
    {
        $attributes = [
            'id' => $request->get_param('id'),
            'date' => $request->get_param('date'),
            'donor' => $request->get_param('donor'),
            'amount' => $request->get_param('amount'),
            'status' => $request->get_param('status'),
            'payment_method' => $request->get_param('payment_method'),
        ];

        return new WP_REST_Response(
            [
                'status' => true,
                'content' => give_donation_history($attributes),
            ]
        );
    }

}

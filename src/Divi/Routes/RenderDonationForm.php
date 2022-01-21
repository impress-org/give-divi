<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class DonationForm
 * @package GiveDivi\Divi\Routes
 */
class RenderDonationForm extends Endpoint
{

    /** @var string */
    protected $endpoint = 'give-divi/render-donation-form';

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
                            'type' => 'integer',
                            'required' => true,
                        ],
                        'style' => [
                            'type' => 'string',
                            'required' => true,
                        ],
                        'title' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => true,
                        ],
                        'goal' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => true,
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
                    'type' => 'integer',
                    'description' => esc_html__('Donation Form id', 'give-divi'),
                ],
                'style' => [
                    'type' => 'string',
                    'description' => esc_html__('Donation Form  display style', 'give-divi'),
                ],
                'title' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Show Donation Form title', 'give-divi'),
                ],
                'goal' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Show Donation Form goal', 'give-divi'),
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
            'display_style' => $request->get_param('style'),
            'show_title' => $request->get_param('title'),
            'show_goal' => $request->get_param('goal'),
        ];

        $_SERVER['QUERY_STRING'] = [
            'rest_route' => null,
            // In order to load the multi step donation form properly, we have to unset the rest_route property
            'rest' => true,
            // used as a flag to determine if reveal iframe script should be loaded
        ];

        return new WP_REST_Response(
            [
                'status' => true,
                'content' => give_form_shortcode($attributes),
            ]
        );
    }

}

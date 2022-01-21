<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Class RenderFormGoal
 * @package GiveDivi\Divi\Routes
 */
class RenderLoginForm extends Endpoint
{

    /** @var string */
    protected $endpoint = 'give-divi/render-login-form';

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
                        'redirect' => [
                            'type' => 'boolean',
                            'required' => false,
                            'default' => false,
                        ],
                        'login' => [
                            'type' => 'string',
                            'required' => false,
                            'default' => '',
                        ],
                        'logout' => [
                            'type' => 'string',
                            'required' => false,
                            'default' => '',
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
                'redirect' => [
                    'type' => 'boolean',
                    'description' => esc_html__('Enable Redirect', 'give-divi'),
                ],
                'login' => [
                    'type' => 'string',
                    'description' => esc_html__('Login Redirect URL', 'give-divi'),
                ],
                'logout' => [
                    'type' => 'string',
                    'description' => esc_html__('logout Redirect URL', 'give-divi'),
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
            'redirect' => $request->get_param('redirect'),
            'login-redirect' => $request->get_param('login'),
            'logout-redirect' => $request->get_param('logout'),
        ];

        return new WP_REST_Response(
            [
                'status' => true,
                'content' => give_login_form_shortcode($attributes),
            ]
        );
    }

}

<?php

namespace GiveDivi\Divi\Routes;

use WP_REST_Response;

/**
 * Class RenderProfileEditor
 * @package GiveDivi\Divi\Routes
 */
class RenderProfileEditor extends Endpoint
{

    /** @var string */
    protected $endpoint = 'give-divi/render-profile-editor';

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
                    'args' => [],
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
            'properties' => [],
        ];
    }

    /**
     * @since 1.0.0
     * @return WP_REST_Response
     */
    public function handleRequest()
    {
        return new WP_REST_Response(
            [
                'status' => true,
                'content' => give_profile_editor_shortcode([]),
            ]
        );
    }

}

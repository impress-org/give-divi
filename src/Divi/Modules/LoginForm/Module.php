<?php

namespace GiveDivi\Divi\Modules\LoginForm;

use ET_Builder_Module;

class Module extends ET_Builder_Module
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $vb_support;

    /**
     * @var string[]
     */
    protected $module_credits;

    /**
     * Module constructor.
     */
    public function __construct()
    {
        $this->slug = 'give_login_form';
        $this->vb_support = 'on';
        $this->module_credits = [
            'module_uri' => '',
            'author' => 'GiveWP',
            'author_uri' => 'https://givewp.com',
        ];

        parent::__construct();
    }

    public function init()
    {
        $this->name = esc_html__('Give Login Form', 'give-divi');
    }

    /**
     * Get module fields
     *
     * @return array[]
     */
    public function get_fields()
    {
        return [
            'redirect' => [
                'label' => esc_html__('Redirect', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'off',
            ],
            'login' => [
                'label' => esc_html__('Login Redirect URL', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '',
                'show_if' => [
                    'redirect' => 'on',
                ],
            ],
            'logout' => [
                'label' => esc_html__('Logout Redirect URL', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '',
                'show_if' => [
                    'redirect' => 'on',
                ],
            ],
        ];
    }

    /**
     * Render Login form
     *
     * @since 1.0.0
     *
     * @param null   $content
     * @param string $render_slug
     *
     * @param array  $attrs
     *
     * @return string
     */
    public function render($attrs, $content = null, $render_slug)
    {
        $attributes = [
            'redirect' => isset($attrs['redirect']) ? filter_var($attrs['redirect'], FILTER_VALIDATE_BOOLEAN) : false,
            'login-redirect' => isset($attrs['login']) ? esc_url($attrs['login']) : '',
            'logout-redirect' => isset($attrs['logout']) ? esc_url($attrs['logout']) : '',
        ];

        return give_login_form_shortcode($attributes);
    }
}

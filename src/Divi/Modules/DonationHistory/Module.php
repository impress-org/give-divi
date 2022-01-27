<?php

namespace GiveDivi\Divi\Modules\DonationHistory;

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
        $this->slug = 'give_donation_history';
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
        $this->name = esc_html__('Give Donation History', 'give-divi');
    }

    /**
     * Get module fields
     *
     * @return array[]
     */
    public function get_fields()
    {
        return [
            'id' => [
                'label' => esc_html__('Show Donation ID', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'on',
                'description' => esc_html__(
                    'Choose if you want to display the column with the ID of the donation.',
                    'give-divi'
                ),
            ],
            'date' => [
                'label' => esc_html__('Show Date', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'on',
                'description' => esc_html__(
                    'Choose if you want to display the column with the date the donation was made.',
                    'give-divi'
                ),
            ],
            'donor' => [
                'label' => esc_html__('Show Donor', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'off',
                'description' => esc_html__(
                    'Choose if you want to display the column with the donor’s full name.',
                    'give-divi'
                ),
            ],
            'amount' => [
                'label' => esc_html__('Show Amount', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'on',
                'description' => esc_html__(
                    'Choose if you want to display the column with the donation amount.',
                    'give-divi'
                ),
            ],
            'status' => [
                'label' => esc_html__('Show Payment Status', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'off',
                'description' => esc_html__(
                    'Choose if you want to display the column with the payment status of the donation.',
                    'give-divi'
                ),
            ],
            'payment_method' => [
                'label' => esc_html__('Show Payment Method', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'off',
                'description' => esc_html__(
                    'Choose if you want to display the column with the payment method the donation was made with.',
                    'give-divi'
                ),
            ],
        ];
    }

    /**
     * Render Donation History
     *
     * @since 1.0.0
     *
     * @param null $content
     * @param string $render_slug
     *
     * @param array $attrs
     *
     * @return string
     */
    public function render($attrs, $content = null, $render_slug)
    {
        $attributes = [
            'id' => isset($attrs['id']) ? filter_var($attrs['id'], FILTER_VALIDATE_BOOLEAN) : true,
            'date' => isset($attrs['date']) ? filter_var($attrs['date'], FILTER_VALIDATE_BOOLEAN) : true,
            'donor' => isset($attrs['donor']) ? filter_var($attrs['donor'], FILTER_VALIDATE_BOOLEAN) : false,
            'amount' => isset($attrs['amount']) ? filter_var($attrs['amount'], FILTER_VALIDATE_BOOLEAN) : true,
            'status' => isset($attrs['status']) ? filter_var($attrs['status'], FILTER_VALIDATE_BOOLEAN) : false,
            'payment_method' => isset($attrs['payment_method']) ? filter_var(
                $attrs['payment_method'],
                FILTER_VALIDATE_BOOLEAN
            ) : false,
        ];

        return give_donation_history($attributes);
    }
}

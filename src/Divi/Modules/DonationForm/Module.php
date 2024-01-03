<?php

namespace GiveDivi\Divi\Modules\DonationForm;

use ET_Builder_Module;
use GiveDivi\Divi\Repositories\Forms;

class Module extends ET_Builder_Module
{

    public $slug;
    public $vb_support;

    protected $module_credits = [
        'module_uri' => '',
        'author' => 'GiveWP',
        'author_uri' => 'https://givewp.com',
    ];
    /**
     * @var Forms
     */
    private $forms;

    /**
     * Module constructor.
     *
     * @param Forms $forms
     */
    public function __construct(Forms $forms)
    {
        $this->forms = $forms;
        $this->slug = 'give_donation_form';
        $this->vb_support = 'on';

        parent::__construct();
    }

    public function init()
    {
        $this->name = esc_html__('Give Donation Form', 'give-divi');

        // Load script to reveal the iframe
        if (isset($_GET['rest'])) {
            add_action(
                'give_embed_footer',
                function () {
                    printf('<script src="%s"></script>', GIVE_DIVI_ADDON_URL . 'public/js/reveal-iframe.js');
                }
            );
        }
    }

    /**
     * Get module fields
     *
     * @return array[]
     */
    public function get_fields()
    {
        $donationForms = $this->forms->getAll();

        $donationFormsKeys = array_map(
            'strval',
            array_keys($donationForms)
        ); // Divi builder module requires array values to be a string

        return [
            'id' => [
                'label' => esc_html__('Select Donation form', 'give-divi'),
                'type' => 'give_multi_select',
                'option_category' => 'basic_option',
                'options' => $donationForms,
                'singleOption' => true,
            ],
            'style' => [
                'label' => esc_html__('Donation form format', 'give-divi'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => $this->forms->getFormFormats(),
                'default' => 'onpage',
                'show_if' => [
                    'id' => $donationFormsKeys,
                ],
            ],
            'title' => [
                'label' => esc_html__('Display form title', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'on',
                'show_if' => [
                    'id' => $donationFormsKeys,
                    'style' => 'onpage',
                ]
            ],
            'goal' => [
                'label' => esc_html__('Display Donation goal', 'give-divi'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'options' => ['off', 'on'],
                'default' => 'on',
                'show_if' => [
                    'id' => $donationFormsKeys,
                    'style' => 'onpage',
                ]
            ],
            'continue_button_title' => [
                'label' => esc_html__('Button label', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' =>  esc_html__('Donate', 'give-divi'),
                'show_if_not' => [
                    'style' => 'onpage',
                ],
            ],
        ];
    }

    /**
     * Render donation form
     *
     * @since 1.0.0
     *
     * @param null $content
     * @param string $render_slug
     *
     * @param array $attrs
     *
     * @return string|void
     */
    public function render($attrs, $content = null, $render_slug)
    {
        if ( ! isset($attrs['id']) || ! boolval($attrs['id'])) {
            return;
        }

        if (isset($attrs['style']) && $attrs['style'] === 'button') {
            $attrs['style'] = 'newTab';
        }

        $style = $attrs['style'] ?? 'onpage';
        $title = isset($attrs['title'])
            ? filter_var($attrs['title'], FILTER_VALIDATE_BOOLEAN)
            : true;
        $goal = isset($attrs['goal'])
            ? filter_var($attrs['goal'], FILTER_VALIDATE_BOOLEAN)
            : true;
        $buttonLabel = $attrs['continue_button_title'] ?? 'Donate';

        return give_form_shortcode([
            'id' => $attrs['id'],
            'display_style' => $style,
            'show_title' => $title,
            'show_goal' => $goal,
            'continue_button_title' => $buttonLabel,
        ]);
    }

}

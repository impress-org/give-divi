<?php

namespace GiveDivi\Divi\Modules\MultiFormGoal;

use ET_Builder_Module;
use Give\MultiFormGoals\MultiFormGoal\Shortcode;
use GiveDivi\Divi\Repositories\Forms;

class Module extends ET_Builder_Module
{

    public $slug;
    public $vb_support;

    protected $module_credits;

    /**
     * @var Forms
     */
    private $forms;

    public function __construct(Forms $forms)
    {
        $this->forms = $forms;
        $this->slug = 'give_multi_form_goal';
        $this->vb_support = 'on';
        $this->module_credits = [
            'module_uri' => '',
            'author' => 'GiveWp',
            'author_uri' => 'https://givewp.com',
        ];

        parent::__construct();
    }

    public function init()
    {
        $this->name = esc_html__('Give Multi Form Goal', 'give-divi');
    }

    /**
     * Get module fields
     *
     * @return array[]
     */
    public function get_fields()
    {
        return [
            'ids' => [
                'label' => esc_html__('Donation Form IDs', 'give-divi'),
                'type' => 'give_multi_select',
                'option_category' => 'basic_option',
                'default' => '',
                'options' => $this->forms->getAll(),
                'description' => esc_html__(
                    'Choose the IDs of the forms you want to display in the multi-form goal.',
                    'give-divi'
                ),
            ],
            'tags' => [
                'label' => esc_html__('Tags', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '',
                'description' => esc_html__(
                    'If you have tags enabled in GiveWP, you can list the category IDs that you want displayed in this grid. A comma-separated list of form tag IDs will cause the grid to include only forms with those tags.',
                    'give-divi'
                ),
            ],
            'categories' => [
                'label' => esc_html__('Categories', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '',
                'description' => esc_html__(
                    'If you have categories enabled in GiveWP, you can list the category IDs that you want displayed in this grid. A comma-separated list of form category IDs will cause the grid to include only forms from those categories.',
                    'give-divi'
                ),
            ],
            'goal' => [
                'label' => esc_html__('Goal Amount', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '1000',
                'description' => esc_html__(
                    'Choose the goal amount to be displayed in the multi-form goal card.',
                    'give-divi'
                ),
            ],
            'enddate' => [
                'label' => esc_html__('End Date', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '',
                'description' => esc_html__('Define when the multi-form goal should come to an end', 'give-divi'),
            ],
            'color' => [
                'label' => esc_html__('Color', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '#28c77b',
                'description' => esc_html__('Choose the primary color of the multi-form goal card', 'give-divi'),
            ],
            'heading' => [
                'label' => esc_html__('Heading Title', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => 'Example Heading',
                'description' => esc_html__(
                    'Choose the heading to be displayed on the multi-form goal card.',
                    'give-divi'
                ),
            ],
            'image' => [
                'label' => esc_html__('Featured Image of the Card', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => GIVE_PLUGIN_URL . 'assets/dist/images/onboarding-preview-form-image.min.jpg',
                'description' => esc_html__('Choose the image URL of the multi-form goal card.', 'give-divi'),
            ],
            'summary' => [
                'label' => esc_html__('Summary', 'give-divi'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => 'This is a summary.',
                'description' => esc_html__('Choose the summary text placed below the heading title.', 'give-divi'),
            ],
        ];
    }

    /**
     * Render multi-form goal
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
        $attributes = [
            'ids' => isset($attrs['ids']) ? esc_attr($attrs['ids']) : '',
            'tags' => isset($attrs['tags']) ? esc_attr($attrs['tags']) : '',
            'categories' => isset($attrs['categories']) ? esc_attr($attrs['categories']) : '',
            'goal' => isset($attrs['goal']) ? (int)$attrs['goal'] : 1000,
            'enddate' => isset($attrs['enddate']) ? esc_attr($attrs['enddate']) : '#28c77b',
            'heading' => isset($attrs['heading']) ? esc_html($attrs['heading']) : '',
            'image' => isset($attrs['image']) ? esc_url(
                $attrs['image']
            ) : GIVE_PLUGIN_URL . 'assets/dist/images/onboarding-preview-form-image.min.jpg',
            'summary' => isset($attrs['summary']) ? esc_html($attrs['summary']) : 'This is a summary.',
        ];

        $shortcode = new Shortcode();

        return $shortcode->renderCallback($attributes);
    }
}

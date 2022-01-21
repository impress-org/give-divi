<?php

namespace GiveDivi\Divi\Modules\ProfileEditor;

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
        $this->slug = 'give_profile_editor';
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
        $this->name = esc_html__('Give Profile Editor', 'give-divi');
    }

    /**
     * Get module fields
     *
     * @return array[]
     */
    public function get_fields()
    {
        return [];
    }

    /**
     * Render profile editor
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
        return give_profile_editor_shortcode($attrs);
    }
}

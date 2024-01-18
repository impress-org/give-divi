<?php

namespace GiveDivi\Divi\Repositories;

use Give_Forms_Query;
use Give\Helpers\Form\Utils;

/**
 * Class Forms
 * @package GiveDivi\Divi\Repositories
 */
class Forms
{
    /**
     * Get all donation forms
     *
     * @since 1.0.0
     * @return array
     */
    public function getAll()
    {
        $forms = [];

        $forms_query = new Give_Forms_Query(
            [
                'posts_per_page' => -1,
                'post_status' => 'publish',
            ]
        );

        $result = $forms_query->get_forms();

        foreach ($result as $form) {
            $forms[$form->ID] = $form->post_title;
        }

        return $forms;
    }

    /**
     * @unreleased
     *
     * @param array $forms
     *
     * @return array
     */
    public function getV3Forms($forms)
    {
        $output = [];

        foreach ($forms as $id) {
            if (Utils::isV3Form($id)) {
                $output[] = $id;
            }
        }

        return $output;
    }

    /**
     * Get Donation form formats
     *
     * @since 1.0.0
     * @return array
     */
    public function getFormFormats()
    {
        return [
            'onpage' => esc_html__('Full form', 'give-divi'),
            'modal' => esc_html__('Modal', 'give-divi'),
            'reveal' => esc_html__('Reveal', 'give-divi'),
            'button' => esc_html__('One Button Launch', 'give-divi'),
        ];
    }

    /**
     * Render registration form
     * This method exist because the give_register_form function doesn't render the registration form if user is logged
     *
     * @param string $redirect
     *
     * @return string
     */
    public function renderRegistrationForm($redirect = '')
    {
        if (empty($redirect)) {
            $redirect = give_get_current_page_url();
        }

        ob_start();

        give_get_template(
            'shortcode-register',
            [
                'give_register_redirect' => $redirect,
            ]
        );

        return apply_filters('give_register_form', ob_get_clean());
    }
}

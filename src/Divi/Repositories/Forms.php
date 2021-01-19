<?php
namespace GiveDivi\Divi\Repositories;

/**
 * Class Forms
 * @package GiveDivi\Divi\Repositories
 */
class Forms {
	/**
	 * Get all donation forms
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getAll() {
		$forms = [];

		$forms_query = new \Give_Forms_Query(
			[
				'number'      => - 1,
				'post_status' => 'publish',
			]
		);

		$result = $forms_query->get_forms();

		foreach ( $result as $form ) {
			$forms[ $form->ID ] = $form->post_title;
		}

		return $forms;
	}

	/**
	 * Get Donation form formats
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getFormFormats() {
		return [
			'onpage' => esc_html__( 'Full form', 'give-divi' ),
			'modal'  => esc_html__( 'Modal', 'give-divi' ),
			'reveal' => esc_html__( 'Reveal', 'give-divi' ),
			'button' => esc_html__( 'One Button Launch', 'give-divi' ),
		];
	}

	/**
	 * Render registration form
	 * This method exist because the give_register_form function doesn't render the registration form if user is logged
	 *
	 * @param  string  $redirect
	 *
	 * @return string
	 */
	public function renderRegistrationForm( $redirect = '' ) {
		if ( empty( $redirect ) ) {
			$redirect = give_get_current_page_url();
		}

		ob_start();

		give_get_template(
			'shortcode-register',
			[
				'give_register_redirect' => $redirect,
			]
		);

		return apply_filters( 'give_register_form', ob_get_clean() );
	}
}

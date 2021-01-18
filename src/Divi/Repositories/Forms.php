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
}

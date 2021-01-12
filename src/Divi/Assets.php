<?php

namespace GiveDivi\Divi;

/**
 * Helper class responsible for loading add-on assets.
 *
 * @package     GiveDivi\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class Assets {
	/**
	 * Load add-on assets.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function loadAssets() {
		wp_enqueue_script(
			'give-divi-script',
			GIVE_DIVI_ADDON_URL . 'public/js/give-divi.js',
			[],
			GIVE_DIVI_ADDON_VERSION,
			true
		);
	}
}

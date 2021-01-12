<?php

namespace GiveDivi\Addon;

class License {

	/**
	 * Check add-on license.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function check() {
		new \Give_License(
			GIVE_DIVI_ADDON_FILE,
			GIVE_DIVI_ADDON_NAME,
			GIVE_DIVI_ADDON_VERSION,
			'GiveWP'
		);
	}
}

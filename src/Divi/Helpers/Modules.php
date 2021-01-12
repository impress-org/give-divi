<?php

namespace GiveDivi\Divi\Helpers;

use GiveDivi\Divi\Modules\DonationForm\Module as DonationFormModule;

/**
 * Class Modules
 * @package GiveDivi\Divi\Helpers
 */
class Modules {
	public static function getModules() {
		return [
			DonationFormModule::class,
		];
	}
}

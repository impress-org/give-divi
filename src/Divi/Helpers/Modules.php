<?php

namespace GiveDivi\Divi\Helpers;

use GiveDivi\Divi\Modules\DonationForm\Module as DonationFormModule;
use GiveDivi\Divi\Modules\DonorWall\Module as DonorWallModule;

/**
 * Class Modules
 * @package GiveDivi\Divi\Helpers
 */
class Modules {
	public static function getModules() {
		return [
			DonationFormModule::class,
			DonorWallModule::class,
		];
	}
}

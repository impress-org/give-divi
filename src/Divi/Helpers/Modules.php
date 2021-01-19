<?php

namespace GiveDivi\Divi\Helpers;

// Modules
use GiveDivi\Divi\Modules\DonationForm\Module as DonationFormModule;
use GiveDivi\Divi\Modules\DonorWall\Module as DonorWallModule;
use GiveDivi\Divi\Modules\FormGoal\Module as FormGoalModule;
use GiveDivi\Divi\Modules\RegistrationForm\Module as RegistrationFormModule;
// Module routes Routes
use GiveDivi\Divi\Routes\RenderDonationForm;
use GiveDivi\Divi\Routes\RenderDonorWall;
use GiveDivi\Divi\Routes\RenderFormGoal;
use GiveDivi\Divi\Routes\RenderRegistrationForm;

/**
 * Class Modules
 * @package GiveDivi\Divi\Helpers
 */
class Modules {
	/**
	 * List of Divi modules with corresponding routes
	 *
	 * @return \string[][]
	 */
	public static function config() {
		return [
			[
				'module' => DonationFormModule::class,
				'route'  => RenderDonationForm::class,
			],
			[
				'module' => DonorWallModule::class,
				'route'  => RenderDonorWall::class,
			],
			[
				'module' => FormGoalModule::class,
				'route'  => RenderFormGoal::class,
			],
			[
				'module' => RegistrationFormModule::class,
				'route'  => RenderRegistrationForm::class,
			],
		];
	}

	/**
	 * Get Modules
	 *
	 * @return array
	 */
	public static function getModules() {
		return array_map(
			function( $module ) {
				return $module['module'];
			},
			static::config()
		);
	}


	/**
	 * Get Routes
	 *
	 * @return array
	 */
	public static function getRoutes() {
		return array_map(
			function( $module ) {
				return $module['route'];
			},
			static::config()
		);
	}
}

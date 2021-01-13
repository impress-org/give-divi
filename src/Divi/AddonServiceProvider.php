<?php

namespace GiveDivi\Divi;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider;
use GiveDivi\Addon\Environment;
use GiveDivi\Addon\License;
use GiveDivi\Addon\Language;
use GiveDivi\Addon\ActivationBanner;
use GiveDivi\Divi\Helpers\Assets;
use GiveDivi\Divi\Helpers\Modules;
use GiveDivi\Divi\Routes\RenderDonationForm;

/**
 * Service provider responsible for add-on initialization.
 *
 * @package     GiveDivi\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class AddonServiceProvider implements ServiceProvider {
	/**
	 * @inheritDoc
	 */
	public function register() {
	}

	/**
	 * @inheritDoc
	 */
	public function boot() {
		// Load add-on translations.
		Hooks::addAction( 'init', Language::class, 'load' );

		Hooks::addAction( 'admin_init', License::class, 'check' );
		Hooks::addAction( 'admin_init', ActivationBanner::class, 'show', 20 );

		// Load add-on assets only if Divi builder is active
		if ( Environment::isDiviBuilderActive() ) {
			Hooks::addAction( 'wp_enqueue_scripts', Assets::class, 'loadAssets' );
		}

		Hooks::addAction( 'rest_api_init', RenderDonationForm::class, 'registerRoute' );

		// Load GiveWP Divi modules
		add_action(
			'et_pagebuilder_module_init',
			function () {
				foreach ( Modules::getModules() as $module ) {
					give( $module );
				}
			}
		);
	}
}

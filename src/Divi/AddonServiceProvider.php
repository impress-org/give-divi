<?php

namespace GiveDivi\Divi;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider;
use GiveDivi\Addon\ActivationBanner;
use GiveDivi\Addon\Language;
use GiveDivi\Addon\License;
use GiveDivi\Divi\Helpers\Assets;
use GiveDivi\Divi\Helpers\Modules;

/**
 * Service provider responsible for add-on initialization.
 *
 * @package     GiveDivi\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class AddonServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        // Load add-on translations.
        Hooks::addAction('init', Language::class, 'load');

        Hooks::addAction('admin_init', License::class, 'check');
        Hooks::addAction('admin_init', ActivationBanner::class, 'show', 20);

        Hooks::addAction('wp_enqueue_scripts', Assets::class, 'loadAssets');

        // Rest routes
        foreach (Modules::getRoutes() as $moduleRoute) {
            Hooks::addAction('rest_api_init', $moduleRoute, 'registerRoute');
        }

        // Load GiveWP Divi modules
        add_action(
            'et_builder_ready',
            function () {
                foreach (Modules::getModules() as $module) {
                    give($module);
                }
            }
        );
    }
}

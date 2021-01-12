<?php namespace GiveDivi;

use GiveDivi\Addon\Environment;
use GiveDivi\Divi\AddonServiceProvider;

/**
 * Plugin Name: Give - Divi Modules
 * Plugin URI:  https://givewp.com/addons/give-divi/
 * Description: Use GiveWP as Divi modules
 * Version:     1.0.0
 * Author:      GiveWP
 * Author URI:  https://givewp.com/
 * Text Domain: give-divi
 * Domain Path: /languages
 */
defined( 'ABSPATH' ) or exit;

// Add-on name
define( 'GIVE_DIVI_ADDON_NAME', 'Give - Divi Modules' );

// Versions
define( 'GIVE_DIVI_ADDON_VERSION', '1.0.0' );
define( 'GIVE_DIVI_ADDON_MIN_GIVE_VERSION', '2.8.0' );

// Add-on paths
define( 'GIVE_DIVI_ADDON_FILE', __FILE__ );
define( 'GIVE_DIVI_ADDON_DIR', plugin_dir_path( GIVE_DIVI_ADDON_FILE ) );
define( 'GIVE_DIVI_ADDON_URL', plugin_dir_url( GIVE_DIVI_ADDON_FILE ) );
define( 'GIVE_DIVI_ADDON_BASENAME', plugin_basename( GIVE_DIVI_ADDON_FILE ) );

require 'vendor/autoload.php';

// Register the add-on service provider with the GiveWP core.
add_action(
	'before_give_init',
	function () {
		// Check Give min required version.
		if ( Environment::giveMinRequiredVersionCheck() ) {
			give()->registerServiceProvider( AddonServiceProvider::class );
		}
	}
);

// Check to make sure GiveWP core is installed and compatible with this add-on.
add_action( 'admin_init', [ Environment::class, 'checkEnvironment' ] );

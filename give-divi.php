<?php
/**
 * Plugin Name: Give - Donation Modules for Divi
 * Plugin URI:  https://go.givewp.com/divi-addon
 * Description: Use GiveWP shortcodes as Divi modules
 * Version:     1.0.3
 * Requires at least: 4.9
 * Requires PHP: 5.6
 * Author:      GiveWP
 * Author URI:  https://givewp.com/
 * Text Domain: give-divi
 * Domain Path: /languages
 */
namespace GiveDivi;

use GiveDivi\Addon\Environment;
use GiveDivi\Divi\AddonServiceProvider;

defined( 'ABSPATH' ) or exit;

// Add-on name
define( 'GIVE_DIVI_ADDON_NAME', 'Give - Divi' );

// Versions
define( 'GIVE_DIVI_ADDON_VERSION', '1.0.3' );
define( 'GIVE_DIVI_ADDON_MIN_GIVE_VERSION', '2.9.6' );

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

<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://brino.sk
 * @since             1.0.0
 * @package           Brino_Sync
 *
 * @wordpress-plugin
 * Plugin Name:       Brino Sync Plugin
 * Plugin URI:        https://brino.sk
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Brino
 * Author URI:        https://brino.sk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       brino-sync
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( !defined('ABSPATH') )
{
   echo 'Sorry! You can\'t access our plugin!!';
   exit;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BRINO_SYNC_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-brino-sync-activator.php
 */
function activate_brino_sync() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brino-sync-activator.php';
	Brino_Sync_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-brino-sync-deactivator.php
 */
function deactivate_brino_sync() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brino-sync-deactivator.php';
	Brino_Sync_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_brino_sync' );
register_deactivation_hook( __FILE__, 'deactivate_brino_sync' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-brino-sync.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_brino_sync() {

	$plugin = new Brino_Sync();
	$plugin->run();

}
run_brino_sync();

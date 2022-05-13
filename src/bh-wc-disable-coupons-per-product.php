<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           brianhenryie/bh-wc-disable-coupons-per-product
 *
 * @see https://stackoverflow.com/a/47603782/336146
 *
 * @wordpress-plugin
 * Plugin Name:       Disable Coupons Per Product
 * Plugin URI:        http://github.com/username/bh-wc-disable-coupons-per-product/
 * Description:       Adds a checkbox on the product edit screen to disable all coupons for that product.
 * Version:           1.0.0
 * Requires PHP:      7.4
 * Author:            BrianHenryIE
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bh-wc-disable-coupons-per-product
 * Domain Path:       /languages
 */

namespace BrianHenryIE\WC_Disable_Coupons_Per_Product;

use BrianHenryIE\WC_Disable_Coupons_Per_Product\WP_Includes\BH_WC_Disable_Coupons_Per_Product;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BH_WC_DISABLE_COUPONS_PER_PRODUCT_VERSION', '1.0.0' );

define( 'BH_WC_DISABLE_COUPONS_PER_PRODUCT_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function instantiate_bh_wc_disable_coupons_per_product(): BH_WC_Disable_Coupons_Per_Product {

	$plugin = new BH_WC_Disable_Coupons_Per_Product();

	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and frontend-facing site hooks.
 */
$GLOBALS['bh_wc_disable_coupons_per_product'] = instantiate_bh_wc_disable_coupons_per_product();

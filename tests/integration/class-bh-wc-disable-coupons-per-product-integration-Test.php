<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package brianhenryie/bh-wc-disable-coupons-per-product
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Disable_Coupons_Per_Product;

use BrianHenryIE\WC_Disable_Coupons_Per_Product\WP_Includes\BH_WC_Disable_Coupons_Per_Product;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Integration_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated(): void {

		$this->assertArrayHasKey( 'bh_wc_disable_coupons_per_product', $GLOBALS );

		$this->assertInstanceOf( BH_WC_Disable_Coupons_Per_Product::class, $GLOBALS['bh_wc_disable_coupons_per_product'] );
	}

}

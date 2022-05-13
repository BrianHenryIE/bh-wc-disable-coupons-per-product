<?php
/**
 * @package brianhenryie/bh-wc-disable-coupons-per-product_Unit_Name
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Disable_Coupons_Per_Product\WP_Includes;

use WP_Mock\Matcher\AnyInstance;

/**
 * Class BrianHenryIE\WC_Disable_Coupons_Per_Product_Unit_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_Disable_Coupons_Per_Product\WP_Includes\BH_WC_Disable_Coupons_Per_Product
 */
class BH_WC_Disable_Coupons_Per_Product_Unit_Test extends \Codeception\Test\Unit {

	protected function setUp(): void {
		parent::setUp();
		\WP_Mock::setUp();
	}

	protected function tearDown(): void {
		parent::tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::set_locale
	 */
	public function test_set_locale_hooked(): void {

		\WP_Mock::expectActionAdded(
			'init',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		new BH_WC_Disable_Coupons_Per_Product();
	}

}

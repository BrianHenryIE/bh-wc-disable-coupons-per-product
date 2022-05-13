<?php

class PluginsPageCest {

	/**
	 * Login and navigate to plugins.php.
	 *
	 * @param AcceptanceTester $I Codeception Actor object.
	 */
	public function _before( AcceptanceTester $I ): void {
		$I->loginAsAdmin();

		$I->amOnPluginsPage();
	}

	/**
	 * Verify the name of the plugin has been set.
	 *
	 * @param AcceptanceTester $I Codeception Actor object.
	 */
	public function testPluginsPageForName( AcceptanceTester $I ): void {

		$I->canSee( 'BH WC Disable Coupons Per Product' );
	}

	/**
	 * Check the description displayed on plugins.php has been changed from the default.
	 *
	 * @param AcceptanceTester $I Codeception Actor object.
	 */
	public function testPluginDescriptionHasBeenSet( AcceptanceTester $I ): void {

		$default_plugin_description = "This is a short description of what the plugin does. It's displayed in the WordPress admin area.";

		$I->cantSee( $default_plugin_description );
	}

}

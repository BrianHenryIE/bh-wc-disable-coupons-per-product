<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * frontend-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-disable-coupons-per-product
 */

namespace BrianHenryIE\WC_Disable_Coupons_Per_Product\WP_Includes;

use BrianHenryIE\WC_Disable_Coupons_Per_Product\Admin\Plugins_Page;
use BrianHenryIE\WC_Disable_Coupons_Per_Product\WooCommerce\Admin_Product_UI;
use BrianHenryIE\WC_Disable_Coupons_Per_Product\WooCommerce\Coupons;
use BrianHenryIE\WC_Disable_Coupons_Per_Product\WooCommerce\Coupons_UI;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * frontend-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class BH_WC_Disable_Coupons_Per_Product {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->set_locale();

		$this->define_admin_product_ui_hooks();
		$this->define_coupons_hooks();
		$this->define_coupons_ui_hooks();

		$this->define_plugins_page_hooks();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	protected function set_locale(): void {

		$plugin_i18n = new I18n();

		add_action( 'init', array( $plugin_i18n, 'load_plugin_textdomain' ) );

	}

	/**
	 * Add a checkbox on the admin product edit page for disabling coupons for that product.
	 */
	protected function define_admin_product_ui_hooks(): void {

		$admin_product_ui = new Admin_Product_UI();

		add_action( 'woocommerce_product_options_general_product_data', array( $admin_product_ui, 'print_custom_field_general_product_fields' ) );
		add_action( 'woocommerce_process_product_meta', array( $admin_product_ui, 'save_custom_field_general_product_fields' ) );

	}

	/**
	 * As coupons are added to the cart, check each product to see has it disabled coupons.
	 */
	protected function define_coupons_hooks(): void {

		$coupons = new Coupons();

		add_filter( 'woocommerce_coupon_is_valid_for_product', array( $coupons, 'set_coupon_validity_for_excluded_products' ), 12, 4 );
		add_filter( 'woocommerce_coupon_get_discount_amount', array( $coupons, 'zero_discount_for_excluded_products' ), 12, 5 );

	}

	/**
	 * In the admin UI for creating a coupon, list the products that have all coupons disabled.
	 *
	 * @see wp-admin/edit.php?post_type=shop_coupon
	 */
	protected function define_coupons_ui_hooks(): void {

		$coupons_ui = new Coupons_UI();

		add_action( 'woocommerce_coupon_options_usage_restriction', array( $coupons_ui, 'print_products_that_globally_disable_coupons' ), 10, 2 );
	}

	/**
	 * Add a link on plugins.php to the list of products that have been configured to disable coupons.
	 *
	 * Requires plugin: Search by ID.
	 *
	 * @see https://wordpress.org/plugins/search-by-id/
	 */
	protected function define_plugins_page_hooks(): void {

		$plugin_basename = defined( 'BH_WC_DISABLE_COUPONS_PER_PRODUCT_BASENAME' ) ? BH_WC_DISABLE_COUPONS_PER_PRODUCT_BASENAME : 'bh-wc-disable-coupons-per-product/bh-wc-disable-coupons-per-product.php';

		$plugins_page = new Plugins_Page();

		add_action( "plugin_action_links_{$plugin_basename}", array( $plugins_page, 'add_products_action_link' ) );

	}
}

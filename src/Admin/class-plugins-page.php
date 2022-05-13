<?php
/**
 * Add a link to products configured to disable coupons.
 *
 * @package brianhenryie/bh-wc-disable-coupons-per-product
 */

namespace BrianHenryIE\WC_Disable_Coupons_Per_Product\Admin;

use BrianHenryIE\WC_Disable_Coupons_Per_Product\WooCommerce\Coupons;

/**
 * Adds action to the plugins row.
 */
class Plugins_Page {

	/**
	 * Adds 'Products' link to list products that have had all coupons disabled.
	 *
	 * @hooked plugin_action_links_{plugin basename}
	 *
	 * @param string[] $links_array The links that will be shown below the plugin name on plugins.php (usually "Deactivate").
	 *
	 * @return string[]
	 * @see \WP_Plugins_List_Table::display_rows()
	 */
	public function add_products_action_link( array $links_array ): array {

		/**
		 * The list of product ids stored in wp_options.
		 *
		 * @var int[] $product_ids
		 */
		$product_ids = get_option( Coupons::PRODUCTS_LIST_OPTION_NAME, array() );

		if ( empty( $product_ids ) ) {
			$url = admin_url( 'edit.php?post_type=product' );
		} else {
			$url = admin_url( 'edit.php?post_status=all&post_type=product&s=' . implode( ',', $product_ids ) );
		}
		$href = "<a href=\"{$url}\">Products</a>";

		array_unshift( $links_array, $href );

		return $links_array;
	}

}

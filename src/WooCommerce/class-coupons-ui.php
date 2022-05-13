<?php
/**
 * Show the list of globally excluded products in the coupons UI.
 *
 * @see woocommerce/includes/admin/meta-boxes/class-wc-meta-box-coupon-data.php
 *
 * @package    brianhenryie/bh-wc-disable-coupons-per-product
 */

namespace BrianHenryIE\WC_Disable_Coupons_Per_Product\WooCommerce;

use WC_Coupon;

/**
 * Print an `options_group` div in the edit coupons metabox.
 */
class Coupons_UI {

	/**
	 * When displaying the edit coupon UI, print the list of products that the coupon will not apply to.
	 *
	 * @hooked woocommerce_coupon_options_usage_restriction
	 *
	 * @param int       $coupon_id The coupon id.
	 * @param WC_Coupon $coupon The coupon object.
	 *
	 * @return void
	 */
	public function print_products_that_globally_disable_coupons( int $coupon_id, WC_Coupon $coupon ):void {

		echo '<div class="options_group">';

		echo '<p class="form-field exclude_sale_items_field ">';
		echo '<label for="exclude_sale_items">Excluded products</label>';

		/**
		 * The list of product ids stored in wp_options.
		 *
		 * @var int[] $product_ids
		 */
		$product_ids = get_option( Coupons::PRODUCTS_LIST_OPTION_NAME, array() );

		/**
		 * `array_filter` should remove any empty entries returned from `wc_get_product`.
		 *
		 * @var \WC_Product[] $products
		 */
		$products = array_filter(
			array_map(
				function( int $product_id ) {
					return wc_get_product( $product_id );
				},
				$product_ids
			)
		);

		if ( empty( $products ) ) {
			echo '<span class="description">No products have been configured to disable all coupons.</span>';
		} else {
			echo '<span class="description">All coupons are disabled for the following products: ';

			$product_hrefs = array_map(
				function( \WC_Product $product ) {
					return '<a href="' . esc_url( admin_url( 'post.php?post=' . $product->get_id() . '&action=edit' ) ) . '">' . esc_html( $product->get_name() ) . '</a>';
				},
				$products
			);

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo implode( ', ', $product_hrefs );

			echo '.';

			echo '</span>';

		}

		echo '</p>';

		echo '</div>';

	}
}

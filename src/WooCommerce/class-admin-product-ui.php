<?php
/**
 * Add a checkbox on the admin edit product screen to disable coupons for that product.
 *
 * @package brianhenryie/bh-wc-disable-coupons-per-product
 */

namespace BrianHenryIE\WC_Disable_Coupons_Per_Product\WooCommerce;

/**
 * Add a checkbox with `woocommerce_wp_checkbox` and validate and save the result.
 */
class Admin_Product_UI {

	/**
	 * Create and display the custom field in product general setting tab.
	 *
	 * @hooked woocommerce_product_options_general_product_data
	 */
	public function print_custom_field_general_product_fields(): void {

		echo '<div class="product_custom_field">';

		woocommerce_wp_checkbox(
			array(
				'id'          => Coupons::DISABLE_COUPONS_FOR_PRODUCT_META_KEY_NAME,
				'label'       => __( 'Disable coupons for this product', 'woocommerce' ),
				'description' => __( 'Disable this products from coupon discounts', 'woocommerce' ),
				'desc_tip'    => 'true',
			)
		);

		echo '</div>';

	}

	/**
	 * Save the custom field and update all excluded product ids in wp_options.
	 *
	 * @hooked woocommerce_process_product_meta
	 *
	 * @param int $product_id The id of the product being edited.
	 *
	 * @return void
	 */
	public function save_custom_field_general_product_fields( int $product_id ) {

		if ( false === check_admin_referer( 'update-post_' . $product_id ) ) {
			return;
		}

		if ( ! isset( $_POST[ Coupons::DISABLE_COUPONS_FOR_PRODUCT_META_KEY_NAME ] ) ) {
			return;
		}

		$is_disable_coupons = 'yes' === sanitize_key( wp_unslash( $_POST[ Coupons::DISABLE_COUPONS_FOR_PRODUCT_META_KEY_NAME ] ) );

		/**
		 * This should always return a WC_Product object, since its hooked to an action on the product edit page.
		 *
		 * @var \WC_Product $product
		 */
		$product                    = wc_get_product( $product_id );
		$is_already_disable_coupons = wc_string_to_bool( $product->get_meta( Coupons::DISABLE_COUPONS_FOR_PRODUCT_META_KEY_NAME ) );

		// Let's not perform any database writes if it's already set.
		if ( $is_disable_coupons === $is_already_disable_coupons ) {
			return;
		}

		$product->update_meta_data( Coupons::DISABLE_COUPONS_FOR_PRODUCT_META_KEY_NAME, wc_bool_to_string( $is_disable_coupons ) );
		$product->save();

		// Save the full list to easily display it elsewhere.
		$products_with_coupons_disabled = get_option( Coupons::PRODUCTS_LIST_OPTION_NAME, array() );
		if ( $is_disable_coupons ) {
			$products_with_coupons_disabled[] = $product_id;
			$products_with_coupons_disabled   = array_unique( $products_with_coupons_disabled );
		} else {
			$products_with_coupons_disabled = array_diff( $products_with_coupons_disabled, array( $product_id ) );
		}
		update_option( Coupons::PRODUCTS_LIST_OPTION_NAME, $products_with_coupons_disabled );
	}

}

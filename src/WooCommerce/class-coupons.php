<?php
/**
 * When applying coupons, check is it valid for the product.
 *
 * @package    brianhenryie/bh-wc-disable-coupons-per-product
 */

namespace BrianHenryIE\WC_Disable_Coupons_Per_Product\WooCommerce;

use WC_Coupon;
use WC_Product;

/**
 * Hook into filters on WC_Coupons to disable coupons for the specific products.
 */
class Coupons {

	const DISABLE_COUPONS_FOR_PRODUCT_META_KEY_NAME = 'disable_coupons_for_product';
	const PRODUCTS_LIST_OPTION_NAME                 = 'products_with_coupons_disabled';

	/**
	 * Make coupons invalid at product level.
	 *
	 * @hooked woocommerce_coupon_is_valid_for_product
	 * @see WC_Coupon::is_valid_for_product()
	 *
	 * @param bool                $valid Is the coupon valid for this product.
	 * @param WC_Product          $product The product the coupon is being applied to.
	 * @param WC_Coupon           $coupon The coupon object.
	 * @param array<string,mixed> $values Looks like cart_item array.
	 *
	 * @return bool
	 */
	public function set_coupon_validity_for_excluded_products( bool $valid, WC_Product $product, WC_Coupon $coupon, array $values ) {

		$is_disabled = wc_string_to_bool( $product->get_meta( self::DISABLE_COUPONS_FOR_PRODUCT_META_KEY_NAME ) );

		return $valid && ! $is_disabled;
	}

	/**
	 * Set the product discount amount to zero.
	 *
	 * This doesn't seem to run if set_coupon_validity_for_excluded_products returns false, so it can probably be deleted.
	 *
	 * @hooked woocommerce_coupon_get_discount_amount
	 * @see WC_Coupon::get_discount_amount()
	 *
	 * @param float               $discount           The discount that will be applied.
	 * @param float               $discounting_amount The amount to apply the discount to (probably the item price).
	 * @param array<string,mixed> $cart_item          The cart item properties.
	 * @param bool                $single             True if discounting a single qty item, false if it's the line.
	 * @param WC_Coupon           $coupon             The coupon being applied.
	 *
	 * @return float
	 */
	public function zero_discount_for_excluded_products( float $discount, float $discounting_amount, array $cart_item, bool $single, WC_Coupon $coupon ) {

		$product = wc_get_product( $cart_item['product_id'] );

		// If the product has been deleted since being added to the cart, it might cause issues.
		if ( ! ( $product instanceof WC_Product ) ) {
			return $discount;
		}

		$is_disabled = wc_string_to_bool( $product->get_meta( self::DISABLE_COUPONS_FOR_PRODUCT_META_KEY_NAME ) );
		if ( $is_disabled ) {
			return 0.0;
		}

		return $discount;
	}

}

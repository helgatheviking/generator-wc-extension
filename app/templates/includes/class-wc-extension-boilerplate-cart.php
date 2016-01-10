<?php
/**
 * <%= opts.projectTitle %> cart functions and filters.
 *
 * @class 	<%= opts.classPrefix %>_Cart
 * @version 0.1.0
 * @since   0.1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class <%= opts.classPrefix %>_Cart {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Functions for cart actions - ensure they have a priority before addons (10)
		add_filter( 'woocommerce_is_purchasable', array( $this, 'is_purchasable' ), 5, 2 );
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data' ), 5, 3 );
		add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'get_cart_item_from_session' ), 11, 2 );
		add_filter( 'woocommerce_add_cart_item', array( $this, 'add_cart_item' ), 11, 1 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'validate_add_cart_item' ), 5, 5 );

	}

	/*-----------------------------------------------------------------------------------*/
	/* Cart Filters */
	/*-----------------------------------------------------------------------------------*/

	/*
	 * Override WC's is_purchasable
	 * @since 0.1.0
	 */
	public function is_purchasable( $purchasable , $product ) {
		if( <%= opts.classPrefix %>_Helpers::is_product_checkbox( $product->id ) ){
			$purchasable = true;
		} else {
			$purchasable = false;
		}
		return $purchasable;
	}

	/*
	 * Add cart session data
	 * @since 0.1.0
	 */
	public function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {

		if( <%= opts.classPrefix %>_Helpers::is_product_checkbox( $product_id ) ){
			$cart_item_data['wc-boilerplate-extension-checkbox'] = 'true';
		}

		if( $number = <%= opts.classPrefix %>_Helpers::get_sample_number( $product_id ) ){
			$cart_item_data['wc-boilerplate-extension-number'] = $number;
		}

		if( $number = <%= opts.classPrefix %>_Helpers::get_sample_textbox( $product_id ) ){
			$cart_item_data['wc-boilerplate-extension-textbox'] = $number;
		}

		return $cart_item_data;
	}

	/*
	 * Preserve cart session data
	 * @since 0.1.0
	 */
	public function get_cart_item_from_session( $cart_item, $values ) {

		if ( isset( $values['wc-boilerplate-extension-checkbox'] ) ) {
			$cart_item['wc-boilerplate-extension-checkbox'] = $values['wc-boilerplate-extension-checkbox'];
			$cart_item = $this->add_cart_item( $cart_item );
		}

		if ( isset( $values['wc-boilerplate-extension-number'] ) ) {
			$cart_item['wc-boilerplate-extension-number'] = $values['wc-boilerplate-extension-number'];
		}

		if ( isset( $values['wc-boilerplate-extension-textbox'] ) ) {
			$cart_item['wc-boilerplate-extension-textbox'] = $values['wc-boilerplate-extension-textbox'];
		}

		return $cart_item;
	}

	/*
	 * Modify item in the cart
	 * @since 0.1.0
	 */
	public function add_cart_item( $cart_item ) {

		// Adjust product in cart if checkbox is set
		if ( <%= opts.classPrefix %>_Helpers::is_product_checkbox( $cart_item['product_id'] ) ) {

			if ( isset( $cart_item['wc-boilerplate-extension-number'] ) ) {
				$cart_item['data']->price = $cart_item['data']->regular_price * 1.25;
			}

		}
		return $cart_item;
	}

	/*
	 * Validate before adding to cart
	 * @since 0.1.0
	 */
	public function validate_add_cart_item( $passed, $product_id, $quantity, $variation_id = '', $variations= '' ) {

		if ( <%= opts.classPrefix %>_Helpers::is_product_checkbox( $product_id ) ) {
			wc_add_notice( __( 'This is a sample notice message', '<%= opts.projectSlug %>' ), 'notice' );
		}

		if( <%= opts.classPrefix %>_Helpers::get_sample_number( $product_id ) < 10 ){
			$passed = false;
			wc_add_notice( __( 'This is a sample error message', '<%= opts.projectSlug %>' ), 'error' );
		}

		return $passed;
	}

} //end class

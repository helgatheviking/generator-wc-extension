<?php

namespace <%= opts.classPrefix %>;

/**
 * <%= opts.projectTitle %> order functions and filters.
 *
 * @class 	<%= opts.classPrefix %>_Order
 * @version <%= opts.version %>
 * @since   <%= opts.version %>
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Order {

	/**
	 * Setup order class
	 */
	public static function init() {

		// Filter price output shown in cart, review-order & order-details templates
		add_filter( 'woocommerce_order_formatted_line_subtotal', array( __CLASS__, 'order_item_subtotal' ), 10, 3 );

		// Modify order items to include bundle meta
		add_action( 'woocommerce_add_order_item_meta', array( __CLASS__, 'add_order_item_meta' ), 10, 3 );

	}


	/**
	 * Modify the subtotal of order-items (order-details.php)
	 *
	 * @param  string   $subtotal   the item subtotal
	 * @param  array    $item       the items
	 * @param  WC_Order $order      the order
	 * @return string               modified subtotal string.
	 * @since <%= opts.version %>
	 */
	public static function order_item_subtotal( $subtotal, $item, $order ) {
		return sprintf( __( 'Sample subtotal: %s', '<%= opts.projectSlug %>' ), $subtotal );
	}


	/**
	 * Add bundle info meta to order items.
	 *
	 * @param  int      $item_id      order item id
	 * @param  array    $cart_item_values   cart item data
	 * @return void
	 * @since <%= opts.version %>
	 */
	public static function add_order_item_meta( $item_id, $cart_item_values, $cart_item_key ) {

		// add data to the product
		if ( isset( $cart_item_values[ 'wc-boilerplate-extension-number' ] ) ) {
			wc_add_order_item_meta( $item_id, '_wc-boilerplate-extension-number', $cart_item_values[ 'wc-boilerplate-extension-number' ] );
		}

		if ( isset( $cart_item_values[ 'wc-boilerplate-extension-textbox' ] ) ) {
			wc_add_order_item_meta( $item_id, '_wc-boilerplate-extension-textbox', $cart_item_values[ 'wc-boilerplate-extension-textbox' ] );
		}

	}

}

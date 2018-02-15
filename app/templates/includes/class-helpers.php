<?php

namespace <%= opts.classPrefix %>;

/**
 * <%= opts.classPrefix %>_Helpers class
 *
 * @class 	<%= opts.classPrefix %>_Order
 * @version <%= opts.version %>
 * @since   <%= opts.version %>
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Helpers {


	/**
	 * Is the Sample Product Checkbox Checked
	 *
	 * @param  WC_Product object $product
	 * @return	boolean
	 * @access 	public
	 * @since 	<%= opts.version %>
	 */
	public static function is_product_checkbox( $product ) {
		if ( 'yes' == $product->get_meta( '_<%= opts.funcPrefix %>', true ) ) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Get the Sample Number
	 *
	 * @param  WC_Product object $product
	 * @return	boolean
	 * @access 	public
	 * @since 	<%= opts.version %>
	 */
	public static function get_sample_number( $product ) {
		return floatval( $product->get_meta( '_<%= opts.funcPrefix %>_number', true ) );
	}


	/**
	 * Get the Sample Textbox
	 * 
	 * @param  WC_Product object $product
	 * @return	boolean
	 * @access 	public
	 * @since 	<%= opts.version %>
	 */
	public static function get_sample_textbox( $product ) {
		return $product->get_meta( '_<%= opts.funcPrefix %>_textbox', true );
	}

} //end class
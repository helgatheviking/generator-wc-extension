<?php

namespace <%= opts.classPrefix %>;

/**
 * Functions related to front-end display
 *
 * @class 	<%= opts.classPrefix %>_Display
 * @version <%= opts.version %>
 * @since   <%= opts.version %>
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Display {

	/**
	 * Setup display class.
	 */
	public static function init() {

		// Single Product Display
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_scripts' ), 20 );
		add_action( 'woocommerce_before_add_to_cart_button', array( __CLASS__, 'display_template' ), 10 );

	}



	/*-----------------------------------------------------------------------------------*/
	/* Single Product Display Functions */
	/*-----------------------------------------------------------------------------------*/


	/**
	 * Register the script
	 *
	 * @since <%= opts.version %>
	 */
	public static function register_scripts() {

		wp_enqueue_style( '<%= opts.projectSlug %>', \<%= opts.classPrefix %>()->get_plugin_url() . '/assets/css/<%= opts.textDomain %>-frontend.css', false, \<%= opts.classPrefix %>::VERSION );

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_register_script( '<%= opts.projectSlug %>', \<%= opts.classPrefix %>()->get_plugin_url() . '/assets/js/<%= opts.textDomain %>'. $suffix . '.js', array( 'jquery' ), \<%= opts.classPrefix %>::VERSION, true );
	}


	/**
	 * Load the scripts
	 *
	 * @since <%= opts.version %>
	 */
	public static function load_scripts() {

		wp_enqueue_script( '<%= opts.projectSlug %>' );

		$params = array(
			'sample-string'  => __( 'A Localized String', '<%= opts.textDomain %>' ),
		);

		wp_localize_script( '<%= opts.projectSlug %>', '<%= opts.funcPrefix %>_params', $params );

	}


	/**
	 * Add a Template
	 *
	 * @since <%= opts.version %>
	 */
	public static function display_template( $product = null ){

		if( ! $product ) {
			global $product;
		}

		// load up the scripts
		$this->load_scripts();

		// display the template
		wc_get_template(
			'single-product/sample-template.php',
			array( 'product' => $product ),
			FALSE,
			<%= opts.classPrefix %>::get_plugin_path() . '/templates/' );

	}

} //end class

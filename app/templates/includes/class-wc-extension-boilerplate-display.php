<?php
/**
 * Functions related to front-end display
 *
 * @class 	<%= opts.classPrefix %>_Display
 * @version 0.1.0
 * @since   0.1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class <%= opts.classPrefix %>_Display {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Single Product Display
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 20 );
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'display_template' ), 10 );

	}



	/*-----------------------------------------------------------------------------------*/
	/* Single Product Display Functions */
	/*-----------------------------------------------------------------------------------*/


	/**
	 * Register the script
	 *
	 * @return void
	 */
	function register_scripts() {

		wp_enqueue_style( '<%= opts.projectSlug %>', <%= opts.classPrefix %>::$url . '/assets/css/<%= opts.textDomain %>-frontend.css', false, <%= opts.classPrefix %>::VERSION );

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_register_script( '<%= opts.projectSlug %>', <%= opts.classPrefix %>::$url . '/assets/js/<%= opts.textDomain %>'. $suffix . '.js', array( 'jquery' ), <%= opts.classPrefix %>::VERSION, true );
	}


	/**
	 * Load the scripts
	 *
	 * @return void
	 */
	function load_scripts() {

		wp_enqueue_script( '<%= opts.projectSlug %>' );

		$params = array(
			'sample-string'  => __( 'A Localized String', 'wc-boilerplate-extension', '<%= opts.projectSlug %>' ),
		);

		wp_localize_script( '<%= opts.projectSlug %>', '<%= opts.funcPrefix %>_params', $params );

	}


	/**
	 * Add a Template
	 *
	 * @return  void
	 * @since 0.1.0
	 */
	public function display_template(){

		global $product;

		// load up the scripts
		$this->load_scripts();

		// display the template
		wc_get_template(
			'single-product/sample-template.php',
			array( 'product_id' => $product->id ),
			FALSE,
			<%= opts.classPrefix %>::$dir . '/templates/' );

	}

} //end class

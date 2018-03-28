<?php

namespace <%= opts.classPrefix %>\Admin;

/**
 * <%= opts.projectTitle %> Admin Main Class
 *
 * Adds a setting tab and product meta.
 *
 * @package		<%= opts.projectTitle %>
 * @subpackage	<%= opts.classPrefix %>_Admin_Main
 * @category	Class
 * @author		<%= opts.authorName %>
 * @since		<%= opts.version %>
 */
class Main {

	/**
	 * Bootstraps the class and hooks required actions & filters.
	 *
	 * @since <%= opts.version %>
	 */
	public static function init() {

		if( ! defined( 'DOING_AJAX' ) ) {

			// Settings Link for Plugin page
			add_filter( 'plugin_action_links_<%= opts.textDomain %>/<%= opts.textDomain %>.php', array( __CLASS__, 'add_action_link' ) );

			// Product Meta boxes
			add_filter( 'product_type_options', array( __CLASS__, 'product_type_options' ) );
			add_action( 'woocommerce_product_options_general_product_data', array( __CLASS__, 'add_to_metabox' ) );
			add_action( 'woocommerce_process_product_meta', array( __CLASS__, 'save_product_meta' ), 20, 2 );

			// Admin Scripts
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'meta_box_script'), 20 );

			// Admin Settings via settings API
			add_filter( 'woocommerce_get_settings_pages', array( __CLASS__, 'add_settings_page' ) );

		}

	}


	/*-----------------------------------------------------------------------------------*/
	/* Plugins Page */
	/*-----------------------------------------------------------------------------------*/

	/*
	 * 'Settings' link on plugin page
	 *
	 * @param array $links
	 * @return array
	 * @since <%= opts.version %>
	 */

	public static function add_action_link( $links ) {
		$settings_link = '<a href="'.admin_url('admin.php?page=wc-settings&tab=<%= opts.textDomain %>').'" title="'.__('Go to the settings page', '<%= opts.projectSlug %>').'">'.__( 'Settings', '<%= opts.projectSlug %>' ).'</a>';
		return array_merge( (array) $settings_link, $links );

	}

    /*-----------------------------------------------------------------------------------*/
	/* Write Panel / metabox */
	/*-----------------------------------------------------------------------------------*/

	/*
	 * Add checkbox to product data metabox title
	 *
	 * @param array $options
	 * @return array
	 * @since <%= opts.version %>
	 */
	public static function product_type_options( $options ){

	  $options['<%= opts.funcPrefix %>'] = array(
	      'id' => '_<%= opts.funcPrefix %>',
	      'wrapper_class' => 'show_if_simple',
	      'label' => __( '<%= opts.projectTitle %>', '<%= opts.projectSlug %>'),
	      'description' => __( 'A description of this checkbox', '<%= opts.projectSlug %>'),
	      'default' => 'no'
	    );

	  return $options;

	}

	/*
	 * Add text inputs to product metabox
	 *
	 * @return print HTML
	 * @since <%= opts.version %>
	 */
	public static function add_to_metabox(){
		global $post;

		echo '<div class="options_group">';

			// Checkbox
			woocommerce_wp_checkbox( array(
						'id' => '_<%= opts.funcPrefix %>_checkbox',
						'wrapper_class' => 'show_if_simple',
						'label' => __( 'Sample Checkbox', '<%= opts.projectSlug %>' ),
						'description' => __( 'This is a sample checkbox.', '<%= opts.projectSlug %>' ) ) );

			// Number
			woocommerce_wp_text_input( array(
				'id' => '_<%= opts.funcPrefix %>_number',
				'class' => 'show_if_simple',
				'label' => __( 'Sample Number Field', '<%= opts.projectSlug %>' ),
				'desc_tip' => 'true',
				'description' => __( 'This is a sample number field', '<%= opts.projectSlug %>' ),
				'type'	=> 'decimal'
			) );

			// Text
			woocommerce_wp_text_input( array(
				'id' => '_<%= opts.funcPrefix %>_textbox',
				'class' => 'show_if_simple',
				'label' => __( 'Sample Text Field', '<%= opts.projectSlug %>' ),
				'desc_tip' => 'true',
				'description' => __( 'This is a sample text field', '<%= opts.projectSlug %>' )
			) );

			do_action( '<%= opts.funcPrefix %>_product_options' );

		echo '</div>';

	  }


	/*
	 * Save extra meta info
	 *
	 * @param int $post_id
	 * @param object $post
	 * @return void
	 */
	public static function save_product_meta( $post_id, $post ) {

	   	$product_type 	= empty( $_POST['product-type'] ) ? 'simple' : sanitize_title( stripslashes( $_POST['product-type'] ) );
	   	$suggested = '';

	   	if ( isset( $_POST['_<%= opts.funcPrefix %>'] ) ) {
			update_post_meta( $post_id, '_<%= opts.funcPrefix %>', 'yes' );
		} else {
			update_post_meta( $post_id, '_<%= opts.funcPrefix %>', 'no' );
		}

		if ( isset( $_POST['_<%= opts.funcPrefix %>_checkbox'] ) && 'yes' == $_POST['_<%= opts.funcPrefix %>_checkbox'] ) {
			update_post_meta( $post_id, '_<%= opts.funcPrefix %>_checkbox', 'yes' );
		} else {
			update_post_meta( $post_id, '_<%= opts.funcPrefix %>_checkbox', 'no' );
		}

		if ( isset( $_POST['_<%= opts.funcPrefix %>_number'] ) ) {
			update_post_meta( $post_id, '_<%= opts.funcPrefix %>_number', floatval( $_POST['_<%= opts.funcPrefix %>_number'] ) );
		}

		if ( isset( $_POST['_<%= opts.funcPrefix %>_textbox'] ) ) {
			update_post_meta( $post_id, '_<%= opts.funcPrefix %>_textbox', sanitize_text_field( $_POST['_<%= opts.funcPrefix %>_textbox'] ) );
		}

	}


	/*
	 * Javascript to handle the metabox options
	 *
	 * @param string $hook
	 * @return void
	 * @since <%= opts.version %>
	 */
    public static function meta_box_script( $hook ){

		// check if on Edit-Post page (post.php or new-post.php).
		if( ! in_array( $hook, array( 'post-new.php', 'post.php' ) ) ){
			return;
		}

		// now check to see if the $post type is 'product'
		global $post;
		if ( ! isset( $post ) || 'product' != $post->post_type ){
			return;
		}

		// enqueue and localize
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script( '<%= opts.funcPrefix %>_admin', <%= opts.classPrefix %>::$url . '/assets/js/<%= opts.textDomain %>-admin'. $suffix . '.js', array( 'jquery' ), <%= opts.classPrefix %>::VERSION, true );

		$i18n = array ( 'sample_string' => __( 'Sample String', '<%= opts.projectSlug %>' ) );

		wp_localize_script( '<%= opts.funcPrefix %>_admin', '<%= opts.funcPrefix %>_admin', $i18n );

	}

	/*-----------------------------------------------------------------------------------*/
	/* Admin Settings */
	/*-----------------------------------------------------------------------------------*/

	/*
	 * Include the settings page class
	 * compatible with WooCommerce 2.1
	 *
	 * @param array $settings ( the included settings pages )
	 * @return array
	 * @since <%= opts.version %>
	 */
	public static function add_settings_page( $settings ) {
		$settings[] = include( 'class-<%= opts.textDomain %>-admin-settings.php' );
		return $settings;
	}

}

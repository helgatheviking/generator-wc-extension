<?php
/**
 * <%= props.projectTitle %> Admin Main Class
 *
 * Adds a setting tab and product meta.
 *
 * @package		<%= props.projectTitle %>
 * @subpackage	<%= props.classPrefix %>_Admin_Main
 * @category	Class
 * @author		<%= props.authorName %>
 * @since		0.1.0
 */
class <%= props.classPrefix %>_Admin {

	/**
	 * Bootstraps the class and hooks required actions & filters.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		if( ! defined( 'DOING_AJAX' ) ) {

			// Settings Link for Plugin page
			add_filter( 'plugin_action_links_<%= props.textDomain %>/<%= props.textDomain %>.php', array( $this, 'add_action_link' ) );

			// Product Meta boxes
			add_filter( 'product_type_options', array( $this, 'product_type_options' ) );
			add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_to_metabox' ) );
			add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_meta' ), 20, 2 );

			// Admin Scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'meta_box_script'), 20 );

			// Admin Settings via settings API
			add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_settings_page' ) );

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
	 * @since 1.0
	 */

	public function add_action_link( $links ) {
		$settings_link = '<a href="'.admin_url('admin.php?page=wc-settings&tab=<%= props.textDomain %>').'" title="'.__('Go to the settings page', '<%= props.projectSlug %>').'">'.__( 'Settings', '<%= props.projectSlug %>' ).'</a>';
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
	 * @since 0.1.0
	 */
	public function product_type_options( $options ){

	  $options['<%= props.funcPrefix %>'] = array(
	      'id' => '_<%= props.funcPrefix %>',
	      'wrapper_class' => 'show_if_simple',
	      'label' => __( '<%= props.projectTitle %>', '<%= props.projectSlug %>'),
	      'description' => __( 'A description of this checkbox', '<%= props.projectSlug %>'),
	      'default' => 'no'
	    );

	  return $options;

	}

	/*
	 * Add text inputs to product metabox
	 *
	 * @return print HTML
	 * @since 0.1.0
	 */
	public function add_to_metabox(){
		global $post;

		echo '<div class="options_group">';

			// Checkbox
			woocommerce_wp_checkbox( array(
						'id' => '_<%= props.funcPrefix %>_checkbox',
						'wrapper_class' => 'show_if_simple',
						'label' => __( 'Sample Checkbox', '<%= props.projectSlug %>' ),
						'description' => __( 'This is a sample checkbox.', '<%= props.projectSlug %>' ) ) );

			// Number
			woocommerce_wp_text_input( array(
				'id' => '_<%= props.funcPrefix %>_number',
				'class' => 'show_if_simple',
				'label' => __( 'Sample Number Field', '<%= props.projectSlug %>' ),
				'desc_tip' => 'true',
				'description' => __( 'This is a sample number field', '<%= props.projectSlug %>' ),
				'type'	=> 'decimal'
			) );

			// Text
			woocommerce_wp_text_input( array(
				'id' => '_<%= props.funcPrefix %>_textbox',
				'class' => 'show_if_simple',
				'label' => __( 'Sample Text Field', '<%= props.projectSlug %>' ),
				'desc_tip' => 'true',
				'description' => __( 'This is a sample text field', '<%= props.projectSlug %>' )
			) );

			do_action( '<%= props.funcPrefix %>_product_options' );

		echo '</div>';

	  }


	/*
	 * Save extra meta info
	 *
	 * @param int $post_id
	 * @param object $post
	 * @return void
	 */
	public function save_product_meta( $post_id, $post ) {

	   	$product_type 	= empty( $_POST['product-type'] ) ? 'simple' : sanitize_title( stripslashes( $_POST['product-type'] ) );
	   	$suggested = '';

	   	if ( isset( $_POST['_<%= props.funcPrefix %>'] ) ) {
			update_post_meta( $post_id, '_<%= props.funcPrefix %>', 'yes' );
		} else {
			update_post_meta( $post_id, '_<%= props.funcPrefix %>', 'no' );
		}

		if ( isset( $_POST['_<%= props.funcPrefix %>_checkbox'] ) && 'yes' == $_POST['_<%= props.funcPrefix %>_checkbox'] ) {
			update_post_meta( $post_id, '_<%= props.funcPrefix %>_checkbox', 'yes' );
		} else {
			update_post_meta( $post_id, '_<%= props.funcPrefix %>_checkbox', 'no' );
		}

		if ( isset( $_POST['_<%= props.funcPrefix %>_number'] ) ) {
			update_post_meta( $post_id, '_<%= props.funcPrefix %>_number', floatval( $_POST['_<%= props.funcPrefix %>_number'] ) );
		}

		if ( isset( $_POST['_<%= props.funcPrefix %>_textbox'] ) ) {
			update_post_meta( $post_id, '_<%= props.funcPrefix %>_textbox', sanitize_text_field( $_POST['_<%= props.funcPrefix %>_textbox'] ) );
		}

	}


	/*
	 * Javascript to handle the metabox options
	 *
	 * @param string $hook
	 * @return void
	 * @since 0.1.0
	 */
    public function meta_box_script( $hook ){

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

		wp_enqueue_script( '<%= props.funcPrefix %>_admin', <%= props.classPrefix %>::$url . '/assets/js/<%= props.textDomain %>-admin'. $suffix . '.js', array( 'jquery' ), <%= props.classPrefix %>::VERSION, true );

		$i18n = array ( 'sample_string' => __( 'Sample String', '<%= props.projectSlug %>' ) );

		wp_localize_script( '<%= props.funcPrefix %>_admin', '<%= props.funcPrefix %>_admin', $i18n );

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
	 * @since 0.1.0
	 */
	public function add_settings_page( $settings ) {
		$settings[] = include( 'class-<%= props.textDomain %>-admin-settings.php' );
		return $settings;
	}

}

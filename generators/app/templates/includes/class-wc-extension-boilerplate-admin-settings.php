<?php
/**
 * <%= props.projectTitle %> Settings
 *
 * @author 		<%= props.authorName %>
 * @category 	Admin
 * @package 	<%= props.classPrefix %>/Admin
 * @version     2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( '<%= props.classPrefix %>_Admin_Settings' ) ) :

/**
 * <%= props.classPrefix %>_Admin_Settings
 */
class <%= props.classPrefix %>_Admin_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = '<%= props.textDomain %>';
		$this->label = __( '<%= props.projectTitle %>', '<%= props.projectSlug %>' );

		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		return apply_filters( 'woocommerce_' . $this->id . '_settings', array(

			array( 
				'id' => '<%= props.funcPrefix %>_options_group_a' ,
				'title' => __( '<%= props.projectTitle %> Settings', '<%= props.projectSlug %>' ), 
				'type' => 'title', 
				'desc' =>  __( 'Modify the text strings used by the Name Your Own Price extension.', '<%= props.projectSlug %>' )
			),

			array(
				'title' => __( 'Sample Text Field', '<%= props.projectSlug %>' ),
				'desc' 		=> __( 'This is a sample text field.', '<%= props.projectSlug %>' ),
				'id' 		=> '<%= props.funcPrefix %>_sample_text',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'default'	=> __( 'Default value', '<%= props.projectSlug %>' ),
				'desc_tip'	=>  true,
			),

			array( 
				'type' => 'sectionend', 
				'id' => '<%= props.funcPrefix %>_options_group_a' 
			),

			array( 
				'title' => __( '<%= props.projectTitle %> Additional Settings', '<%= props.projectSlug %>' ), 
				'type' => 'title',
				'id' => '<%= props.funcPrefix %>_options_group_b' 
			),

			array(
				'title' => __( '<%= props.projectTitle %> Sample Checkbox', '<%= props.projectSlug %>' ),
				'id' 		=> '<%= props.funcPrefix %>_sample_checkbox',
				'type' 		=> 'checkbox',
				'default'		=> 'no',
			),

			array( 
				'type' => 'sectionend', 
				'id' => '<%= props.funcPrefix %>_options_group_b' 
			),

		)); // End pages settings
	}
}

endif;

return new <%= props.classPrefix %>_Admin_Settings();
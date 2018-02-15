<?php

namespace <%= opts.classPrefix %>\Admin;

/**
 * <%= opts.projectTitle %> Settings
 *
 * @author 		<%= opts.authorName %>
 * @category 	Admin
 * @package 	<%= opts.classPrefix %>/Admin
 * @version     2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Settings
 */
class Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = '<%= opts.textDomain %>';
		$this->label = __( '<%= opts.projectTitle %>', '<%= opts.projectSlug %>' );

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
				'id' => '<%= opts.funcPrefix %>_options_group_a' ,
				'title' => __( '<%= opts.projectTitle %> Settings', '<%= opts.projectSlug %>' ), 
				'type' => 'title', 
				'desc' =>  __( 'Modify the text strings used by the Name Your Own Price extension.', '<%= opts.projectSlug %>' )
			),

			array(
				'title' => __( 'Sample Text Field', '<%= opts.projectSlug %>' ),
				'desc' 		=> __( 'This is a sample text field.', '<%= opts.projectSlug %>' ),
				'id' 		=> '<%= opts.funcPrefix %>_sample_text',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'default'	=> __( 'Default value', '<%= opts.projectSlug %>' ),
				'desc_tip'	=>  true,
			),

			array( 
				'type' => 'sectionend', 
				'id' => '<%= opts.funcPrefix %>_options_group_a' 
			),

			array( 
				'title' => __( '<%= opts.projectTitle %> Additional Settings', '<%= opts.projectSlug %>' ), 
				'type' => 'title',
				'id' => '<%= opts.funcPrefix %>_options_group_b' 
			),

			array(
				'title' => __( '<%= opts.projectTitle %> Sample Checkbox', '<%= opts.projectSlug %>' ),
				'id' 		=> '<%= opts.funcPrefix %>_sample_checkbox',
				'type' 		=> 'checkbox',
				'default'		=> 'no',
			),

			array( 
				'type' => 'sectionend', 
				'id' => '<%= opts.funcPrefix %>_options_group_b' 
			),

		)); // End pages settings
	}
}

return new <%= opts.classPrefix %>/Admin/Settings();
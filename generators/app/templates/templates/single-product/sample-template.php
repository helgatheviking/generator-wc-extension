<?php
/**
 * Template
 * 
 * @author 		<%= props.authorName %>
 * @package 	<%= props.classPrefix %>/Templates
 * @version     0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<div class="<%= props.projectSlug %>">

	<?php do_action( '<%= props.funcPrefix %>_before_template', $product_id ); ?>

	<p><?php _e( '<%= props.projectTitle %> Template', '<%= props.projectSlug %>' ); ?><p>

	<?php if ( $option = get_option( '<%= props.funcPrefix %>_sample_text' ) ) {
		printf( '<p>' . __( 'Sample Text Option: %s', '<%= props.projectSlug %>') . '</p>', $option );
	}
	?>

	<?php if ( $meta = <%= props.classPrefix %>_Helpers::get_sample_textbox( $product_id ) ) {
		printf( '<p>' . __( 'Sample Text Meta: %s', '<%= props.projectSlug %>') . '</p>', $meta );
	}
	?>

	<?php do_action( '<%= props.funcPrefix %>_after_template', $product_id ); ?>

</div>
<?php
/**
 * Template
 * 
 * @author 		<%= opts.authorName %>
 * @package 	<%= opts.classPrefix %>/Templates
 * @version     0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<div class="<%= opts.projectSlug %>">

	<?php do_action( '<%= opts.funcPrefix %>_before_template', $product_id ); ?>

	<p><?php _e( '<%= opts.projectTitle %> Template', '<%= opts.projectSlug %>' ); ?><p>

	<?php if ( $option = get_option( '<%= opts.funcPrefix %>_sample_text' ) ) {
		printf( '<p>' . __( 'Sample Text Option: %s', '<%= opts.projectSlug %>') . '</p>', $option );
	}
	?>

	<?php if ( $meta = <%= opts.classPrefix %>_Helpers::get_sample_textbox( $product_id ) ) {
		printf( '<p>' . __( 'Sample Text Meta: %s', '<%= opts.projectSlug %>') . '</p>', $meta );
	}
	?>

	<?php do_action( '<%= opts.funcPrefix %>_after_template', $product_id ); ?>

</div>
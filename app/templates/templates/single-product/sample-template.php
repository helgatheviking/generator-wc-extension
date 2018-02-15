<?php
/**
 * Template
 * 
 * @author 		<%= opts.authorName %>
 * @package 	<%= opts.classPrefix %>/Templates
 * @version     <%= opts.version %>
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<div class="<%= opts.projectSlug %>">

	<?php do_action( '<%= opts.funcPrefix %>_before_template', $product ); ?>

	<p><?php _e( '<%= opts.projectTitle %> Template', '<%= opts.textDomain %>' ); ?><p>

	<?php if ( $option = get_option( '<%= opts.funcPrefix %>_sample_text' ) ) {
		printf( '<p>' . __( 'Sample Text Option: %s', '<%= opts.textDomain %>') . '</p>', $option );
	}
	?>

	<?php if ( $meta = \<%= opts.classPrefix %>\Helpers::get_sample_textbox( $product ) ) {
		printf( '<p>' . __( 'Sample Text Meta: %s', '<%= opts.textDomain %>') . '</p>', $meta );
	}
	?>

	<?php do_action( '<%= opts.funcPrefix %>_after_template', $product ); ?>

</div>
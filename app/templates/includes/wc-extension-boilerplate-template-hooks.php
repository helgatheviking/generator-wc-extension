<?php
/**
 * <%= opts.projectTitle %> template hooks
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( '<%= opts.funcPrefix %>_before_template', '<%= opts.funcPrefix %>_before_template' );
add_action( '<%= opts.funcPrefix %>_after_template', '<%= opts.funcPrefix %>_after_template' );
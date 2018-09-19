<?php
/**
 * <%= props.projectTitle %> template hooks
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( '<%= props.funcPrefix %>_before_template', '<%= props.funcPrefix %>_before_template' );
add_action( '<%= props.funcPrefix %>_after_template', '<%= props.funcPrefix %>_after_template' );
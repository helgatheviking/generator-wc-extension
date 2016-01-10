<?php
/**
 * <%= opts.projectTitle %> template functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function <%= opts.funcPrefix %>_before_template(){
	echo '<p>' . __( 'Before Template', '<%= opts.projectSlug %>' ) . '</p>';
}

function <%= opts.funcPrefix %>_after_template(){
	echo '<p>' . __( 'After Template', '<%= opts.projectSlug %>' ) . '</p>';
}
<?php
/**
 * <%= props.projectTitle %> template functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function <%= props.funcPrefix %>_before_template(){
	echo '<p>' . __( 'Before Template', '<%= props.projectSlug %>' ) . '</p>';
}

function <%= props.funcPrefix %>_after_template(){
	echo '<p>' . __( 'After Template', '<%= props.projectSlug %>' ) . '</p>';
}
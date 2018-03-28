<?php

namespace <%= opts.classPrefix %>\Compatibility;

/**
 * Load classes related to extension cross-compatibility
 *
 * @class 	<%= opts.classPrefix %>_Compatibility
 * @version <%= opts.version %>
 * @since   <%= opts.version %>
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ){
	exit; 	
}

class Main {

	function __construct() {

		add_action( 'plugins_loaded', array( __CLASS__, 'init' ) );

	}

	/**
	 * Launch compatibility modules.
	 *
	 * @return	void
	 * @access	public
	 * @since	@since <%= opts.version %>
	 */
	public static function init() {

	}



} // end class
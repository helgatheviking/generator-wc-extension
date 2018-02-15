<?php
/**
 * Plugin Name: <%= opts.projectTitle %>
 * Plugin URI:  <%= opts.projectHome %>
 * Description: <%= opts.description %>
 * Version:     0.1.0
 * Author:      <%= opts.authorName %>
 * Author URI:  <%= opts.authorUrl %>
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: <%= opts.funcPrefix %>
 * Domain Path: /languages
 * Requires at least: 3.8.0
 * Tested up to: 4.4.0
 * WC requires at least: 2.4.0
 * WC tested up to: 2.5.0   
 */

/**
 * Copyright: © <%= opts.Year %> <%= opts.authorName %>.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * The Main <%= opts.classPrefix %> class
 **/
if ( ! class_exists( '<%= opts.classPrefix %>' ) ) :

class <%= opts.classPrefix %> {

	const VERSION = '0.1.0';
	const PREFIX  = '<%= opts.classPrefix %>';
	const REQUIRED_WC = '2.1.0';

	/**
	 * @var <%= opts.classPrefix %> - the single instance of the class
	 * @since 0.1.0
	 */
	protected static $instance = null;            

	/**
	 * Plugin Directory
	 *
	 * @since 0.1.0
	 * @var string $dir
	 */
	public static $dir = '';

	/**
	 * Plugin URL
	 *
	 * @since 0.1.0
	 * @var string $url
	 */
	public static $url = '';


	/**
	 * Main <%= opts.classPrefix %> Instance
	 *
	 * Ensures only one instance of <%= opts.classPrefix %> is loaded or can be loaded.
	 *
	 * @static
	 * @see <%= opts.classPrefix %>()
	 * @return <%= opts.classPrefix %> - Main instance
	 * @since <%= opts.version %>
	 */
	public static function get_instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since <%= opts.version %>
	 */
	public function __clone() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', '<%= opts.textDomain %>' ) );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since <%= opts.version %>
	 */
	public function __wakeup() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', '<%= opts.textDomain %>' ) );
	}


	/**
	 * Construct the instance of <%= opts.classPrefix %>  
	 */
	public function __construct(){
		$this->includes();
		$this->init_hooks();
	}


	/*-----------------------------------------------------------------------------------*/
	/* Required Files */
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Include required core files used in admin and on the frontend
	 * 
	 * @since       <%= opts.version %>
	 */
	public function includes(){

		// Include our autoloader.
		require_once( 'includes/autoloader/autoloader.php' );

		// Include admin class to handle all backend functions.
		if( is_admin() ){
			update_option( '<%= opts.funcPrefix %>_version', self::VERSION );
			<%= opts.classPrefix %>\Admin\Main::init();
		}

		// Include the front-end functions.
		if ( ! is_admin() ) {
			<%= opts.classPrefix %>\Display::init();
			<%= opts.classPrefix %>\Cart::init();
			<%= opts.classPrefix %>\Order::init();
		}

		// For compatibility with other extensions.
		<%= opts.classPrefix %>\Compatibility\Main::init();
	}

	/**
	 * Add actions and filters
	 *
	 * @since       <%= opts.version %>
	 */
	private function init_hooks() {

		register_activation_hook( WC_PLUGIN_FILE, array( __CLASS__, 'install' ) );
		
		// Load translation files.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Check we're running the required version of WC.
		if ( ! defined( 'WC_VERSION' ) || version_compare( WC_VERSION, self::REQUIRED_WC, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice' ) );
			return false;
		}

		// Include required files.
		add_action( 'after_setup_theme', array( $this, 'template_includes' ) );
	}

	/**
	 * Include frontend functions and hooks
	 *
	 * @return void
	 * @since  <%= opts.version %>
	 */
	public static function template_includes(){
		require_once( 'includes/<%= opts.textDomain %>-template-functions.php' );
		require_once( 'includes/<%= opts.textDomain %>-template-hooks.php' );
	}


	/**
	 * Displays a warning message if version check fails.
	 * @return string
	 * @since  2.1
	 */
	public function admin_notice() {
		echo '<div class="error"><p>' . sprintf( __( '<%= opts.projectTitle %> requires at least WooCommerce %s in order to function. Please upgrade WooCommerce.', 'woocommerce-mix-and-match-products', '<%= opts.projectSlug %>' ), self::REQUIRED_WC ) . '</p></div>';
	}


	/*-----------------------------------------------------------------------------------*/
	/* Localization */
	/*-----------------------------------------------------------------------------------*/


	/**
	 * Make the plugin translation ready
	 *
	 * @return void
	 * @since  1.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( '<%= opts.textDomain %>' , false , dirname( plugin_basename( __FILE__ ) ) .  '/languages/' );
	}


} //end class: do not remove or there will be no more guacamole for you

endif; // end class_exists check


/**
 * Returns the main instance of <%= opts.classPrefix %> to prevent the need to use globals.
 *
 * @since  2.0
 * @return <%= opts.classPrefix %>
 */
function <%= opts.classPrefix %>() {
	return <%= opts.classPrefix %>::instance();
}

// Launch the whole plugin
add_action( 'woocommerce_loaded', '<%= opts.classPrefix %>' );
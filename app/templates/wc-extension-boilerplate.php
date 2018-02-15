<?php
/**
 * Plugin Name: <%= opts.projectTitle %>
 * Plugin URI:  <%= opts.projectHome %>
 * Description: <%= opts.description %>
 * Version:     <%= opts.version %>
 * Author:      <%= opts.authorName %>
 * Author URI:  <%= opts.authorUrl %>
 * Requires at least: 4.4.0
 * Tested up to: 4.8.2
 * WC requires at least: 3.0.0
 * WC tested up to: 3.3.0
 * 
 * Text Domain: <%= opts.funcPrefix %>
 * Domain Path: /languages
 *
 * @author <%= opts.authorName %>
 * @category Core
 * @package <%= opts.projectTitle %>
 *
 * Copyright: © <%= opts.Year %> <%= opts.authorName %>.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * The Main <%= opts.classPrefix %> class
 **/
if ( ! class_exists( '<%= opts.classPrefix %>' ) ) :

class <%= opts.classPrefix %> {

	const VERSION = '<%= opts.version %>';
	const PREFIX  = '<%= opts.classPrefix %>';
	const REQUIRED_WC = '3.0.0';

	/**
	 * @var <%= opts.classPrefix %> - the single instance of the class
	 * @since <%= opts.version %>
	 */
	protected static $_instance = null;            

	/**
	 * Plugin Path Directory
	 *
	 * @since <%= opts.version %>
	 * @var string $path
	 */
	private $path = '';

	/**
	 * Plugin URL
	 *
	 * @since <%= opts.version %>
	 * @var string $url
	 */
	private $url = '';


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
	 * @since  <%= opts.version %>
	 */
	public function admin_notice() {
		echo '<div class="error"><p>' . sprintf( __( '<%= opts.projectTitle %> requires at least WooCommerce %s in order to function. Please upgrade WooCommerce.', '<%= opts.textDomain %>' ), self::REQUIRED_WC ) . '</p></div>';
	}

	/*-----------------------------------------------------------------------------------*/
	/* Install */
	/*-----------------------------------------------------------------------------------*/


	/**
	 * Do something on install.
	 *
	 * @return void
	 * @since  <%= opts.version %>
	 */
	public function install() {}


	/*-----------------------------------------------------------------------------------*/
	/* Localization */
	/*-----------------------------------------------------------------------------------*/


	/**
	 * Make the plugin translation ready
	 *
	 * @return void
	 * @since  <%= opts.version %>
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( '<%= opts.textDomain %>' , false , dirname( plugin_basename( __FILE__ ) ) .  '/languages/' );
	}


	/*-----------------------------------------------------------------------------------*/
	/* Helpers */
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Get plugin URL
	 *
	 * @return string
	 * @since  <%= opts.version %>
	 */
	public function get_plugin_url() {
		if( $this->url == '' ) {
			$this->url = untrailingslashit( plugins_url( '/', __FILE__ ) );
		}
		return $this->url;
	}

	/**
	 * Get plugin path
	 *
	 * @return string
	 * @since  <%= opts.version %>
	 */
	public function get_plugin_path() {
		if( $this->path == '' ) {
			$this->path = untrailingslashit( plugin_dir_path( __FILE__ ) );
		}
		return $this->path;

	}

} // End class: do not remove or there will be no more guacamole for you.

endif; // End class_exists check.


/**
 * Returns the main instance of <%= opts.classPrefix %> to prevent the need to use globals.
 *
 * @since  <%= opts.version %>
 * @return <%= opts.classPrefix %>
 */
function <%= opts.classPrefix %>() {
	return <%= opts.classPrefix %>::get_instance();
}

// Launch the whole plugin.
add_action( 'woocommerce_loaded', '<%= opts.classPrefix %>' );
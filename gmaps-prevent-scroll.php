<?php
/**
 * Plugin Name: Google Maps Prevent Scroll
 * Plugin URI: https://longtailcreative.com/google-maps-prevent-scroll-plugin/
 * Description: Wordpress Plugin to prevent the scroll of Google Maps windows. Sourced from https://github.com/diazemiliano/googlemaps-scrollprevent
 * Version: 1.0.0
 * Author: Gabe Lloyd
 * Author URI: https://longtailcreative.com
 * Requires at least: 4.0.0
 * Tested up to: 4.0.0
 *
 * Text Domain: google-maps-prevent-scroll-plugin
 * Domain Path: /languages/
 *
 * @package gMap_PreventScroll
 * @category Core
 * @author Gabe Lloyd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of gMap_PreventScroll to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object gMap_PreventScroll
 */
function gMap_PreventScroll() {
	return gMap_PreventScroll::instance();
} // End gMap_PreventScroll()

add_action( 'plugins_loaded', 'gMap_PreventScroll' );

/**
 * Main gMap_PreventScroll Class
 *
 * @class gMap_PreventScroll
 * @version	1.0.0
 * @since 1.0.0
 * @package	gMap_PreventScroll
 * @author Gabe Lloyd
 */
final class gMap_PreventScroll {
	/**
	 * gMap_PreventScroll The single instance of gMap_PreventScroll.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * The plugin directory URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_url;

	/**
	 * The plugin directory path.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_path;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * The settings object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings;
	// Admin - End

	// Post Types - Start
	/**
	 * The post types we're registering.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $post_types = array();
	// Post Types - End
	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 */
	public function __construct () {
		$this->token 			= 'google-maps-prevent-scroll-plugin';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';

		// Admin - Start
		require_once( 'classes/class-google-maps-prevent-scroll-plugin-settings.php' );
			$this->settings = gMap_PreventScroll_Settings::instance();

		if ( is_admin() ) {
			require_once( 'classes/class-google-maps-prevent-scroll-plugin-admin.php' );
			$this->admin = gMap_PreventScroll_Admin::instance();
		}
		// Admin - End

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
	} // End __construct()

	/**
	 * Main gMap_PreventScroll Instance
	 *
	 * Ensures only one instance of gMap_PreventScroll is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see gMap_PreventScroll()
	 * @return Main gMap_PreventScroll instance
	 */
	public static function instance () {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 * @access  public
	 * @since   1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'google-maps-prevent-scroll-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	} // End load_plugin_textdomain()

	/**
	 * Cloning is forbidden.
	 * @access public
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 * @access public
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __wakeup()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 */
	public function install () {
		$this->_log_version_number();
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 */
	private function _log_version_number () {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	} // End _log_version_number()
} // End Class

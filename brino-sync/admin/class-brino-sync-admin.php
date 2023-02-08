<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://brino.sk
 * @since      1.0.0
 *
 * @package    Brino_Sync
 * @subpackage Brino_Sync/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Brino_Sync
 * @subpackage Brino_Sync/admin
 * @author     Brino <leklement@protonmail.com>
 */
class Brino_Sync_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version; 
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Brino_Sync_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Brino_Sync_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/brino-sync-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Brino_Sync_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Brino_Sync_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/brino-sync-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add our custom menu.
	 *
	 * @since    1.0.0
	 */
	public function my_admin_menu() {
		add_menu_page( 'Brino Plugin', 'Brino Settings', 'manage_options', 'Brino Sync', array($this, 'brino_sync_admin_page'), 'dashicons-cloud-upload', 250);
		add_submenu_page( 'Brino Sync', 'Categories Sync', 'Sync Categories', 'manage_options', 'plugin-name/importer.php', array($this, 'brino_sync_admin_sub_page_category'));
		
	}

	public function brino_sync_admin_page() {
		// return views
		require_once 'partials/brino-sync-admin-display.php';
	}

	public function brino_sync_admin_sub_page_category() {
		// return views
		require_once 'partials/brino-sync-admin-categories-display.php';
	}

	/**
	 * Register custom fields for plugin settings
	 *
	 * @since    1.0.0
	 */
	public function register_brino_general_settings() {
		//register settings for brino plugin
		register_setting('brinocustomsettings', 'brinnoApikey');
	}

}

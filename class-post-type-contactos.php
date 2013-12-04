<?php
/**
 * Post Type Contactos.
 *
 * @package   Post_Type_Contactos
 * @author    Matias Esteban <estebanmatias92@gmail.com>
 * @license   MIT License
 * @link      http://example.com
 * @copyright 2013 Matias Esteban
 */

// Includes
require_once( 'includes/helpers.php' );
require_once( 'views/class-contactos-post-public.php' );
require_once( 'includes/class-contactos-set-post-type.php' );
require_once( 'includes/class-contactos-set-meta-social.php' );
require_once( 'includes/class-contactos-set-post-avatar.php' );
require_once( 'includes/class-contactos-upload-avatar.php' );
require_once( 'includes/class-contactos-get-templates.php' );

/**
 * Post_Type_Contactos.
 *
 * Plugin class, creates a contact post-type, to post contact profiles.
 *
 * @package Post_Type_Contactos
 * @author  Matias Esteban <estebanmatias92@gmail.com>
 */
class Post_Type_Contactos {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   0.1.0
	 *
	 * @var     string
	 */
	protected $version = '0.1.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected static $plugin_slug = 'post_type_contactos';

	/**
	 * Instance of this class.
	 *
	 * @since    0.1.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * [$entities description]
	 *
	 * @var array
	 */
	protected static $entities = array(

        'Hombre' => array(
			'ID'  => '',
			'url' => ''
        ),

        'Mujer'  => array(
			'ID'  => '',
			'url' => ''
        )

    );

    /**
	 * Plugin default post type and tax values.
	 */
	protected static $post_type     = 'contactos';

	protected static $type_singular = 'Contacto';

	protected static $type_name     = 'Contactos';

	protected static $taxonomy      = 'ciudad';

	protected static $tax_singular  = 'Ciudad';

	protected static $tax_name      = 'Ciudades';

	/**
	 * Name for the post type page and menu item.
	 *
	 * @var string
	 */
	protected static $page_name = '';


	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     0.1.0
	 */
	private function __construct() {

		// Create post type, taxonomies and meta boxes
		add_action( 'after_setup_theme', array( $this, 'create_type_tax_and_meta' ) );

		// Update values
		self::$page_name = self::$type_name;
		add_action( 'wp_loaded', array( $this, 'set_properties' ) );

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Set post custom post columns in admin view
		add_action( 'admin_init', array( $this, 'admin_columns' ), 9 );

		// Set default thumbnail and social meta data
		add_action( 'admin_init', array( $this, 'set_thumbnail_and_meta' ), 10 );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) ); // BORRAR !!!!!!

		// Get the post type templates
		add_filter( 'template_include', array( $this, 'template_chooser' ) );

		// Get content template part for plugin
		//add_action( 'get_template_part_content', array( $this, 'get_plugin_template_part' ), 10, 2 );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.1.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    0.1.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

	    // Insert the page (views)
	    add_page_and_menu( self::$page_name, PTC_PLUGIN_ROOT . 'views/templates/archive.php' );

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    0.1.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		// Delete archive page and menu
	    remove_page_and_menu( self::$page_name, true );

	}

	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @since  0.1.0
	 */
	public static function uninstall() {

		// Delete archive page and menu
	    remove_page_and_menu( self::$page_name, true );

		// Delete all post-type terms, and taxonomies
		add_action( 'unregister_post_type', 'delete_post_type_taxonomies', 10 );

		// Delete all related posts and his attachments
		delete_post_type_posts( self::$post_type, true, true );

		// Remove post-type from Wordpress
		unregister_post_type( self::$post_type );

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		$domain = self::$plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     0.1.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		global $post_type;

		if ( self::$post_type == $post_type ) {
			wp_enqueue_style( self::$plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
		}

	}

	/**
	 * Add admin post view.
	 *
	 * @since  0.1.0
	 */
	public function admin_columns() {

		require_once('views/class-contactos-post-admin.php');

		Contactos_Post_Admin::get_instance();

	}

	/**
	 * Function to create the plugin post type and taxonomy.
	 *
	 * @since  0.1.0
	 *
	 * @return null      The post type and tax registered when the call him.
	 */
	public function create_type_tax_and_meta() {
		new Contactos_Set_Post_Type();
	}

	/**
	 * Get properties values.
	 *
	 * @since  0.1.0
	 *
	 * @return array     Returns properties values, to start the object.
	 */
	private function get_properties() {

		return self::$entities;

	}

	/**
	 * Set properties values
	 *
	 * @since 0.1.0
	 */
	public function set_properties() {

		// Set and update the entities array
		$this->update_entities();

		// If entity ID value is empty, this function reupload
		Contactos_Upload_Avatar::upload();

		// Save the avatar attachs values in options
		update_option( self::$plugin_slug . '_option',  self::$entities );

	}

	/**
	 * Function to update the entities array property.
	 *
	 * @since  0.1.0
	 */
	private function update_entities() {

		// Force the array keys to lower case
		self::$entities = array_change_key_case( self::$entities, CASE_LOWER );

		// Get the current options values
		$options = get_option( self::$plugin_slug . '_option', $this->get_properties() );

		// Compare and delete the extra keys
		$array_diff = array_keys( array_diff_key( $options, self::$entities ) );
		foreach ( $array_diff as $diff ) {
			unset($options[$diff]);
		}

		// Merge the saved array with the property array
		self::$entities = array_replace_recursive( self::$entities, $options );

	}

	/**
	 * Auto sets a default image for the post thumbnails and update the social input with the social network url.
	 *
	 * @since 0.1.0
	 */
	public function set_thumbnail_and_meta() {

		// Set default post thumbnail
		new Contactos_Set_Post_Avatar();

		// Add url to social profiles
		new Contactos_Set_Meta_Social();

	}

	/**
	 * Get the custom post-type templates.
	 *
	 * @since 0.1.0
	 *
	 * @param string    $template Default wordpress hierarchy template to use.
	 *
	 * @return string    The current template file that will be use.
	 */
	public function template_chooser( $template ) {

		$file = new Contactos_Get_Templates();

		return $file->get_template( $template );

	}

}

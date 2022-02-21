<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wwdh.de
 * @since      1.0.0
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/includes
 */

use Hupa\License\Register_Product_License;
use Post\Selector\Post_Selector_Callback;
use Post\Selector\Post_Selector_Data;
use Post\Selector\Post_Selector_Database_Handle;
use Post\Selector\Post_Selector_Galerie_Templates;
use Post\Selector\Post_Selector_Helper;
use Post\Selector\Post_Selector_News_Template;
use Post\Selector\Post_Selector_Slider;
use Post\Selector\Register_Post_Selector_Endpoint;


/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Post_Selector
 * @subpackage Post_Selector/includes
 * @author     Jens Wiecker <email@jenswiecker.de>
 */


class Post_Selector {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Post_Selector_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected Post_Selector_Loader $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected string $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected string $version = '';

	/**
	 * The current database version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $db_version The current database version of the plugin.
	 */
	protected string $db_version;

	/**
	 * Store plugin main class to allow public access.
	 *
	 * @since    1.0.0
	 * @var object The main class.
	 */
	public object $main;

	/**
	 * The plugin Slug Path.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_slug plugin Slug Path.
	 */
	private string $plugin_slug;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = POST_SELECTOR_BASENAME;
		$this->plugin_slug = POST_SELECTOR_SLUG_PATH;
		$this->main        = $this;


		$plugin = get_file_data(plugin_dir_path( dirname( __FILE__ ) ) . $this->plugin_name . '.php', array('Version' => 'Version'), false);
		if(!$this->version){
			$this->version = $plugin['Version'];
		}

		if ( defined( 'POST_SELECTOR_PLUGIN_DB_VERSION' ) ) {
			$this->db_version = POST_SELECTOR_PLUGIN_DB_VERSION;
		} else {
			$this->db_version = '1.0.0';
		}

		$this->check_dependencies();
		$this->load_dependencies();
		$this->set_locale();
		$this->define_product_license_class();
		$this->register_helper_class();
		$this->register_post_selector_data();
		$this->define_templates_class();
		$this->register_post_selector_endpoint();
		$this->register_post_selector_render_callback();
		$this->register_post_selector_database_handle();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Post_Selector_Loader. Orchestrates the hooks of the plugin.
	 * - Post_Selector_i18n. Defines internationalization functionality.
	 * - Post_Selector_Admin. Defines all hooks for the admin area.
	 * - Post_Selector_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-post-selector-loader.php';
		/**
		 * The class responsible for defining WP REST API Routes
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/gutenberg/class_register_post_selector_endpoint.php';
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-post-selector-i18n.php';

		/**
		 * The trait for the default settings
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/trait_post_selector_defaults.php';


		/**
		 * The class Helper
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class_post_selector_helper.php';

		/**
		 * The  database for the Post-Sector Plugin
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/database/class_post_selector_database_handle.php';

		/**
		 * Post Selector Admin Filter
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/post-selector-data/class_post_selector_data.php';


		/**
		 * Update-Checker-Autoload
		 * Git Update for Theme|Plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/update-checker/autoload.php';

		/**
		 * // The class responsible for defining all Templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/templates/class_post_selector_galerie_templates.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/templates/class_post_selector_news_template.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/templates/class_post_selector_slider.php';


		/**
		 * // JOB The class responsible for defining all actions that occur in the license area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/license/class_register_product_license.php';



		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		if ( is_file( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-post-selector-admin.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/gutenberg/class_post_selector_callback.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-post-selector-admin.php';
		}

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-post-selector-public.php';

		$this->loader = new Post_Selector_Loader();

	}

	/**
	 * Check PHP and WordPress Version
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function check_dependencies(): void {
		global $wp_version;
		if ( version_compare( PHP_VERSION, POST_SELECTOR_MIN_PHP_VERSION, '<' ) || $wp_version < POST_SELECTOR_MIN_WP_VERSION ) {
			$this->maybe_self_deactivate();
		}
	}

	/**
	 * Self-Deactivate
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function maybe_self_deactivate(): void {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		deactivate_plugins( $this->plugin_slug );
		add_action( 'admin_notices', array( $this, 'self_deactivate_notice' ) );
	}

	/**
	 * Self-Deactivate Admin Notiz
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function self_deactivate_notice(): void {
		echo sprintf( '<div class="notice notice-error is-dismissible" style="margin-top:5rem"><p>' . __( 'This plugin has been disabled because it requires a PHP version greater than %s and a WordPress version greater than %s. Your PHP version can be updated by your hosting provider.', 'hupa-teams' ) . '</p></div>', POST_SELECTOR_MIN_PHP_VERSION, POST_SELECTOR_MIN_WP_VERSION );
		exit();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Post_Selector_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Post_Selector_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_product_license_class() {

		if(!get_option('hupa_server_url')){
			update_option('hupa_server_url', $this->get_license_config()->api_server_url);
		}
		global $product_license;
		$product_license = new Register_Product_License( $this->get_plugin_name(), $this->get_version(), $this->get_license_config(), $this->main );
		$this->loader->add_action( 'init', $product_license, 'license_site_trigger_check' );
		$this->loader->add_action( 'template_redirect', $product_license, 'license_callback_site_trigger_check' );
	}

	/**
	 * Register all the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_templates_class() {
     	$galerie_template = new Post_Selector_Galerie_Templates( $this->get_plugin_name(), $this->get_version(), $this->main );
		$news_template = new Post_Selector_News_Template( $this->get_plugin_name(), $this->get_version(), $this->main );
		$slider_template = new Post_Selector_Slider( $this->get_plugin_name(), $this->get_version(), $this->main );

		$this->loader->add_action( $this->plugin_name.'/load_galerie_templates', $galerie_template, 'loadGalerieTemplate' );
		$this->loader->add_action( $this->plugin_name.'/load_news_template', $news_template, 'loadNewsTemplate',10,2 );
		$this->loader->add_action( $this->plugin_name.'/load_slider_template', $slider_template, 'loadSliderTemplate',10,2 );
	}

	/**
	 * Register all the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_helper_class() {

		global $plugin_helper;
		$plugin_helper = new Post_Selector_Helper( $this->get_plugin_name(), $this->get_version(), $this->main );
		$this->loader->add_action( $this->plugin_name.'/get_random_string', $plugin_helper, 'getPSRandomString' );
		$this->loader->add_action( $this->plugin_name.'/generate_random_id', $plugin_helper, 'getPSGenerateRandomId', 10, 4 );
		$this->loader->add_action( $this->plugin_name.'/array_to_object', $plugin_helper, 'postSelectArrayToObject' );
		$this->loader->add_action( $this->plugin_name.'/ps_select_design_optionen', $plugin_helper, 'psSelectDesignOptionen' );
		$this->loader->add_action( $this->plugin_name.'/get_post_slider_demo', $plugin_helper, 'getPostSliderDemo' );
		$this->loader->add_action( $this->plugin_name.'/post_hupa_thumbnail_html', $plugin_helper, 'post_remove_thumbnail_width_height' );
		$this->loader->add_action( $this->plugin_name.'/ps_user_roles_select', $plugin_helper, 'post_selector_user_roles_select' );
		$this->loader->add_action( $this->plugin_name.'/get_galerie_types_select', $plugin_helper, 'getGalerieTypesSelect' );
		$this->loader->add_action( $this->plugin_name.'/post_selector_get_animate_select', $plugin_helper, 'postSelectorGetAnimateSelect' );
		$this->loader->add_action( $this->plugin_name.'/post_select_file_size_convert', $plugin_helper, 'PostSelectFileSizeConvert' );
		$this->loader->add_action( $this->plugin_name.'/ps2_svg_icons', $plugin_helper, 'ps2_svg_icons',10,3 );
		//
	}

	/**
	 * Register all the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_post_selector_data() {

		global $post_selector_data;
		$post_selector_data = new Post_Selector_Data( $this->get_plugin_name(), $this->get_version(), $this->main );

		$this->loader->add_action( $this->plugin_name.'/get_post_select_data_type', $post_selector_data, 'getPostSelectDataType',10,2 );
		$this->loader->add_action( $this->plugin_name.'/post_selector_get_theme_pages', $post_selector_data, 'postSelectorGetThemePages' );
		$this->loader->add_action( $this->plugin_name.'/post_selector_get_theme_posts', $post_selector_data, 'postSelectorGetThemePosts' );
		$this->loader->add_action( $this->plugin_name.'/post_selector_wp_get_attachment', $post_selector_data, 'wp_get_attachment' );
	}

	/**
	 * Register all the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		if(!get_option('ps_two_user_role')){
			update_option('ps_two_user_role', 'manage_options');
		}

		if ( is_file( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-post-selector-admin.php' ) && get_option( "{$this->plugin_name}_product_install_authorize" ) ) {
			$plugin_admin = new Post_Selector_Admin( $this->get_plugin_name(), $this->get_version(), $this->main, $this->get_license_config() );
			$this->loader->add_action( 'init', $plugin_admin, 'set_post_selector_update_checker' );
			$this->loader->add_action( 'in_plugin_update_message-' . $this->plugin_name . '/' . $this->plugin_name .'.php', $plugin_admin, 'post_selector_show_upgrade_notification',10,2 );


			//Gutenberg INIT
			$this->loader->add_action( 'init', $plugin_admin, 'gutenberg_block_post_selector_two_register' );
			$this->loader->add_action( 'init', $plugin_admin, 'gutenberg_block_post_selector_two_galerie_register' );
			//Gutenberg Scripts
			$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'post_selector_two_plugin_editor_block_scripts' );
			$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'post_selector_two_plugin_editor_galerie_scripts' );
			//Admin Menu | AJAX
			$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_post_selector_menu' );
			$this->loader->add_action( 'wp_ajax_PS2Handle', $plugin_admin, 'prefix_ajax_PS2Handle' );

		}
	}

	/**
	 * Register all the hooks related to the Gutenberg Plugins functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_post_selector_database_handle() {
		global $post_selector_database;
		$post_selector_database = new Post_Selector_Database_Handle( $this->get_db_version(), $this->main );

		$this->loader->add_action( $this->plugin_name.'/post_selector_get_by_args', $post_selector_database, 'postSelectorGetByArgs',10,3 );
		$this->loader->add_action( $this->plugin_name.'/post_selector_set_slider', $post_selector_database, 'postSelectorSetSlider' );
		$this->loader->add_action( $this->plugin_name.'/update_post_selector_slider', $post_selector_database, 'updatePostSelectorSlider' );
		$this->loader->add_action( $this->plugin_name.'/delete_post_selector_slider', $post_selector_database, 'deletePostSelectorSlider' );
		//Gallery
		$this->loader->add_action( $this->plugin_name.'/post_selector_set_galerie', $post_selector_database, 'postSelectorSetGalerie' );
		$this->loader->add_action( $this->plugin_name.'/post_selector_get_galerie', $post_selector_database, 'postSelectorGetGalerie',10,3 );
		$this->loader->add_action( $this->plugin_name.'/post_selector_update_galerie', $post_selector_database, 'postSelectorUpdateGalerie' );
		$this->loader->add_action( $this->plugin_name.'/post_selector_delete_galerie', $post_selector_database, 'PostSelectorDeleteGalerie' );
		//Images
		$this->loader->add_action( $this->plugin_name.'/post_selector_set_image', $post_selector_database, 'postSelectorSetImage' );
		$this->loader->add_action( $this->plugin_name.'/post_selector_update_image', $post_selector_database, 'postSelectorUpdateImage' );
		$this->loader->add_action( $this->plugin_name.'/post_selector_get_images', $post_selector_database, 'postSelectorGetImages',10,3 );
		$this->loader->add_action( $this->plugin_name.'/post_selector_delete_image', $post_selector_database, 'PostSelectorDeleteImage' );
		$this->loader->add_action( $this->plugin_name.'/post_update_sortable_position', $post_selector_database, 'postSelectorUpdateSortablePosition',10,2 );


		$this->loader->add_action( 'init', $post_selector_database, 'post_selector_check_jal_install' );
		//

	}
	/**
	 * Register all the hooks related to the Gutenberg Plugins functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_post_selector_render_callback() {
		global $post_selector_callback;
		if ( is_file( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-post-selector-admin.php' ) && get_option( "{$this->plugin_name}_product_install_authorize" ) ) {
			$post_selector_callback = new Post_Selector_Callback( $this->get_plugin_name(), $this->get_version(), $this->main );
		}
	}

	/**
	 * Register all the hooks related to the Gutenberg Plugins functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_post_selector_endpoint() {
		global $post_selector_endpoint;
		$post_selector_endpoint = new Register_Post_Selector_Endpoint( $this->get_plugin_name(), $this->get_version(), $this->main );
		$this->loader->add_action('rest_api_init', $post_selector_endpoint, 'register_post_selector_routes');
	}

	/**
	 * Register all the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Post_Selector_Public( $this->get_plugin_name(), $this->get_version(), $this->main );

		$this->loader->add_action( 'wp_ajax_nopriv_PS2HandlePublic', $plugin_public, 'prefix_ajax_PS2HandlePublic' );
		$this->loader->add_action( 'wp_ajax_PS2HandlePublic', $plugin_public, 'prefix_ajax_PS2HandlePublic' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name(): string {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Post_Selector_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader(): Post_Selector_Loader {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version(): string {
		return $this->version;
	}

	/**
	 * Retrieve the database version number of the plugin.
	 *
	 * @return    string    The database version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_db_version(): string {
		return $this->db_version;
	}

	/**
	 * License Config for the plugin.
	 *
	 * @return    object License Config.
	 * @since     1.0.0
	 */
	public function get_license_config():object {
		$config_file = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/license/config.json';

		return json_decode(file_get_contents($config_file));
	}

}

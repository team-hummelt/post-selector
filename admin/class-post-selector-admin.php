<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wwdh.de
 * @since      1.0.0
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/admin
 */

use Post\Selector\Post_Selector_Admin_Ajax;


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/admin
 * @author     Jens Wiecker <email@jenswiecker.de>
 */
class Post_Selector_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $basename    The ID of this plugin.
	 */
	private string $basename;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private string $version;

	/**
	 * Store plugin main class to allow public access.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var Post_Selector $main The main class.
	 */
	private  Post_Selector $main;

	/**
	 * License Config of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var  object $config License Config.
	 */
	private object $config;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name The name of this plugin.
	 * @param string $version    The version of this plugin.
	 *
	 *@since    1.0.0
	 */
	public function __construct( string $plugin_name, string $version, Post_Selector $main, object $config) {

		$this->basename = $plugin_name;
		$this->version = $version;
		$this->main = $main;
		$this->config = $config;
	}

	public function register_post_selector_menu() {
		$hook_suffix = add_menu_page(
			__( 'Post-Selector 2', 'post-selector' ),
			__( 'Post-Selector 2', 'post-selector' ),
			get_option('ps_two_user_role'),
			'post-selector-two-settings',
			array( $this, 'admin_post_selector_two_settings_page' ),
			apply_filters($this->basename.'/ps2_svg_icons','sign-post',true,true), 7
		);

		add_action( 'load-' . $hook_suffix, array( $this, 'post_selector_two_load_ajax_admin_options_script' ) );
	}

	public function admin_post_selector_two_settings_page() :void {
		wp_enqueue_media();
		require_once 'partials/post-selector-admin-display.php';
	}

	public function post_selector_two_load_ajax_admin_options_script():void {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		$title_nonce = wp_create_nonce( 'post_selector_two_admin_handle' );

		wp_register_script( 'post-selector-two-admin-ajax-script', '', [], '', true );
		wp_enqueue_script( 'post-selector-two-admin-ajax-script' );
		wp_localize_script( 'post-selector-two-admin-ajax-script', 'ps_two_ajax_obj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $title_nonce,
			'data_table'      => plugin_dir_url( __FILE__ ) . 'json/DataTablesGerman.json',
			'rest_url' => get_rest_url()
		));
	}

	/**
	 * Register POST SELECTOR AJAX ADMIN RESPONSE HANDLE
	 *
	 * @since    1.0.0
	 */
	public function prefix_ajax_PS2Handle(): void {
		check_ajax_referer( 'post_selector_two_admin_handle' );
		require_once 'ajax/class_post_selector_admin_ajax.php';
		$adminAjaxHandle = new Post_Selector_Admin_Ajax($this->basename, $this->version, $this->main);
		wp_send_json($adminAjaxHandle->ps2_admin_ajax_handle());
	}

	/**
	 * REGISTER POST-SELECTOR GUTENBERG BLOCK TYPE
	 *
	 * @since    1.0.0
	 */
	public function gutenberg_block_post_selector_two_register() {
		global $post_selector_callback;
		register_block_type( 'hupa/post-selector-two', array(
			'render_callback' => array($post_selector_callback, 'callback_post_selector_two_block'),
			'editor_script'   => 'gutenberg-post-selector-two-block',
		));

		add_filter('gutenberg_block_post_selector_two_render', array($post_selector_callback, 'gutenberg_block_post_selector_two_render_filter'), 10, 20);
	}

	/**
	 * REGISTER POST-SELECTOR GUTENBERG SCRIPTS
	 *
	 * @since    1.0.0
	 */
	public function post_selector_two_plugin_editor_block_scripts(): void {
		$plugin_asset = require plugin_dir_path( dirname( __FILE__ ) )  . 'admin/gutenberg/post-selector-data/build/index.asset.php';


		// Scripts.
		wp_register_script(
			'gutenberg-post-selector-two-block',
			plugins_url($this->basename).'/admin/gutenberg/post-selector-data/build/index.js',
			$plugin_asset['dependencies'], $plugin_asset['version'], true
		);

		if (function_exists('wp_set_script_translations')) {
			wp_set_script_translations('gutenberg-post-selector-two-block', 'post-selector', plugin_dir_path( dirname( __FILE__ ) ) . 'languages');
		}

		// Styles.
		wp_enqueue_style(
			'gutenberg-post-selector-two-block', // Handle.
			plugins_url($this->basename).'/admin/gutenberg/post-selector-data/build/index.css', array(), $plugin_asset['version']
		);

		wp_register_script( 'post-selector-two-rest-gutenberg-js-localize', '', [], $plugin_asset['version'], true );
		wp_enqueue_script( 'post-selector-two-rest-gutenberg-js-localize' );
		wp_localize_script( 'post-selector-two-rest-gutenberg-js-localize',
			'PS2RestObj',
			array(
				'url'   => esc_url_raw( rest_url( 'post-selector-endpoint/v2/' ) ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
				'rest_url' => get_rest_url()
			)
		);
	}

	/**
	 * REGISTER POST-SELECTOR GALLERY GUTENBERG BLOCK TYPE
	 *
	 * @since    1.0.0
	 */
	public function gutenberg_block_post_selector_two_galerie_register() {
		global $post_selector_callback;
		register_block_type( 'hupa/post-selector-two-galerie', array(
			'render_callback' => array($post_selector_callback, 'callback_post_selector_two_galerie'),
			'editor_script'   => 'gutenberg-post-selector-two-galerie',
		) );

	}

	/**
	 * REGISTER POST-SELECTOR GALLERY GUTENBERG SCRIPTS
	 *
	 * @since    1.0.0
	 */
	public function post_selector_two_plugin_editor_galerie_scripts(): void {
		$plugin_asset = require plugin_dir_path( dirname( __FILE__ ) )  . 'admin/gutenberg/galerie-data/build/index.asset.php';

		// Scripts.
		wp_register_script(
			'gutenberg-post-selector-two-galerie',
			plugins_url($this->basename).'/admin/gutenberg/galerie-data/build/index.js',
			$plugin_asset['dependencies'], $plugin_asset['version'], true
		);

		if (function_exists('wp_set_script_translations')) {
			wp_set_script_translations('gutenberg-post-selector-two-galerie', 'post-selector', plugin_dir_path( dirname( __FILE__ ) ) . 'languages');
		}

		// Styles.
		wp_enqueue_style(
			'gutenberg-post-selector-two-galerie', // Handle.
			plugins_url($this->basename).'/admin/gutenberg/galerie-data/build/index.css', array(), $plugin_asset['version']
		);
	}

	/**
	 * Register the Update-Checker for the Plugin.
	 *
	 * @since    1.0.0
	 */
	public function set_post_selector_update_checker() {

		if(get_option("{$this->basename}_server_api") && get_option($this->basename.'_server_api')->update->update_aktiv) {
			$postSelectorUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
				get_option("{$this->basename}_server_api")->update->update_url_git,
				WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $this->basename . DIRECTORY_SEPARATOR . $this->basename . '.php',
				$this->basename
			);

			if (get_option("{$this->basename}_server_api")->update->update_type == '1') {
				if (get_option("{$this->basename}_server_api")->update->update_branch == 'release') {
					$postSelectorUpdateChecker->getVcsApi()->enableReleaseAssets();
				} else {
					$postSelectorUpdateChecker->setBranch(get_option("{$this->basename}_server_api")->update->branch_name);
				}
			}
		}
	}

	public function post_selector_show_upgrade_notification( $current_plugin_metadata, $new_plugin_metadata ) {

		/**
		 * Check "upgrade_notice" in readme.txt.
		 *
		 * Eg.:
		 * == Upgrade Notice ==
		 * = 20180624 = <- new version
		 * Notice		<- message
		 *
		 */
		if ( isset( $new_plugin_metadata->upgrade_notice ) && strlen( trim( $new_plugin_metadata->upgrade_notice ) ) > 0 ) {

			// Display "upgrade_notice".
			echo sprintf( '<span style="background-color:#d54e21;padding:10px;color:#f9f9f9;margin-top:10px;display:block;"><strong>%1$s: </strong>%2$s</span>', esc_attr( 'Important Upgrade Notice', 'post-selector' ), esc_html( rtrim( $new_plugin_metadata->upgrade_notice ) ) );

		}
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
		 * defined in Post_Selector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Selector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery' );
		//TODO FontAwesome / Bootstrap
		wp_enqueue_style( 'post-selector-admin-two-bs-style', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, false );
		// TODO ADMIN ICONS
		wp_enqueue_style( 'post-selector-two-admin-icons-style', plugin_dir_url( __FILE__ ) . 'css/font-awesome.css', array(), $this->version, false );
		// TODO DASHBOARD STYLES
		wp_enqueue_style( 'post-selector-two-admin-dashboard-style', plugin_dir_url( __FILE__ ) . 'css/admin-dashboard-style.css', array(), $this->version, false );
		// TODO DataTable STYLES
		wp_enqueue_style( 'post-selector-two-admin-data-table', plugin_dir_url( __FILE__ ) . 'css/tools/dataTables.bootstrap5.min.css', array(), $this->version, false );

		wp_enqueue_style(
			'post-selector-two-lightbox-css',
			plugin_dir_url( __FILE__ ) . 'css/tools/blueimp-gallery.css',
			array(), $this->version );

		//TODO Bootstrap
		wp_enqueue_script( 'post-selector-two-bs',
			plugins_url($this->basename) . '/public/js/bs/bootstrap.bundle.min.js', array(),
			$this->version, true );

		//TODO SORTABLE
		wp_enqueue_script( 'gutenberg-post-selector-two-sortable',
			plugin_dir_url( __FILE__ ) . 'js/tools/Sortable.min.js', array(),
			$this->version, true );

		//TODO LIGHTBOX
		wp_enqueue_script( 'gutenberg-post-selector-two-lightbox',
			plugin_dir_url( __FILE__ ) . 'js/tools/blueimp-gallery.min.js', array(),
			$this->version, true );

		//TODO LIGHTBOX
		wp_enqueue_script( 'gutenberg-post-selector-two-jq-lightbox',
			plugin_dir_url( __FILE__ ) . 'js/tools/jquery.blueimp-gallery.js', array(),
			$this->version, true );

		//DataTables
		wp_enqueue_script( 'gutenberg-post-selector-two-jq-data-table',
			plugin_dir_url( __FILE__ ) . 'js/tools/data-table/jquery.dataTables.min.js', array(),
			$this->version, true );
		wp_enqueue_script( 'gutenberg-post-selector-two-bs5-data-table',
			plugin_dir_url( __FILE__ ) . 'js/tools/data-table/dataTables.bootstrap5.min.js', array(),
			$this->version, true );
		wp_enqueue_script( 'gutenberg-post-selector-two-data-table-galerie',
			plugin_dir_url( __FILE__ ) . 'js/tools/data-table/data-table-galerie.js', array(),
			$this->version, true );

		wp_enqueue_script( 'post-selector-two-script', plugin_dir_url( __FILE__ ) . 'js/post-selector-admin.js', array('jquery'), $this->version, true );
	}

}

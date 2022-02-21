<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wwdh.de
 * @since      1.0.0
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/public
 */

use Post\Selector\Post_Selector_Public_Ajax;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/public
 * @author     Jens Wiecker <email@jenswiecker.de>
 */
class Post_Selector_Public {

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
	private Post_Selector $main;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name The name of the plugin.
	 * @param string $version    The version of this plugin.
	 *
	 *@since    1.0.0
	 */
	public function __construct( string $plugin_name, string $version, Post_Selector  $main) {

		$this->basename = $plugin_name;
		$this->version = $version;
		$this->main = $main;
	}

	/**
	 * ===================================================
	 * =========== AJAX PUBLIC RESPONSE HANDLE ===========
	 * ===================================================
	 */
	public function prefix_ajax_PS2HandlePublic(): void {
		check_ajax_referer( 'post_selector_two_public_handle' );
		require_once 'ajax/class_post_selector_public_ajax.php';
		$publicAjaxHandle = new Post_Selector_Public_Ajax($this->basename, $this->main);
		wp_send_json($publicAjaxHandle->ps2_public_ajax_handle());
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/gutenberg/post-selector-data/build/ps-style.css' ) );

		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/css/tools/splide-default.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/css/tools/splide-skyblue.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/css/tools/splide-sea-green.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/css/tools/splide.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/css/bs/bootstrap.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/css/tools/lightbox/blueimp-gallery.min.css' ) );

		wp_enqueue_style(
			'post-selector-two-public-style',
			plugins_url($this->basename) . '/admin/gutenberg/post-selector-data/build/ps-style.css',
			array(), $modificated );


		//if nicht Install Starter Theme
		$ifHupaStarter = wp_get_theme( 'hupa-starter' );
		if ( ! $ifHupaStarter->exists() ) {
			// TODO Bootstrap CSS
			wp_enqueue_style(
				'post-selector-two-bootstrap',
				plugin_dir_url( __FILE__ )  . 'css/bs/bootstrap.min.css',
				array(), $modificated );
		}

		// TODO SPLIDE CSS
		wp_enqueue_style(
			'post-selector-two-splide',
			plugin_dir_url( __FILE__ ) . 'css/tools/splide.min.css',
			array(), $modificated );

		// TODO LIGHTBOX CSS
		wp_enqueue_style(
			'post-selector-two-lightbox',
			plugin_dir_url( __FILE__ ) . 'css/tools/lightbox/blueimp-gallery.min.css',
			array(), $modificated );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/js/tools/splide.min.js' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/js/bs/bootstrap.bundle.min.js' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/js/tools/lightbox/blueimp-gallery.min.js' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/js/tools/imagesloaded.pkgd.min.js' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/js/tools/masonry.pkgd.min.js' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/js/tools/wowjs/wow.min.js' ) );
		$modificated = date( 'YmdHi', filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/js/tools/post-selector-splide.js' ) );

		$ifHupaStarter = wp_get_theme( 'hupa-starter' );
		if ( ! $ifHupaStarter->exists() ) {

			// TODO Bootstrap JS
			wp_enqueue_script( 'gutenberg-post-selector-two-bs',
				plugin_dir_url( __FILE__ ) . 'js/bs/bootstrap.bundle.min.js', array(),
				$modificated, true );
		}

		// TODO MASONRY
		wp_enqueue_script( 'gutenberg-post-selector-two-masonry-pkgd',
			plugin_dir_url( __FILE__ ) . 'js/tools/masonry.pkgd.min.js', array(),
			$modificated, true );

		//TODO LIGHTBOX
		wp_enqueue_script( 'gutenberg-post-two-selector-lightbox',
			plugin_dir_url( __FILE__ ) . 'js/tools/lightbox/blueimp-gallery.min.js', array(),
			$modificated, true );

		//TODO SLIDER
		wp_enqueue_script( 'gutenberg-post-selector-two-splide',
			plugin_dir_url( __FILE__ ) . 'js/tools/splide.min.js', array(),
			$modificated, true );

		//TODO IMAGES LOADED
		wp_enqueue_script( 'post-selector-two-galerie-images-loaded',
			plugin_dir_url( __FILE__ ) . 'js/tools/imagesloaded.pkgd.min.js', array(),
			$modificated, true );

		//TODO SLIDER  OPTIONEN
		wp_enqueue_script( 'gutenberg-post-selector-two-splide-optionen',
			plugin_dir_url( __FILE__ ) . 'js/tools/post-selector-splide.js', array(),
			$modificated, true );

		wp_enqueue_script( 'gutenberg-post-selector-two-wowjs',
			plugin_dir_url( __FILE__ ) . 'js/tools/wowjs/wow.min.js', array(),
			$modificated, true );

		$public_nonce = wp_create_nonce( 'post_selector_two_public_handle' );
		wp_register_script( 'post-selector-two-public-ajax-script', '', [], '', true );
		wp_enqueue_script( 'post-selector-two-public-ajax-script' );
		wp_localize_script( 'post-selector-two-public-ajax-script', 'ps_two_ajax_obj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $public_nonce,
			'rest_url' => get_rest_url()
		));
	}
}

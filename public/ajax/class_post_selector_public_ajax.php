<?php
namespace Post\Selector;

use Post_Selector;
use stdClass;

defined( 'ABSPATH' ) or die();

/**
 * Define the Public AJAX functionality.
 *
 * Loads and defines the Public Ajax files for this plugin
 *
 *
 * @link       https://www.hummelt-werbeagentur.de/
 * @since      1.0.0
 */

/**
 * Define the License AJAX functionality.
 *
 * Loads and defines the Public Ajax files for this plugin
 *
 *
 * @since      1.0.0
 * @author     Jens Wiecker <wiecker@hummelt.com>
 */

class Post_Selector_Public_Ajax {
	/**
	 * The AJAX METHOD
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $method The AJAX METHOD.
	 */
	protected string $method;

	/**
	 * The Helper Class.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object $helper The Helper Class.
	 */
	protected object $helper;

	/**
	 * The AJAX DATA
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array|object $data The AJAX DATA.
	 */
	private $data;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $basename The ID of this plugin.
	 */
	private string $basename;


	/**
	 * Store plugin main class to allow public access.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var Post_Selector $main The main class.
	 */
	private Post_Selector $main;

	public function __construct( string $basename,  Post_Selector $main ) {

		$this->basename   = $basename;
		$this->method     = '';
		if ( isset( $_POST['daten'] ) ) {
			$this->data   = $_POST['daten'];
			$this->method = filter_var( $this->data['method'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		}

		if ( ! $this->method ) {
			$this->method = $_POST['method'];
		}

		$this->main = $main;

		global $plugin_helper;
		$this->helper = $plugin_helper;
	}

	/**
	 * @return stdClass
	 */
	public function ps2_public_ajax_handle(): stdClass {

		$responseJson         = new stdClass();
		$responseJson->status = false;
		$responseJson->time   = date( 'H:i:s', current_time( 'timestamp' ) );

		switch ( $this->method ) {
			case 'get_slider_settings':
				$id   = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT );
				$rand = filter_input( INPUT_POST, 'rand', FILTER_SANITIZE_STRING );

				if ( ! $id ) {
					return $responseJson;
				}

				$args     = sprintf( 'WHERE id=%d', $id );
				$settings = apply_filters( $this->basename.'/post_selector_get_by_args', $args, false );
				if ( ! $settings->status ) {
					return $responseJson;
				}

				$settings = $settings->record->data;
				$settings->slide_type ? $slide_type = $settings->slide_type : $slide_type = 'loop';
				$settings->pro_move ? (int) $pro_move = $settings->pro_move : $pro_move = 1;
				$settings->pro_page ? (int) $pro_page = $settings->pro_page : $pro_page = 2;
				$settings->intervall ? (int) $intervall = $settings->intervall : $intervall = 3000;
				$settings->focus ? $focus = $settings->focus : $focus = 'center';
				$settings->width ? $width = $settings->width : $width = '80%';
				$settings->height ? $height = $settings->height : $height = '250px';
				$settings->gap ? $gap = $settings->gap : $gap = '.5rem';
				if ( ! $settings->speed ) {
					$settings->speed = 0;
				}

				$settings->lazy_load == 'false' ? $lazy_load = false : $lazy_load = $settings->lazy_load;
				$settings->start_index ? $start = $settings->start_index : $start = 0;
				$settings->preload_pages ? $preload_pages = $settings->preload_pages : $preload_pages = 0;
				$settings->auto_width ? $auto_width = true : $auto_width = false;

				$breakpoints = [
					450  => [
						'perPageXs' => $settings->pro_page_xs ?: '',
						'heightXs'  => $settings->height_xs,
						'widthXs'   => $settings->width_xs,
						'gapXs'     => $settings->gap_xs,
					],
					576  => [
						'perPageSm' => $settings->pro_page_sm ?: '',
						'heightSm'  => $settings->height_sm,
						'widthSm'   => $settings->width_sm,
						'gapSm'     => $settings->gap_sm,
					],
					768  => [
						'perPageMd' => $settings->pro_page_md ?: '',
						'heightMd'  => $settings->height_md,
						'widthMd'   => $settings->width_md,
						'gapMd'     => $settings->gap_md
					],
					992  => [
						'perPageLg' => $settings->pro_page_lg ?: '',
						'heightLg'  => $settings->height_lg,
						'widthLg'   => $settings->width_lg,
						'gapLg'     => $settings->gap_lg
					],
					1200 => [
						'perPageXl' => $settings->pro_page_xl ?: '',
						'heightXl'  => $settings->height_xl,
						'widthXl'   => $settings->width_xl,
						'gapXl'     => $settings->gap_xl
					],
					1400 => [
						'perPageXxl' => $settings->pro_page_xxl ?: '',
						'heightXxl'  => $settings->height_xxl,
						'widthXxl'   => $settings->width_xxl,
						'gapXxl'     => $settings->gap_xxl
					]
				];

				$sendSettings = [
					'type'         => $slide_type,
					'autoplay'     => (bool) $settings->autoplay,
					'cover'        => (bool) $settings->cover,
					'autoWidth'    => $auto_width,
					'autoHeight'   => (bool) $settings->auto_height,
					'arrows'       => (bool) $settings->arrows,
					'lazyLoad'     => $lazy_load,
					'pauseOnHover' => (bool) $settings->pause_on_hover,
					'pauseOnFocus' => (bool) $settings->pause_on_focus,
					'drag'         => (bool) $settings->drag,
					'keyboard'     => (bool) $settings->keyboard,
					'rewind'       => (bool) $settings->rewind,
					'speed'        => (int) $settings->speed,
					'rewindSpeed'  => (int) $settings->rewind_speed,
					'fixedWidth'   => $settings->fixed_width,
					'fixedHeight'  => $settings->fixed_height,
					'heightRatio'  => $settings->height_ratio,
					'start'        => (int) $start,
					'flickPower'   => (int) $settings->flick_power,
					'preloadPages' => (int) $preload_pages,
					'pagination'   => (bool) $settings->pagination,
					'slideFocus'   => (bool) $settings->slide_focus,
					'interval'     => (int) $settings->intervall,
					'width'        => $width,
					'height'       => $height,
					'gap'          => $gap,
					'perMove'      => $pro_move,
					'perPage'      => $pro_page,
					'focus'        => $focus,
					'perPageXs' => $settings->pro_page_xs ?: '',
					'heightXs'  => $settings->height_xs,
					'widthXs'   => $settings->width_xs,
					'gapXs'     => $settings->gap_xs,
					'perPageSm' => $settings->pro_page_sm ?: '',
					'heightSm'  => $settings->height_sm,
					'widthSm'   => $settings->width_sm,
					'gapSm'     => $settings->gap_sm,
					'perPageMd' => $settings->pro_page_md ?: '',
					'heightMd'  => $settings->height_md,
					'widthMd'   => $settings->width_md,
					'gapMd'     => $settings->gap_md,
					'perPageLg' => $settings->pro_page_lg ?: '',
					'heightLg'  => $settings->height_lg,
					'widthLg'   => $settings->width_lg,
					'gapLg'     => $settings->gap_lg,
					'perPageXl' => $settings->pro_page_xl ?: '',
					'heightXl'  => $settings->height_xl,
					'widthXl'   => $settings->width_xl,
					'gapXl'     => $settings->gap_xl,
					'perPageXxl' => $settings->pro_page_xxl ?: '',
					'heightXxl'  => $settings->height_xxl,
					'widthXxl'   => $settings->width_xxl,
					'gapXxl'     => $settings->gap_xxl

				];


				if ( ! $settings->fixed_width ) {
					unset( $sendSettings['fixedWidth'] );
				}

				if ( ! $settings->fixed_height ) {
					unset( $sendSettings['fixedHeight'] );
				}

				$responseJson->status       = true;
				$responseJson->rand         = $rand;
				$responseJson->sendSettings = $sendSettings;
				break;
		}
		return $responseJson;
	}
}
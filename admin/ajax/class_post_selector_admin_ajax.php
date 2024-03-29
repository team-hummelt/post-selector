<?php
namespace Post\Selector;

use finfo;
use Post_Selector;
use stdClass;

defined( 'ABSPATH' ) or die();

/**
 * Define the Admin AJAX functionality.
 *
 * Loads and defines the Admin Ajax files for this plugin
 *
 *
 * @link       https://www.hummelt-werbeagentur.de/
 * @since      1.0.0
 */

/**
 * Define the License AJAX functionality.
 *
 * Loads and defines the Admin Ajax files for this plugin
 *
 *
 * @since      1.0.0
 * @author     Jens Wiecker <wiecker@hummelt.com>
 */

class Post_Selector_Admin_Ajax {

	/**
	 * The plugin Slug Path.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_dir plugin Slug Path.
	 */
	protected string $plugin_dir;

	/**
	 * The AJAX METHOD
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $method The AJAX METHOD.
	 */
	protected string $method;

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
	 * The Version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current Version of this plugin.
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


	public function __construct( string $basename, string $version,  Post_Selector $main ) {

		$this->basename   = $basename;
		$this->version    = $version;
		$this->main = $main;
		$this->plugin_dir = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $this->basename . DIRECTORY_SEPARATOR;
		$this->method     = '';
		if ( isset( $_POST['daten'] ) ) {
			$this->data   = $_POST['daten'];
			$this->method = filter_var( $this->data['method'], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH );
		}

		if ( ! $this->method ) {
			$this->method = $_POST['method'];
		}
	}

	public function ps2_admin_ajax_handle() {

		$responseJson         = new stdClass();
		$record = new stdClass();
		$responseJson->status = false;
		$responseJson->time   = date( 'H:i:s', current_time( 'timestamp' ) );
		switch ( $this->method ) {
			case'slider-form-handle';

				$type = filter_input( INPUT_POST, 'type', FILTER_UNSAFE_RAW );

				if ( ! $type ) {
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';

					return $responseJson;
				}
				$bezeichnung = filter_input( INPUT_POST, 'bezeichnung', FILTER_UNSAFE_RAW );

				$img_size = filter_input( INPUT_POST, 'img_size', FILTER_UNSAFE_RAW );

				//Input CheckBoxen
				filter_input( INPUT_POST, 'autoplay', FILTER_UNSAFE_RAW ) ? $autoplay = 1 : $autoplay = 0;
				filter_input( INPUT_POST, 'cover', FILTER_UNSAFE_RAW ) ? $cover = 1 : $cover = 0;

				filter_input( INPUT_POST, 'auto_width', FILTER_UNSAFE_RAW ) ? $auto_width = 1 : $auto_width = 0;
				filter_input( INPUT_POST, 'auto_height', FILTER_UNSAFE_RAW ) ? $auto_height = 1 : $auto_height = 0;
				filter_input( INPUT_POST, 'arrows', FILTER_UNSAFE_RAW ) ? $arrows = 1 : $arrows = 0;

				filter_input( INPUT_POST, 'pause_on_hover', FILTER_UNSAFE_RAW ) ? $pause_on_hover = 1 : $pause_on_hover = 0;
				filter_input( INPUT_POST, 'pause_on_focus', FILTER_UNSAFE_RAW ) ? $pause_on_focus = 1 : $pause_on_focus = 0;
				filter_input( INPUT_POST, 'drag', FILTER_UNSAFE_RAW ) ? $drag = 1 : $drag = 0;
				filter_input( INPUT_POST, 'keyboard', FILTER_UNSAFE_RAW ) ? $keyboard = 1 : $keyboard = 0;

				filter_input( INPUT_POST, 'hover', FILTER_UNSAFE_RAW ) ? $hover = 1 : $hover = 0;
				filter_input( INPUT_POST, 'label', FILTER_UNSAFE_RAW ) ? $label = 1 : $label = 0;
				filter_input( INPUT_POST, 'textauszug', FILTER_UNSAFE_RAW ) ? $textauszug = 1 : $textauszug = 0;

				filter_input( INPUT_POST, 'img_link_aktiv', FILTER_UNSAFE_RAW ) ? $img_link_aktiv = 1 : $img_link_aktiv = 0;
				$select_design_option = filter_input( INPUT_POST, 'select_design_option', FILTER_VALIDATE_INT );
				$select_design_btn_link = filter_input( INPUT_POST, 'select_design_btn_link', FILTER_VALIDATE_INT );
				filter_input( INPUT_POST, 'design_btn_aktiv', FILTER_UNSAFE_RAW ) ? $design_btn_aktiv = 1 : $design_btn_aktiv = 0;
				$design_btn_txt  = filter_input( INPUT_POST, 'design_btn_txt', FILTER_UNSAFE_RAW);
				$design_btn_css  = filter_input( INPUT_POST, 'design_btn_css', FILTER_UNSAFE_RAW);
				$design_link_tag_txt  = filter_input( INPUT_POST, 'design_link_tag_txt', FILTER_UNSAFE_RAW);
				filter_input( INPUT_POST, 'design_text_aktiv', FILTER_UNSAFE_RAW ) ? $design_text_aktiv = 1 : $design_text_aktiv = 0;
				$select_design_text = filter_input( INPUT_POST, 'select_design_text', FILTER_VALIDATE_INT );
				$design_titel_css  = filter_input( INPUT_POST, 'design_titel_css', FILTER_UNSAFE_RAW);
				$design_auszug_css  = filter_input( INPUT_POST, 'design_auszug_css', FILTER_UNSAFE_RAW);
				$select_title_tag = filter_input( INPUT_POST, 'select_title_tag', FILTER_VALIDATE_INT );

				$design_container_height  = filter_input( INPUT_POST, 'design_container_height', FILTER_UNSAFE_RAW);
				$inner_container_height  = filter_input( INPUT_POST, 'inner_container_height', FILTER_UNSAFE_RAW);
				//inner_container_height


				filter_input( INPUT_POST, 'rewind', FILTER_UNSAFE_RAW ) ? $rewind = 1 : $rewind = 0;

				//Input Breakpoints
				$pro_page_xs  = filter_input( INPUT_POST, 'pro_page_xs', FILTER_VALIDATE_INT );
				$pro_page_sm  = filter_input( INPUT_POST, 'pro_page_sm', FILTER_VALIDATE_INT );
				$pro_page_md  = filter_input( INPUT_POST, 'pro_page_md', FILTER_VALIDATE_INT );
				$pro_page_lg  = filter_input( INPUT_POST, 'pro_page_lg', FILTER_VALIDATE_INT );
				$pro_page_xl  = filter_input( INPUT_POST, 'pro_page_xl', FILTER_VALIDATE_INT );
				$pro_page_xxl = filter_input( INPUT_POST, 'pro_page_xxl', FILTER_VALIDATE_INT );

				$gap_xs  = filter_input( INPUT_POST, 'gap_xs', FILTER_UNSAFE_RAW);
				$gap_sm  = filter_input( INPUT_POST, 'gap_sm', FILTER_UNSAFE_RAW);
				$gap_md  = filter_input( INPUT_POST, 'gap_md', FILTER_UNSAFE_RAW);
				$gap_lg  = filter_input( INPUT_POST, 'gap_lg', FILTER_UNSAFE_RAW);
				$gap_xl  = filter_input( INPUT_POST, 'gap_xl', FILTER_UNSAFE_RAW);
				$gap_xxl = filter_input( INPUT_POST, 'gap_xxl', FILTER_UNSAFE_RAW );

				$width_xs  = filter_input( INPUT_POST, 'width_xs', FILTER_UNSAFE_RAW);
				$width_sm  = filter_input( INPUT_POST, 'width_sm', FILTER_UNSAFE_RAW);
				$width_md  = filter_input( INPUT_POST, 'width_md', FILTER_UNSAFE_RAW);
				$width_lg  = filter_input( INPUT_POST, 'width_lg', FILTER_UNSAFE_RAW);
				$width_xl  = filter_input( INPUT_POST, 'width_xl', FILTER_UNSAFE_RAW);
				$width_xxl = filter_input( INPUT_POST, 'width_xxl', FILTER_UNSAFE_RAW );

				$height_xs  = filter_input( INPUT_POST, 'height_xs', FILTER_UNSAFE_RAW );
				$height_sm  = filter_input( INPUT_POST, 'height_sm', FILTER_UNSAFE_RAW );
				$height_md  = filter_input( INPUT_POST, 'height_md', FILTER_UNSAFE_RAW );
				$height_lg  = filter_input( INPUT_POST, 'height_lg', FILTER_UNSAFE_RAW );
				$height_xl  = filter_input( INPUT_POST, 'height_xl', FILTER_UNSAFE_RAW );
				$height_xxl = filter_input( INPUT_POST, 'height_xxl', FILTER_UNSAFE_RAW );

				$slide_type = filter_input( INPUT_POST, 'slide_type', FILTER_UNSAFE_RAW );
				$pro_move   = filter_input( INPUT_POST, 'pro_move', FILTER_VALIDATE_INT );
				$pro_page   = filter_input( INPUT_POST, 'pro_page', FILTER_VALIDATE_INT );
				$gap        = filter_input( INPUT_POST, 'gap', FILTER_UNSAFE_RAW );
				$width      = filter_input( INPUT_POST, 'width', FILTER_UNSAFE_RAW );
				$height     = filter_input( INPUT_POST, 'height', FILTER_UNSAFE_RAW );
				$intervall  = filter_input( INPUT_POST, 'intervall', FILTER_VALIDATE_INT );
				$focus      = filter_input( INPUT_POST, 'focus', FILTER_UNSAFE_RAW );

				$trim_space   = filter_input( INPUT_POST, 'trim_space', FILTER_UNSAFE_RAW );
				$lazy_load    = filter_input( INPUT_POST, 'lazy_load', FILTER_UNSAFE_RAW );
				$speed        = filter_input( INPUT_POST, 'speed', FILTER_VALIDATE_INT );
				$rewind_speed = filter_input( INPUT_POST, 'rewind_speed', FILTER_VALIDATE_INT );

				$fixed_width  = filter_input( INPUT_POST, 'fixed_width', FILTER_UNSAFE_RAW );
				$fixed_height = filter_input( INPUT_POST, 'fixed_height', FILTER_UNSAFE_RAW );

				$height_ratio = filter_input( INPUT_POST, 'height_ratio', FILTER_UNSAFE_RAW );
				$start_index  = filter_input( INPUT_POST, 'start_index', FILTER_SANITIZE_NUMBER_INT );

				$flick_power   = filter_input( INPUT_POST, 'flick_power', FILTER_SANITIZE_NUMBER_INT );
				$preload_pages = filter_input( INPUT_POST, 'preload_pages', FILTER_SANITIZE_NUMBER_INT );

				filter_input( INPUT_POST, 'pagination', FILTER_UNSAFE_RAW ) ? $pagination = 1 : $pagination = 0;
				filter_input( INPUT_POST, 'slide_focus', FILTER_UNSAFE_RAW ) ? $slide_focus = 1 : $slide_focus = 0;

				$demo_type = filter_input( INPUT_POST, 'demo_type', FILTER_SANITIZE_NUMBER_INT );

				$sliderSettings = [
					'img_size'       => $img_size,
					'autoplay'       => $autoplay,
					'cover'          => $cover,
					'trim_space'     => $trim_space,
					'auto_width'     => $auto_width,
					'auto_height'    => $auto_height,
					'arrows'         => $arrows,
					'lazy_load'      => $lazy_load,
					'pause_on_hover' => $pause_on_hover,
					'pause_on_focus' => $pause_on_focus,
					'drag'           => $drag,
					'keyboard'       => $keyboard,
					'hover'          => $hover,
					'label'          => $label,
					'textauszug'     => $textauszug,

					'img_link_aktiv' => $img_link_aktiv,
					'select_design_option' => $select_design_option,
					'select_design_btn_link' => $select_design_btn_link,
					'design_btn_aktiv' => $design_btn_aktiv,
					'design_btn_txt' => $design_btn_txt,
					'design_btn_css' => $design_btn_css,
					'design_link_tag_txt' => $design_link_tag_txt,
					'design_text_aktiv' => $design_text_aktiv,
					'select_design_text' => $select_design_text,
					'design_titel_css' => $design_titel_css,
					'design_auszug_css' => $design_auszug_css,
					'select_title_tag' => $select_title_tag,
					'design_container_height' => $design_container_height,
					'inner_container_height' => $inner_container_height,

					'rewind'         => $rewind,
					'speed'          => $speed,
					'rewind_speed'   => $rewind_speed,
					'fixed_width'    => $fixed_width,
					'fixed_height'   => $fixed_height,
					'height_ratio'   => $height_ratio,
					'start_index'    => $start_index,
					'flick_power'    => $flick_power,
					'preload_pages'  => $preload_pages,
					'pagination'     => $pagination,
					'slide_focus'    => $slide_focus,

					'pro_page_xs'  => $pro_page_xs,
					'pro_page_sm'  => $pro_page_sm,
					'pro_page_md'  => $pro_page_md,
					'pro_page_lg'  => $pro_page_lg,
					'pro_page_xl'  => $pro_page_xl,
					'pro_page_xxl' => $pro_page_xxl,

					'gap_xs'  => $gap_xs,
					'gap_sm'  => $gap_sm,
					'gap_md'  => $gap_md,
					'gap_lg'  => $gap_lg,
					'gap_xl'  => $gap_xl,
					'gap_xxl' => $gap_xxl,

					'width_xs'  => $width_xs,
					'width_sm'  => $width_sm,
					'width_md'  => $width_md,
					'width_lg'  => $width_lg,
					'width_xl'  => $width_xl,
					'width_xxl' => $width_xxl,

					'height_xs'  => $height_xs,
					'height_sm'  => $height_sm,
					'height_md'  => $height_md,
					'height_lg'  => $height_lg,
					'height_xl'  => $height_xl,
					'height_xxl' => $height_xxl,

					'slide_type' => $slide_type,
					'pro_move'   => $pro_move,
					'pro_page'   => $pro_page,
					'gap'        => $gap,
					'width'      => $width,
					'height'     => $height,
					'intervall'  => $intervall,
					'focus'      => $focus,
				];

				/*if ( $trim_space == 'move' ) {
					unset( $sliderSettings['trim_space'] );
				} else {
					$sliderSettings['trim_space'] = str_replace( "'", '', $sliderSettings['trim_space'] );
				}*/


				$record->bezeichnung = $bezeichnung;
				$record->slider_id   = apply_filters( $this->basename.'/generate_random_id', 12, 0 );
				$record->data        = json_encode( $sliderSettings );

				switch ( $type ) {
					case 'insert':
					case 'demo':
						if($type == 'demo' && $demo_type){
							$demo = apply_filters($this->basename.'/get_post_slider_demo', $demo_type);
							if($demo->status) {
								$record->bezeichnung = $demo->bezeichnung;
								$record->data        = json_encode( $demo->record );
							}
						}
						$insert               = apply_filters( $this->basename.'/post_selector_set_slider', $record );
						$responseJson->status = $insert->status;
						$responseJson->msg    = $insert->msg;
						break;
					case 'update':
						$id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
						if ( ! $id ) {
							$responseJson->msg = 'Ein Fehler ist aufgetreten!';

							return $responseJson;
						}
						$record->id = $id;
						apply_filters( $this->basename.'/update_post_selector_slider', $record );
						$responseJson->status = true;
						$responseJson->msg    = 'Änderungen gespeichert!';
						break;
				}

				$load_toast = apply_filters( $this->basename.'/post_selector_get_by_args', 'ORDER BY created_at ASC' );
				if ( $load_toast->status ) {
					$responseJson->load_toast = $load_toast->record;
				}

				break;

			case'post_galerie_handle':

				$type = filter_input( INPUT_POST, 'type', FILTER_UNSAFE_RAW );
				$bezeichnung = filter_input( INPUT_POST, 'bezeichnung', FILTER_UNSAFE_RAW );
				$beschreibung = filter_input( INPUT_POST, 'beschreibung', FILTER_UNSAFE_RAW );
				$record->animate_select = filter_input( INPUT_POST, 'animate_select', FILTER_UNSAFE_RAW );
				$record->type   = filter_input( INPUT_POST, 'galerie_type', FILTER_VALIDATE_INT );
				$link = filter_input( INPUT_POST, 'link', FILTER_UNSAFE_RAW);
				$url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);

				filter_input(INPUT_POST, 'show_bezeichnung', FILTER_UNSAFE_RAW) ? $record->show_bezeichnung = true : $record->show_bezeichnung = false;
				filter_input(INPUT_POST, 'show_beschreibung', FILTER_UNSAFE_RAW) ? $record->show_beschreibung = true : $record->show_beschreibung = false;

				filter_input(INPUT_POST, 'hover_aktiv', FILTER_UNSAFE_RAW) ? $record->hover_aktiv = true : $record->hover_aktiv = false;
				filter_input(INPUT_POST, 'hover_title_aktiv', FILTER_UNSAFE_RAW) ? $record->hover_title_aktiv = true : $record->hover_title_aktiv = false;
				filter_input(INPUT_POST, 'hover_beschreibung_aktiv', FILTER_UNSAFE_RAW) ? $record->hover_beschreibung_aktiv = true : $record->hover_beschreibung_aktiv = false;
				filter_input(INPUT_POST, 'lightbox_aktiv', FILTER_UNSAFE_RAW) ? $record->lightbox_aktiv = true : $record->lightbox_aktiv = false;
				filter_input(INPUT_POST, 'caption_aktiv', FILTER_UNSAFE_RAW) ? $record->caption_aktiv = true : $record->caption_aktiv = false;

				filter_input(INPUT_POST, 'lazy_load_aktiv', FILTER_UNSAFE_RAW) ? $record->lazy_load_aktiv = true : $record->lazy_load_aktiv = false;
				filter_input(INPUT_POST, 'lazy_load_ani_aktiv', FILTER_UNSAFE_RAW) ? $record->lazy_load_ani_aktiv = true : $record->lazy_load_ani_aktiv = false;

				filter_input(INPUT_POST, 'link_target', FILTER_UNSAFE_RAW) ? $record->link_target = true : $record->link_target = false;

				$img_size = filter_input( INPUT_POST, 'image_size', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH );

				$record->is_link = false;
				if($url){
					$record->link = $url;
				} elseif ($link) {
					$record->link = $link;
					$record->is_link = true;
				} else {
					$record->link = '';
				}

				if(!$type){
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';
					$responseJson->status = false;
					return $responseJson;
				}

				if(!$bezeichnung) {
					$bezeichnung = 'Galerie-' .apply_filters($this->basename.'/generate_random_id',4,0,4);
				}

				switch ($record->type){
					case '1':
						$slider_id   = filter_input( INPUT_POST, 'slider_id', FILTER_VALIDATE_INT );

						$typeSettings = [
							'slider_id' => $slider_id,
							'img_size' => $img_size
						];
						break;
					case'2':
						filter_input(INPUT_POST, 'galerie_crop_aktiv', FILTER_UNSAFE_RAW) ? $galerie_crop_aktiv = true : $galerie_crop_aktiv = false;
						$img_width   = filter_input( INPUT_POST, 'img_width', FILTER_VALIDATE_INT );
						$img_height   = filter_input( INPUT_POST, 'img_height', FILTER_VALIDATE_INT );

						$xl_grid_column = filter_input( INPUT_POST, 'xl_grid_column', FILTER_UNSAFE_RAW);
						$xl_grid_gutter = filter_input( INPUT_POST, 'xl_grid_gutter', FILTER_UNSAFE_RAW);

						$lg_grid_column = filter_input( INPUT_POST, 'lg_grid_column', FILTER_UNSAFE_RAW);
						$lg_grid_gutter = filter_input( INPUT_POST, 'lg_grid_gutter', FILTER_UNSAFE_RAW);

						$md_grid_column = filter_input( INPUT_POST, 'md_grid_column', FILTER_UNSAFE_RAW);
						$md_grid_gutter = filter_input( INPUT_POST, 'md_grid_gutter', FILTER_UNSAFE_RAW);

						$sm_grid_column = filter_input( INPUT_POST, 'sm_grid_column', FILTER_UNSAFE_RAW);
						$sm_grid_gutter = filter_input( INPUT_POST, 'sm_grid_gutter', FILTER_UNSAFE_RAW);

						$xs_grid_column = filter_input( INPUT_POST, 'xs_grid_column', FILTER_UNSAFE_RAW);
						$xs_grid_gutter = filter_input( INPUT_POST, 'xs_grid_gutter', FILTER_UNSAFE_RAW);

						$typeSettings = [
							'img_size' => $img_size,
							'crop' => $galerie_crop_aktiv,
							'img_width' => $img_width ?: 260,
							'img_height' => !$img_height &&  !$galerie_crop_aktiv ? 160 : $img_height,
							'xl_grid_column' => $xl_grid_column ?: 5,
							'xl_grid_gutter' => $xl_grid_gutter ?: 1,
							'lg_grid_column' => $lg_grid_column ?: 4,
							'lg_grid_gutter' => $lg_grid_gutter ?: 1,
							'md_grid_column' => $md_grid_column ?: 3,
							'md_grid_gutter' => $md_grid_gutter ?: 1,
							'sm_grid_column' => $sm_grid_column ?: 2,
							'sm_grid_gutter' => $sm_grid_gutter ?: 1,
							'xs_grid_column' => $xs_grid_column ?: 1,
							'xs_grid_gutter' => $xs_grid_gutter ?: 1
						];
						break;
					case '3':
						$xl_column = filter_input( INPUT_POST, 'xl_column', FILTER_UNSAFE_RAW);
						$xl_gutter = filter_input( INPUT_POST, 'xl_gutter', FILTER_UNSAFE_RAW);

						$lg_column = filter_input( INPUT_POST, 'lg_column', FILTER_UNSAFE_RAW);
						$lg_gutter = filter_input( INPUT_POST, 'lg_gutter', FILTER_UNSAFE_RAW);

						$md_column = filter_input( INPUT_POST, 'md_column', FILTER_UNSAFE_RAW);
						$md_gutter = filter_input( INPUT_POST, 'md_gutter', FILTER_UNSAFE_RAW);

						$sm_column = filter_input( INPUT_POST, 'sm_column', FILTER_UNSAFE_RAW);
						$sm_gutter = filter_input( INPUT_POST, 'sm_gutter', FILTER_UNSAFE_RAW);

						$xs_column = filter_input( INPUT_POST, 'xs_column', FILTER_UNSAFE_RAW);
						$xs_gutter = filter_input( INPUT_POST, 'xs_gutter', FILTER_UNSAFE_RAW);

						$typeSettings = [
							'img_size'  => $img_size,
							'xl_column' => $xl_column ?: 6,
							'xl_gutter' => $xl_gutter ?: 2,
							'lg_column' => $lg_column ?: 5,
							'lg_gutter' => $lg_gutter ?: 1,
							'md_column' => $md_column ?: 4,
							'md_gutter' => $md_gutter ?: 1,
							'sm_column' => $sm_column ?: 3,
							'sm_gutter' => $sm_gutter ?: 1,
							'xs_column' => $xs_column ?: 2,
							'xs_gutter' => $xs_gutter ?: 1
						];
						break;
					default:
						$typeSettings = [];
				}

				if(!$typeSettings){
					$responseJson->msg = 'kein Galerie Type ausgewählt!';
					return $responseJson;
				}
				$record->type_settings = json_encode($typeSettings);
				$record->bezeichnung = esc_html($bezeichnung);
				$record->beschreibung = esc_textarea($beschreibung);

				switch ($type){
					case'insert':
						$insert = apply_filters($this->basename.'/post_selector_set_galerie', $record);
						if(!$insert->id) {
							$responseJson->msg = $insert->msg;
							$responseJson->status = false;
							return $responseJson;
						}
						$responseJson->id = $insert->id;
						$args = sprintf('WHERE id=%d', $insert->id);
						$galerie = apply_filters($this->basename.'/post_selector_get_galerie','');
						if(!$galerie->status){
							$responseJson->msg = 'Ein Fehler ist aufgetreten!';
							$responseJson->status = false;
							return $responseJson;
						}

						$responseJson->images = false;
						$responseJson->galerie = $galerie->record;
						$responseJson->show_galerie = true;
						$responseJson->reset = true;
						$responseJson->status = true;
						break;

					case 'update':
						$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
						if(!$id){

							$responseJson->msg = 'Ein Fehler ist aufgetreten!';
							$responseJson->status = false;
							return $responseJson;
						}
						$record->id = $id;
						apply_filters($this->basename.'/post_selector_update_galerie', $record);
						$responseJson->msg = 'Änderungen erfolgreich gespeichert!';

						break;
				}
				$responseJson->status = true;
				break;

			case 'get_galerie_data':

				$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
				$type = filter_input( INPUT_POST, 'type', FILTER_UNSAFE_RAW);
				$responseJson->status = true;
				$responseJson->type = $type;

				switch ($type) {
					case'galerie-toast':
						$galerie = apply_filters($this->basename.'/post_selector_get_galerie','');
						$responseJson->galerie = $galerie->record;
						return $responseJson;
				}

				if(!$id || !$type){
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';
					$responseJson->status = false;
					return $responseJson;
				}

				$responseJson->aniSelect = apply_filters($this->basename.'/post_selector_get_animate_select', false);

				$pages = apply_filters($this->basename.'/post_selector_get_theme_pages', false);
				$post = apply_filters($this->basename.'/post_selector_get_theme_posts', false);
				if ($post) {
					$responseJson->sitesSelect = array_merge_recursive($pages, $post);
				} else {
					$responseJson->sitesSelect = $pages;
				}
				$responseJson->galerieSelect = apply_filters($this->basename.'/get_galerie_types_select','');

				$galerieArgs = sprintf('WHERE id=%d', $id);
				$galerie = apply_filters($this->basename.'/post_selector_get_galerie',$galerieArgs, false);
				$responseJson->record = $galerie->record;

				$galerie->record->type_settings = json_decode($galerie->record->type_settings);


				$args = sprintf('WHERE galerie_id=%d ORDER BY position ASC', $id);
				$images = apply_filters($this->basename.'/post_selector_get_images',$args);

				$img_arr = [];
				if($images->status){
					foreach ($images->record as $tmp){
						$src = wp_get_attachment_image_src( $tmp->img_id, 'medium', false );
						$url = wp_get_attachment_image_src( $tmp->img_id, 'large', false );
						isset($tmp->img_bezeichnung) && $tmp->img_bezeichnung ? $img_bezeichnung = $tmp->img_bezeichnung : $img_bezeichnung = '';
						isset($tmp->beschreibung) && $tmp->beschreibung ? $beschreibung = $tmp->beschreibung : $beschreibung = '';
						isset($tmp->img_title) && $tmp->img_title ? $img_title = $tmp->img_title : $img_title = '';
						$img_item = [
							'id' => $tmp->id,
							'src' => $src[0],
							'url' => $url[0],
							'img_id' => $tmp->img_id,
							'bezeichnung' => $img_bezeichnung,
							'beschreibung' => $beschreibung,
							'title' => $img_title
						];
						$img_arr[] = $img_item;
					}
				}
				$img_arr ? $responseJson->images = $img_arr : $responseJson->images = false;
				break;

			case 'delete_image':
				$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
				$responseJson->type   = filter_input( INPUT_POST, 'type', FILTER_UNSAFE_RAW );
				if(!$id){
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';
					$responseJson->status = false;
					return $responseJson;
				}
				apply_filters($this->basename.'/post_selector_delete_image', $id);
				$responseJson->id = $id;
				$responseJson->status = true;
				$responseJson->msg = 'Bild gelöscht!';
				break;

			case 'add_galerie_image':
				$type   = filter_input( INPUT_POST, 'type', FILTER_UNSAFE_RAW );
				$record->img_title   = filter_input( INPUT_POST, 'img_title', FILTER_UNSAFE_RAW );
				$record->img_beschreibung   = filter_input( INPUT_POST, 'img_beschreibung', FILTER_UNSAFE_RAW );
				$record->img_caption   = filter_input( INPUT_POST, 'img_caption', FILTER_UNSAFE_RAW );

				switch ($type){
					case 'insert':
						$galerie_id   = filter_input( INPUT_POST, 'galerie_id', FILTER_VALIDATE_INT );
						$image_id   = filter_input( INPUT_POST, 'image_id', FILTER_VALIDATE_INT );
						$record->galerie_id = (int) $galerie_id;
						$record->img_id = (int) $image_id;
						$insert = apply_filters($this->basename.'/post_selector_set_image', $record);
						$responseJson->id = $insert->id;
						break;
					case'update':
						$record->id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
						if(!$record->id ){
							$responseJson->msg = 'Ein Fehler ist aufgetreten!';
							$responseJson->status = false;
							return $responseJson;
						}
						filter_input(INPUT_POST, 'hover_aktiv', FILTER_UNSAFE_RAW) ? $record->hover_aktiv = true : $record->hover_aktiv = false;
						filter_input(INPUT_POST, 'hover_title_aktiv', FILTER_UNSAFE_RAW) ? $record->hover_title_aktiv = true : $record->hover_title_aktiv = false;
						filter_input(INPUT_POST, 'hover_beschreibung_aktiv', FILTER_UNSAFE_RAW) ? $record->hover_beschreibung_aktiv = true : $record->hover_beschreibung_aktiv = false;
						filter_input(INPUT_POST, 'galerie_settings_aktiv', FILTER_UNSAFE_RAW) ? $record->galerie_settings_aktiv = true : $record->galerie_settings_aktiv = false;
						filter_input(INPUT_POST, 'link_target', FILTER_UNSAFE_RAW) ? $record->link_target = true : $record->link_target = false;

						$link = filter_input( INPUT_POST, 'link', FILTER_UNSAFE_RAW );
						$url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);

						$record->is_link = false;
						if($url){
							$record->link = $url;
						} elseif ($link) {
							$record->link = $link;
							$record->is_link = true;
						} else {
							$record->link = '';
						}

						apply_filters($this->basename.'/post_selector_update_image', $record);
						$responseJson->msg = 'Änderungen gespeichert!';
						break;
				}

				$responseJson->status = true;
				break;

			case 'delete_galerie':
				$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
				$type = filter_input( INPUT_POST, 'type', FILTER_UNSAFE_RAW );
				if(!$id || !$type){
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';
					$responseJson->status = false;
					return $responseJson;
				}
				apply_filters($this->basename.'/post_selector_delete_galerie', $id);
				$galerie = apply_filters($this->basename.'/post_selector_get_galerie','');
				$responseJson->type = $type;
				$responseJson->galerie = $galerie->record;
				$responseJson->status = true;
				$responseJson->id = $id;
				$responseJson->msg = 'Galerie gelöscht!';
				break;


			case 'get_slider_data':
				$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
				$type = filter_input( INPUT_POST, 'type', FILTER_UNSAFE_RAW );

				$responseJson->status = true;
				if ( $type == 'update' ) {
					if ( ! $id ) {
						$responseJson->msg = 'Ein Fehler ist aufgetreten!';

						return $responseJson;
					}
					$args                        = sprintf( 'WHERE id=%d', $id );
					$fetch                       = false;
					$responseJson->load_template = true;
					$responseJson->id            = $id;
					$responseJson->type          = $type;

				} else {
					$args                     = 'ORDER BY created_at ASC';
					$fetch                    = true;
					$responseJson->load_toast = true;
				}
				//Get Galerie
				$galerie = apply_filters($this->basename.'/post_selector_get_galerie', '');
				$galerie->status ? $responseJson->galerie = $galerie->record : $responseJson->galerie = false;

				//Get Slider
				$load_toast = apply_filters( $this->basename.'/post_selector_get_by_args', $args, $fetch );
				if ( ! $load_toast->status ) {
					return $responseJson;
				}
				$responseJson->record = $load_toast->record;
				$responseJson->select_optionen = apply_filters($this->basename.'/ps_select_design_optionen',false);
				$responseJson->status = true;
				break;

			case 'delete_post_items':
				$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
				$type = filter_input( INPUT_POST, 'type', FILTER_UNSAFE_RAW );

				if ( ! $id || ! $type ) {
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';

					return $responseJson;
				}
				switch ( $type ) {
					case 'slider':
						apply_filters( $this->basename.'/delete_post_selector_slider', $id );
						break;
				}
				$responseJson->id     = $id;
				$responseJson->type   = $type;
				$responseJson->status = true;
				$responseJson->msg    = 'erfolgreich gelöscht!';
				break;

			case 'get_galerie_modal_data':
				$pages = apply_filters($this->basename.'/post_selector_get_theme_pages', false);
				$post = apply_filters($this->basename.'/post_selector_get_theme_posts', false);
				if ($post) {
					$responseJson->sitesSelect = array_merge_recursive($pages, $post);
				} else {
					$responseJson->sitesSelect = $pages;
				}
				$responseJson->aniSelect = apply_filters($this->basename.'/post_selector_get_animate_select', false);
				$responseJson->galerieSelect = apply_filters($this->basename.'/get_galerie_types_select','');
				$responseJson->status = true;
				break;

			case'get_image_modal_data':
				$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

				if(!$id){
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';
					$responseJson->status = false;
					return $responseJson;
				}

				$args = sprintf('WHERE id=%d ORDER BY position ASC', $id);
				$image = apply_filters($this->basename.'/post_selector_get_images', $args, false);
				if(!$image->status){
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';
					$responseJson->status = false;
					return $responseJson;
				}

				$responseJson->record = $image->record;
				$pages = apply_filters($this->basename.'/post_selector_get_theme_pages', false);
				$post = apply_filters($this->basename.'/post_selector_get_theme_posts', false);
				if ($post) {
					$responseJson->sitesSelect = array_merge_recursive($pages, $post);
				} else {
					$responseJson->sitesSelect = $pages;
				}

				$responseJson->galerieSelect = apply_filters($this->basename.'/get_galerie_types_select','');
				$responseJson->status = true;
				break;

			case 'get_galerie_type_data':
				$typeId   = filter_input( INPUT_POST, 'type_id', FILTER_VALIDATE_INT );
				$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
				if(!$typeId){
					$responseJson->msg = 'keine Daten gefunden!';
					return $responseJson;
				}

				if($id){
					$galerieArgs = sprintf('WHERE id=%d', $id);
					$galerie = apply_filters($this->basename.'/post_selector_get_galerie',$galerieArgs, false);
					$galerie->status ? $responseJson->typeSettings = json_decode($galerie->record->type_settings) : $responseJson->typeSettings = false;
				}

				$responseJson->type = (string) $typeId;
				switch ($typeId){
					case '1':
						$postSlider = apply_filters($this->basename.'/post_selector_get_by_args','', true, 'bezeichnung, id');
						if(!$postSlider->status){
							$responseJson->msg = 'kein Slider gefunden!';
							return $responseJson;
						}
						$responseJson->sliderSelect = $postSlider->record;
						$responseJson->status = true;
						$responseJson->disabled = false;
						break;
					case '2':
					case '3':
						$responseJson->aniSelect = apply_filters($this->basename.'/post_selector_get_animate_select', false);
						$responseJson->status = true;
						$responseJson->disabled = false;
						break;
				}

				break;
			case'image_change_position':
				$regEx = '/(\d{1,6})/i';
				if($_POST['data']){
					$position = 1;
					foreach ($_POST['data'] as $tmp){
						preg_match($regEx, $tmp, $hit);
						if($hit[0]){
							apply_filters($this->basename.'/post_update_sortable_position',$hit[0], $position);
							$position++;
						}
					}
				}

				$responseJson->status = true;
				break;

			case'delete_images_array':
				if($_POST['images']){
					foreach ($_POST['images'] as $tmp){
						$id = filter_var($tmp, FILTER_VALIDATE_INT);
						apply_filters($this->basename.'/post_selector_delete_image', $id);
					}

					$responseJson->status = true;
				}
				break;

			case'update_ps_settings':
				$responseJson->spinner = true;
				$userRole   = filter_input( INPUT_POST, 'user_role', FILTER_UNSAFE_RAW );
				if(!$userRole){
					$responseJson->msg = 'Es wurden keine Daten übertragen!';
					return $responseJson;
				}

				update_option('ps_two_user_role', $userRole);
				$responseJson->status = true;
				$responseJson->msg = date('H:i:s', current_time('timestamp'));
				break;

			case 'galerie_data_table':
				$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
				$query = '';
				$columns = array(
					"",
					"",
					"img_title",
					"created_at",
					"",
					"",
					"",
					""
				);

				if (isset($_POST['search']['value'])) {
					$query = 'WHERE ( galerie_id='. $id .'
                              AND ( img_title LIKE "%' . $_POST['search']['value'] . '%"
                              OR created_at LIKE "%' . $_POST['search']['value'] . '%"
                              OR img_caption LIKE "%' . $_POST['search']['value'] . '%"
                              OR img_beschreibung LIKE "%' . $_POST['search']['value'] . '%"
                            ) ) ';
				} else {
					$query = 'WHERE galerie_id='.$id.'';
				}

				if (isset($_POST['order'])) {
					$query .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
				} else {
					$query .= ' ORDER BY position ASC';
				}

				$limit = '';
				if ($_POST["length"] != -1) {
					$limit = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
				}

				$table = apply_filters($this->basename.'/post_selector_get_images',$query . $limit);
				$data_arr = array();
				if (!$table->status) {
					return array(
						"draw" => $_POST['draw'],
						"recordsTotal" => 0,
						"recordsFiltered" => 0,
						"data" => $data_arr
					);
				}

				foreach ($table->record as $tmp) {

					$checkbox = '<div class="form-check mb-0 pb-0">
                         <input data-id="'.$tmp->id.'"  class="form-check-input check-table-items" type="checkbox">
                         </div>';
					$img_src = wp_get_attachment_image_src($tmp->img_id);
					$img_full = wp_get_attachment_image_src($tmp->img_id, 'full');
					$imgMeta = wp_get_attachment_metadata($tmp->img_id);
					$file = get_attached_file( $tmp->img_id ) ;
					$size = filesize($file);

					$finfo = new finfo(FILEINFO_MIME_TYPE);
					$mimeType = $finfo->file($file);
					$date = explode(' ', $tmp->created);
					$data_item = array();
					$data_item[] = $checkbox;
					$data_item[] = '<a data-gallery="" title="'.$tmp->img_title.'" href="'.$img_full[0].'"><img src="'.$img_src[0].'" alt="" width="50"></a>';
					$data_item[] = $tmp->img_title;
					$data_item[] = '<span class="d-none">' . $tmp->created_at . '</span><b class="strong-font-weight">' . $date[0] . '</b><small style="font-size: .9rem" class="d-block">' . $date[1] . ' Uhr</small>';
					$data_item[] = $mimeType;
					$data_item[] = apply_filters('post_select_file_size_convert', $size);

					$data_item[] = $imgMeta['width'] . 'x' .$imgMeta['height'] . ' (px)';
					$data_item[] = '<button data-bs-id="'.$tmp->id.'" data-bs-type="image" data-bs-handle="image" data-bs-toggle="modal" data-bs-target="#galerieHandleModal" class="btn btn-blue-outline btn-sm"><i class="fa fa-gear"></i>&nbsp; settings</button>';
					$data_item[] = '<button type="button" data-bs-id="'.$tmp->id.'" data-bs-type="table" data-bs-method="delete_image" data-bs-toggle="modal" data-bs-target="#formDeleteModal" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i>&nbsp; löschen</button>';
					$data_arr[] = $data_item;
				}

				$tbCount = apply_filters($this->basename.'/post_selector_get_images', 'WHERE galerie_id='.$id.'');
				$responseJson = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $tbCount->count,
					"recordsFiltered" => $tbCount->count,
					"data" => $data_arr,
				);
				break;
		}
		return  $responseJson;
	}
}
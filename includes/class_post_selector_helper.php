<?php

namespace Post\Selector;

use Exception;
use Post_Selector;
use stdClass;


/**
 * ADMIN Post-Selector Helper
 *
 * @link       https://wwdh.de
 * @since      1.0.0
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/admin/gutenberg/
 */
defined( 'ABSPATH' ) or die();

class Post_Selector_Helper {

	/**
	 * The plugin Slug Path.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_dir plugin Slug Path.
	 */
	protected string $plugin_dir;

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

	/**
	 * Store plugin helper class.
	 *
	 * @param string $basename
	 * @param string $version
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @var Post_Selector $main
	 */

	public function __construct( string $basename, string $version,  Post_Selector $main ) {

		$this->basename   = $basename;
		$this->version    = $version;
		$this->main       = $main;

	}

	/**
	 * @throws Exception
	 */
	public function getPSRandomString(): string
	{
		if (function_exists('random_bytes')) {
			$bytes = random_bytes(16);
			$str = bin2hex($bytes);
		} elseif (function_exists('openssl_random_pseudo_bytes')) {
			$bytes = openssl_random_pseudo_bytes(16);
			$str = bin2hex($bytes);
		} else {
			$str = md5(uniqid('post_selector_rand', true));
		}

		return $str;
	}

	public function getPSGenerateRandomId($passwordlength = 12, $numNonAlpha = 1, $numNumberChars = 4, $useCapitalLetter = true): string
	{
		$numberChars = '123456789';
		//$specialChars = '!$&?*-:.,+@_';
		$specialChars = '!$%&=?*-;.,+~@_';
		$secureChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
		$stack = $secureChars;
		if ($useCapitalLetter == true) {
			$stack .= strtoupper($secureChars);
		}
		$count = $passwordlength - $numNonAlpha - $numNumberChars;
		$temp = str_shuffle($stack);
		$stack = substr($temp, 0, $count);
		if ($numNonAlpha > 0) {
			$temp = str_shuffle($specialChars);
			$stack .= substr($temp, 0, $numNonAlpha);
		}
		if ($numNumberChars > 0) {
			$temp = str_shuffle($numberChars);
			$stack .= substr($temp, 0, $numNumberChars);
		}

		return str_shuffle($stack);
	}

	/**
	 * @param false $args
	 *
	 * @return object
	 */
	public function psSelectDesignOptionen( bool $args = false): object
	{
		$selectDesign = [
			'0' => [
				'id' => 0,
				'name' => 'auswählen...'
			],
			'1' => [
				'id' => 1,
				'name' => 'erweitert'
			]
		];

		$selectLinkType = [
			'0'=> [
				'id' => 1,
				'name' => 'Light Box',
			],
			'1'=> [
				'id' => 2,
				'name' => 'zum Beitrag',
			],
			'2'=> [
				'id' => 3,
				'name' => 'Bildanhang Seite',
			],
			'3'=> [
				'id' => 4,
				'name' => 'extra Url',
			]
		];

		$selectTextOption = [
			'0' => [
				'id' => 1,
				'name' => 'Beitragstitel'
			],
			'1' => [
				'id' => 2,
				'name' => 'Textauszug'
			],
			'2' => [
				'id' => 3,
				'name' => 'Beitragstitel & Textauszug'
			]
		];

		$selectTitleTag = [
			'0' => [
				'id' => 1,
				'name' => 'Beitragstitel'
			],
			'1' => [
				'id' => 2,
				'name' => 'individuell'
			]
		];

		$returnArray = [
			'select_design' => $selectDesign,
			'select_link' => $selectLinkType,
			'select_text' => $selectTextOption,
			'select_title_tag' => $selectTitleTag
		];

		return $this->postSelectArrayToObject($returnArray);
	}

	public function post_remove_thumbnail_width_height($imgHtml): string
	{
		return preg_replace('@(width.+height.+?".+?")@i', "", $imgHtml);
	}

	public function post_selector_user_roles_select(): array {

		return [
			'read'           => esc_html__( 'Subscriber', 'wp-post-selector' ),
			'edit_posts'     => esc_html__( 'Contributor', 'wp-post-selector' ),
			'publish_posts'  => esc_html__( 'Author', 'wp-post-selector' ),
			'publish_pages'  => esc_html__( 'Editor', 'wp-post-selector' ),
			'manage_options' => esc_html__( 'Administrator', 'wp-post-selector' )
		];
	}

	//WARNING JOB HELPER

	/**
	 * @param false $id
	 *
	 * @return object
	 */
	public function getGalerieTypesSelect($id = 0): object
	{

		$types = [
			'0' => [
				'id' => '',
				'bezeichnung' => 'auswählen...'
			],
			'1' => [
				'id' => 1,
				'bezeichnung' => 'Slider'
			],
			'2' => [
				'id' => 2,
				'bezeichnung' => 'Galerie Grid'
			],
			'3' => [
				'id' => 3,
				'bezeichnung' => 'Masonry Grid'
			]
		];

		return $this->postSelectArrayToObject($types);
	}

	public function postSelectorGetAnimateSelect(): object
	{
		$seekers = array("bounce", "flash", "pulse", "rubberBand", "shakeX", "headShake", "swing", "tada", "wobble", "jello", "heartBeat");
		$entrances = array("backInDown", "backInLeft", "backInRight", "backInUp");
		//$back_exits = array("backOutDown","backOutLeft","backOutRight","backOutUp");
		$bouncing = array("bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp");
		$fade = array("fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "fadeInTopLeft", "fadeInTopRight",
			"fadeInBottomLeft", "fadeInBottomRight");
		$flippers = array("flip", "flipInX", "flipInY", "flipOutX", "flipOutY");
		$lightspeed = array("lightSpeedInRight", "lightSpeedInLeft", "lightSpeedOutRight", "lightSpeedOutLeft");
		$rotating = array("rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight");
		$zooming = array("zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp");
		$sliding = array("slideInDown", "slideInLeft", "slideInRight", "slideInUp");

		$ani_arr = array();
		for ($i = 0; $i < count($seekers); $i++) {
			$ani_item = array(
				"animate" => $seekers[$i]
			);
			$ani_arr[] = $ani_item;
		}

		$ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

		for ($i = 0; $i < count($entrances); $i++) {
			$ani_item = array(
				"animate" => $entrances[$i]
			);
			$ani_arr[] = $ani_item;
		}

		$ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);


		for ($i = 0; $i < count($bouncing); $i++) {
			$ani_item = array(
				"animate" => $bouncing[$i]
			);
			$ani_arr[] = $ani_item;
		}

		$ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

		for ($i = 0; $i < count($fade); $i++) {
			$ani_item = array(
				"animate" => $fade[$i]
			);
			$ani_arr[] = $ani_item;
		}

		$ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

		for ($i = 0; $i < count($flippers); $i++) {
			$ani_item = array(
				"animate" => $flippers[$i]
			);
			$ani_arr[] = $ani_item;
		}

		$ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

		for ($i = 0; $i < count($lightspeed); $i++) {
			$ani_item = array(
				"animate" => $lightspeed[$i]
			);
			$ani_arr[] = $ani_item;
		}

		$ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

		for ($i = 0; $i < count($rotating); $i++) {
			$ani_item = array(
				"animate" => $rotating[$i]
			);
			$ani_arr[] = $ani_item;
		}

		$ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

		for ($i = 0; $i < count($zooming); $i++) {
			$ani_item = array(
				"animate" => $zooming[$i]
			);
			$ani_arr[] = $ani_item;
		}

		$ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

		for ($i = 0; $i < count($sliding); $i++) {
			$ani_item = array(
				"animate" => $sliding[$i]
			);
			$ani_arr[] = $ani_item;
		}

		return $this->postSelectArrayToObject($ani_arr);
	}

	public function PostSelectFileSizeConvert(float $bytes): string
	{
		$result = '';
		$bytes = floatval($bytes);
		$arBytes = array(
			0 => array("UNIT" => "TB", "VALUE" => pow(1024, 4)),
			1 => array("UNIT" => "GB", "VALUE" => pow(1024, 3)),
			2 => array("UNIT" => "MB", "VALUE" => pow(1024, 2)),
			3 => array("UNIT" => "KB", "VALUE" => 1024),
			4 => array("UNIT" => "B", "VALUE" => 1),
		);

		foreach ($arBytes as $arItem) {
			if ($bytes >= $arItem["VALUE"]) {
				$result = $bytes / $arItem["VALUE"];
				$result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
				break;
			}
		}
		return $result;
	}

	/**
	 * @param $name
	 * @param bool $base64
	 * @param bool $data
	 *
	 * @return string
	 */
	public function ps2_svg_icons($name, bool $base64 = true, bool $data = true): string {
		$icon = '';
		switch ($name){
			case 'layer':
				$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="ps2-icon" viewBox="0 0 16 16">
  						  <path d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882l-7.5-4zM8 9.433 1.562 6 8 2.567 14.438 6 8 9.433z"/>
						 </svg>';
				break;
			case'sign-post':
				$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="ps2-icon" viewBox="0 0 16 16">
  						 <path d="M7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586a1 1 0 0 0-2 0zM13.5 3l.75 1-.75 1H2V3h11.5zm.5 5v2H2.5l-.75-1 .75-1H14z"/>
						 </svg>';
				break;
		}
		if($base64){
			if ($data){
				return 'data:image/svg+xml;base64,'. base64_encode($icon);
			}
			return base64_encode($icon);
		}
		return $icon;
	}

	/**
	 * @param $id
	 *
	 * @return object
	 */
	public function getPostSliderDemo($id): object
	{

		$rand = $this->getPSGenerateRandomId(4, 0, 4);
		$sliderSettings = [];
		$return = new stdClass();
		$return->status = false;
		switch ($id) {
			case '1':
				$return->bezeichnung = 'Beitrags Slider Demo-' . $rand;
				$return->status = true;
				$sliderSettings = [
					'autoplay' => 'loop',
					'cover' => 1,
					'trim_space' => 'true',
					'auto_width' => 0,
					'auto_height' => 0,
					'arrows' => 1,
					'lazy_load' => 'sequential',
					'pause_on_hover' => 1,
					'pause_on_focus' => 1,
					'drag' => 1,
					'keyboard' => 1,
					'hover' => 1,
					'label' => 0,

					'img_link_aktiv' => 1,
					'select_design_option' => 0,
					'select_design_btn_link' => 1,
					'design_btn_aktiv' => 0,
					'design_btn_txt' => 'Button Beschriftung',
					'design_btn_css' => '',
					'design_link_tag_txt' => '',
					'design_text_aktiv' => 0,
					'select_design_text' => 1,
					'design_titel_css' => '',
					'design_auszug_css' => '',
					'select_title_tag' => 1,
					'design_container_height'=> '450px',
					'inner_container_height' => '150px',

					'textauszug' => 1,
					'rewind' => 0,
					'speed' => 500,
					'rewind_speed' => 1000,
					'fixed_width' => '',
					'fixed_height' => '',
					'height_ratio' => '',
					'start_index' => 3,
					'flick_power' => 500,
					'preload_pages' => 1,
					'pagination' => 0,
					'slide_focus' => 1,

					'pro_page_xs' => 1,
					'pro_page_sm' => 1,
					'pro_page_md' => 1,
					'pro_page_lg' => 2,
					'pro_page_xl' => 3,
					'pro_page_xxl' => 4,

					'gap_xs' => '0.1rem',
					'gap_sm' => '0.1rem',
					'gap_md' => '0.1rem',
					'gap_lg' => '0.3rem',
					'gap_xl' => '0.3rem',
					'gap_xxl' => '0.3rem',

					'width_xs' => '100%',
					'width_sm' => '100%',
					'width_md' => '100%',
					'width_lg' => '100%',
					'width_xl' => '100%',
					'width_xxl' => '100%',

					'height_xs' => '300px',
					'height_sm' => '300px',
					'height_md' => '300px',
					'height_lg' => '250px',
					'height_xl' => '250px',
					'height_xxl' => '250px',

					'slide_type' => 'loop',
					'pro_move' => '',
					'pro_page' => 5,
					'gap' => '0.5rem',
					'width' => '100%',
					'height' => '250px',
					'intervall' => 3000,
					'focus' => 'center',
				];
				break;
			case'2':
				$return->status = true;
				$return->bezeichnung = 'Einzelbild Demo-' . $rand;
				$sliderSettings = [
					'autoplay' => 1,
					'cover' => 1,
					'trim_space' => 'true',
					'auto_width' => 0,
					'auto_height' => 0,
					'arrows' => 0,
					'lazy_load' => 'nearby',
					'pause_on_hover' => 0,
					'pause_on_focus' => 0,
					'drag' => 0,
					'keyboard' => 0,
					'hover' => 0,
					'label' => 1,

					'img_link_aktiv' => 1,
					'select_design_option' => 0,
					'select_design_btn_link' => 1,
					'design_btn_aktiv' => 0,
					'design_btn_txt' => 'Button Beschriftung',
					'design_btn_css' => '',
					'design_link_tag_txt' => '',
					'design_text_aktiv' => 0,
					'design_titel_css' => '',
					'design_auszug_css' => '',
					'select_title_tag' => 1,
					'select_design_text' => 1,
					'design_container_height'=> '450px',
					'inner_container_height' => '150px',

					'textauszug' => 0,
					'rewind' => 1,
					'speed' => 1200,
					'rewind_speed' => 2500,
					'fixed_width' => '',
					'fixed_height' => '',
					'height_ratio' => '',
					'start_index' => 0,
					'flick_power' => 500,
					'preload_pages' => 3,
					'pagination' => 0,
					'slide_focus' => 1,

					'pro_page_xs' => '',
					'pro_page_sm' => '',
					'pro_page_md' => '',
					'pro_page_lg' => '',
					'pro_page_xl' => '',
					'pro_page_xxl' => '',

					'gap_xs' => '',
					'gap_sm' => '',
					'gap_md' => '',
					'gap_lg' => '',
					'gap_xl' => '',
					'gap_xxl' => '',

					'width_xs' => '450px',
					'width_sm' => '450px',
					'width_md' => '450px',
					'width_lg' => '450px',
					'width_xl' => '450px',
					'width_xxl' => '450px',

					'height_xs' => '350px',
					'height_sm' => '350px',
					'height_md' => '350px',
					'height_lg' => '350px',
					'height_xl' => '350px',
					'height_xxl' => '350px',

					'slide_type' => 'fade',
					'pro_move' => 1,
					'pro_page' => 1,
					'gap' => '0',
					'width' => '450px',
					'height' => '350px',
					'intervall' => 8000,
					'focus' => '0',
				];
				break;

		}
		$return->record = $sliderSettings;

		return $return;
	}

	/**
	 * @param $array
	 *
	 * @return object
	 */
	final public function postSelectArrayToObject($array): object
	{
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$array[$key] = self::postSelectArrayToObject($value);
			}
		}

		return (object)$array;
	}

}

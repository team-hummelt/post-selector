<?php

namespace Post\Selector;

use Post_Selector;
use stdClass;


/**
 * ADMIN Post-Selector Admin Option
 *
 * @link       https://wwdh.de
 * @since      1.0.0
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/admin/gutenberg/
 */
defined( 'ABSPATH' ) or die();

class Post_Selector_Data {

	use Post_Selector_Defaults;

	/**
	 * The plugin Slug Path.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_dir plugin Slug Path.
	 */
	protected string $plugin_dir;

	/**
	 * The Helper Class.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object $helper The Helper Class.
	 */
	protected object $helper;

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
	public function __construct( string $basename, string $version, Post_Selector $main ) {

		$this->basename = $basename;
		$this->version  = $version;
		$this->main     = $main;

		global $plugin_helper;
		$this->helper = $plugin_helper;

	}

	public function getPostSelectDataType($query, $attr)
	{

		$attributes = $this->helper->postSelectArrayToObject($attr);

		$record = new stdClass();
		$record->status = false;
		$sendData = new stdClass();
		$postArr = [];
		isset($attributes->imageCheckActive) ? $sendData->image = true : $sendData->image = false;
		isset($attributes->radioOrder) ? $radioOrder = $attributes->radioOrder : $radioOrder = 1;
		isset($attributes->radioOrderBy) ? $radioOrderBy = $attributes->radioOrderBy : $radioOrderBy = 1;

		if (isset($attributes->selectedCat) && !empty($attributes->selectedCat)) {
			$sendData->kategorie = true;
			isset($attributes->postCount) && $attributes->postCount ? $sendData->postCount = $attributes->postCount : $sendData->postCount = '-1';
			$sendData->katId = $attributes->selectedCat;

			if (isset($query) && !empty($query)) {
				$post = $this->get_posts_by_category($query->posts, $attributes);

			} else {
				$post = $this->get_posts_by_data($sendData, $attributes);
			}

			switch ($radioOrder) {
				case '1':
					$type = 'menu_order';
					break;
				case '2':
					$type = 'post_date';
					break;
				default:
					$type = 'post_date';
			}

			$postSort = $this->order_by_args($post, $type, $radioOrderBy);
			$post = $this->helper->postSelectArrayToObject($postSort);

			switch ($attributes->outputType) {
				case 1:
					do_action($this->basename.'/load_slider_template', $post, $attributes);
					break;
				case 3:
					do_action($this->basename.'/load_news_template', $post, $attributes);
					break;
			}
		}

		if (!isset($attributes->selectedCat) || empty($attributes->selectedCat) && isset($attributes->selectedPosts) && !empty($attributes->selectedPosts)) {
			if (isset($attributes->selectedPosts) && $attributes->selectedPosts) {
				foreach ($attributes->selectedPosts as $tmp) {
					$post = $this->get_posts_by_id($tmp);
					$postArr[] = $post;
				}
			}

			switch ($radioOrder) {
				case '1':
					$type = 'menu_order';
					break;
				case '2':
					$type = 'post_date';
					break;
				default:
					$type = 'post_date';
			}

			$postArr = $this->order_by_args($postArr, $type, $radioOrderBy);
			$post = $this->helper->postSelectArrayToObject($postArr);

			if (isset($attributes->outputType)) {
				switch ($attributes->outputType) {
					case '1':
						do_action($this->basename.'/load_slider_template', $post, $attributes);
						break;
					case '3':
						do_action($this->basename.'/load_news_template', $post, $attributes);
						break;
				}
			}
		}
	}

	/**
	 * @param $args
	 *
	 * @return array
	 */
	final public function postSelectorGetThemePages($args): array
	{
		$pages = get_pages();
		$retArr = [];
		foreach ($pages as $page) {
			$ret_item = [
				'name' => $page->post_title,
				'id' => $page->ID,
				'type' => 'page'
			];
			$retArr[] = $ret_item;
		}
		return $retArr;
	}

	/**
	 * @param $args
	 *
	 * @return array
	 */
	final public function postSelectorGetThemePosts($args): array
	{
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => -1
		);

		$posts = get_posts($args);
		$retArr = [];
		$i = 1;
		foreach ($posts as $post) {

			$ret_item = [
				'name' => $post->post_title,
				'id' => $post->ID,
				'type' => 'post',
				'first' => $i === 1
			];
			$retArr[] = $ret_item;
			$i++;
		}
		return $retArr;
	}

	/**
	 * @param $data
	 * @param false $attr
	 *
	 * @return array
	 */
	private function get_posts_by_data($data, bool $attr = false): array
	{
		$page_id = get_queried_object_id();
		global $post;

		$args = [
			'post_type' => get_post_types(),
			'posts_per_page' => $data->postCount,
			'category' => $data->katId,
			'post_status' => 'publish'
		];

		$posts = get_posts($args);

		$postArr = [];
		foreach ($posts as $post) {
			setup_postdata($post);
			$customTitle = get_post_meta(get_the_ID(), '_hupa_custom_title', true);
			$customTitle ? $title = $customTitle : $title = get_the_title();
			$image_id = get_post_thumbnail_id();
			$attachment = (object)$this->wp_get_attachment($image_id);

			$post_item = [
				'post_id' => get_the_ID(),
				'parent_id' => $page_id,
				'img_id' => $image_id,
				'title' => $title,
				'permalink' => get_the_permalink(),
				'author' => get_the_author(),
				'alt' => $attachment->alt,
				'captions' => $attachment->caption,
				'description' => $attachment->description,
				'href' => $attachment->href,
				'src' => $attachment->src,
				'img_title' => $attachment->title,
				'content' => get_the_content(),
				'excerpt' => get_the_excerpt(),
				'page_excerpt' => get_the_excerpt($page_id),
				'date' => esc_html(get_the_date()),
				'post_date' => strtotime($post->post_date),
				'menu_order' => $post->menu_order
			];

			$postArr[] = $post_item;
		}
		return $postArr;
	}

	/**
	 * @param $id
	 *
	 * @return array
	 */
	private function get_posts_by_id($id): array
	{
		$page_id = get_queried_object_id();
		global $post;

		$post = get_post($id);
		setup_postdata($post);
		$customTitle = get_post_meta(get_the_ID(), '_hupa_custom_title', true);
		$customTitle ? $title = $customTitle : $title = get_the_title();
		$image_id = get_post_thumbnail_id();


		$attachment = (object)$this->wp_get_attachment($image_id);

		return [
			'post_id' => get_the_ID(),
			'img_id' => $image_id,
			'parent_id' => $page_id,
			'title' => $title,
			'image' => get_the_post_thumbnail_url(),
			'permalink' => get_the_permalink(),
			'author' => get_the_author(),
			'alt' => $attachment->alt,
			'description' => $attachment->description,
			'href' => $attachment->href,
			'src' => $attachment->src,
			'img_title' => $attachment->title,
			'content' => get_the_content(),
			'page_excerpt' => get_the_excerpt($page_id),
			'excerpt' => get_the_excerpt(),
			'captions' => $attachment->caption,
			'date' => esc_html(get_the_date()),
			'post_date' => strtotime($post->post_date),
			'menu_order' => $post->menu_order
		];
	}

	/**
	 * @param $postArr
	 * @param $value
	 * @param $order
	 *
	 * @return array|mixed
	 */
	private function order_by_args($postArr,$value, $order) {
		switch ($order){
			case'1':
				usort($postArr, fn ($a, $b) => $a[$value] - $b[$value]);
				return  array_reverse($postArr);
			case '2':
				usort($postArr, fn ($a, $b) => $a[$value] - $b[$value]);
				break;
		}

		return $postArr;
	}

	/**
	 * @param $query
	 * @param false $attr
	 *
	 * @return array
	 */
	private function get_posts_by_category($query,  $attr = ''): array
	{
		$page_id = get_queried_object_id();
		global $post;
		$postArr = [];

		foreach ($query as $post) {
			setup_postdata($post);
			$customTitle = get_post_meta($post->ID, '_hupa_custom_title', true);
			$customTitle ? $title = $customTitle : $title = get_the_title();
			$image_id = get_post_thumbnail_id();
			$attachment = (object)$this->wp_get_attachment($image_id);

			$post_item = [
				'post_id' => get_the_ID(),
				'parent_id' => $page_id,
				'img_id' => $image_id,
				'title' => $title,
				'permalink' => get_the_permalink(),
				'author' => get_the_author(),
				'alt' => $attachment->alt,
				'captions' => $attachment->caption,
				'description' => $attachment->description,
				'href' => $attachment->href,
				'src' => $attachment->src,
				'img_title' => $attachment->title,
				'content' => get_the_content(),
				'excerpt' => get_the_excerpt(),
				'page_excerpt' => get_the_excerpt($page_id),
				'date' => esc_html(get_the_date()),
				'post_date' => strtotime($post->post_date),
				'menu_order' => $post->menu_order
			];
			$postArr[] = $post_item;
		}
		return $postArr;
	}

	/**
	 * @param $attachment_id
	 *
	 * @return array
	 */
	public function wp_get_attachment($attachment_id): array {

		$attachment = get_post($attachment_id);

		return array(
			'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
			'description' => $attachment->post_content,
			'href' => get_permalink($attachment->ID),
			'src' => $attachment->guid,
			'title' => $attachment->post_title,
			'caption' => $attachment->post_excerpt,
		);
	}
}

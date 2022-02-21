<?php
namespace Post\Selector;

use Post_Selector;
use WP_Query;

/**
 * ADMIN Post-Selector Gutenberg Callback
 *
 * @link       https://wwdh.de
 * @since      1.0.0
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/admin/gutenberg/
 */
defined('ABSPATH') or die();

class Post_Selector_Callback {

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
	 * Store plugin main class to allow public access.
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
	 * @param $attributes
	 *
	 * @return mixed|void
	 */
	public function callback_post_selector_two_block($attributes) {
		$selected_posts = $attributes['selectedPosts'] ?? false;
		$total = 0;
		$pagination = '';
		if (isset($attributes['selectedCat']) && !empty($attributes['selectedCat'])) {
			//Pagination
			isset( $attributes['paginationActive'] ) && $attributes['paginationActive'] ? $paginationActive = true : $paginationActive = false;
			isset( $attributes['postPaginationLimit'] ) ? $postPaginationLimit = (int) $attributes['postPaginationLimit'] : $postPaginationLimit = 10;
			isset($attributes['postCount']) && !empty($attributes['postCount']) ? $count = abs($attributes['postCount']) : $count = -1;
			if($paginationActive){
				get_query_var('paged') ? $paged = get_query_var('paged') : $paged = 1;
				$limit = $postPaginationLimit;
				$totalArgs = [
					'post_type' => 'post',
					'cat' => $attributes['selectedCat'],
					'posts_per_page' => -1,
				];

				$totalPosts = new WP_Query($totalArgs);
				if($totalPosts){
					$total = count($totalPosts->posts);
				}

				$pagination = $this->make_news_pagination($total,$limit,$paged);

				$args = array(
					'post_type' => 'post',
					'cat' => $attributes['selectedCat'],
					'posts_per_page' => $limit,
					'offset' => $paged,
					//  'orderby' => $orderBy,
					//  'order' => $order,
				);
				$posts = new WP_Query($args);

			} else {
				$args = array(
					'post_type' => 'post',
					'cat' => $attributes['selectedCat'],
					'posts_per_page' => $count,
					//  'orderby' => $orderBy,
					//  'order' => $order,
				);
				$posts = new WP_Query($args);
			}
		} else {
			$posts = new WP_Query([
				'post__in' => $selected_posts,
				'post_type' => get_post_types(),
				//'order_by' => 'posts__in'
			]);
		}

		wp_reset_query();
		return apply_filters('gutenberg_block_post_selector_two_render', $posts, $attributes, $pagination);

	}

	/**
	 * @param $query
	 * @param $attributes
	 * @param $pagination
	 *
	 * @return false|string|void
	 */
	public function gutenberg_block_post_selector_two_render_filter($query, $attributes, $pagination) {
		if ($query->have_posts()) {
			ob_start();
			apply_filters("$this->basename/get_post_select_data_type", $query, $attributes);
			if($pagination){
				echo $pagination;
			}
			return ob_get_clean();
		}
	}


	/**
	 * @param $attributes
	 *
	 * @return false|string|void
	 */
	public function callback_post_selector_two_galerie($attributes) {
		if ($attributes) {
			ob_start();
			apply_filters("$this->basename/load_galerie_templates", $attributes);
			wp_reset_query();
			return ob_get_clean();
		}
	}

	/**
	 * @param $total
	 * @param $limit
	 * @param $paged
	 * @param int $range
	 *
	 * @return string
	 */
	public function make_news_pagination($total, $limit, $paged, int $range = 2):string {
		$pages  = ceil( $total / $limit );
		if($pages < 2){
			return '';
		}
		$showitems = ($range * 2) + 1;
		$paged == (int)$pages ? $last = 'disabled' : $last = '';
		$paged == '1' ? $first = 'disabled' : $first = '';
		$html = '<nav id="theme-pagination" aria-label="Page navigation" role="navigation">';
		$html .= '<span class="sr-only">Page navigation</span>';
		$html .= '<ul class="pagination justify-content-center ft-wpbs mb-4">';
		$html .= '<li class="page-item ' . $first . '"><a class="page-link" href="' . get_pagenum_link(1) . '" aria-label="First Page"><i class="fa fa-angle-double-left"></i></a></li>';
		$html .= '<li class="page-item ' . $first . '"><a class="page-link" href="' . get_pagenum_link($paged - 1) . '" aria-label="Previous Page"><i class="fa fa-angle-left"></i></a></li>';
		for ($i = 1; $i <= $pages; $i++) {
			if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
				$html .= ($paged == $i) ? '<li class="page-item active"><span class="page-link"><span class="sr-only">Current Page </span>' . $i . '</span></li>' : '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($i) . '"><span class="sr-only">Page </span>' . $i . '</a></li>';
			}
		}
		$html .= '<li class="page-item ' . $last . '"><a class="page-link" href="' . get_pagenum_link($paged + 1) . '" aria-label="Next Page"><i class="fa fa-angle-right"></i> </a></li>';
		$html .= '<li class="page-item ' . $last . '"><a class="page-link" href="' . get_pagenum_link($pages) . '" aria-label="Last Page"><i class="fa fa-angle-double-right"></i> </a></li>';
		$html .= '</ul>';
		$html .= '</nav>';
		$html .= '<div class="pagination-info mb-5 text-center"> <span class="text-muted">( Seite</span> ' . $paged . ' <span class="text-muted">von ' . $pages . ' )</span></div>';
		return preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $html));
	}
}
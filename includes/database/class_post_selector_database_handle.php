<?php
namespace Post\Selector;

use Post_Selector;
use stdClass;

class Post_Selector_Database_Handle {

	/**
	 * The current version of the DB-Version.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $db_version The current version of the database Version.
	 */
	protected string $db_version;

	/**
	 * The Helper Class.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object $helper The Helper Class.
	 */
	protected object $helper;


	use Post_Selector_Defaults;

	/**
	 * Store plugin main class to allow public access.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var Post_Selector $main The main class.
	 */
	private Post_Selector $main;

	public function __construct( string $db_version,  Post_Selector $main ) {

		$this->db_version   = $db_version;
		$this->main       = $main;
		global $plugin_helper;
		$this->helper = $plugin_helper;

	}

	public function postSelectorGetByArgs($args, $fetchMethod = true, $col = false): object
	{
		global $wpdb;
		$return = new stdClass();
		$return->status = false;
		$return->count = 0;
		$fetchMethod ? $fetch = 'get_results' : $fetch = 'get_row';
		$table = $wpdb->prefix . $this->table_slider;
		$col ? $select = $col : $select = '*';
		$result = $wpdb->$fetch("SELECT {$select}, DATE_FORMAT(created_at, '%d.%m.%Y %H:%i') AS created  FROM {$table} {$args}");
		if (!$result) {
			return $return;
		}
		$fetchMethod ? $count = count($result) : $count = 1;
		$return->status = true;

		$return->count = $count;
		if ($col) {
			$return->record = $this->helper->postSelectArrayToObject($result);

			return $return;
		}

		if ($fetchMethod) {
			$retArr = [];
			$count = count($result);
			foreach ($result as $tmp) {
				$ret_item = [
					'id' => $tmp->id,
					'slider_id' => $tmp->slider_id,
					'bezeichnung' => $tmp->bezeichnung,
					'created_at' => $tmp->created_at,
					'created' => $tmp->created,
					'data' => json_decode($tmp->data)
				];
				$retArr[] = $ret_item;
			}
			$return->record = $this->helper->postSelectArrayToObject($retArr);
		} else {
			$data = json_decode($result->data);
			$result->data = $data;
			$return->record = $this->helper->postSelectArrayToObject($result);
			$count = 1;
		}
		$return->count = $count;
		$return->status = true;

		return $return;
	}

	public function postSelectorSetSlider($record): object
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_slider;
		$wpdb->insert(
			$table,
			array(
				'slider_id' => $record->slider_id,
				'bezeichnung' => $record->bezeichnung,
				'data' => $record->data,
			),
			array('%s', '%s', '%s')
		);

		$return = new stdClass();
		if (!$wpdb->insert_id) {
			$return->status = false;
			$return->msg = 'Daten konnten nicht gespeichert werden!';
			$return->id = false;

			return $return;
		}
		$return->status = true;
		$return->msg = 'Daten gespeichert!';
		$return->id = $wpdb->insert_id;

		return $return;
	}

	public function updatePostSelectorSlider($record): void
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_slider;
		$wpdb->update(
			$table,
			array(
				'bezeichnung' => $record->bezeichnung,
				'data' => $record->data
			),
			array('id' => $record->id),
			array(
				'%s',
				'%s'
			),
			array('%d')
		);
	}

	public function deletePostSelectorSlider($id): void
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_slider;
		$wpdb->delete(
			$table,
			array(
				'id' => $id
			),
			array('%d')
		);
	}

	/**
	 * @param $record
	 *
	 * @return object
	 */
	public function postSelectorSetGalerie($record): object
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_galerie;
		$wpdb->insert(
			$table,
			array(
				'bezeichnung' => $record->bezeichnung,
				'type' => $record->type,
				'type_settings' => $record->type_settings,
				'link' => $record->link,
				'is_link' => $record->is_link,
				'hover_aktiv' => $record->hover_aktiv,
				'hover_title_aktiv' => $record->hover_title_aktiv,
				'hover_beschreibung_aktiv' => $record->hover_beschreibung_aktiv,
				'lightbox_aktiv' => $record->lightbox_aktiv,
				'caption_aktiv' => $record->caption_aktiv,
				'show_bezeichnung' => $record->show_bezeichnung,
				'show_beschreibung' => $record->show_beschreibung,
				'beschreibung' => $record->beschreibung,
				'lazy_load_aktiv' => $record->lazy_load_aktiv,
				'lazy_load_ani_aktiv' => $record->lazy_load_ani_aktiv,
				'animate_select' => $record->animate_select,
				'link_target' => $record->link_target
			),
			array('%s', '%d', '%s', '%s','%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%s', '%d')
		);

		$return = new stdClass();
		if (!$wpdb->insert_id) {
			$return->status = false;
			$return->msg = 'Daten konnten nicht gespeichert werden!';
			$return->id = false;

			return $return;
		}
		$return->status = true;
		$return->msg = 'Daten gespeichert!';
		$return->id = $wpdb->insert_id;

		return $return;
	}

	/**
	 * @param $args
	 * @param bool $fetchMethod
	 * @param string $col
	 *
	 * @return object
	 */
	public function postSelectorGetGalerie($args, bool $fetchMethod = true, string $col = ''): object
	{
		global $wpdb;
		$return = new stdClass();
		$return->status = false;
		$return->count = 0;
		$fetchMethod ? $fetch = 'get_results' : $fetch = 'get_row';
		$table = $wpdb->prefix . $this->table_galerie;
		$col ? $select = $col : $select = '*';
		$result = $wpdb->$fetch("SELECT {$select}  FROM {$table} {$args}");
		if (!$result) {
			return $return;
		}
		$fetchMethod ? $return->count = count($result) : $return->count = 1;
		$return->status = true;
		$return->record = $result;
		return $return;
	}

	/**
	 * @param $record
	 */
	public function postSelectorUpdateGalerie($record): void
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_galerie;
		$wpdb->update(
			$table,
			array(
				'bezeichnung' => $record->bezeichnung,
				'type' => $record->type,
				'type_settings' => $record->type_settings,
				'link' => $record->link,
				'is_link' => $record->is_link,
				'hover_aktiv' => $record->hover_aktiv,
				'hover_title_aktiv' => $record->hover_title_aktiv,
				'hover_beschreibung_aktiv' => $record->hover_beschreibung_aktiv,
				'lightbox_aktiv' => $record->lightbox_aktiv,
				'caption_aktiv' => $record->caption_aktiv,
				'show_bezeichnung' => $record->show_bezeichnung,
				'show_beschreibung' => $record->show_beschreibung,
				'beschreibung' => $record->beschreibung,
				'lazy_load_aktiv' => $record->lazy_load_aktiv,
				'lazy_load_ani_aktiv' => $record->lazy_load_ani_aktiv,
				'animate_select' => $record->animate_select,
				'link_target' => $record->link_target,
			),
			array('id' => $record->id),
			array('%s', '%d', '%s','%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%s', '%d'),
			array('%d')
		);
	}

	/**
	 * @param $id
	 */
	public function PostSelectorDeleteGalerie($id): void
	{

		$args = sprintf('WHERE galerie_id=%d', $id);
		$galerie = $this->postSelectorGetImages($args);
		if ($galerie->status) {
			foreach ($galerie->record as $tmp) {
				$this->PostSelectorDeleteImage($tmp->id);
			}
		}

		global $wpdb;
		$table = $wpdb->prefix . $this->table_galerie;
		$wpdb->delete(
			$table,
			array(
				'id' => $id
			),
			array('%d')
		);
	}

	/**
	 * @param $args
	 * @param bool $fetchMethod
	 * @param false $col
	 *
	 * @return object
	 */
	public function postSelectorGetImages($args, bool $fetchMethod = true, $col = ''): object
	{
		global $wpdb;
		$return = new stdClass();
		$return->status = false;
		$return->count = 0;
		$fetchMethod ? $fetch = 'get_results' : $fetch = 'get_row';
		$table = $wpdb->prefix . $this->table_galerie_images;
		$col ? $select = $col : $select = '*, DATE_FORMAT(created_at, \'%d.%m.%Y %H:%i:%s\') AS created';
		$result = $wpdb->$fetch("SELECT {$select}  FROM {$table} {$args}");
		if (!$result) {
			return $return;
		}
		$fetchMethod ? $return->count = count($result) : $return->count = 1;
		$return->status = true;
		$return->record = $result;
		return $return;
	}

	/**
	 * @param $id
	 */
	public function PostSelectorDeleteImage($id): void
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_galerie_images;
		$wpdb->delete(
			$table,
			array(
				'id' => $id
			),
			array('%d')
		);
	}

	//JOB IMAGES DB HANDLES
	/**
	 * @param $record
	 *
	 * @return object
	 */
	public function postSelectorSetImage($record): object
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_galerie_images;
		$wpdb->insert(
			$table,
			array(
				'galerie_id' => $record->galerie_id,
				'img_id' => $record->img_id,
				'img_beschreibung' => $record->img_beschreibung,
				'img_caption' => $record->img_caption,
				'img_title' => $record->img_title,
			),
			array('%d', '%d', '%s', '%s', '%s')
		);

		$return = new stdClass();
		if (!$wpdb->insert_id) {
			$return->status = false;
			$return->msg = 'Daten konnten nicht gespeichert werden!';
			$return->id = false;

			return $return;
		}
		$return->status = true;
		$return->msg = 'Daten gespeichert!';
		$return->id = $wpdb->insert_id;

		return $return;
	}

	/**
	 * @param $record
	 */
	public function postSelectorUpdateImage($record): void
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_galerie_images;
		$wpdb->update(
			$table,
			array(
				'img_beschreibung' => $record->img_beschreibung,
				'img_caption' => $record->img_caption,
				'img_title' => $record->img_title,
				'link' => $record->link,
				'is_link' => $record->is_link,
				'galerie_settings_aktiv' => $record->galerie_settings_aktiv,
				'hover_aktiv' => $record->hover_aktiv,
				'hover_title_aktiv' => $record->hover_title_aktiv,
				'hover_beschreibung_aktiv' => $record->hover_beschreibung_aktiv,
				'link_target' => $record->link_target
			),
			array('id' => $record->id),
			array('%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d'),
			array('%d')
		);
	}

	/**
	 * @param $id
	 * @param $position
	 */
	public function postSelectorUpdateSortablePosition($id, $position): void
	{
		global $wpdb;
		$table = $wpdb->prefix . $this->table_galerie_images;
		$wpdb->update(
			$table,
			array(
				'position' => $position
			),
			array('id' => $id),
			array('%d'),
			array('%d')
		);
	}


	public function post_selector_check_jal_install() {
		if ( get_option( 'jal_post_selector_two_db_version' ) != $this->db_version ) {
			 update_option('jal_post_selector_two_db_version', $this->db_version);
			$this->post_selector_jal_install();
		}
	}

	public function post_selector_jal_install() {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;
		$table_name      = $wpdb->prefix . $this->table_slider;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        slider_id varchar(14) NOT NULL UNIQUE,
        bezeichnung varchar(128) NOT NULL,
        data text NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (id)
     ) $charset_collate;";
		dbDelta( $sql );

		$table_name      = $wpdb->prefix . $this->table_galerie;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        bezeichnung varchar(60) NOT NULL,
        beschreibung text,
        type mediumint(6) NOT NULL,
        type_settings text NOT NULL,
        link varchar(255) NULL,
        is_link  BOOLEAN NULL,
        hover_aktiv  BOOLEAN NOT NULL DEFAULT FALSE,
        link_target  BOOLEAN NOT NULL DEFAULT TRUE,
        hover_title_aktiv  BOOLEAN NOT NULL DEFAULT TRUE,
        lazy_load_aktiv BOOLEAN NOT NULL DEFAULT TRUE,
        lazy_load_ani_aktiv BOOLEAN NOT NULL DEFAULT TRUE,
        animate_select varchar(60) NULL,
        hover_beschreibung_aktiv  BOOLEAN NOT NULL DEFAULT TRUE,  
        lightbox_aktiv  BOOLEAN NOT NULL DEFAULT TRUE,
        caption_aktiv  BOOLEAN NOT NULL DEFAULT TRUE, 
        show_bezeichnung  BOOLEAN NOT NULL DEFAULT FALSE,
        show_beschreibung  BOOLEAN NOT NULL DEFAULT FALSE,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (id)
     ) $charset_collate;";
		dbDelta( $sql );

		$table_name      = $wpdb->prefix . $this->table_galerie_images;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE $table_name ( 
        id int(11) NOT NULL AUTO_INCREMENT,
        galerie_id mediumint(11) NOT NULL,
        img_id int(11) NOT NULL,
        position int(11) NOT NULL DEFAULT 0,
        img_caption varchar(128) NULL,
        img_title varchar(128) NULL, 
        img_beschreibung text NULL,
        link varchar(255) NULL,
        is_link  BOOLEAN NULL,
        galerie_settings_aktiv BOOLEAN NOT NULL DEFAULT TRUE,
        hover_aktiv BOOLEAN NOT NULL DEFAULT FALSE,
        link_target  BOOLEAN NOT NULL DEFAULT TRUE,
        hover_title_aktiv BOOLEAN NOT NULL DEFAULT FALSE,
        hover_beschreibung_aktiv BOOLEAN NOT NULL DEFAULT FALSE,      
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (id)
     ) $charset_collate;";
		dbDelta( $sql );
	}
}
<?php
namespace Post\Selector;
/**
 * Default Plugin Settings
 *
 * @link       https://wwdh.de
 * @since      1.0.0
 *
 * @package    Post_Selector
 * @subpackage Post_Selector/includes
 */
defined('ABSPATH') or die();

/**
 * ADMIN Settings TRAIT
 * @package Hummelt & Partner WordPress-Plugin
 * Copyright 2022, Jens Wiecker
 * @Since 1.0.0
 */



trait Post_Selector_Defaults {

	// DB-Tables
	protected  string $table_slider = 'ps_two_slide';
	protected  string $table_galerie = 'ps_two_galerie';
	protected  string $table_galerie_images = 'ps_two_galerie_images';

}

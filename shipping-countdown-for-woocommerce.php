<?php
/*
Plugin Name: Shipping Countdown for WooCommerce
Plugin URI:
Description: Shipping Countdown For WooCommerce allows you to add a countdown timer to the product page to show shoppers when you will ship the product.
Version: 1.0
Author: Bradley Davis
Author URI: https://bradley-davis.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: scfwc
WC requires at least: 3.4.0
WC tested up to: 3.4.5
@author		Bradley Davis
@package	Shipping Countdown for WooCommerce
@since		1.0

Shipping Countdown for WooCommerce allows you to add a countdown timer to the product page to show shoppers when you will ship the product.

Copyright (C) 2014
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.
*/
if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

/**
 * Check if WooCommerce is active.
 * @since 1.0
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :

	class scfwc {

		/**
		 * The Constructor.
		 * @since 1.0
		 */
		public function __construct() {
			$this->scfwc_add_actions_filters();
			$this->scfwc_uninstall_hooks();
		}

		/**
		 * Init.
		 * @since 1.0
		 */
		public static function scfwc_add_actions_filters() {
			self::scfwc_includes();
			add_action( 'wp_enqueue_scripts', __CLASS__ . '::scfwc_enqueue_style' );
			add_action( 'wp_enqueue_scripts', __CLASS__ . '::scfwc_enqueue_script' );
		}

		/**
		 * Add the includes.
		 * @since 1.0
		 */
		public static function scfwc_includes() {
			require_once( 'classes/class-scfwc-output.php');
			require_once( 'classes/class-scfwc-customizer.php');
			require_once( 'classes/class-scfwc-uninstall.php');
		}

		public static function scfwc_uninstall_hooks() {
			register_uninstall_hook( __FILE__, array( 'scfwc_uninstall', 'scfc_delete_data' ) );
		}

		/**
		 * Enqueue styles.
		 * @since 1.0
		 */
		public static function scfwc_enqueue_style() {
			wp_enqueue_style( 'scfwc-style', plugin_dir_url( __FILE__ ) . 'css/scfwc-style.css', '25062018' );
		}

		/**
		 * Enqueue scripts.
		 * @since 1.0
		 */
		public static function scfwc_enqueue_script() {
		  wp_enqueue_script( 'scfwc-js', plugin_dir_url( __FILE__ ) . 'js/scfwc-js.js', array(), '25062018' );
		}

	} // END class

	/**
	 * Instantiate the class and let the awesomeness happen!
	 * @since 1.0
	 */
	 $scfwc = new scfwc();

endif;

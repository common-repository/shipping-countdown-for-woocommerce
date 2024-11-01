<?php
/*
 * Shipping Countdown for WooCommerce
 *
 * Remove the data from the DB on uninstall
 *
 * @author  Bradley Davis
 * @package Shipping Countdown for WooCommerce
 * @since   1.0
 */
 if ( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly.
 }

class scfwc_uninstall {

  /**
   * Removes data when plugin uninstalled.
   * @since 1.0
   */
  public static function scfwc_delete_data() {
    delete_option( 'scfwc_time' );
    delete_option( 'scfwc_title' );
    delete_option( 'scfwc_select_days' );
    delete_option( 'scfwc_render_location' );
  }

} // ENDS class

/**
 * Instantiate the class
 * @since 1.0
 */
$scfwc_uninstall = new scfwc_uninstall();

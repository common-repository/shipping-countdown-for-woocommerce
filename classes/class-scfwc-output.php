<?php
/*
 * Shipping Countdown for WooCommerce
 *
 * The output on the front-end of all the info.
 *
 * @author  Bradley Davis
 * @package Shipping Countdown for WooCommerce
 * @since   1.0
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class scfwc_output {

  /**
	 * The Constructor.
	 * @since 1.0
	 */
	function __construct() {
		$this->scfwc_output_add_actions_filters();
	}

  /**
	 * The init for all the actions and filters.
	 * @since 1.0
	 */
	function scfwc_output_add_actions_filters() {
		add_action( 'wp_footer', array( $this, 'scfwc_output_js' ), 999 );

		$scfwc_render_location = get_theme_mod( 'scfwc_render_location');
		switch ( $scfwc_render_location ) :
			case 'scfwc_after_heading' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'scfwc_html_product' ), 6 );
				break;
			case 'scfwc_after_price' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'scfwc_html_product' ), 11 );
				break;
			case 'pffwc_after_short_desc' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'scfwc_html_product' ), 21 );
				break;
			case 'pffwc_after_add_cart' :
				add_action( 'woocommerce_single_product_summary', array( $this, 'scfwc_html_product' ), 31 );
				break;
		endswitch;
	}

  /**
   * Calculate the time in JS
	 * Note: Some vars have picked up some whitespace, used trim to remove.
	 * @return string
	 * @since 1.0
   */
  function scfwc_output_js() {
		// Get wp set timezone
		$sc_timezone_wp = get_option( 'gmt_offset' );
		// PHP: Get time name to set timezone for php
		$sc_get_timezone_name = timezone_name_from_abbr('', $sc_timezone_wp * 3600, false);
		// Sets php timezone for all php only use
		date_default_timezone_set( $sc_get_timezone_name );
		// Create our date time object
		$sc_today = new DateTime( $sc_get_timezone_name );
		// JS: If timezone is + we need to add the + for the JS. Note: Used only for JS timezone, not for php
		$sc_timezone = ( $sc_timezone_wp >= 0 ? '+' . $sc_timezone_wp : $sc_timezone_wp );
		// Get shipping countdown shipping time
		$sc_time = get_theme_mod( 'scfwc_time' );
		// Convert the time string to unix timestamp
		$sc_time_converted = strtotime( $sc_time );
		// Time now in unix time
		$sc_now = strtotime( 'now' );
		// Get shipping countdown days selected to ship
		$sc_days = get_theme_mod( 'scfwc_select_days' );
		// Get a numerical value for the day
		$sc_day_x = date_format( $sc_today, 'N' );
		// Set value of first day of shipping
		$sc_day_first;
		// Passed to date() as the number of days to add
		$sc_day_plus;

		foreach ( $sc_days as $sc_day => $sc_day_val ) :
			// Picked up some sneaky white space from the array().
			$sc_day_val = trim( $sc_day_val, ' ' );
			$sc_day_first = $sc_day_val;
			// Same day and before shipping time
			if ( $sc_day_val == $sc_day_x && $sc_now < $sc_time_converted ) :
				$sc_day_plus = 0;
				break;
			// Shipping day is in the future
			elseif ( $sc_day_x < $sc_day_val ) :
				$sc_day_plus = $sc_day_val - $sc_day_x;
				break;
			else :
				// Shipping day(s) have past
				$sc_day_plus = $sc_day_first + ( 7 - $sc_day_x );
			endif;
		endforeach;

		$sc_shipping = date( 'M d, Y', strtotime( $sc_day_plus . ' days' ) ) . ' ' . $sc_time . ' UTC' . $sc_timezone;
		// Pass the new shipping into the JS Date()
		// Init the clock and add the countdown to the dom #countdown ?>
		<script type="text/javascript">
			var deadline = new Date('<?php echo esc_attr( $sc_shipping ); ?>');
			initializeClock('shipping-countdown', deadline);
		</script> <?php
	}

	/**
	 * Add html to prodcut page for binding the countdown
	 * @since 1.0
	 */
	function scfwc_html_product() {
		// Title for shipping countdown
		$sc_title = get_theme_mod( 'scfwc_title' ); ?>
			<div id="shipping-countdown">
				<p class="title"><?php _e( $sc_title, 'scfwc' ); ?> </p>
			  <div>
			    <span class="days"></span>
			    <div class="smalltext">Days</div>
			  </div>
			  <div>
			    <span class="hours"></span>
			    <div class="smalltext">Hours</div>
			  </div>
			  <div>
			    <span class="minutes"></span>
			    <div class="smalltext">Minutes</div>
			  </div>
			  <div>
			    <span class="seconds"></span>
			    <div class="smalltext">Seconds</div>
			  </div>
			</div> <?php
	}


} // END class

/**
 * Instantiate the class.
 * @since 1.0
 */
$scfwc_output = new scfwc_output();

<?php
/*
 * Shipping Countdown for WooCommerce
 *
 * All the customizer settings for Shipping Countdown for WooCommerce
 *
 * @author  Bradley Davis
 * @package Shipping Countdown for WooCommerce
 * @since   1.0
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

class scfwc_customizer {

  /**
	 * The Constructor.
	 * @since 1.0
	 */
	public function __construct() {
		$this->scfwc_customizer_add_actions_filters();
	}

  /**
	 * The init for all the actions and filters.
	 * @since 1.0
	 */
	public function scfwc_customizer_add_actions_filters() {
		add_action( 'customize_register', array( $this, 'scfwc_customizer_add_options' ) );
	}

  /**
   * WHAT MAGIC WILL HAPPEN
   * @since 1.0
   */
  public function scfwc_customizer_add_options( $wp_customize ) {

    // Include extended class to give multi select option
    require_once( 'class_extends_customizer.php');

    // Add section to WooCommerce Panel
    $wp_customize->add_section( 'scfwc_options',
      array(
        'title'      => __( 'Shipping Countdown', 'scfwc' ),
        'panel'      => 'woocommerce',
        'capability' => '',
        'priority'   => 500,
      )
    );

		$wp_customize->add_setting( 'scfwc_title',
			array(
				'default'           => 'Shipping Location',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
		) );
		$wp_customize->add_control( 'scfwc_title',
			array(
				'type' => 'text',
				'section' => 'scfwc_options',
			  'label' => __( 'Title For Shipping Countdown', 'scfwc' ),
			  'description' => __( 'This will change the title above the countdown clock, leave blank if you do not require a title.', 'scfwc' ),
			)
		);

    // Choose a time
    $wp_customize->add_setting( 'scfwc_time',
      array(
        'default'           => 13,
        'sanitize_callback' => array( $this, 'scfwc_sanitize_time' ),
    ) );
    $wp_customize->add_control( 'scfwc_time',
      array(
        'type'        => 'time',
        'section'     => 'scfwc_options',
        'label'       => __( 'Closing Time For Next Shipment' ),
        'description' => __( 'For example, you ship at 3pm every Wednesday, but you need all purchases to be made before 1pm on Wednesday to be included, enter 1pm below.' ),
      ) );

    // Choose Shipping Countdown days of shipping
    $wp_customize->add_setting( 'scfwc_select_days',
      array(
        'default'           => 'scfwc_ship_fri',
        'sanitize_callback' => array( $this, 'scfwc_sanitize_day'),
      )
    );
    $wp_customize->add_control( new scfwc_dropdown_custom_control( $wp_customize, 'scfwc_select_days',
      array(
        'label'       => __( 'Select Shipping Days', 'scfwc' ),
        'description' => __( 'Choose the days that you ship products. You can select multiple days', 'scfwc'),
        'settings'    => 'scfwc_select_days',
        'section'     => 'scfwc_options',
        'type'        => 'multiple-select',
        'choices'     => array(
          1 => __( 'Monday', 'scfwc' ),
          2 => __( 'Tuesday', 'scfwc' ),
        	3 => __( 'Wednesday', 'scfwc' ),
          4 => __( 'Thursday', 'scfwc' ),
          5 => __( 'Friday', 'scfwc' ),
          6 => __( 'Saturday', 'scfwc' ),
          7 => __( 'Sunday', 'scfwc' ),
        ),
      )
    ));


    // Choose Shipping Countdown output location
    $wp_customize->add_setting( 'scfwc_render_location',
      array(
        'default'           => 'scfwc_after_add_cart',
        'sanitize_callback' => array( $this, 'scfwc_sanitize_location'),
      )
    );
    $wp_customize->add_control( 'scfwc_render_location',
      array(
        'label'       => __( 'Add Shipping Countdown To:', 'scfwc' ),
        'description' => __( 'Choose the location that you would like the shipping countdown to display.', 'scfwc'),
        'settings'    => 'scfwc_render_location',
        'section'     => 'scfwc_options',
        'type'        => 'select',
        'choices'     => array(
          'scfwc_after_heading'    => __( 'After product heading', 'scfwc' ),
          'scfwc_after_price'      => __( 'After product price', 'scfwc' ),
          'scfwc_after_short_desc' => __( 'After short description', 'scfwc' ),
          'scfwc_after_add_cart'   => __( 'After add to cart', 'scfwc' ),
        ),
      )
    );
	}

	/**
	 * Check the time option is real.
	 * @param  string $input
	 * @return string $input
	 * @since 1.0
	 */
	public function scfwc_sanitize_time( $input ) {
		$time = new DateTime( $input );
		return $time->format( 'H:i' );
	}

  /**
   * Check the shipping day option is real.
   * @param  string[] $input
   * @return string $input
   * @since 1.0
   */
  public function scfwc_sanitize_day( $input ) {
    $scfwc_valid_day = array( 1, 2, 3, 4, 5, 6, 7 );
    foreach ( $input as $key => $val ) {
      if ( in_array( $val, $scfwc_valid_day  ) ) {
        $input[ $key ] = $val;
      }
    }
    return $input;
  }

  /**
   * Check the render locatoin option is real.
	 * @param  string[] $input
   * @return string $input
   * @since 1.0
   */
  public function scfwc_sanitize_location( $input ) {
    $scfwc_valid_location = array(
      'scfwc_after_heading',
      'scfwc_after_price',
      'scfwc_after_short_desc',
      'scfwc_after_add_cart',
    );
    foreach ( $input as $key => $val ) {
      if ( in_array( $val, $scfwc_valid_location  ) ) {
        $input[ $key ] = $val;
      }
    }
    return $input;
  }

} // END class

/**
 * Instantiate the class.
 * @since 1.0
 */
$scfwc_customizer = new scfwc_customizer();

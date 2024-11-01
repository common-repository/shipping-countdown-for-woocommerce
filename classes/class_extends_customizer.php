<?php
/**
 * Shipping Countdown for WooCommerce
 *
 * Class to create a custom multiselect dropdown control
 *
 * @author  Bradley Davis
 * @package Shipping Countdown for WooCommerce
 * @since   1.0
 */
class scfwc_dropdown_custom_control extends WP_Customize_Control {
  /**
  * Render the content on the theme customizer page
  */
  public $type = 'multiple-select';
  //scfwc_render_multiselect
  public function render_content() { ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
      <select <?php $this->link(); ?> multiple="multiple" size="7"> <?php

        foreach ( $this->choices as $value => $label ) :
          $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
          echo '<option value="' . esc_attr( $value ) . ' " ' . esc_attr( $selected ) . '>' . esc_attr( $label ) . '</option>';
        endforeach; ?>

      </select>
    </label> <?php
  }
}

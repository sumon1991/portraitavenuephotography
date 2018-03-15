<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Icon
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_icon extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    print $this->element_before();

    $value  = $this->element_value();
    $hidden = ( empty( $value ) ) ? ' hidden' : '';

    print '<div class="cs-icon-select">';
    print '<span class="cs-icon-preview'. $hidden .'"><i class="'. $value .'"></i></span>';
    print '<a href="#" class="button button-primary cs-icon-add">'. __( 'Add Icon', CS_TEXTDOMAIN ) .'</a>';
    print '<a href="#" class="button cs-warning-primary cs-icon-remove'. $hidden .'">'. __( 'Remove Icon', CS_TEXTDOMAIN ) .'</a>';
    print '<input type="text" name="'. $this->element_name() .'" value="'. $value .'"'. $this->element_class( 'cs-icon-value' ) . $this->element_attributes() .' />';
    print '</div>';

    print $this->element_after();

  }

}

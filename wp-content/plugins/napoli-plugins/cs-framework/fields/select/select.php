<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Select
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_select extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    print $this->element_before();

    if( isset( $this->field['options'] ) ) {

      $options    = $this->field['options'];
      $class      = $this->element_class();
      $options    = ( is_array( $options ) ) ? $options : array_filter( $this->element_data( $options ) );
      $extra_name = ( isset( $this->field['attributes']['multiple'] ) ) ? '[]' : '';
      $chosen_rtl = ( is_rtl() && strpos( $class, 'chosen' ) ) ? 'chosen-rtl' : '';

      print '<select name="'. $this->element_name( $extra_name ) .'"'. $this->element_class( $chosen_rtl ) . $this->element_attributes() .'>';

      print ( isset( $this->field['default_option'] ) ) ? '<option value="">'.$this->field['default_option'].'</option>' : '';

      if( !empty( $options ) ){
        foreach ( $options as $key => $value ) {
          print '<option value="'. $key .'" '. $this->checked( $this->element_value(), $key, 'selected' ) .'>'. $value .'</option>';
        }
      }

      print '</select>';

    }

    print $this->element_after();

  }

}

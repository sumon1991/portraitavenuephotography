<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Sorter
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_Sorter extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output(){

    print $this->element_before();

    $value          = $this->element_value();
    $value          = ( ! empty( $value ) ) ? $value : $this->field['default'];
    $enabled        = ( ! empty( $value['enabled'] ) ) ? $value['enabled'] : array();
    $disabled       = ( ! empty( $value['disabled'] ) ) ? $value['disabled'] : array();
    $enabled_title  = ( isset( $this->field['enabled_title'] ) ) ? $this->field['enabled_title'] : __( 'Enabled Modules', CS_TEXTDOMAIN );
    $disabled_title = ( isset( $this->field['disabled_title'] ) ) ? $this->field['disabled_title'] : __( 'Disabled Modules', CS_TEXTDOMAIN );

    print '<div class="cs-modules">';
    print '<h3>'. $enabled_title .'</h3>';
    print '<ul class="cs-enabled">';
    if( ! empty( $enabled ) ) {
      foreach( $enabled as $en_id => $en_name ) {
        print '<li><input type="hidden" name="'. $this->element_name( '[enabled]['. $en_id .']' ) .'" value="'. $en_name .'"/><label>'. $en_name .'</label></li>';
      }
    }
    print '</ul>';
    print '</div>';

    print '<div class="cs-modules">';
    print '<h3>'. $disabled_title .'</h3>';
    print '<ul class="cs-disabled">';
    if( ! empty( $disabled ) ) {
      foreach( $disabled as $dis_id => $dis_name ) {
        print '<li><input type="hidden" name="'. $this->element_name( '[disabled]['. $dis_id .']' ) .'" value="'. $dis_name .'"/><label>'. $dis_name .'</label></li>';
      }
    }
    print '</ul>';
    print '</div>';
    print '<div class="clear"></div>';

    print $this->element_after();

  }

}

<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Fieldset
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_fieldset extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    print $this->element_before();

    print '<div class="cs-inner">';

    foreach ( $this->field['fields'] as $field ) {

      $field_id    = ( isset( $field['id'] ) ) ? $field['id'] : '';
      $field_value = ( isset( $this->value[$field_id] ) ) ? $this->value[$field_id] : '';
      $unique_id   = $this->unique .'['. $this->field['id'] .']';

      print cs_add_element( $field, $field_value, $unique_id );

    }

    print '</div>';

    print $this->element_after();

  }

}

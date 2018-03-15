<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Sub Heading
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_subheading extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    print $this->element_before();
    print $this->field['content'];
    print $this->element_after();

  }

}

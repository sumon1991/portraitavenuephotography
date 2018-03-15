<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Image
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_Image extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output(){

    print $this->element_before();

    $preview = '';
    $value   = $this->element_value();
    $add     = ( ! empty( $this->field['add_title'] ) ) ? $this->field['add_title'] : __( 'Add Image', CS_TEXTDOMAIN );
    $hidden  = ( empty( $value ) ) ? ' hidden' : '';

    if( ! empty( $value ) ) {
      $attachment = wp_get_attachment_image_src( $value, 'thumbnail' );
      $preview    = $attachment[0];
    }

    print '<div class="cs-image-preview'. $hidden .'"><div class="cs-preview"><i class="fa fa-times cs-remove"></i><img src="'. $preview .'" alt="preview" /></div></div>';
    print '<a href="#" class="button button-primary cs-add">'. $add .'</a>';
    print '<input type="text" name="'. $this->element_name() .'" value="'. $this->element_value() .'"'. $this->element_class() . $this->element_attributes() .'/>';

    print $this->element_after();

  }

}

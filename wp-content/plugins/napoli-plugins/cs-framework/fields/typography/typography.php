<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Typography
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_typography extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    print $this->element_before();

    $defaults_value = array(
      'family'  => 'Arial',
      'variant' => 'regular',
      'font'    => 'websafe',
    );

    $default_variants = apply_filters( 'cs_websafe_fonts_variants', array(
      'regular',
      'italic',
      '700',
      '700italic',
      'inherit'
    ));

    $websafe_fonts = apply_filters( 'cs_websafe_fonts', array(
      'Arial',
      'Arial Black',
      'Comic Sans MS',
      'Impact',
      'Lucida Sans Unicode',
      'Tahoma',
      'Trebuchet MS',
      'Verdana',
      'Courier New',
      'Lucida Console',
      'Georgia, serif',
      'Palatino Linotype',
      'Times New Roman'
    ));

    $value         = wp_parse_args( $this->element_value(), $defaults_value );
    $family_value  = $value['family'];
    $variant_value = $value['variant'];
    $is_variant    = ( isset( $this->field['variant'] ) && $this->field['variant'] === false ) ? false : true;
    $is_chosen     = ( isset( $this->field['chosen'] ) && $this->field['chosen'] === false ) ? '' : 'chosen ';
    $google_json   = wp_remote_get( CS_URI .'/fields/typography/google-fonts.json' ); 
    $google_json   = json_decode( $google_json['body'] );
    $chosen_rtl    = ( is_rtl() && ! empty( $is_chosen ) ) ? 'chosen-rtl ' : '';

    if( ! empty( $google_json ) ) {

      $googlefonts = array();

      foreach ( $google_json->items as $key => $font ) {
        $googlefonts[$font->family] = $font->variants;
      }

      $is_google = ( array_key_exists( $family_value, $googlefonts ) ) ? true : false;

      print '<label class="cs-typography-family">';
      print '<select name="'. $this->element_name( '[family]' ) .'" class="'. $is_chosen . $chosen_rtl .'cs-typo-family" data-atts="family"'. $this->element_attributes() .'>';

      do_action( 'cs_typography_family', $family_value, $this );

      print '<optgroup label="'. __( 'Web Safe Fonts', CS_TEXTDOMAIN ) .'">';
      foreach ( $websafe_fonts as $websafe_value ) {
        print '<option value="'. $websafe_value .'" data-variants="'. implode( '|', $default_variants ) .'" data-type="websafe"'. selected( $websafe_value, $family_value, true ) .'>'. $websafe_value .'</option>';
      }
      print '</optgroup>';

      print '<optgroup label="'. __( 'Google Fonts', CS_TEXTDOMAIN ) .'">';
      foreach ( $googlefonts as $google_key => $google_value ) {
        print '<option value="'. $google_key .'" data-variants="'. implode( '|', $google_value ) .'" data-type="google"'. selected( $google_key, $family_value, true ) .'>'. $google_key .'</option>';
      }
      print '</optgroup>';

      print '</select>';
      print '</label>';

      if( ! empty( $is_variant ) ) {

        $variants = ( $is_google ) ? $googlefonts[$family_value] : $default_variants;
        $variants = ( $value['font'] === 'google' || $value['font'] === 'websafe' ) ? $variants : array( 'regular' );

        print '<label class="cs-typography-variant">';
        print '<select name="'. $this->element_name( '[variant]' ) .'" class="'. $is_chosen . $chosen_rtl .'cs-typo-variant" data-atts="variant">';
        foreach ( $variants as $variant ) {
          print '<option value="'. $variant .'"'. $this->checked( $variant_value, $variant, 'selected' ) .'>'. $variant .'</option>';
        }
        print '</select>';
        print '</label>';

      }

      print '<input type="text" name="'. $this->element_name( '[font]' ) .'" class="cs-typo-font hidden" data-atts="font" value="'. $value['font'] .'" />';

    } else {

      _e( 'Error! Can not load json file.', CS_TEXTDOMAIN );

    }

    print $this->element_after();

  }

}

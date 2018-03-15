<?php
 
function napoli_map( $atts, $content = '', $id = '' ) {
	extract( shortcode_atts( array(
		'latitude'       => '51.5255069',
		'longitude'      => '-0.0836207',
		'marker'         => '',
		'zoom'           => '14',
		'marker_text'    => '',
		'contacts_style' => '',
		'map_style'      => '',
		'google_api_key' => 'AIzaSyA6M45oe9V8IfJfUB6x4k0FKhmEf58nJAs',
		't1_title'       => 'Address',
		't1_text1'       => 'Via Cesare Rosaroll, 118',
		't1_text2'       => '80139 Napoli',
		't2_title'       => 'Phones',
		't2_text1'       => '+789 558 69 85',
		't2_text2'       => '+789 023 58 96',
		't3_title'       => 'Emails',
		't3_text1'       => 'napoli@info.com',
		't3_text2'       => 'support@napoli.com'
	), $atts ) );

	wp_enqueue_script( 'gmaps', 'http://maps.google.com/maps/api/js?key=' . $google_api_key . '&ver=4.6', array( 'jquery' ), true, false );

	$marker   = ( is_numeric( $marker ) && ! empty( $marker ) ) ? wp_get_attachment_url( $marker ) : get_template_directory_uri() . '/assets/images/map-marker.png';
	$map_zoom = ( is_numeric( $zoom ) ) ? $zoom : 14;

	$output = '';
	$output .= '<div class="row">';
	if ( is_numeric( $latitude ) and is_numeric( $longitude ) ) {
		$output .= '<div id="google-map" data-string="' . $marker_text . '" data-lat="' . $latitude . '" data-lng="' . $longitude . '" data-zoom="' . $map_zoom . '" data-marker="' . $marker . '" ' . $map_style . '></div>';
		$output .= '<div class="contact-info" ' . $contacts_style . '>';
		if ( ! empty( $t1_title ) && ( ! empty( $t1_text1 ) || ! empty( $t1_text2 ) ) ) {
			$output .= '<div class="info-box">';
			$output .= '<div class="details">';
			$output .= '<h5 class="title">' . $t1_title . '</h5>';
			$output .= ( ! empty( $t1_text1 ) ) ? '<h6>' . $t1_text1 . '</h6>' : '';
			$output .= ( ! empty( $t1_text2 ) ) ? '<h6>' . $t1_text2 . '</h6>' : '';
			$output .= '</div>';
			$output .= '</div>';
		}
		if ( ! empty( $t2_title ) && ( ! empty( $t2_text1 ) || ! empty( $t2_text2 ) ) ) {
			$output .= '<div class="info-box">';
			$output .= '<div class="details">';
			$output .= '<h5 class="title">' . $t2_title . '</h5>';
			$output .= ( ! empty( $t2_text1 ) ) ? '<a href="tel:' . $t2_text1 . '">' . $t2_text1 . '</a>' : '';
			$output .= ( ! empty( $t2_text2 ) ) ? '<a href="tel:' . $t2_text2 . '">' . $t2_text2 . '</a>' : '';
			$output .= '</div>';
			$output .= '</div>';
		}
		if ( ! empty( $t3_title ) && ( ! empty( $t3_text1 ) || ! empty( $t3_text2 ) ) ) {
			$output .= '<div class="info-box">';
			$output .= '<div class="details">';
			$output .= '<h5 class="title">' . $t3_title . '</h5>';
			$output .= ( ! empty( $t3_text1 ) ) ? '<a href="mailto:' . $t3_text1 . '">' . $t3_text1 . '</a>' : '';
			$output .= ( ! empty( $t3_text2 ) ) ? '<a href="mailto:' . $t3_text2 . '">' . $t3_text2 . '</a>' : '';
			$output .= '</div>';
			$output .= '</div>';
		}
		$output .= '</div>';
	}
	$output .= '</div>';

	return $output;
}

add_shortcode( 'napoli_map', 'napoli_map' );

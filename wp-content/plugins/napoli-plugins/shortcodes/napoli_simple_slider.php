<?php
 
function napoli_simple_slider( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'images' => ''
	), $atts ) );

	$output = '';
	if ( ! empty( $images ) ) {
		$slides = explode( ',', $images );

		$output = '<div class="img-slider">';
		$output .= '<ul class="slides">';
		foreach ( $slides as $slide ) {
			$url = ( is_numeric( $slide ) && ! empty( $slide ) ) ? wp_get_attachment_url( $slide ) : '';
			$output .= '<li>';
			$output .= napoli_the_lazy_load_flter( $url,
								array(
								  'class' => '',
								  'alt'   => ''
								)
							);
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '</div>';
	}

	return $output;
}

add_shortcode( 'napoli_simple_slider', 'napoli_simple_slider' );

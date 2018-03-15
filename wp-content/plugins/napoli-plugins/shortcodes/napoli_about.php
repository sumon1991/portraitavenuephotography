<?php
 
function napoli_about( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'title' => '',
		'link_text' => '',
		'link_url' => '',
		'image' => '',
		'subtitle' => '',

	), $atts ) );

	$url = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';

	$output = '<div class="about-section row">';
	$output .= '<div class="person-wrap s-back-switch">';
	$output .= napoli_the_lazy_load_flter( $url, array(
		'class' => 'person s-img-switch',
		'alt'   => ''
	) );
	$output .= '</div>';
	$output .= '<div class="content text-light">';
	if ( ! empty( $subtitle ) ) {
		$output .= '<h6 class="subtitle">' . $subtitle . '</h6>';
	}
	if ( ! empty( $title ) ) {
		$output .= '<h5 class="title">' . $title . '</h5>';
	}
	if ( ! empty( $content ) ) {
		$output .= '<div class="descr">' . wp_kses_post( do_shortcode( $content ) ) . '</div>';
	}
	if ( !empty( $link_text) && !empty( $link_url ) ) {
		$output .= '<div class="but-wrap">';
		$output .= '<a href="' . $link_url . '" class="a-btn-2">' . $link_text . '</a>';
		$output .= '</div>';
	}

	$output .= '</div>';
	$output .= '</div>';

	return $output;
}

add_shortcode( 'napoli_about', 'napoli_about' );

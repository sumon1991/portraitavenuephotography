<?php
 
function napoli_simple_text_block( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'title'    => '',
		'size'     => 'h1',
		'subtitle' => '',
		'btn_text' => '',
		'btn_url'  => '',
	), $atts ) );

	$output = '<div class="simple-details">';

	$output .= '<div class="content">';
	if ( ! empty( $subtitle ) ) {
		$output .= '<h5 class="subtitle">' . $subtitle . '</h5>';
	}
	if ( ! empty( $title ) ) {
		$output .= '<' . $size . ' class="title">' . $title . '</' . $size . '>';
	}
	if ( ! empty( $content ) ) {
		$output .= '<div class="text">' . wp_kses_post( do_shortcode( $content ) ) . '</div>';
	}
	if ( !empty( $btn_text ) && ! empty($btn_url ) ) {
		$output .= '<div class="button-wrap">';
		$output .= '<a href="' . $btn_url . '" class="a-btn-2 button">' . $btn_text . '</a>';
		$output .= '</div>';
	}

	$output .= '</div>';

	$output .= '</div>';

	return $output;
}

add_shortcode( 'napoli_simple_text_block', 'napoli_simple_text_block' );

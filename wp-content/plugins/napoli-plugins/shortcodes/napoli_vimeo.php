<?php
 
function napoli_vimeo( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'url'      => '',
		'autoplay' => ''
	), $atts ) );

	$containment = "containment:'self'";
	$autoplay    = ( $autoplay == 'yes' ) ? "autoPlay:true" : "autoPlay:false";


	//autoplay
	if ( $autoplay === 'autoPlay:true' ) {
		$autoplay = 'autoplay=1';
	} else {
		$autoplay = 'autoplay=0';
	}

	$output = '<iframe class="vimeo-video" src="https://player.vimeo.com/video/' . $url . '?' . $autoplay . '&loop=1" width="500" height="269" frameborder="0" autoplay webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

	return $output;

}

add_shortcode( 'napoli_vimeo', 'napoli_vimeo' );
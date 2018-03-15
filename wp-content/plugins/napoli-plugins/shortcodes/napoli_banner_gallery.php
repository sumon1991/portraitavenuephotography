<?php
/**
 *
 * Banner with gallery
 * @since 1.0.0
 * @version 1.1.0
 * @
 */
// ==========================================================================================
// BANNER WITH GALLERY                                                                                 -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Banner with gallery', 'js_composer' ),
		'base'        => 'napoli_banner_gallery',
		'category'    => __( 'Media', 'js_composer' ),
		'description' => __( 'Banner with gallery, text and button', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Description', 'js_composer' ),
				'param_name' => 'description'
			),
			array(
				'type'       => 'attach_images',
				'heading'    => __( 'Images for banner', 'js_composer' ),
				'param_name' => 'images'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button text', 'js_composer' ),
				'param_name' => 'btn_text',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button URL', 'js_composer' ),
				'param_name' => 'btn_url',
				'value'      => ''
			)
		)
	)
);
function napoli_banner_gallery( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'image'       => '',
		'title'       => '',
		'images'      => '',
		'description' => '',
		'btn_url'     => '',
		'btn_text'    => '',
	), $atts ) );

	$output = '';

	$output .= '<div class="banner-gallery">';

	$output .= '<div class="gridrotate banner-gal">';
	$output .= '<ul class="banner-list">';

	$slides = explode( ',', $images );

	$i = 1;

	foreach ( $slides as $slide ) {
		$url = ( ! empty( $slide ) && is_numeric( $slide ) ) ? wp_get_attachment_image_src( $slide ) : '';
		$output .= '<li><span><img src="' . $url[0] . '" alt="" class="s-img-switch"></span></li>';
		$i ++;
	}
	$output .= '</ul>';
	$output .= '</div>';

	$output .= '<div class="content-wrap text-center">';
	$output .= '<div class="content vertical-align">';
	$output .= '<h1 class="title">' . $title . '</h1>';
	$output .= '<div class="description">' . $description . '</div>';
	if ( ! empty( $btn_text ) && ! empty( $btn_url ) ) {
		$output .= '<a href="' . $btn_url . '" class="a-btn-2 button">' . $btn_text . '</a>';
	}
	$output .= '</div>';
	$output .= '</div>';


	$output .= '</div>';


	return $output;
}

add_shortcode( 'napoli_banner_gallery', 'napoli_banner_gallery' );

// napoli options
if (!is_admin()) {
wp_enqueue_script( 'jquery.gridrotator', get_template_directory_uri() . '/assets/js/lib/jquery.gridrotator.js', array( 'jquery' ), '', true );
}


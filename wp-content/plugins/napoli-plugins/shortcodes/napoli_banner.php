<?php
 
// ==========================================================================================
// BANNER                                                                                   ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Image banner', 'js_composer' ),
		'base'        => 'napoli_banner',
		'description' => __( 'Image banner with text and button', 'js_composer' ),
		'category'    => __( 'Media', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Style Banner', 'js_composer' ),
				'param_name' => 'style',
				'value'      => array(
					'Default' => '',
					'Left content (another colors)' => 'left_content',
					'Center content' => 'center_content',
				)
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Full height?', 'js_composer' ),
				'param_name' => 'height',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Top align text?', 'js_composer' ),
				'param_name' => 'top_align',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Heading', 'js_composer' ),
				'param_name' => 'size',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6'
				)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Subtitle', 'js_composer' ),
				'param_name' => 'subtitle'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Description', 'js_composer' ),
				'param_name' => 'description'
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
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Background image', 'js_composer' ),
				'param_name' => 'image'
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Show overlay?', 'js_composer' ),
				'param_name' => 'overlay',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
			),
		)
	)
);

function napoli_banner( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'style'       => '',
		'title'       => '',
		'subtitle'    => '',
		'top_align'   => '',
		'description' => '',
		'btn_text'    => '',
		'btn_url'     => '',
		'image'       => '',
		'size'        => 'h1',
		'height'      => '',
		'overlay'      => '',
	), $atts ) );

	$banner_height = '';
	if ( !empty( $height ) ) {
		$banner_height = 'full-height';
	}
	$top_align_text = '';

	if ( ! empty( $top_align ) ) {
		$top_align_text = ' top_align ';
	}

	$image = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';

	if ( !empty($style) ) {
		$banner_height .= ' ' . $style;
	}

	

	$output = '';
	$output .= '<div class="container-fluid top-banner ' . esc_attr( $banner_height ) . esc_attr( $top_align_text ) . ' ">';
	if ( ! empty( $image ) ) {

		$output .= napoli_the_lazy_load_flter( $image, array( 'class' => 's-img-switch', 'alt' => '' ) );

	}

	if ( !empty($overlay)) {
		$output .= '<span class="overlay"></span>';
	}
	$output .= '<div class="content">';
	$output .= '<div class="row text-light">';
	$output .= '<div class="col-xs-12">';
	if ( ! empty( $subtitle ) ) {
		$output .= '<h4 class="subtitle">' . $subtitle . '</h4>';
	}
	if ( ! empty( $title ) ) {
		$output .= '<' . $size . ' class="title">' . $title . '</' . $size . '>';
	}
	if ( ! empty( $description ) ) {
		$output .= '<p class="descr">' . $description . '</p>';
	}
	if ( !empty( $btn_text ) && !empty( $btn_url ) ) {
		$output .= '<a href="' . $btn_url . '" class="a-btn margin-lg-20t">' . $btn_text . '</a>';
	}
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';


	return $output;
}

add_shortcode( 'napoli_banner', 'napoli_banner' );

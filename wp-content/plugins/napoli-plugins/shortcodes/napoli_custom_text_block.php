<?php

 vc_map(
	array(
		'name'        => __( 'Custom text block', 'js_composer' ),
		'base'        => 'napoli_custom_text_block',
		'description' => __( 'Section with text, quote and button (with paddings)', 'js_composer' ),
		'category'    => __( 'Content', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Style', 'js_composer' ),
				'param_name' => 'style',
				'value'      => array(
					'Style' => '',
					'Style 2' => 'style2',
					'Style 3' => 'style3',
					'Style 4' => 'style4'
				)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Heading for title', 'js_composer' ),
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
				'param_name' => 'title',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title 2', 'js_composer' ),
				'param_name' => 'title2',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Subtitle', 'js_composer' ),
				'param_name' => 'subtitle',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Label Text', 'js_composer' ),
				'param_name' => 'label_text',
				'value'      => '',
				'dependency' => array(
								'element' => 'style',
								'value' => 'style2',
							)
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __( 'Text', 'js_composer' ),
				'param_name' => 'content',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button text', 'js_composer' ),
				'param_name' => 'btn_text',
				'value'      => '',
				'dependency' => array(
								'element' => 'style',
								'value' => array(''),
							),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button URL', 'js_composer' ),
				'param_name' => 'btn_url',
				'value'      => '',
				'dependency' => array(
								'element' => 'style',
								'value' => array(''),
							)
			)
		)
	)
);


/**
 *
 * About details
 * @since 1.0.0
 * @version 1.1.0
 *
 */
function napoli_custom_text_block( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'title'    => '',
		'title2'    => '',
		'size'     => 'h1',
		'subtitle' => '',
		'style' => '',
		'label_text' => '',
		'btn_text' => '',
		'btn_url'  => '',
	), $atts ) );


	$output = '<div class="about-details '. esc_attr( $style ) . '">';

	$output .= '<div class="content">';
	if ( ! empty( $subtitle ) ) {
		$output .= '<h5 class="subtitle">' . $subtitle . '</h5>';
	}
	if ( ! empty( $title ) ) {
		$title2 = !empty( $title2) ? $title2 : '';
		$output .= '<' . $size . ' class="title">' . $title . '<br>' . $title2 . '</' . $size . '>';
	}
	

	if ( ! empty( $content ) ) {
		$output .= '<div class="text"><p>' . wp_kses_post( do_shortcode( $content ) ) . '</p></div>';
	}
		
	if ( ! empty( $label_text ) && $style == 'style2') {
		$output .= '<span class="label_text">' . $label_text . '</span>';
	}
	if ( ! empty( $btn_text ) && ! empty( $btn_url ) && empty($style) ) {
		$output .= '<div class="button-wrap">';
		$output .= '<a href="' . $btn_url . '" class="a-btn-2 button">' . $btn_text . '</a>';
		$output .= '</div>';
	}

	$output .= '</div>';

	$output .= '</div>';

	return $output;
}

add_shortcode( 'napoli_custom_text_block', 'napoli_custom_text_block' );

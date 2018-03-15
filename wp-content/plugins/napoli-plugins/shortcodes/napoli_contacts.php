<?php

vc_map(
	array(
		'name'        => __( 'Contacts', 'js_composer' ),
		'base'        => 'napoli_contacts',
		'description' => __( 'Contacts info', 'js_composer' ),
		'category'    => __( 'Content', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Label', 'js_composer' ),
				'param_name' => 'label',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title',
				'value'      => ''
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __( 'Text', 'js_composer' ),
				'param_name' => 'content',
				'value'      => ''
			),
		)
	)
);


/**
 *
 * Contacts
 * @since 1.0.0
 * @version 1.1.0
 *
 */
function napoli_contacts( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'title'    => '',
		'label'    => ''
	), $atts ) );


	$output = '<div class="simple-contacts">';

	if ( ! empty( $label ) ) {
		$output .= '<div class="label">' . esc_html($label) . '</div>';
	}

	$output .= '<div class="content">';
	if ( ! empty( $title ) ) {
		$output .= '<h5 class="title">' . esc_html($title) . '</h5>';
	}
	if ( ! empty( $content ) ) {
		$output .= '<div class="text"><p>' . wp_kses_post( do_shortcode( $content ) ) . '</p></div>';
	}
	$output .= '</div>';

	$output .= '</div>';


	return $output;
}

add_shortcode( 'napoli_contacts', 'napoli_contacts' );

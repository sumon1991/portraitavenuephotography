<?php
/**
 *
 * Instagram
 * @since 1.0.0
 * @version 1.1.0
 *
 */

// ==========================================================================================
// INSTAGRAM                                                                          -
// ==========================================================================================

vc_map(
	array(
		'name'   => __( 'Instagram', 'js_composer' ),
		'base'   => 'napoli_instagram',
		'params' => array(
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Username', 'js_composer' ),
				'admin_label' => true,
				'param_name'  => 'username'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Count images', 'js_composer' ),
				'admin_label' => true,
				'param_name'  => 'count'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Title', 'js_composer' ),
				'admin_label' => true,
				'param_name'  => 'title'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Extra class name', 'js_composer' ),
				'param_name'  => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
				'value'       => ''
			),
			/* CSS editor */
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'CSS box', 'js_composer' ),
				'param_name' => 'css',
				'group'      => __( 'Design options', 'js_composer' )
			)
		)
	)
);

function napoli_instagram( $atts, $content = '', $id = '' ) {

	extract( shortcode_atts( array(
		'username' => '',
		'title'    => '',
		'count'    => 'h1',
		'button'   => '',
		'el_class' => '',
		'css'      => ''
	), $atts ) );

	if ( ! empty( $username ) ) {
		$class = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );
		$count = ( ! empty( $count ) && is_numeric( $count ) ) ? $count : 6;
		$instagram_images = napoli_get_imstagram( $username, $count );

		$output = '';
		$output .= '<div class="row">';
		$output .= '<div class="insta-box ' . $class . '">';
		$output .= '<div class="insta-box-follow">' . $title . ' <a href="' . esc_url( 'https://www.instagram.com/' . $username ) . '" class="insta-acc">@' . $username . '</a></div>';

		$output .= '<div class="insta-img-wrap">';
		if ( ! empty( $instagram_images ) ) {
			foreach ( $instagram_images as $image ) {
				$output .= '<a href="' . esc_url( 'https://instagram.com/p/' . $image['link'] ) . '" target="_blank">';
				$output .= napoli_the_lazy_load_flter( 'https://instagram.com/p/' . $image['link'] . '/media/?size=t', array(
					'class' => 'img-responsive img',
					'alt'   => ''
				) );
				$output .= '</a>';
			}
		}

		$output .= '</div>';

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}

add_shortcode( 'napoli_instagram', 'napoli_instagram' );

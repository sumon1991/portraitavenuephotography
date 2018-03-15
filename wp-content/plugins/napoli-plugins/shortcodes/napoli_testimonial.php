<?php
/*
 * Testimonial Shortcode
 * Author: FOXTHEMES
 * Author URI: http://foxthemes.com
 * Version: 1.0.0
 */
vc_map(
	array(
		'name'                    => __( 'Testimonial', 'js_composer' ),
		'base'                    => 'napoli_slider',
		'as_parent'               => array( 'only' => 'napoli_slider_items' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Style', 'js_composer' ),
				'param_name' => 'style',
				'value'      => array(
					'Classic'         => 'classic',
					'Simple'        => 'simpple',
				)
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Background image', 'js_composer' ),
				'param_name' => 'image',
				'dependency'  => array( 'element' => 'style', 'value' => 'classic' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Autoplay (sec)', 'js_composer' ),
				'description' => __( '0 - off autoplay.', 'js_composer' ),
				'param_name'  => 'autoplay',
				'value'       => '0'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Speed (milliseconds)', 'js_composer' ),
				'description' => __( 'Speed Animation. Default 1000 milliseconds', 'js_composer' ),
				'param_name'  => 'speed',
				'value'       => '500'
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Loop', 'js_composer' ),
				'param_name' => 'loop',
				'value'      => '1',
				'dependency'  => array( 'element' => 'style', 'value' => 'classic' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Extra class name', 'js_composer' ),
				'param_name'  => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
				'value'       => ''
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'CSS box', 'js_composer' ),
				'param_name' => 'css',
				'group'      => __( 'Design options', 'js_composer' )
			)
		) //end params
	)
);

class WPBakeryShortCode_napoli_slider extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'image'              => '',
			'style'           => 'classic',
			'autoplay'           => '',
			'loop'           => '',
			'speed'              => '',
			'css'                => '',
			'class'              => '',
			'el_class'           => ''
		), $atts ) );

		$class = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );


		$autoplay = is_numeric( $autoplay ) ? $autoplay * 1000 : 0;
		$speed    = is_numeric( $speed ) ? $speed : '500';
		$loop     = ! empty( $loop ) ? '1' : '0';
		if($style == 'simpple'){
			$loop = '0';
		}

		$count_style = $style == 'classic' ? '1' : '2';


		$output = '';

		global $napoli_slider_items;
		$napoli_slider_items = '';

		do_shortcode( $content );


		if ( ! empty( $napoli_slider_items ) && count( $napoli_slider_items ) > 0 ) {
			$output .= '<div class="row main-header-testimonial ' . esc_attr( $class ) . ' ' . esc_attr($style) . '">';
			if ( ! empty( $image ) && is_numeric( $image ) && $style == 'classic') {
				$output .= '<div class="banner-overlay"></div>';
				$output .= '<img src="' . esc_url( wp_get_attachment_url( $image ) ) . '" alt="slider" class="s-img-switch">';
			}
			$output .= '<div class="swiper-container" data-autoplay="' . esc_attr( $autoplay ) . '" data-slides-per-view="responsive" data-loop="' . esc_attr($loop) . '" data-speed="' . esc_attr( $speed ) . '" data-mode="horizontal" data-xs-slides="1" data-sm-slides="1" data-md-slides="1" data-lg-slides="' . esc_attr($count_style) . '" data-add-slides="' . esc_attr($count_style) . '">';
			$output .= '<div class="swiper-wrapper">';

			foreach ( $napoli_slider_items as $item ) {
				$value       = (object) $item['atts'];
				$class_slide = '';
				if ( ! empty( $value->css ) ) {
					$class_slide .= vc_shortcode_custom_css_class( $value->css, ' ' );
				}
				$output .= '<div class="swiper-slide ' . esc_attr( $class_slide ) . '">';

				if($style == 'classic'){
					$output .= '<div class="content-slide">';
					$output .= ( ! empty( $item['content'] ) ) ? '<div class="description clearfix"><p>' . do_shortcode( $item['content'] ) . '</p></div>' : '';
					$output .= ( ! empty( $value->author ) ) ? '<div class="author">' . esc_html( $value->author ) . '</div>' : '';
					if ( ! empty( $value->logo_image ) && is_numeric( $value->logo_image ) ) {
						$alt = get_post_meta( $value->logo_image, '_wp_attachment_image_alt', true );
						if(!empty($value->logo_url)){
							$output .= '<a href="' . esc_url( $value->logo_url ) . '" class="logo-customer" ><img src="' . esc_url( wp_get_attachment_url( $value->logo_image ) ) . '" alt="' . esc_attr( $alt ) . '" class="logo-img-customer"></a>';
						}else{
							$output .= '<div class="logo-customer" ><img src="' . esc_url( wp_get_attachment_url( $value->logo_image ) ) . '" alt="' . esc_attr( $alt ) . '" class="logo-img-customer"></div>';
						}
					}
					$output .= '</div>';
				}else{

					$output .= '<div class="wrap">';
					if ( ! empty( $value->logo_image ) && is_numeric( $value->logo_image ) ) {
						$alt = get_post_meta( $value->logo_image, '_wp_attachment_image_alt', true );
						if(!empty($value->logo_url)){
							$output .= '<a href="' . esc_url( $value->logo_url ) . '" class="logo-customer" ><img src="' . esc_url( wp_get_attachment_url( $value->logo_image ) ) . '" alt="' . esc_attr( $alt ) . '" class="s-img-switch logo-img-customer"></a>';
						}else{
							$output .= '<div class="logo-customer" ><img src="' . esc_url( wp_get_attachment_url( $value->logo_image ) ) . '" alt="' . esc_attr( $alt ) . '" class="logo-img-customer s-img-switch"></div>';
						}
					}
					$output .= '<div class="content-slide">';
					$output .= ( ! empty( $value->author ) ) ? '<div class="author">' . esc_html( $value->author ) . '</div>' : '';
					$output .= ( ! empty( $item['content'] ) ) ? '<div class="description clearfix"><p>' . do_shortcode( $item['content'] ) . '</p></div>' : '';
					$output .= '</div>';
					$output .= '</div>';

				}
				$output .= '</div>';
			}
			$output .= '</div>';
			$output .= '<div class="pagination '. esc_attr($style) .'"></div>';
			$output .= '<div class="swiper-arrow-left"><i class="fa fa-angle-left" aria-hidden="true"></i></div>';
			$output .= '<div class="swiper-arrow-right"><i class="fa fa-angle-right" aria-hidden="true"></i></div>';
			$output .= '</div>';
			$output .= '</div>';


		}

		return  $output ;
	}
}


vc_map(
	array(
		'name'            => 'Testimonial item',
		'base'            => 'napoli_slider_items',
		'as_child'        => array( 'only' => 'napoli_slider' ),
		'content_element' => true,
		'params'          => array(
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Image/Logo', 'js_composer' ),
				'param_name' => 'logo_image',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Image/Logo url', 'js_composer' ),
				'param_name' => 'logo_url',
				'value'      => ''
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __( 'Content', 'js_composer' ),
				'param_name' => 'content',
				'holder'     => 'div',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( "Author's name", 'js_composer' ),
				'param_name' => 'author',
				'value'      => ''
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'CSS box', 'js_composer' ),
				'param_name' => 'css',
				'group'      => __( 'Design options', 'js_composer' )
			)
		) //end params
	)
);

class WPBakeryShortCode_napoli_slider_items extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		global $napoli_slider_items;
		$napoli_slider_items[] = array( 'atts' => $atts, 'content' => $content );

		return;
	}
}


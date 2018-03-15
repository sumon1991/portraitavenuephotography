<?php
 
vc_map(
	array(
		'name'                    => __( 'Banner Slider', 'js_composer' ),
		'base'                    => 'banner_slider',
		'as_parent'               => array( 'only' => 'banner_slider_items' ),
		'content_element'         => true,
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Type Slider', 'js_composer' ),
				'param_name' => 'type_slider',
				'value' => array(
					__( 'Vertical slider (default)', 'js_composer' ) => '',
					__( 'Horizontal slider', 'js_composer' ) => 'horizontal',
				),
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Autoplay (sec)', 'js_composer' ),
				'description' => __( '0 - off autoplay.', 'js_composer' ),
				'param_name'  => 'autoplay',
				'value'       => '0',
				'group'       => __( 'Animation', 'js_composer' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Speed (milliseconds)', 'js_composer' ),
				'description' => __( 'Speed Animation. Default 1000 milliseconds', 'js_composer' ),
				'param_name'  => 'speed',
				'value'       => '500',
				'group'       => __( 'Animation', 'js_composer' )
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

class WPBakeryShortCode_banner_slider extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'type_slider' => '',
			'autoplay' => '0',
			'speed'    => '500',
			'css'      => '',
			'el_class' => ''
		), $atts ) );


		$autoplay = is_numeric( $autoplay ) ? $autoplay * 1000 : 0;
		$speed    = is_numeric( $speed ) ? $speed : '500';

		$class = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );
		$output = '';

		global $banner_slider_items;
		$banner_slider_items = '';

		$data_type_slider = $type_slider == 'horizontal' ? 'horizontal' : 'vertical';

		$dataSwipe = $data_type_slider == 'vertical' ? 'data-noSwiping="true"' : "";

		$class .= ' ' . $data_type_slider; 

		do_shortcode( $content );

		if ( ! empty( $banner_slider_items ) ) {

			$output .= '
			<style>
			.banner-slider-wrap .img-bg{
				height: 100%;
				width: 100%;
			}
			.horizontal{ 
			}
			</style>
			<div class="banner-slider-wrap ' . esc_attr( $class ) . '">';
			$output .= '<div class="swiper-container" data-mode="' . esc_attr( $data_type_slider ) . '"  '. $dataSwipe .' data-autoplay="' . esc_attr( $autoplay ) . '" data-loop="1" data-speed="' . esc_attr( $speed ) . '" data-slides-per-view="responsive" data-add-slides="1" data-xs-slides="1" data-sm-slides="1" data-md-slides="1" data-lg-slides="1">';

			$output .= '<div class="swiper-wrapper">';
			foreach ( $banner_slider_items as $item ) {

				$value = (object) $item['atts'];


				$img_url = ( !empty( $value->image) && is_numeric($value->image) ) ? wp_get_attachment_url( $value->image ) : '';


				$output .= '<div class="swiper-slide">';
				$output .= '<div class="slider-banner full-height-hard">';
				$output .= '<div class="img-bg bg-cover">';

				$output .= napoli_the_lazy_load_flter( $img_url,
							array(
							  'class' => 's-img-switch',
							  'alt'   => ''
							)
						);

				$output .= '</div>';

				if ($type_slider != 'horizontal') {

					$output .= '<div class="container no-padd-md">';
					$output .= '<div class="row">';
					$output .= '<div class="col-xs-12">';
					if ( ! empty( $value->subtitle ) ) {
						$output .= '<h4 class="subtitle">' . $value->subtitle . '</h4>';
					}
					if ( ! empty( $value->title ) ) {
						if ( ! empty( $value->size_header ) ) {
							$output .= '<' . $value->size_header . ' class="title">' . $value->title . '</' . $value->size_header . '>';
						} else {
							$output .= '<h1 class="title">' . $value->title . '</h1>';
						}

					}
					if ( ! empty( $item['content'] ) ) {
						$output .= '<p class="descr">' . do_shortcode( $item['content'] ) . '</p>';
					}

					if ( ! empty( $value->button ) ) {
						$url = vc_build_link( $value->button );
					} else {
						$url['url']   = '#';
						$url['title'] = 'title';
					}

					if ( ! empty( $value->button ) ) {
						$output .= '<a href="' . esc_attr( $url['url'] ) . '" class="a-btn ">' . esc_html( $url['title'] ) . '</a>';
					}
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
				} // end horizontal

				$output .= '</div>';
				$output .= '</div>';
			}
			$output .= '</div>';

			$output .= '<div class="pagination"></div>';
			if ($type_slider != 'horizontal') {
				$output .= '<div class="swiper-arrow-left"></div><div class="swiper-arrow-right"><i class="fa fa-angle-double-down" aria-hidden="true"></i></div>';
			}
			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}
}

vc_map(
	array(
		'name'            => 'Slider item',
		'base'            => 'banner_slider_items',
		'as_child'        => array( 'only' => 'banner_slider' ),
		'content_element' => true,
		'params'          => array(
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Background Image', 'js_composer' ),
				'param_name' => 'image',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Subtitle', 'js_composer' ),
				'param_name' => 'subtitle',
				'value'      => '',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title',
				'value'      => ''
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Size title', 'js_composer' ),
				'param_name' => 'size_header',
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
				'type'       => 'textarea_html',
				'heading'    => __( 'Content', 'js_composer' ),
				'param_name' => 'content',
				'holder'     => 'div',
				'value'      => ''
			),
			array(
				'type'       => 'vc_link',
				'heading'    => __( 'Button', 'js_composer' ),
				'param_name' => 'button'
			),
		) //end params
	)
);

class WPBakeryShortCode_banner_slider_items extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		global $banner_slider_items;
		$banner_slider_items[] = array( 'atts' => $atts, 'content' => $content );

		return;
	}
}
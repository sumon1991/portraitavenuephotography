<?php
// ==========================================================================================
// SERVICES                                                                                -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Services', 'js_composer' ),
		'base'        => 'napoli_services',
		'category'    => __( 'Content', 'js_composer' ),
		'description' => __( 'Block with image and text', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Style', 'js_composer' ),
				'param_name' => 'style',
				'value'      => array(
					'Default' => 'default',
					'With image background' => 'image_style'
				)
			),
			array(
				'type'       => 'vc_link',
				'heading'    => __( 'Button', 'js_composer' ),
				'param_name' => 'button',
				'dependency' => array( 'element' => 'style', 'value' => array('image_style') ),
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Background image', 'js_composer' ),
				'param_name' => 'bg_image',
				'dependency' => array( 'element' => 'style', 'value' => array('image_style') ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Icon', 'js_composer' ),
				'param_name' => 'image'
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Editor type', 'js_composer' ),
				'param_name' => 'editor_type',
				'value'      => array(
					'Simple text' => '',
					'Editor' => 'editor',
				)
			),
			array(
				'type'       => 'textarea',
				'heading'    => __( 'Text', 'js_composer' ),
				'param_name' => 'text',
				'dependency' => array(
									'element' => 'editor_type',
									'value' => array(''),
								)
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __( 'Text', 'js_composer' ),
				'param_name' => 'content',
				'dependency' => array(
									'element' => 'editor_type',
									'value' => 'editor',
								)
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => 'Title color',
				'param_name' => 'title_color',
				'value'      => '',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => 'Description color',
				'param_name' => 'desc_color',
				'value'      => '',
			),
		)
	)
);


if (class_exists('WPBakeryShortCode')) {
	/* Frontend Output Shortcode */
	class WPBakeryShortCode_napoli_services extends WPBakeryShortCode {
		protected function content( $atts, $content = null ) {

			extract( shortcode_atts( array(
				'title' => '',
				'bg_image' => '',
				'title_color' => '',
				'desc_color' => '',
				'style' => '',
				'button' => '',
				'image' => '',
				'editor_type' => '',
				'text'  => ''
			), $atts ) );

			$url = (! empty( $image ) && is_numeric( $image ) ) ? wp_get_attachment_url( $image ) : '';
			$url_bg = ( ! empty( $bg_image ) && is_numeric( $bg_image )) ? wp_get_attachment_url( $bg_image ) : '';

			$desc_color = isset($desc_color) && !empty($desc_color) ? 'style="color:' . $desc_color . ';"' : '';
			$title_color = isset($title_color) && !empty($title_color) ? 'style="color:' . $title_color . ';"' : '';

			$output = '<div class="services">';

			if(isset($style) && $style == 'image_style'){
				$output .= napoli_the_lazy_load_flter( $url_bg,
					array(
						'class' => 's-img-switch',
						'alt'   => ''
					)
				);
			}
			if (!empty($url)) {
				$output .= '<div class="img-wrap">';
				$output .= napoli_the_lazy_load_flter( $url,
					array(
						'class' => 'img',
						'alt'   => ''
					)
				);
				$output .= '</div>';
			}

			$button_class = (empty($url) && empty($title) && empty($content) && empty($text)) ? 'no-content-button' : "";

			$output .= '<div class="content ' . esc_attr($button_class) . '">';
			if (!empty($title)) {
				$output .= '<h4 class="title"  ' . $title_color . '>' . $title . '</h4>';
			}
			if (!empty($editor_type) && $editor_type == 'editor' && !empty($content)) {
				$output .= '<div class="text" ' . $desc_color . '>' . wpautop( do_shortcode( $content ) ) . '</div>';
			} else {
				if (!empty($text)) {
					$output .= '<div class="text" ' . $desc_color . '>' . $text . '</div>';
				}
			}


			if (isset($button) && !empty($button)) {
				if ( ! empty( $button ) ) {
					$url_button = vc_build_link( $button);
				} else {
					$url_button['url']   = '#';
					$url_button['title'] = 'title';
				}

				if ( ! empty( $button ) ) {
					$output .= '<div class="text-center"><a href="' . esc_attr( $url_button['url'] ) . '" class="a-btn ">' . esc_html( $url_button['title'] ) . '</a></div>';
				}
			}
			$output .= '</div>';

			$output .= '</div>';

			return $output;
		}
	}
} 

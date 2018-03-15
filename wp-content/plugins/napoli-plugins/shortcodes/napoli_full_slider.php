<?php
if (function_exists('vc_map')) {
	vc_map(
		array(
			'name'                    => __( 'Fullscreen Slider', 'js_composer' ),
			'base'                    => 'fullscreen_slider',
			'params'                  => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Type', 'js_composer' ),
					'param_name' => 'slider_type',
					'value'      => array(
						__( 'Full Screen', 'js_composer' ) => '',
						__( 'Full Screen with content', 'js_composer' ) => 'fullcontent',
						__( 'Zoom', 'js_composer' ) => 'kenburn_slider',
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => 'Text color',
					'param_name' => 'text_color',
					'value'      => '',
					'dependency' => array(
						'element' => 'slider_type',
						'value' => 'fullcontent',
					)
				),
				array(
					'type'       => 'attach_images',
					'heading'    => __( 'Images for banner', 'js_composer' ),
					'param_name' => 'images',
					'description' => __( 'For Full Screen with content style you can add text to images for "alt" and "description" like title and subtitle.', 'js_composer' ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Disable window scroll', 'js_composer' ),
					'param_name' => 'disable_scroll',
					'value' => array( __( 'Yes', 'js_composer' ) => 'disable_scroll' ),
					'std'  => '',
					'group'       => __( 'Animation', 'js_composer' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Autoplay', 'js_composer' ),
					'description' => __( '0 - off autoplay. (milliseconds)', 'js_composer' ),
					'param_name'  => 'autoplay',
					'value'       => '0',
					'group'       => __( 'Animation', 'js_composer' ),
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
					'type'        => 'checkbox',
					'heading'     => __( 'Loop', 'js_composer' ),
					'param_name'  => 'loop',
					'value'       => '0',
					'group'       => __( 'Animation', 'js_composer' )
				),
				array(
					'type'       => 'napoli_file',
					'heading'    => __( 'Sound Background', 'js_composer' ),
					'param_name' => 'napoli_file'
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Sound Autoplay', 'js_composer' ),
					'param_name' => 'sound_autoplay', 
					'std'  => '', 
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
}

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_fullscreen_slider extends WPBakeryShortCode {
		protected function content( $atts, $content = null ) {

			extract( shortcode_atts( array(
				'slider_type'  => '',
				'images'      => '',
				'text_color'      => '',
				'autoplay' => '0',
				'loop' => '0',
				'disable_scroll' => '',
				'napoli_file' => '',
				'sound_autoplay' => '',
				'speed'    => '500',
				'el_class'    => '',
				'css'    => '',
			), $atts ) );

			$slides = explode( ',', $images );

			$autoplay = is_numeric( $autoplay ) ? $autoplay : 0;
			$speed    = is_numeric( $speed ) ? $speed : '500';
			$loop    = !empty( $loop ) ? '1' : '0';

			$class = ( ! empty( $el_class ) ) ? $el_class : '';
			$class .= vc_shortcode_custom_css_class( $css, ' ' );

			$class .= !empty($disable_scroll) ? ' ' . $disable_scroll : '';

			$color_style = !empty($text_color) ? 'style="color:' . $text_color . ';"' : '';

			ob_start(); ?>
			
			<div class="page-calculate fullheight">
				<div class="full_screen_slider <?php echo esc_attr( $class ); ?> <?php echo esc_attr( $slider_type ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-loop="<?php echo esc_attr( $loop ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-slides-per-view="responsive" data-add-slides="1" data-xs-slides="1" data-sm-slides="1" data-md-slides="1" data-lg-slides="1">
					<div class="swiper-wrapper">
						<?php foreach ($slides as $key => $slide) : 
							$url = ( ! empty( $slide ) && is_numeric( $slide ) ) ? wp_get_attachment_image_src( $slide, 'full' ) : '';
							$url = is_array($url) ? $url[0] : $url;
							$image_alt = !empty($slide) ?  get_post_meta( $slide, '_wp_attachment_image_alt', true) : '';
							$attachment = get_post( $slide );
							?>
						<div class="swiper-slide">
							<div class="height-100 full-screen-slider__img napoli-bg">
								<?php 
								echo napoli_the_lazy_load_flter( $url, array(
								  'class' => 's-img-switch',
								  'alt'   => $image_alt
								) );

								if($slider_type == 'fullcontent'){ ?>
									<div class="full-content-wrap" <?php echo $color_style; ?>>
										<?php if(!empty($image_alt)){ ?>
											<div class="full-title"><?php echo wp_kses_post($image_alt); ?></div>
										<?php }
										if(!empty($attachment) && !empty($attachment->post_content)){ ?>
											<div class="full-subtitle"><?php echo wp_kses_post($attachment->post_content); ?></div>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<div class="pagination"></div>
						<div class="slider-wrapperok-left">
							<div class="slider-click left">
				                <div class="number">
				                    <div class="left"></div>
				                    <div class="middle"></div>
				                    <div class="right"></div>
				                </div>
				                <div class="arrow"></div>
				            </div>
				        </div>
				        <div class="slider-wrapperok-right">
				            <div class="slider-click right">
				                <div class="arrow"></div>
				                <div class="number">
				                    <div class="left"></div>
				                    <div class="middle"></div>
				                    <div class="right"></div>
				                </div>
				            </div>
				        </div>
				</div>
			</div>
			
			<?php if (!empty($napoli_file)): ?>
				<?php 
				$class_button = empty($sound_autoplay) ? '' : 'play';
				$enable_autoplay = !empty($sound_autoplay) ? 'autoplay' : '';
				?>
				<button class="napoli-sound-btn <?php echo esc_attr( $class_button ); ?>"></button>
				<?php $mime_type = wp_check_filetype($napoli_file); ?>
				<audio class="napoli-audio-file" <?php echo esc_attr( $enable_autoplay ); ?> preload loop>
					<source src="<?php echo esc_url( $napoli_file ); ?>" type="<?php echo esc_attr( $mime_type['type'] ); ?>">
				</audio>
			<?php endif; ?>

			<?php return ob_get_clean();
		}
	}
}
<?php
 

vc_map(
	array(
		'name'            => 'Video Shortcode',
		'base'            => 'video_shortcode',
		'content_element' => true,
		'params'          => array(
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Preview Image', 'js_composer' ),
				'param_name' => 'preview',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title',
				'value'      => ''
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Start play', 'js_composer' ),
				'param_name' => 'type_start',
				'value'      => array(
					'Click' => 'click',
					'Hover' => 'hover',
				)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Video services', 'js_composer' ),
				'param_name' => 'services',
				'value'      => array(
					'Youtube' => 'youtube',
					'Vimeo' => 'vimeo',
					'Other' => 'other',
				)
			),
			array(
				'type'       => 'textarea_raw_html',
				'heading'    => __( 'Insert iframe', 'js_composer' ),
				'param_name' => 'iframe_code',
				'value'      => '', 
				'dependency' => array(
									'element' => 'services',
									'value' => array('other'),
								)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Video link', 'js_composer' ),
				'description' => __( 'Insert your video link', 'js_composer' ),
				'param_name' => 'video_link',
				'value'      => '',
				'dependency' => array(
									'element' => 'services',
									'value' => array('youtube','vimeo'),
								)
			),

			/*array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Autoplay', 'js_composer' ),
				'param_name'       => 'autoplay',
				'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
				'std'  => 'off',
				'dependency' => array(
									'element' => 'services',
									'value' => array('youtube','vimeo'),
								)
			),*/
			/*array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Loop', 'js_composer' ),
				'param_name'       => 'loop',
				'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
				'std'  => 'off',
				'dependency' => array(
									'element' => 'services',
									'value' => array('youtube','vimeo'),
								)
			),*/
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Controls', 'js_composer' ),
				'param_name' => 'controls',
				'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
				'std'  => 'on',
				'dependency' => array(
									'element' => 'services',
									'value' => array('youtube'),
								)
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Mute sound', 'js_composer' ),
				'param_name' => 'mute',
				'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
				'std'  => 'off',
				'dependency' => array(
									'element' => 'services',
									'value' => array('youtube'),
								)
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Showinfo', 'js_composer' ),
				'param_name'       => 'showinfo',
				'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
				'std'  => 'on',
				'dependency' => array(
									'element' => 'services',
									'value' => array('youtube'),
								)
			),

			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Video begins from (sec)', 'js_composer' ),
				'param_name' => 'start',
				'value'      => '',
				'dependency' => array(
									'element' => 'services',
									'value' => array('youtube'),
								)
			),

			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Video ends at (sec)', 'js_composer' ),
				'param_name' => 'end',
				'value'      => '',
				'dependency' => array(
									'element' => 'services',
									'value' => array('youtube'),
								)
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

class WPBakeryShortCode_video_shortcode extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'css'      => '',
			'el_class' => '',
			'title' => '',
			'type_start' => 'click',
			'preview' => '',
			'iframe_code' => '',
			'video_link' => '',
			'services' => 'youtube',
			'autoplay' => '0',
			'loop' => 'on',
			'controls' => 'on',
			'showinfo' => 'on',
			'mute' => 'off',
			'start' => '0',
			'end' => '0',
			'color' => '',
		), $atts ) ); 

		$video_params = array();

		$class = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );

		if (empty($services ) || $services == 'youtube') {
			wp_enqueue_script( 'napoli_youtube', 'https://www.youtube.com/iframe_api', '', true );
		}


		// for youtube
		if (empty($services) || $services == 'youtube') {
		 
			$video_params = array(
				'enablejsapi' => 1,
				/*'autoplay' => $autoplay == 'on' ? 1 : 0 ,*/
				'loop' => $loop == 'on' ? 1 : 0,
				'controls' => $controls == 'on' ? 1 : 0 ,
				'showinfo' => $showinfo == 'on' ? 1 : 0 ,
				'start' => !empty($start)  ? $start : 0 ,
				'end' => !empty($end) ? $end : 0 , 
				'modestbranding' => 0,
				'rel' => 0,
			);

			$mute = ($mute == 'on') ? 1 : 0;

		}
 

		// for vimeo
		if ($services == 'vimeo') {
			$video_params = array(
				'autoplay' => !empty($autoplay) ? 1 : 0,
				'loop' => !empty($loop) ? 1 : 0,
				'byline' => !empty($byline) ? 1 : 0,
			);
		}
		

		$img_url = ( !empty( $image ) && is_numeric( $image ) ) ? wp_get_attachment_url( $image ) : '';

		
   		$preview_url = !empty($preview) ? wp_get_attachment_url( $preview )  : '';

		ob_start();
		?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<div class="iframe-video <?php echo esc_attr( $services ); ?>" data-type-start="<?php echo esc_attr( $type_start ); ?>" data-mute="<?php echo esc_attr( $mute ); ?>" >
				<?php
				if (empty($services) ||  $services == 'youtube' || $services == 'vimeo') {
					if (!empty($video_link) && $services == 'youtube') {
						echo str_replace("?feature=oembed", "?feature=oembed&" . http_build_query ( $video_params ), wp_oembed_get($video_link));
					}
					if ($services == 'vimeo') {
						$video_iframe = wp_oembed_get($video_link);
						$video_iframe = str_replace("src=\"", "src=\"about:blank\" data-src=\"", $video_iframe );
						echo preg_replace("/\/(\d+?)\"/","/$1?" . http_build_query ( $video_params ) . "\"", $video_iframe );
					} 
				} else {
					$iframe_code = rawurldecode( base64_decode( strip_tags( $iframe_code ) ) ); 
					$iframe_code = str_replace("src=\"", "src=\"about:blank\" data-src=\"", $iframe_code );
					echo $iframe_code;
				}
				?>
				<?php if ($preview_url) : ?>
				<?php  
				echo napoli_the_lazy_load_flter( $preview_url, array(
				  'class' => 's-img-switch',
				  'alt'   => ''
				) );
				?> 
				<?php endif; ?>
				<div class="video-content">
					<?php if ($type_start != 'hover') : ?>
					<a href="#" class="play-button"></a>
					<?php endif; ?>
				</div>
				<?php if ($type_start !== 'hover') : ?>
				<span class="video-close-button fa fa-close"></span>
				<?php endif; ?>
			</div>
			<div class="iframe-video-title">
				<?php echo esc_html( $title ); ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
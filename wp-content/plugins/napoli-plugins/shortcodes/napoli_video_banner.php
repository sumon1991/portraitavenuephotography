<?php


vc_map(
	array(
		'name'            => 'Video Banner',
		'base'            => 'video_banner',
		'content_element' => true,
		'params'          => array(
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Preview Image', 'js_composer' ),
				'param_name' => 'preview',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Video link', 'js_composer' ),
				'description' => __( 'Insert your video link', 'js_composer' ),
				'param_name' => 'video_link',
				'value'      => ''
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Autoplay', 'js_composer' ),
				'param_name'       => 'autoplay',
				'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
				'std'  => 'off'
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Mute sound', 'js_composer' ),
				'param_name' => 'mute',
				'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
				'std'  => 'off'
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Showinfo', 'js_composer' ),
				'param_name'       => 'showinfo',
				'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
				'std'  => 'on'
			),

			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Video begins from (sec)', 'js_composer' ),
				'param_name' => 'start',
				'value'      => ''
			),

			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Video ends at (sec)', 'js_composer' ),
				'param_name' => 'end',
				'value'      => ''
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

class WPBakeryShortCode_video_banner extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'css'      => '',
			'el_class' => '',
			'preview' => '',
			'video_link' => '',
			'autoplay' => '0',
			'showinfo' => 'on',
			'mute' => 'off',
			'start' => '0',
			'end' => '0'
		), $atts ) );

		$video_params = array();

		$class = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );

		wp_enqueue_script( 'napoli_youtube', 'https://www.youtube.com/iframe_api', '', true );


		// for youtube

			$video_params = array(
				'enablejsapi' => 1,
				'autoplay' => $autoplay == 'on' ? 1 : 0 ,
				'loop' => 1,
				'controls' => 0 ,
				'showinfo' => $showinfo == 'on' ? 1 : 0 ,
				'start' => !empty($start)  ? $start : 0 ,
				'end' => !empty($end) ? $end : 0 ,
				'modestbranding' => 0,
				'rel' => 0,
			);

			$mute = ($mute == 'on') ? 1 : 0;


		$classAutoplay = $autoplay == 'on' ? ' play':'';
		$classAutoplayPause = $autoplay == 'on' ? ' start':'';

		$preview_url = !empty($preview) ? wp_get_attachment_url( $preview )  : '';

		ob_start();
		?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<div class="iframe-video banner-video youtube <?php echo esc_attr( $classAutoplay); ?>" data-type-start="click" data-mute="<?php echo esc_attr( $mute ); ?>" >
				<?php
					if (!empty($video_link)) {
						echo str_replace("?feature=oembed", "?feature=oembed&" . http_build_query ( $video_params ), wp_oembed_get($video_link));
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
					<a href="#" class="mute-button mute<?php echo esc_attr($mute); ?>"></a>
					<a href="#" class="play-button<?php echo esc_attr($classAutoplayPause); ?>"></a>
					<a href="#" class="full-button"></a>
				</div>

				<span class="video-close-button fa fa-close"></span>

			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
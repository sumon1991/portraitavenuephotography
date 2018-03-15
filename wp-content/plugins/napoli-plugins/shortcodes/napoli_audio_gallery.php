<?php
 

vc_map(
	array(
		'name'            => 'Audio Shortcode',
		'base'            => 'audio_shortcode',
		'content_element' => true,
		'params'          => array(
			array(
				'type' => 'napoli_file',
				'heading' => __('Sound file', 'js_composer'),
				'param_name' => 'napoli_file'
			),
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

class WPBakeryShortCode_audio_shortcode extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'css'      => '',
			'el_class' => '',
			'title' => '',
			'napoli_file' => '',
			'preview' => '',
		), $atts ) );

		$class = ( ! empty( $el_class ) ) ? $el_class : '';
		$class .= vc_shortcode_custom_css_class( $css, ' ' );

   		$preview_url = !empty($preview) ? wp_get_attachment_url( $preview )  : '';

		ob_start();
		?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<div class="iframe-video audio">
				<?php if (!empty($napoli_file)): ?>
					<button class="napoli-sound-btn "></button>
					<?php $mime_type = wp_check_filetype($napoli_file); ?>
					<audio class="napoli-audio-file" preload loop>
						<source src="<?php echo esc_url($napoli_file); ?>"
								type="<?php echo esc_attr($mime_type['type']); ?>">
					</audio>
				<?php endif;
				if ($preview_url) :
				echo napoli_the_lazy_load_flter( $preview_url, array(
				  'class' => 's-img-switch',
				  'alt'   => ''
				) );
				endif; ?>
			</div>
			<div class="iframe-video-title">
				<?php
				if(!empty($title)){
					echo esc_html( $title );
				} ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
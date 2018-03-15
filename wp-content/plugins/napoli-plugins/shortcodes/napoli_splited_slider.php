<?php
 

vc_map( array(
	'name'                    => esc_html__( 'Napoli Splited Slider', 'js_composer' ),
	'base'                    => 'napoli_splited_slider',
	'show_settings_on_create' => false,
	'description'             => esc_html__( 'Splited slider', 'js_composer' ),
	'params'                  => array(
		array(
			'type'        => 'attach_images',
			'heading'     => 'Images',
			'param_name'  => 'images',
			'admin_label' => true,
			'description' => 'Upload your images.'
		),
		array(
			'type'        => 'checkbox',
			'heading'     => 'Loop',
			'param_name'  => 'loop',
			'std'  => 'on',
			'value' => array( __( 'Yes', 'js_composer' ) => 'on' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => 'Height',
			'param_name'  => 'fullheight',
			'value'		  => array(
								'Fullheight'   => 'fullheight',
								'Custom'    	=> 'custom',
							),
		),
		array(
			'type'        => 'textfield',
			'heading'     => 'Custom Height',
			'param_name'  => 'height',
			'value' => '',
			'dependency'  => array( 'element' => 'fullheight', 'value' => array('custom') ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => 'Keyboard',
			'param_name'  => 'keyboard',
			'std'  => 'on',
			'value' => array( __( 'Yes', 'js_composer' ) => 'on' )
		),
		array(
			'type'        => 'checkbox',
			'heading'     => 'Controls',
			'param_name'  => 'controls',
			'value' => array( __( 'Yes', 'js_composer' ) => 'on' )
		),
		array(
			'type'        => 'textfield',
			'heading'     => 'Speed',
			'param_name'  => 'speed',
			'value' => '',
		),


	) //end params
) );


class WPBakeryShortCode_napoli_splited_slider extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'images'   => '',
			'loop' => 'on',
			'keyboard' => 'on',
			'fullheight' => 'fullheight',
			'height' => '',
			'speed' => '700',
			'controls' => '',
			'css'      => '',
			'el_class' => '',
		), $atts ) );

		// el class
		$css_classes = array(
			$this->getExtraClass( $el_class )
		);

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts );

		// custum css
		$css_class .= vc_shortcode_custom_css_class( $css, ' ' );

		// custum class
		$css_class .= ( ! empty( $css_class ) ) ? 'multiscroll-slider ' . $css_class : 'multiscroll-slider';

		$loop = (!empty($loop) && $loop == 'on' ) ? 1 : 0;
		$keyboard = (!empty($keyboard) && $keyboard == 'on' ) ? 1 : 0;
		$css_class .= !empty($fullheight) && $fullheight == 'fullheight'  ? ' fullheight' : ''; 
		

		$height = !empty($height) ? ' style="height:' . esc_attr( $height ) . 'px;"' : '';

		ob_start();

		if ( ! empty( $images ) ) : ?>
		<div class="<?php echo esc_attr( $css_class ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-loop="<?php echo esc_attr( $loop ); ?>" data-keyboard="<?php echo esc_attr( $keyboard ); ?>" <?php echo $height; ?>>
			<div class="multiscroll-slider-left">
				<div class="ms-left">
					<?php $images = explode( ',', $images ); 
					foreach ($images as $key => $image) : 
						if ($key%2 == 1)  continue;
						$attachment = get_post( $image );
					?>
		            <div class="ms-section ms-table">
		                <div class="ms-inner">
		                    <img src="<?php echo esc_url( wp_get_attachment_image_url( $image, 'large') ); ?>" class="s-img-switch" alt="<?php echo esc_attr( $attachment->post_title ); ?>">
		                </div>
		                <?php echo esc_html( $attachment->post_excerpt ); ?>
		            </div>
		       		<?php endforeach; ?>
				</div>
			</div>
			<div class="multiscroll-slider-right">
				<div class="ms-right">
		            <?php
					foreach ($images as $key => $image) : 
						if ($key%2 == 0)  continue;
						$attachment = get_post( $image );
					?>
		            <div class="ms-section ms-table">
		                <div class="ms-inner">
		                    <img src="<?php echo esc_url( wp_get_attachment_image_url( $image, 'large') ); ?>" class="s-img-switch" alt="<?php echo esc_attr( $attachment->post_title ); ?>">
		                </div>
		                <?php echo esc_html( $attachment->post_excerpt ); ?>
		            </div>
		       		<?php endforeach; ?>
				</div>
			</div>
			<?php if (!empty($controls)) : ?>
			<div class="scroll-btn down"></div>
			<div class="scroll-btn up"></div>
			<?php endif; ?>
		</div>
		<?php 
		endif;

		return ob_get_clean();

	}

}

<?php
if ( function_exists( 'vc_map' ) ) {
	vc_map(
		array(
			'name'                    => esc_html__( 'Pricing', 'js_composer' ),
			'base'                    => 'vc_pricing',
			'content_element'         => true,
			'show_settings_on_create' => true,
			'description'             => esc_html__( '', 'js_composer' ),
			'params'                  => array(
				array(
					'param_name'  => 'image',
					'type'        => 'attach_image',
					'description' => '',
					'heading'     => 'Image',
					'value'       => '',
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => 'Background color',
					'param_name' => 'bg_color',
					'value'      => '',
				),
				array(
					'param_name'  => 'color_mask',
					'type'        => 'colorpicker',
					'description' => '',
					'heading'     => 'Color Mask',
					'value'       => '',
				),
				array(
					'param_name'  => 'title',
					'type'        => 'textfield',
					'description' => '',
					'heading'     => 'Title',
					'value'       => '',
				),
				array(
					'param_name'  => 'subtitle',
					'type'        => 'textfield',
					'description' => '',
					'heading'     => 'Subtitle',
					'value'       => '',
				),
				array(
					'param_name'  => 'button_link',
					'type'        => 'textfield',
					'description' => '',
					'heading'     => 'Button Link',
					'value'       => '',
				),
				array(
					'param_name'  => 'button_text',
					'type'        => 'textfield',
					'description' => '',
					'heading'     => 'Button Text',
					'value'       => '',
				),
				array(
					'param_name'  => 'content',
					'type'        => 'textarea_html',
					'description' => '',
					'heading'     => 'Content',
					'value'       => '',
				),
				array(
					'type'        => 'textfield',
					'heading'     => 'Extra class name',
					'param_name'  => 'el_class',
					'description' => 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.',
					'value'       => '',
				),
				array(
					'type'       => 'css_editor',
					'heading'    => 'CSS box',
					'param_name' => 'css',
					'group'      => 'Design options',
				),
			)
			//end params
		)
	);
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
	/* Frontend Output Shortcode */

	class WPBakeryShortCode_vc_pricing extends WPBakeryShortCode {
		protected function content( $atts, $content = null ) {
			/* get all params */
			extract( shortcode_atts( array(
				'image'       => '',
				'bg_color'    => '',
				'color_mask'  => '',
				'title'       => '',
				'subtitle'    => '',
				'button_link' => '',
				'button_text' => '',
				'el_class'    => '',
				'css'         => '',

			), $atts ) );

			/* get custum css as class*/
			// el class
			$css_classes = array(
				$this->getExtraClass( $el_class )
			);

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts );

			// custum css
			$css_class .= vc_shortcode_custom_css_class( $css, ' ' );

			// custum class
			$css_class .= ( ! empty( $css_class ) ) ? ' ' . $css_class : '';

			$bg_color = isset($bg_color) && !empty($bg_color) ? 'style="background-color:' . $bg_color . ';"' : '';

			// start output
			ob_start(); ?>
			<div class="pricing-item <?php echo esc_attr( $css_class ); ?>" <?php echo $bg_color; ?>>
				<?php if ( ! empty( $image ) ) : ?>
					<div class="mask-image">
						<?php
						$image = wp_get_attachment_image_src( $image, 'large' );
						$image = is_array( $image ) ? $image[0] : 0;
						?>
						<?php
						echo napoli_the_lazy_load_flter( $image,
							array(
								'class' => 's-img-switch',
								'alt'   => ''
							)
						);
						?>
						<svg class="svg-mask" width="100%" height="100%" viewBox="0 0 200 323"
						     preserveAspectRatio="xMidYMid slice">
							<path <?php echo ! empty( $color_mask ) ? 'style="fill:' . esc_attr( $color_mask ) . ';"' : ''; ?>
								class="pricing_mask"
								d="M200,166V0h-82v60H41V0H0v67h118v92H0v164h83v-62h77v62h40v-69H82v-88H200z M125,30h66v129h-66V30z M76,295H10V166h66V295z"/>
							<path class="pricing-transparent-mask"
							      d="M41,0h77v60H41V0z M0,67h118v92H0V67z M82,166h118v88H82V166z M10,166h66v129H10V166z M125,30h66v129h-66 V30z M83,261h77v62H83V261z"/>
						</svg>
					</div>
				<?php endif; ?>
				<div class="pricing-info">
					<?php if ( ! empty( $subtitle ) ) : ?>
						<h4 class="subtitle"><?php echo esc_html( $subtitle ); ?></h4>
					<?php endif; ?>
					<?php if ( ! empty( $title ) ) : ?>
						<h3 class="title"><?php echo esc_html( $title ); ?></h3>
					<?php endif; ?>

					<div class="pricing-list">
						<?php echo wp_kses_post( $content ); ?>
					</div>

					<?php if ( ! empty( $button_link ) ) : ?>
						<a href="<?php echo esc_html( $button_link ); ?>"
						   class="a-btn-2"><?php echo esc_html( $button_text ); ?></a>
					<?php endif; ?>
				</div>
			</div>


			<?php
			// end output
			return ob_get_clean();
		}
	}
}

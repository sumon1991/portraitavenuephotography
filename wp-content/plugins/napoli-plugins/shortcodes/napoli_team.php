<?php
// ==========================================================================================
// TEAM                                                                                     -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Team', 'js_composer' ),
		'base'        => 'napoli_team',
		'description' => __( 'My team', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Type Gallery', 'js_composer' ),
				'param_name' => 'style',
				'value'      => array(
					'Default' => '',
					'Modern' => 'custom',
					'Fullheight' => 'fullheight',
				)
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Custom Height', 'js_composer' ),
				'param_name'  => 'custom_height',
				'dependency' => array( 'element' => 'style', 'value' => array('fullheight') ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Name', 'js_composer' ),
				'param_name' => 'name'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Position', 'js_composer' ),
				'param_name' => 'position'
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Photo', 'js_composer' ),
				'param_name' => 'image'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Facebook', 'js_composer' ),
				'param_name'  => 'social_fb',
				'value'       => '#',
				'description' => __( 'Enter facebook social link url.', 'js_composer' ),
				'group'       => 'Social URL'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Dribbble', 'js_composer' ),
				'param_name'  => 'social_dr',
				'value'       => '#',
				'description' => __( 'Enter dribbble social link url.', 'js_composer' ),
				'group'       => 'Social URL'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Pinterest', 'js_composer' ),
				'param_name'  => 'social_pnt',
				'value'       => '#',
				'description' => __( 'Enter pinterest social link url.', 'js_composer' ),
				'group'       => 'Social URL'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Twitter', 'js_composer' ),
				'param_name'  => 'social_tw',
				'value'       => '#',
				'description' => __( 'Enter twitter social link url.', 'js_composer' ),
				'group'       => 'Social URL'
			)
		)
	)
);


class WPBakeryShortCode_napoli_team extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {


		extract( shortcode_atts( array(
			'style'       => '',
			'custom_height' => '',
			'name'       => '',
			'position'   => '',
			'image'      => '',
			'social_fb'  => '#',
			'social_dr'  => '#',
			'social_tw'  => '#',
			'social_pnt' => '#',
			'controls'   => ''
		), $atts ) );

		$img = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';

		$css = '';
		$custom_height = is_numeric($custom_height) ? $custom_height . 'px' : $custom_height;
		$css .= !empty($custom_height) ? 'height:' . esc_attr( $custom_height ) . ';' : '';

		$style_attr = $style;
		if ($style == 'fullheight' && empty($custom_height)) {
			$style_attr .= ' full_height';
		}

		$css_attr = '';
		if ($style == 'fullheight' && !empty($css)) {
			$css_attr = ' style="' . $css . '"';
		}
		ob_start();
		?>
		<div class="team-member <?php echo esc_attr( $style_attr ); ?>" <?php echo $css_attr; ?>>
			
			<?php if (!empty($style) && $style == 'fullheight'): ?>
				<?php  
				echo napoli_the_lazy_load_flter( $img, array(
				  'class' => 's-img-switch',
				  'alt'   => ''
				) );
				?> 
				<div class="info">
					<h5 class="title"><?php echo esc_html( $name ); ?></h5>
					<h6 class="description"><?php echo esc_html( $position ); ?></h6>
					<?php if ( ! empty( $social_fb ) || ! empty( $social_dr ) || ! empty( $social_tw ) || ! empty( $social_pnt ) ) { ?>
					<div class="social">
						<div class="vertical-align text-center wrap">

							<?php if (!empty($social_fb)): ?>
							<a href="<?php echo esc_url( $social_fb ); ?>" target="_blank">
								<i class="fa fa-facebook"></i>
							</a>
							<?php endif; ?>

							<?php if (!empty($social_pnt)): ?>
							<a href="<?php echo esc_url( $social_pnt ); ?>" target="_blank">
								<i class="fa fa-pinterest-p"></i>
							</a>
							<?php endif; ?>

							<?php if (!empty($social_tw)): ?>
							<a href="<?php echo esc_url( $social_tw ); ?>" target="_blank">
								<i class="fa fa-twitter"></i>
							</a>
							<?php endif; ?>

							<?php if (!empty($social_dr)): ?>
							<a href="<?php echo esc_url( $social_dr ); ?>" target="_blank">
								<i class="fa fa-dribbble"></i>
							</a>
							<?php endif; ?>

						</div>
					</div>
				<?php } ?>
				</div>

			<?php else: ?>
			<div class="avatar">
				<?php  
				echo napoli_the_lazy_load_flter( $img, array(
				  'class' => 's-img-switch',
				  'alt'   => ''
				) );
				?>
				<?php if ( ! empty( $social_fb ) || ! empty( $social_dr ) || ! empty( $social_tw ) || ! empty( $social_pnt ) ) { ?>
					<div class="social">
						<div class="vertical-align text-center wrap">
						<?php if ( !empty($social_fb) ): ?>
						<a href="<?php echo esc_url( $social_fb ); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
						<?php endif; ?>
						<?php if ( !empty($social_pnt) ): ?>
						<a href="<?php echo esc_url( $social_pnt ); ?>" target="_blank"><i class="fa fa-pinterest-p"></i></a>
						<?php endif; ?>
						<?php if ( !empty($social_tw) ): ?>
						<a href="<?php echo esc_url( $social_tw ); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
						<?php endif; ?>
						<?php if ( !empty($social_dr) ): ?>
						<a href="<?php echo esc_url( $social_dr ); ?>" target="_blank"><i class="fa fa-dribbble"></i></a>
						<?php endif; ?>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="info">
				<h6 class="position"><?php echo esc_html( $position ); ?></h6>
				<h5 class="title"><?php echo esc_html( $name ); ?></h5>
			</div>

			<?php endif; ?>

		</div>
		<?php 
		return ob_get_clean();
	}

} 
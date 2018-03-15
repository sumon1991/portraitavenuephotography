<?php
 

vc_map( array(
	'name'                    => __( 'Skills', 'js_composer' ),
	'base'                    => 'napolins_skills',
	'content_element'         => true,
	'show_settings_on_create' => true,
	'description'             => __( 'Image, title, position, social links', 'js_composer' ),
	'params'                  => array(
		array(
			'type'       => 'textfield',
			'heading'    => __( 'Main title', 'js_composer' ),
			'param_name' => 'main_title',
		),
		array(
			'type'        => 'param_group',
			'heading'     => __( 'Values', 'js_composer' ),
			'param_name'  => 'skills',
			'description' => __( 'Enter values for skill - title and number.', 'js_composer' ),
			'value'       => urlencode( json_encode( array() ) ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Title', 'js_composer' ),
					'param_name'  => 'title',
					'description' => __( 'Add title for your skill.', 'js_composer' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Number', 'js_composer' ),
					'param_name'  => 'number',
					'description' => __( 'Only number.', 'js_composer' ),
				),

			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Extra class name', 'js_composer' ),
			'param_name'  => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'value'       => '',
		),
		array(
			'type'       => 'css_editor',
			'heading'    => __( 'CSS box', 'js_composer' ),
			'param_name' => 'css',
			'group'      => __( 'Design options', 'js_composer' ),
		),
	) //end params
) );

class WPBakeryShortCode_napolins_skills extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'main_title' => '',
			'skills'     => '',
			'el_class'   => '',
			'css'        => ''
		), $atts ) );


		// custum css
		$css_class = vc_shortcode_custom_css_class( $css, ' ' );

		// custum class
		$css_class .= ( ! empty( $el_class ) ) ? ' ' . $el_class : '';


		ob_start();

		?>

		<div class="skill-wrapper <?php echo esc_attr( $css_class ); ?>">
			<?php if ( ! empty( $main_title ) ) { ?>
				<h2 class="main-title"><?php echo esc_html( $main_title ); ?></h2>
			<?php } ?>

			<?php if ( ! empty( $skills ) ) {
				?>
				<div class="skills">
					<?php
					$skills = (array) vc_param_group_parse_atts( $skills );
					foreach ( $skills as $skill ) {

						if ( ! empty( $skill['title'] ) && ! empty( $skill['number'] ) && is_numeric( $skill['number'] ) ) { ?>

							<div class="skill" data-value="<?php echo esc_attr( $skill['number'] ); ?>">
								<div class="line">
									<div class="active-line"></div>
								</div>
								<span class="label-skill"><?php echo esc_html( $skill['title'] ); ?></span>
								<div class="value"><span class="counter" data-from="0" data-speed="1000"
								                         data-to="<?php echo esc_attr( $skill['number'] ); ?>">0</span>%
								</div>
								
							</div>

						<?php }
					}
					?>
				</div>
			<?php } ?>


		</div>

		<?php
		return ob_get_clean();
	}
}
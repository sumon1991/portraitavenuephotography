<?php
// ==========================================================================================
// TITLE AND SUBTITLE                                                                       -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Title and subtitle', 'js_composer' ),
		'base'        => 'napoli_title',
		'description' => __( 'Simple title and subtitle', 'js_composer' ),
		'category'    => __( 'Content', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title',
				'value'      => ''
			),
			array(
				'type'       => 'textarea',
				'heading'    => __( 'Subtitle', 'js_composer' ),
				'param_name' => 'subtitle',
				'value'      => ''
			),
			array(
				'type'        => 'dropdown',
				'heading'     => 'Style',
				'param_name'  => 'style',
				'value'		  => array(
									'Dafault'   => '',
									'Left'    	=> 'left',
								),
			),
		)
	)
);
class WPBakeryShortCode_napoli_title extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'title'    => '',
			'subtitle' => '',
			'style' => ''
		), $atts ) );

		ob_start(); ?>
		<div class="titles <?php echo esc_attr( $style ); ?>">
			<h2 class="title"><?php echo esc_html( $title ); ?></h2>
			<div class="subtitle"><?php echo esc_html( $subtitle ); ?></div>
		</div>
		<?php
		return ob_get_clean();

	}

}

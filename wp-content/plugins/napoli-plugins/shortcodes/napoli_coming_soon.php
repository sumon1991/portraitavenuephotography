<?php
 
if (function_exists('vc_map')) {

	vc_map( 
		array(
			'name'						=> esc_html__( 'Coming soon', 'js_composer' ),
			'base'						=> 'napoli_coming_soon',
			'content_element'			=> true,
			'show_settings_on_create'	=> true,
			'description'				=> esc_html__( '', 'js_composer'),
			'params'					=> array ( 
          array (
            'param_name' => 'title',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Title',
            'value' => '',
          ), 
          array (
            'param_name' => 'subtitle',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Subtitle',
            'value' => '',
          ), 
          array (
            'param_name' => 'date',
            'type' => 'wpc_date',
            'description' => '',
            'heading' => 'Date',
            'value' => '',
          ), 
          array (
            'param_name' => 'img',
            'type' => 'attach_image',
            'description' => '',
            'heading' => 'Image',
            'value' => '',
          ), 
          array (
            'param_name' => 'url_button',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Url Button',
            'value' => '',
          ), 
          array (
            'param_name' => 'label_button',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Label Button',
            'value' => '',
          ), 

          array (
            'param_name' => 'days',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Days',
            'value' => '',
            'group' => 'Desktop',
          ), 
          array (
            'param_name' => 'hours',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Hours',
            'value' => '',
            'group' => 'Desktop',
          ), 
          array (
            'param_name' => 'minutes',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Minutes',
            'value' => '',
            'group' => 'Desktop',
          ), 
          array (
            'param_name' => 'seconds',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Seconds',
            'value' => '',
            'group' => 'Desktop',
          ), 

          array (
            'param_name' => 'days_mobile',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Days',
            'value' => '',
            'group' => 'Mobile',
          ), 
          array (
            'param_name' => 'hours_mobile',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Hours',
            'value' => '',
            'group' => 'Mobile',
          ), 
          array (
            'param_name' => 'minutes_mobile',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Minutes',
            'value' => '',
            'group' => 'Mobile',
          ), 
          array (
            'param_name' => 'seconds_mobile',
            'type' => 'textfield',
            'description' => '',
            'heading' => 'Seconds',
            'value' => '',
            'group' => 'Mobile',
          ),
          array (
            'type' => 'textfield',
            'heading' => 'Extra class name',
            'param_name' => 'el_class',
            'description' => 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.',
            'value' => '',
          ), 
          array (
            'type' => 'css_editor',
            'heading' => 'CSS box',
            'param_name' => 'css',
            'group' => 'Design options',
          ),
      ),
      'admin_enqueue_js' => array(
        esc_url( 'cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.js' ),
      ),
      'admin_enqueue_css' => array(
        esc_url( 'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' ),
      )
			//end params
		) 
	);
}
if (class_exists('WPBakeryShortCode')) {
	/* Frontend Output Shortcode */
	class WPBakeryShortCode_napoli_coming_soon extends WPBakeryShortCode {
		protected function content( $atts, $content = null ) {
			/* get all params */
			extract( shortcode_atts( array(
						'title'	=> '',
						'subtitle'	=> '',
						'date'	=> '',
            'days' => '',
            'hours' => '',
            'minutes' => '',
            'seconds' => '',
            'days_mobile' => '',
            'hours_mobile' => '',
            'minutes_mobile' => '',
            'seconds_mobile' => '',
						'img'	=> '',
						'url_button'	=> '',
						'label_button'	=> '',
						'el_class'	=> '',
						'css'	=> '',
			
			), $atts ) );

      // el class
      $css_classes = array(
        $this->getExtraClass( $el_class )
      );

      $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts );

      // custum css
      $css_class .= vc_shortcode_custom_css_class( $css, ' ' );

      // custum class
      $css_class .= ( ! empty( $css_class ) ) ? ' ' . $css_class : '';

			
			// start output
			ob_start(); ?>
			<div class="<?php echo esc_attr( $css_class ); ?>">
  				<div class="coming-page-wrapper">
          		<?php if(!empty($title)) : ?>
          		  <h2 class="title">
              <?php echo esc_html($title); ?></h2>
              
              <?php endif; ?>
              <?php if(!empty($subtitle)) : ?>
      		        <h3 class="subtitle"><?php echo esc_html($subtitle); ?></h3>
      	      <?php endif; ?>

          		<div class="coming-soon-wrap">
                <?php $random = substr( md5(rand()), 0, 7); ?>
                <style type="text/css">
                  .svgRect { 
                    -webkit-mask: url(#<?php echo esc_attr($random); ?>);
                    mask: url(#<?php echo esc_attr($random); ?>);
                  } 
                </style>
                <section class="coming-soon-bg">
                  <?php
                    $img = wp_get_attachment_image_src( $img, 'full' ); 
                    $img = is_array($img) ? $img[0] : $img;
                  ?>
                  <?php 
                  echo napoli_the_lazy_load_flter( $img, array(
                    'class' => 's-img-switch',
                    'alt'   => ''
                  ) );
                  ?> 
                </section>
          			<div class="coming-soon" data-end="<?php echo esc_html($date); ?>">
                  <svg class="svg" width="100%" height="100%">
                     <defs>
                       <mask id="<?php echo esc_attr($random); ?>" class="mask" x="0" y="0"  >
                         <rect class="maskRect" x="0" y="0" width="100%" height="100%" />
                         <text textAnchor="middle" class="count count-days" x="12.5%" y="98%">%D</text>
                         <text textAnchor="middle" class="count count-point1" x="25%" y="98%">:</text>
                         <text textAnchor="middle" class="count count-hours" x="37.5%" y="98%">%H</text>
                         <text textAnchor="middle" class="count count-point2" x="50%"  y="98%">:</text>
                         <text textAnchor="middle" class="count count-mins" x="62.5%" y="98%">%M</text>
                         <text textAnchor="middle" class="count count-point3" x="75%"  y="98%">:</text>
                         <text textAnchor="middle" class="count count-secs" x="87.5%" y="98%">%S</text>
                       </mask>
                     </defs>
                     <rect class="svgRect" x="0" y="0" width="100%" height="100%" />
                   </svg>
                </div>
          			<ul class="coming-soon-descr">
                    <?php if (!empty($days)): ?>
                    <li data-mobile="<?php echo esc_attr( $days_mobile ); ?>" data-desktop="<?php echo esc_attr($days ); ?>"></li>
                    <?php endif; ?>
                    <?php if (!empty($hours)): ?>
                    <li data-mobile="<?php echo esc_attr( $hours_mobile ); ?>" data-desktop="<?php echo esc_attr($hours ); ?>"></li>
                    <?php endif; ?> 
                    <?php if (!empty($minutes)): ?>
                    <li data-mobile="<?php echo esc_attr( $minutes_mobile ); ?>" data-desktop="<?php echo esc_attr($minutes ); ?>"></li>
                    <?php endif; ?>  
                    <?php if (!empty($seconds)): ?>
                    <li data-mobile="<?php echo esc_attr( $seconds_mobile ); ?>" data-desktop="<?php echo esc_attr($seconds ); ?>"></li>
                    <?php endif ?>    
                </ul>
          		</div>

      		    <a href="<?php echo esc_html($url_button); ?>" class="a-btn-2"><?php echo esc_html($label_button); ?></a>
          </div>
			</div>
			<?php
			// end output
			return ob_get_clean();
		}
	}
}

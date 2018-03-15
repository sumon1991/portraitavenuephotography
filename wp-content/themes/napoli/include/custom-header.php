<?php
/*
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Napoli
 */

if ( ! function_exists( 'napoli_custom_header_setup' ) ) :
	/**
	 * Set up the WordPress core custom header feature.
	 *
	 * @uses napoli_header_style()
	 */
	function napoli_custom_header_setup() {
		add_theme_support( 'custom-header', apply_filters( 'napoli_custom_header_args', array(
			'default-image'      => '',
			'default-text-color' => '131313',
			'width'              => 1000,
			'height'             => 250,
			'flex-height'        => true,
			'wp-head-callback'   => 'napoli_header_style',
		) ) );


		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'napoli_custom_background_args', array(
			'default-color' => 'fff',
			'default-image' => '',
		) ) );

	}


endif;
add_action( 'after_setup_theme', 'napoli_custom_header_setup' );

if ( ! function_exists( 'napoli_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see napoli_custom_header_setup().
	 */
	function napoli_header_style() {
		$header_text_color = get_header_textcolor();
		$header_image      = get_header_image();


		if ( $header_image ) : ?>
			<style type="text/css">
				.header_top_bg,
				header#right-menu {
					background-image: url(<?php echo esc_url( $header_image ); ?>);
					background-position: center;
					background-size: cover;
					background-repeat: no-repeat;
				}

				header, header.right-menu, #topmenu {
					background-color: transparent;
				}
			</style>
			<?php
		endif;

		// If we get this far, we have custom styles. Let's do this.
		if ( $header_text_color != '131313' ) : ?>
			<style type="text/css">
				#topmenu ul li a,
				header.right-menu a,
				#topmenu {
					color: # <?php echo esc_attr( $header_text_color ); ?>;
				}
			</style>
		<?php endif;

	}
endif;

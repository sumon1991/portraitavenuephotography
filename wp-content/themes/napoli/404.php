<?php
/**
 * 404 Page
 *
 * @package napoli
 * @since 1.0
 *
 */

get_header();
?>
	<div class="container-fluid no-padd error-height">
		<div class="hero-inner bg-cover">

			<?php if ( cs_get_option( 'image_404' ) ): ?>
				<?php
				echo napoli_the_lazy_load_flter( cs_get_option( 'image_404' ), array(
				  'class' => 's-img-switch',
				  'alt'   => esc_attr__( '404 image', 'napoli' )
				) );
				?>
			<?php endif; ?>
			<div class="overlay overlay-dark-2x"></div>
			<div class="fullheight text-light text-center">
				<div class="vertical-align">
					<h1 class="bigtext margin-lg-10t"><?php esc_html_e( '404 error', 'napoli' ); ?></h1>
					<h6 class="title bold font-1 text-uppercase"><?php echo esc_html( cs_get_option( 'error_title' ) ); ?></h6>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="margin-lg-15t a-btn"><?php echo esc_html( cs_get_option( 'error_btn_text' ) ); ?></a>
				</div>
			</div>
		</div>
	</div>
<?php get_footer();

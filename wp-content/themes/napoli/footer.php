<?php
/**
 *
 * Footer
 * @since 1.0.0
 * @version 1.0.0
 *
 */
 

// page options
$meta_data = get_post_meta( get_the_ID(), '_custom_page_options', true );
$class_footer = !empty($meta_data['fixed_transparent_footer']) || is_404() ? ' fix-bottom' : '';
?>


<footer id="footer" class="<?php echo esc_attr( $class_footer ); ?>">
	<div class="container no-padd">

		<div class="copyright">
			<?php
			$footer_text = cs_get_option( 'footer_text' ) ? cs_get_option( 'footer_text' ) : ' ';
			if ( ! function_exists( 'cs_framework_init' ) ) {
				$footer_text = esc_html__( 'Napoli &copy; ', 'napoli' ) . date( 'Y' ) . esc_html__( '. Development with love by ', 'napoli' ) . ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'FOXTHEMES', 'napoli' ) . '</a>';
			}
			echo wp_kses_post( $footer_text );
			?>
		</div>
		<?php if ( cs_get_option( 'footer_social' ) ) { ?>
			<div class="social-links">
				<?php foreach ( cs_get_option( 'footer_social' ) as $link ) { ?>
					<a href="<?php echo esc_url( $link['footer_social_link'] ); ?>" target="_blank"><i
							class="<?php echo esc_attr( $link['footer_social_icon'] ); ?>"></i></a>
				<?php } ?>
			</div>
		<?php } ?>

	</div>

</footer>


</div>
<?php
$classCopy = cs_get_option('enable_copyright') && !cs_get_option('text_copyright') ? '' : 'copy';
if ( cs_get_option('enable_copyright') ): ?>
<div class="napoli_copyright_overlay <?php echo esc_attr($classCopy); ?>">
	<div class="napoli_copyright_overlay.active">
		<?php if( cs_get_option('text_copyright') ) : ?>
		<div class="napoli_copyright_overlay_text">
			<?php echo wp_kses_post(cs_get_option('text_copyright')); ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
<div class="fullview">
	<div class="fullview__close"></div>
</div>

<?php if(cs_get_option('page_scroll_top') == true){ ?>
	<div class="scroll-top-button">
		<a href="#" id="back-to-top">&uarr;</a>
	</div>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>
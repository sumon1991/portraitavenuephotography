<?php
/**
 * Custom Page Template
 *
 * @package napoli
 * @since 1.0
 *
 */
get_header();
$page_meta = get_post_meta( $post->ID, '_custom_page_options' );
if ( cs_get_option( 'page_navigation' ) == true ) {

	$pages = napoli_get_pages_for_navi();

	$current = array_search( $post->ID, $pages );

	$prevID = ( ! empty( $pages[ $current - 1 ] ) ) ? $pages[ $current - 1 ] : $pages[ count( $pages ) - 1 ];

	$nextID = ( ! empty( $pages[ $current + 1 ] ) ) ? $pages[ $current + 1 ] : '';


	if ( ! empty( $prevID ) ) {
		$prev_post_title = get_the_title( $prevID );
		$prev_title      = implode( ' ', preg_split( '//u', $prev_post_title, - 1, PREG_SPLIT_NO_EMPTY ) );
		$prev_title      = str_replace( "   ", " &nbsp; ", $prev_title ); ?>
		<a class="side-link left animsition-link" href="<?php echo esc_url( get_page_link( $prevID ) ); ?>"
		   data-animsition-out="fade-out-right-sm">
			<div class="side-arrow"></div>
			<div class="side-title"><?php echo esc_html( $prev_title ); ?></div>
		</a>
	<?php }

	if ( ! empty( $nextID ) ) {
		$next_post_title = get_the_title( $nextID );
		$next_title      = implode( ' ', preg_split( '//u', $next_post_title, - 1, PREG_SPLIT_NO_EMPTY ) );
		$next_title      = str_replace( "   ", " &nbsp; ", $next_title );
		?>
		<a class="side-link right animsition-link" href="<?php echo esc_url( get_page_link( $nextID ) ); ?>"
		   data-animsition-out="fade-out-left-sm">
			<div class="side-arrow"></div>
			<div class="side-title"><?php echo esc_html( $next_title ); ?></div>
		</a>
		<?php
	}
}

$protected = '';

if ( post_password_required() ) {
	$protected = 'protected-page';
}


while ( have_posts() ) : the_post();
	$content = get_the_content();
	if ( ! strpos( $content, 'vc_' ) ) { ?>
		<div class="single-post">
				<?php $equal = function_exists('is_woocommerce') && !is_woocommerce() && !is_cart() && !is_checkout() ? 'equal-height' : ''; ?>
				<div class="container <?php echo esc_attr( $equal ); ?> no-padd <?php echo esc_attr( $protected ); ?>">
					<div class="row">
						<div class="col-xs-12">
							<?php if ( function_exists('is_checkout') && get_the_title() && (!function_exists('is_cart') || !is_cart() && !is_checkout() ) ) { ?>
								<?php if ( post_password_required() ) {
									$thumb = get_the_post_thumbnail( $post->ID, 'full');
									if(!empty($thumb)){ ?>
										<div class="thumb-wrap-protected">
											<?php echo $thumb; ?>
										</div>
									<?php }

									the_title( '<h3 class="title protected-title">', '</h3>' ); ?>
								<?php } else { ?>
									<?php the_title( '<h3 class="title no-vc">', '</h3>' ); ?>
								<?php } ?>
							<?php } ?>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			<?php 
			if ( comments_open() ) { ?>
				<div class="comments container no-padd-md">
					<?php comments_template( '', true ); ?>
				</div>
			<?php } ?>
		</div>
	<?php } else { ?>
		<?php $class_container = !empty($page_meta[0]['disable_container_padding']) ? ' no-padd' : '';  ?>
		<div class="container<?php echo esc_attr( $class_container ); ?>">
			<div class="hero">
				<?php the_content(); ?>
			</div>
		</div>
	<?php }
endwhile;
get_footer();
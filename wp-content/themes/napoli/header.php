<?php
/**
 *
 * The Header for our theme
 * @since 1.0.0
 * @version 1.0.0
 *
 */
$menu_class = ( cs_get_option( 'menu_style' ) && cs_get_option( 'menu_style' ) == 'right' ) ? 'right-menu' : 'top-menu';
$menu_class = apply_filters( 'napoli_menu_style', $menu_class );

// page options
$meta_data = get_post_meta( get_the_ID(), '_custom_page_options', true );
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- MAIN_WRAPPER -->
<?php 
$class_animsition = 'animsition';
if (cs_get_option( 'napoli_disable_preloader' )) {
	$class_animsition = '';
} ?>
<div class="main-wrapper <?php echo esc_attr( $class_animsition ); ?>">
	<?php
	$fixed_menu_class = cs_get_option( 'fixed_menu' ) || is_404() ? ' enable_fixed' : '';
	$fixed_menu_class .= !empty($meta_data['fixed_transparent_header']) || is_404() ? ' header_trans-fixed' : '';
	?>
	<div class="header_top_bg <?php echo esc_attr($fixed_menu_class) ?>">
		<div class="container no-padd">
			<div class="row">
				<div class="col-xs-12">

					<!-- HEADER -->
					<header class="<?php echo esc_attr( $menu_class ); ?>">
						<!-- LOGO -->
						<?php napoli_site_logo(); ?>
						<!-- /LOGO -->

						<!-- MOB MENU ICON -->
						<a href="#" class="mob-nav">
							<i class="fa fa-bars"></i>
						</a>
						<!-- /MOB MENU ICON -->

						<!-- NAVIGATION -->
						<nav id="topmenu">
							<?php napoli_custom_menu(); ?>

							<?php $hidden_class = ! empty( $hidden_class ) ? $hidden_class : '';
								if ( cs_get_option( 'header_social' ) ) { ?>
								<div class="napoli-top-social">
									<span class="social-icon fa fa-share-alt"></span>
									<ul class="social <?php echo esc_attr( $hidden_class ); ?>">
										<?php foreach ( cs_get_option( 'header_social' ) as $link ) { ?>
											<li><a href="<?php echo esc_url( $link['header_social_link'] ); ?>" target="_blank"><i class="<?php echo esc_attr( $link['header_social_icon'] ); ?>"></i></a>
											</li>
										<?php } ?>
									</ul>
								</div>
								<?php }

							if ( function_exists('WC') ) {
								if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
								 
								    $count = WC()->cart->cart_contents_count;
								    ?>
								    <div class="mini-cart-wrapper">
								    	<a class="napoli-shop-icon fa fa-shopping-cart" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart','napoli' ); ?>"> 
										<?php  if ( $count > 0 ) {  ?>
									    <div class="cart-contents">
					        		    	<span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
					        		    </div>
									    <?php } ?></a>
										<?php echo napoli_mini_cart(); ?>
									</div>
								<?php } } ?>


						</nav>
						<!-- NAVIGATION -->

					</header>

				</div>
			</div>

		</div>
	</div>
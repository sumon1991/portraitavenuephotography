<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$gallery = $product->get_gallery_image_ids();
?>
<div class="napoli_images">
	<?php if ( has_post_thumbnail() || count( $gallery ) > 0 ) {
	    
	    if ( count( $gallery ) > 0 ) {
	    	?>
	    	<div class="swiper-container" data-autoplay="3000" data-touch="1"  data-slides-per-view="1" data-loop="1" data-speed="1000">
	    		<div class="swiper-wrapper">
		    	<?php
		        foreach ( $gallery as $item ) {
		            $image_url = wp_get_attachment_image_url( $item, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
		            echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="swiper-slide s-back-switch"><a class="popup-image" href="%s"  data-size="600x450"><img src="%s" class="s-img-switch" alt="" /></a></div>', $image_url, $image_url ), $post->ID );
		        }
		        ?>
		    	</div>
			    <div class="pagination"></div>
			    <div class="slide-prev"></div>
			    <div class="slide-next"></div>
			</div>
		   	<?php
	    } else {
	    	if ( has_post_thumbnail() ) {
	    	    $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
	    	    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<figure><a href="%s" class="popup-image" data-size="600x450">%s</a></figure>', $props['url'], get_the_post_thumbnail() ), $post->ID );
	    	}
	    }
	} else {
	    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<figure><img src="%s" data-size="600x450" alt="%s" /></figure>', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'napoli' ) ), $post->ID );
	} ?>
 
	<?php if ( $product->is_on_sale() ) : ?>

		<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>

	<?php endif; ?>

</div>

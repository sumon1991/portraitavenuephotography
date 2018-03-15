<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $post;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$class_column = cs_get_option('products_per_row') ? 'col-md-' . cs_get_option('products_per_row') : 'col-md-4';
?>
<li <?php post_class($class_column); ?>>

	<div class="napoli-prod-list-image s-back-switch">

		<?php if ( $product->is_on_sale() ) : ?>

			<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>

		<?php endif;  

		$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );

		if ( has_post_thumbnail() ) {
			$props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			echo get_the_post_thumbnail( $post->ID, $image_size, array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
				'class'  => 's-img-switch',
			) );
		} elseif ( wc_placeholder_img_src() ) {
			echo wc_placeholder_img( $image_size );
		}

		?>
		<div class="product-links-wrapp">
			<div class="napoli-add-to-cart">
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			</div>
			<a href="<?php the_permalink(); ?>" class="napoli-link">
				<?php esc_html_e('view', 'napoli'); ?>
			</a>
		</div>
	</div>

	<div class="category-product">
		<?php echo wc_get_product_category_list( ', ' ); ?>
	</div>

	<?php
	/**
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	?>
	<a href="<?php the_permalink(); ?>"><?php do_action( 'woocommerce_shop_loop_item_title' ); ?></a>

    <?php
	/**
	 *
	 * @include woocommerce price product
	 */
	 wc_get_template( 'loop/price.php' );
	?>
</li>

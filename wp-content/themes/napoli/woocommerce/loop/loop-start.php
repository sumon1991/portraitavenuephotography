<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     2.0.0
 */

// Style product list
$menu_class = ( cs_get_option( 'products_list_style' ) && cs_get_option( 'products_list_style' ) == 'modern' ) ? 'modern' : 'default';

switch (cs_get_option('products_per_row')) {
	case '3':
		$class_wrapper = ' gutt-col-4';
		break;
	case '6':
		$class_wrapper = ' gutt-col-2';
		break;
	default:
		$class_wrapper = ' gutt-col-3';
		break;
}

?>

<ul class="products <?php echo esc_attr( $menu_class ); echo esc_attr($class_wrapper);  ?>">

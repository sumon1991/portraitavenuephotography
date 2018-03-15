<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Single no-padd class
$no_padd_product = ( is_shop() ) ? ' no-padd' : '';

$no_padd_category = !is_product() ? ' no-padd' : '';

$class_col = 'col-md-12' . $no_padd_category;
if ( ! function_exists( 'cs_framework_init' ) || cs_get_option('enable_sidebar_ecommerce') ) {
	$class_col = 'col-md-8 	';
}
?>
<div id="container" class="container no-padd">
<div class="row">
<div class="<?php echo esc_attr( $class_col . $no_padd_product ); ?> "><div id="content" role="main">
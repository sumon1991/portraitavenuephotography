<?php
/**
 * Filters for lazy load (etc)
 *
 * @package eventine
 * @since 1.0.0
 *
 */

 
if (!function_exists('is_cart')) {
	function is_cart($value='')
	{
		return false;
	}
}

add_filter( 'wp_get_attachment_image_attributes', 'napoli_lazy_load' );
if ( ! function_exists( 'napoli_lazy_load' ) ) {
	function napoli_lazy_load( $data ) {
			if (
				cs_get_option( 'enable_lazy_load' ) &&
				!is_admin() &&
				(!is_cart() || !is_woocommerce())
			) {
			$uri_img = 'data:image/gif;base64,R0lGODdhAQABAIAAAAAAAMzMzCwAAAAAAQABAAACAkQBADs=';
			$data['data-lazy-src'] = esc_url( $data['src'] );
			unset( $data['srcset'] );
			unset( $data['sizes'] );
			$data['src'] = $uri_img;
		}

		return apply_filters( 'napoli_lazy_load', $data );
	}
}

if ( ! function_exists( 'napoli_the_lazy_load_flter' ) ) {
	function napoli_the_lazy_load_flter( $id, $attr = array(), $state = true, $size = 'full', $uri_img = '') {

		if (!isset($id)) {
			return "";
		}

		if ( empty($uri_img) ) {
			$uri_img = 'data:image/gif;base64,R0lGODdhAQABAIAAAAAAAMzMzCwAAAAAAQABAAACAkQBADs=';
		}

		if (is_numeric($id)) {
			$id = wp_get_attachment_image_src($id, $size );
		} else {
			$id = array($id,'','');
		}
		if (!cs_get_option( 'enable_lazy_load' )){
			$state = false;
		}
			$default_attr = array(
			'data-lazy-src' => esc_url($id[0]),
			'src'     => $uri_img,
			'class'     => 's-img-switch',
			'width'     => $id[1],
			'height' => $id[2],
		);

		$attr = wp_parse_args( $attr, $default_attr );

		if ( !$state ) {
			unset($attr['data-lazy-src']);
			$attr['src'] = esc_url($id[0]);
		}

		$attr = apply_filters('prefix_image_lazy_load',$attr );

		$attr = array_map( 'esc_attr', $attr );
		$html = '<img';
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';

		return $html;
	}
}

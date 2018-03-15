<?php
 

function cr_get_row_offset( $pref, $suf, $max = 50, $step = 5 ) {
	$ar = array();
	for ( $i = 0; $i < $max + $step; $i += $step ) {
		$ar[ $i . 'px' ] = $pref . '-' . $i . $suf;
	}

	return array_merge( array( 'Default' => 'none' ), $ar );
}

$responsive_classes = array(
	array(
		'type'       => 'checkbox',
		'heading'    => __( 'Enable Ovarlay', 'js_composer' ),
		'param_name' => 'enable_ovarlay',
		'value'      => ''
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Desctop margin top', 'js_composer' ),
		'param_name' => 'desctop_mt',
		'value'      => cr_get_row_offset( 'margin-lg', 't', 80 ),
		'group'      => 'Responsive Margins'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Desctop margin bottom', 'js_composer' ),
		'param_name' => 'desctop_mb',
		'value'      => cr_get_row_offset( 'margin-lg', 'b', 80 ),
		'group'      => 'Responsive Margins',
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Tablets margin top', 'js_composer' ),
		'param_name' => 'tablets_mt',
		'value'      => cr_get_row_offset( 'margin-sm', 't' ),
		'group'      => 'Responsive Margins'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Tablets margin bottom', 'js_composer' ),
		'param_name' => 'tablets_mb',
		'value'      => cr_get_row_offset( 'margin-sm', 'b' ),
		'group'      => 'Responsive Margins'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Mobile margin top', 'js_composer' ),
		'param_name' => 'mobile_mt',
		'value'      => cr_get_row_offset( 'margin-xs', 't' ),
		'group'      => 'Responsive Margins'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Mobile margin bottom', 'js_composer' ),
		'param_name' => 'mobile_mb',
		'value'      => cr_get_row_offset( 'margin-xs', 'b' ),
		'group'      => 'Responsive Margins'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Desctop padding top', 'js_composer' ),
		'param_name' => 'desctop_pt',
		'value'      => cr_get_row_offset( 'padding-md', 't', 80 ),
		'group'      => 'Responsive Paddings'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Desctop padding bottom', 'js_composer' ),
		'param_name' => 'desctop_pb',
		'value'      => cr_get_row_offset( 'padding-md', 'b', 80 ),
		'group'      => 'Responsive Paddings',
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Tablets padding top', 'js_composer' ),
		'param_name' => 'tablets_pt',
		'value'      => cr_get_row_offset( 'padding-sm', 't' ),
		'group'      => 'Responsive Paddings'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Tablets padding bottom', 'js_composer' ),
		'param_name' => 'tablets_pb',
		'value'      => cr_get_row_offset( 'padding-sm', 'b' ),
		'group'      => 'Responsive Paddings'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Mobile padding top', 'js_composer' ),
		'param_name' => 'mobile_pt',
		'value'      => cr_get_row_offset( 'padding-xs', 't' ),
		'group'      => 'Responsive Paddings'
	),
	array(
		'type'       => 'dropdown',
		'heading'    => __( 'Mobile padding bottom', 'js_composer' ),
		'param_name' => 'mobile_pb',
		'value'      => cr_get_row_offset( 'padding-xs', 'b' ),
		'group'      => 'Responsive Paddings'
	),
);

if ( function_exists( 'vc_add_params' ) ) {
	vc_add_params( 'vc_row', $responsive_classes );
}

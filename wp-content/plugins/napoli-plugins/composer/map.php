<?php

include_once( EF_ROOT . '/composer/params.php' );

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
}

if ( !function_exists('napoli_categories')) {
	function napoli_categories()
	{
		return array();
	}
}
if ( !function_exists('napoli_element_values')) {
	function napoli_element_values()
	{
		return array();
	}
}



// ==========================================================================================
// VIMEO                                                                                  -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Vimeo', 'js_composer' ),
		'base'        => 'napoli_vimeo',
		'description' => __( 'Vimeo video player', 'js_composer' ),
		'category'    => __( 'Media', 'js_composer' ),
		'params'      => array(
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Vimeo Video ID', 'js_composer' ),
				'param_name'  => 'url',
				'description' => __( 'Add vimeo video id e.g 87701971', 'js_composer' )
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Autoplay video?', 'js_composer' ),
				'param_name' => 'autoplay',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
			)
		)
	)
);




// ==========================================================================================
// ABOUT SECTION                                                                            -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'About section', 'js_composer' ),
		'base'        => 'napoli_about',
		'description' => __( 'Section with image, text and button', 'js_composer' ),
		'category'    => __( 'Content', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Subtitle', 'js_composer' ),
				'param_name' => 'subtitle'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __( 'Description', 'js_composer' ),
				'param_name' => 'content',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Link text', 'js_composer' ),
				'param_name' => 'link_text'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Link url', 'js_composer' ),
				'param_name' => 'link_url'
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Person image', 'js_composer' ),
				'param_name' => 'image'
			),
		)
	)
);





// ==========================================================================================
// CUSTOM TEXT BLOCK                                                                                  -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Custom text block', 'js_composer' ),
		'base'        => 'napoli_custom_text_block',
		'description' => __( 'Section with text, quote and button (with paddings)', 'js_composer' ),
		'category'    => __( 'Content', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Heading for title', 'js_composer' ),
				'param_name' => 'size',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6'
				)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Subtitle', 'js_composer' ),
				'param_name' => 'subtitle',
				'value'      => ''
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __( 'Text', 'js_composer' ),
				'param_name' => 'content',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button text', 'js_composer' ),
				'param_name' => 'btn_text',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button URL', 'js_composer' ),
				'param_name' => 'btn_url',
				'value'      => ''
			)
		)
	)
);

// ==========================================================================================
// SIMPLE TEXT BLOCK                                                                                  -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Simple text block', 'js_composer' ),
		'base'        => 'napoli_simple_text_block',
		'description' => __( 'Section with text, quote and button (without paddings)', 'js_composer' ),
		'category'    => __( 'Content', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Heading for title', 'js_composer' ),
				'param_name' => 'size',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6'
				)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Subtitle', 'js_composer' ),
				'param_name' => 'subtitle',
				'value'      => ''
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __( 'Text', 'js_composer' ),
				'param_name' => 'content',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button text', 'js_composer' ),
				'param_name' => 'btn_text',
				'value'      => ''
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button URL', 'js_composer' ),
				'param_name' => 'btn_url',
				'value'      => ''
			)
		)
	)
);



// ==========================================================================================
// SIMPLE SLIDER                                                                                -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Simple slider', 'js_composer' ),
		'base'        => 'napoli_simple_slider',
		'category'    => __( 'Media', 'js_composer' ),
		'description' => __( 'Image slider', 'js_composer' ),
		'params'      => array(
			array(
				'type'        => 'attach_images',
				'heading'     => __( 'Slides', 'js_composer' ),
				'param_name'  => 'images',
				'description' => __( 'Images for sliding.', 'js_composer' ),
				'value'       => ''
			)
		)
	)
);


// ==========================================================================================
// MAP                                                                                      -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Map', 'js_composer' ),
		'base'        => 'napoli_map',
		'icon'        => 'icon-wpb-map-pin',
		'description' => __( 'Google maps block', 'js_composer' ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Latitude', 'js_composer' ),
				'param_name' => 'latitude',
				'value'      => '51.5255069'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Longitude', 'js_composer' ),
				'param_name' => 'longitude',
				'value'      => '-0.0836207'
			),
			array(
				'type'        => 'attach_image',
				'heading'     => __( 'Marker', 'js_composer' ),
				'param_name'  => 'marker',
				'description' => 'Map marker image.'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Map zoom', 'js_composer' ),
				'param_name'  => 'zoom',
				'description' => 'Map zooming value. Max - 19, min - 0.',
				'value'       => 14
			),
			array(
				'type'       => 'textarea',
				'heading'    => __( 'Marker text', 'js_composer' ),
				'param_name' => 'marker_text'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Google api key', 'js_composer' ),
				'param_name' => 'google_api_key'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 't1_title',
				'value'      => 'Office',
				'group'      => 'Address'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'First text line', 'js_composer' ),
				'param_name' => 't1_text1',
				'value'      => 'Via Cesare Rosaroll, 118',
				'group'      => 'Address'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Second text line', 'js_composer' ),
				'param_name' => 't1_text2',
				'value'      => '80139 Napoli',
				'group'      => 'Address'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 't2_title',
				'value'      => 'Phone',
				'group'      => 'Phones'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'First text line', 'js_composer' ),
				'param_name' => 't2_text1',
				'value'      => '+789 558 69 85',
				'group'      => 'Phones'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Second text line', 'js_composer' ),
				'param_name' => 't2_text2',
				'value'      => '+789 023 58 96',
				'group'      => 'Phones'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 't3_title',
				'value'      => 'Emails',
				'group'      => 'Emails'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'First text line', 'js_composer' ),
				'param_name' => 't3_text1',
				'value'      => 'napoli@info.com',
				'group'      => 'Emails'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Second text line', 'js_composer' ),
				'param_name' => 't3_text2',
				'value'      => 'support@napoli.com',
				'group'      => 'Emails'
			)
		)
	)
);
 
// ==========================================================================================
// PORTFOLIO LIST                                                                           -
// ==========================================================================================
vc_map(
	array(
		'name'        => __( 'Portfolio list', 'js_composer' ),
		'base'        => 'napoli_portfolio_list',
		'description' => __( 'List of portfolio items', 'js_composer' ),
		'category'    => __( 'Content', 'js_composer' ),
		'params'      => array(
			array(
				'type'        => 'vc_efa_chosen',
				'heading'     => __( 'Select Categories', 'js_composer' ),
				'param_name'  => 'cats',
				'placeholder' => __( 'Select category', 'js_composer' ),
				'value'       => napoli_element_values( 'categories', array(
					'sort_order' => 'ASC',
					'taxonomy'   => 'portfolio-category',
					'hide_empty' => false,
				) ),
				'std'         => '',
				'description' => __( 'you can choose spesific categories for portfolio, default is all categories', 'js_composer' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Style', 'js_composer' ),
				'param_name' => 'style',
				'value'      => array(
					'Simple'  => 'sim',
					'Classic' => 'cla',
				)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Select hover for items', 'js_composer' ),
				'param_name' => 'hover',
				'value'      => array(
					'Default'           => 'default',
					'Zoom Out'          => 'hover1',
					'Slide'             => 'hover2',
					'Rotate'            => 'hover3',
					'Blur'              => 'hover4',
					'Gray Scale'        => 'hover5',
					'Sepia'             => 'hover6',
					'Blur + Gray Scale' => 'hover7',
					'Opacity'           => 'hover8',
					'Shine'             => 'hover9',
				)
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Add category filter?', 'js_composer' ),
				'param_name' => 'filter',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Count items', 'js_composer' ),
				'param_name' => 'count'
			),
		)
	)
);



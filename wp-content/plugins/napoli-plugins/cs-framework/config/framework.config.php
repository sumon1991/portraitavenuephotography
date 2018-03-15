<?php if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings = array(
	'menu_title' => 'Theme Options',
	'menu_type'  => 'add_menu_page',
	'menu_slug'  => 'cs-framework',
	'ajax_save'  => false,
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();

// ----------------------------------------
// general option section
// ----------------------------------------
$options[] = array(
	'name'   => 'general',
	'title'  => 'General',
	'icon'   => 'fa fa-globe',
	'fields' => array(
		array(
			'id'      => 'page_scroll_top',
			'type'    => 'switcher',
			'title'   => 'Enable scroll top button',
			'default' => false
		),
		array(
			'id'      => 'sidebar',
			'type'    => 'checkbox',
			'title'   => 'Show sidebar on pages:',
			'options' => array(
				'post' => 'Post',
				'blog' => 'Blog'
			)
		),
		array(
			'id'      => 'protected_title',
			'type'    => 'textarea',
			'title'   => 'Protected title',
			'default' => "LOOK'S LIKE THIS GALLERY PROTECTECTED BY AUTHOR",
		),

		array(
			'id'      => 'enable_lazy_load',
			'type'    => 'switcher',
			'title'   => 'Enable lazy load',
			'desc'    => 'This option is available for Images and Maps',
			'default' => true
		),

		array(
		  'id'    => 'napoli_enable_coming_soon',
		  'type'  => 'switcher',
		  'title' => 'Enable Coming Soon',
		),
		array(
		  'id'             => 'napoli_page_coming_soon',
		  'type'           => 'select',
		  'title'          => 'Page Coming Soon',
		  'options'        => 'pages',
		  'query_args'    => array(
		      'sort_order'  => 'ASC',
		      'sort_column' => 'post_title',
		   ),
		),
		array(
			'id'    => 'enable_copyright',
			'type'  => 'switcher',
			'title' => 'Enable Copyright',
			'default' => false,
		),
		array(
			'id'         => 'text_copyright',
			'type'       => 'text',
			'title'      => 'Text Copyright',
			'default'    => '@ 2017 Napoli', 
			'dependency' => array( 'enable_copyright', '==', 'true' ),
		),
		array(
		  'id'    => 'napoli_disable_preloader',
		  'type'  => 'switcher',
		  'title' => 'Disable Preloader',
		  'default' => false,
		),

		array(
			'id'      => 'preloader_image',
			'type'    => 'image',
			'title'   => 'Preloader Image',
			'default' => '',
			'dependency' => array( 'napoli_disable_preloader', '==', false ),
		),

	) // end: fields
);


// ----------------------------------------
// Header option section
// ----------------------------------------
$options[] = array(
	'name'   => 'header',
	'title'  => 'Header',
	'icon'   => 'fa fa-star',
	'fields' => array(
		//enable fixed menu
		array(
			'id'      => 'fixed_menu',
			'type'    => 'switcher',
			'title'   => 'Fixed menu on scroll',
			'default' => false
		),
		//Site logo
		array(
			'id'      => 'menu_style',
			'type'    => 'select',
			'title'   => 'Menu style',
			'options' => array(
				'center' => 'Center',
				'right'  => 'Right'
			),
			'default' => 'right',
		),
		array(
			'id'      => 'site_logo',
			'type'    => 'radio',
			'title'   => 'Type of site logo',
			'options' => array(
				'txtlogo' => 'Text Logo',
				'imglogo' => 'Image Logo',
			),
			'default' => array( 'imglogo' ),
		),
		array(
			'id'         => 'text_logo',
			'type'       => 'text',
			'title'      => 'Text Logo',
			'default'    => 'Napoli',
			'sanitize'    => 'textarea',
			'dependency' => array( 'site_logo_txtlogo', '==', 'true' ),
		),
		array(
			'id'         => 'text_logo_style',
			'type'       => 'radio',
			'title'      => 'Text logo style',
			'options'    => array(
				'default' => 'Default',
				'custom'  => 'Custom',
			),
			'default'    => array( 'default' ),
			'dependency' => array( 'site_logo_txtlogo', '==', 'true' )
		),
		array(
			'id'         => 'text_logo_width',
			'type'       => 'text',
			'title'      => 'Max width logo section',
			'default'    => '70px',
			'dependency' => array( 'text_logo_style_custom|site_logo_txtlogo', '==|==', 'true|true' )
		),
		array(
			'id'         => 'text_logo_color',
			'type'       => 'color_picker',
			'title'      => 'Text Logo Color',
			'default'    => '#fff',
			'dependency' => array( 'text_logo_style_custom|site_logo_txtlogo', '==|==', 'true|true' )
		),
		array(
			'id'         => 'text_logo_font_size',
			'type'       => 'text',
			'title'      => 'Text logo font size',
			'desc'       => 'By default the logo have 20px font size',
			'default'    => '20px',
			'dependency' => array( 'text_logo_style_custom|site_logo_txtlogo', '==|==', 'true|true' )
		),
		array(
			'id'         => 'image_logo',
			'type'       => 'upload',
			'title'      => 'Site Logo (Right style)',
			'default'    => get_template_directory_uri() . '/assets/images/logo.png',
			'desc'       => 'Upload any media using the WordPress Native Uploader.',
			'dependency' => array( 'site_logo_imglogo|menu_style', '==|==', 'true|right' ),
		),
		array(
			'id'         => 'image_logo2',
			'type'       => 'upload',
			'title'      => 'Site Logo (Center style)',
			'default'    => get_template_directory_uri() . '/assets/images/logo.png',
			'desc'       => 'Upload any media using the WordPress Native Uploader.',
			'dependency' => array( 'site_logo_imglogo|menu_style', '==|==', 'true|center' ),
		),
		array(
			'id'         => 'img_logo_style',
			'type'       => 'radio',
			'title'      => 'Image logo style',
			'options'    => array(
				'default' => 'Default',
				'custom'  => 'Custom',
			),
			'default'    => array( 'default' ),
			'dependency' => array( 'site_logo_imglogo', '==', 'true' )
		),
		array(
			'id'         => 'img_logo_width',
			'type'       => 'text',
			'title'      => 'Site Logo Width Size*',
			'desc'       => 'By default the logo have 60px width size',
			'dependency' => array( 'img_logo_style_custom|site_logo_imglogo', '==|==', 'true|true' )
		),
		array(
			'id'         => 'img_logo_height',
			'type'       => 'text',
			'title'      => 'Site Logo Height Size*',
			'desc'       => 'By default the logo have 52px height size',
			'dependency' => array( 'img_logo_style_custom|site_logo_imglogo', '==|==', 'true|true' )
		),
		array(
			'id'           => 'header_social',
			'type'         => 'group',
			'title'        => 'Header social links',
			'button_title' => 'Add New',
			'fields'       => array(
				array(
					'id'    => 'header_social_link',
					'type'  => 'text',
					'title' => 'Link'
				),
				array(
					'id'    => 'header_social_icon',
					'type'  => 'icon',
					'title' => 'Icon'
				)
			),
			'default'      => array(
				array(
					'header_social_link' => 'https://www.facebook.com/',
					'header_social_icon' => 'fa fa-facebook'
				),
				array(
					'header_social_link' => 'https://www.pinterest.com/',
					'header_social_icon' => 'fa fa-pinterest-p'
				),
				array(
					'header_social_link' => 'https://twitter.com/',
					'header_social_icon' => 'fa fa-twitter'
				),
				array(
					'header_social_link' => 'https://dribbble.com/',
					'header_social_icon' => 'fa fa-dribbble'
				),
			)
		),
		array(
		  'type'  => 'subheading',
		  'content' => 'Menu item options',
		),
		array(
			'id'      => 'default_underline_deleted',
			'type'    => 'switcher',
			'title'   => 'Hide default underline',
			'default' => false
		),
		array(
			'id'         => 'menu_underline_height',
			'type'       => 'text',
			'title'      => 'Height Underline Menu Item',
			'desc'       => 'Example: 1px (required)',
			'dependency' => array( 'default_underline_deleted','==','true'),
		),
		array(
		  'id'      => 'menu_underline_color',
		  'type'    => 'color_picker',
		  'title'   => 'Color Underline Menu Item',
		  'dependency' => array( 'default_underline_deleted','==','true'),
		),
		array(
		  'id'      => 'menu_underline_wave_color',
		  'type'    => 'color_picker',
		  'title'   => 'Color Default Underline Menu Item (Wave)', 
		  'dependency' => array( 'default_underline_deleted','==','false'),
		),
	) // end: fields
);

// Typography
$options[] = array(
	'name'   => 'typography',
	'title'  => 'Typography',
	'icon'   => 'fa fa-font',
	'fields'      => array(

		array(
		  'type'    => 'heading',
		  'content' => 'Typography Headings',
		),
		array(
			'id'              => 'heading',
			'type'            => 'group',
			'title'           => 'Typography Headings',
			'button_title'    => 'Add New',
			'accordion_title' => 'Add New',

			// begin: fields
			'fields'      => array(

			    // header size
			    array(
			      'id'             => 'heading_tag',
			      'type'           => 'select',
			      'title'          => 'Title Tag',
			      'options'        => array(
			        'h1'             => esc_html__('H1','napoli'),
			        'h2'             => esc_html__('H2','napoli'),
			        'h3'             => esc_html__('H3','napoli'),
			        'h4'             => esc_html__('H4','napoli'),
			        'h5'             => esc_html__('H5','napoli'),
			        'h6'             => esc_html__('H6','napoli'),
			        'p'             => esc_html__('Paragraph','napoli'),
			      ),
			    ),

			    // font family
			    array(
			      'id'        => 'heading_family',
			      'type'      => 'typography',
			      'title'     => 'Font Family',
			      'default'   => array(
			        'family'  => 'Open Sans',
			        'variant' => 'regular',
			        'font'    => 'google', // this is helper for output
			      ),
			    ),

			    // font size
			    array(
			      'id'          => 'heading_size',
			      'type'        => 'text',
			      'title'       => 'Font Size (in px)',
			      'default'     => '54px',
			    ),

			    // font color
			    array(
			      'id'      => 'heading_color',
			      'type'    => 'color_picker',
			      'title'   => 'Font Color',
			      
			    ),
			),
		),


		array(
		  'type'    => 'heading',
		  'content' => 'Typography Menu',
		),
		// menu
		array(
		  'id'        => 'menu_item_family',
		  'type'      => 'typography',
		  'title'     => 'Menu Item Font Family',
		  'default'   => array(
		    'family'  => 'Montserrat',
		    'variant' => 'regular',
		    'font'    => 'google', // this is helper for output
		  ),
		),

		// font size
		array(
		  'id'          => 'menu_item_size',
		  'type'        => 'text',
		  'title'       => 'Menu Item Font Size (in px)',
		  'default'     => '12px',
		),

		// line height
		array(
		  'id'          => 'menu_line_height',
		  'type'        => 'text',
		  'title'       => 'Menu Line Height',
		  'default'     => '45px',
		),

		// font color
		array(
		  'id'      => 'menu_item_color',
		  'type'    => 'color_picker',
		  'title'   => 'Menu Item Font Color',
		  
		),

		//submenu
		array(
		  'id'        => 'submenu_item_family',
		  'type'      => 'typography',
		  'title'     => 'Submenu Item Font Family',
		  'default'   => array(
		    'family'  => 'Montserrat',
		    'variant' => 'regular',
		    'font'    => 'google', // this is helper for output
		  ),
		),

		// font size
		array(
		  'id'          => 'submenu_item_size',
		  'type'        => 'text',
		  'title'       => 'Submenu Item Font Size (in px)',
		  'default'     => '12px',
		),

		// line height
		array(
		  'id'          => 'submenu_line_height',
		  'type'        => 'text',
		  'title'       => 'Submenu Line Height',
		  'default'     => '26px',
		),

		// font color
		array(
		  'id'      => 'submenu_item_color',
		  'type'    => 'color_picker',
		  'title'   => 'Submenu Item Font Color',
		),

		array(
		  'type'    => 'heading',
		  'content' => 'Typography Banner Gallery',
		),

		//gallery_font_family
		array(
		  'id'        => 'gallery_font_family',
		  'type'      => 'typography',
		  'title'     => 'Gallery Description Font Family',
		  'default'   => array(
		    'family'  => 'Libre Baskerville',
		    'variant' => 'regular',
		    'font'    => 'google', // this is helper for output
		  ),
		),

		// font size
		array(
		  'id'          => 'gallery_font_size',
		  'type'        => 'text',
		  'title'       => 'Gallery Description Font Size (in px)',
		  'default'     => '14px',
		),

		// line height
		array(
		  'id'          => 'gallery_line_height',
		  'type'        => 'text',
		  'title'       => 'Gallery Description Line Height',
		  'default'     => '28px',
		),

		// font color
		array(
		  'id'      => 'gallery_item_color',
		  'type'    => 'color_picker',
		  'title'   => 'Gallery Description Font Color',
		),

		array(
		  'type'    => 'heading',
		  'content' => 'Typography Footer',
		),

		// footer_font_family
		array(
		  'id'        => 'footer_font_family',
		  'type'      => 'typography',
		  'title'     => 'Footer Font Family',
		  'default'   => array(
		    'family'  => 'Libre Baskerville',
		    'variant' => 'regular',
		    'font'    => 'google', // this is helper for output
		  ),
		),

		// font size
		array(
		  'id'          => 'footer_font_size',
		  'type'        => 'text',
		  'title'       => 'Footer Font Size (in px)',
		  'default'     => '12px',
		),

		// line height
		array(
		  'id'          => 'footer_line_height',
		  'type'        => 'text',
		  'title'       => 'Footer Line Height',
		  'default'     => '30px',
		),

		// font color
		array(
		  'id'      	=> 'footer_item_color',
		  'type'    	=> 'color_picker',
		  'title'   	=> 'Footer Font Color',
		),

		array(
		  'type'    => 'heading',
		  'content' => 'Typography Item Napoli Gallery',
		),


		// footer_font_family
		array(
		  'id'        => 'item_gallery_font_family',
		  'type'      => 'typography',
		  'title'     => 'Typography Font Family',
		  'default'   => array(
		    'family'  => '',
		    'variant' => 'regular',
		    'font'    => 'websafe', // this is helper for output
		  ),
		),

		// font size
		array(
		  'id'          => 'item_gallery_font_size',
		  'type'        => 'text',
		  'title'       => 'Typography Font Size (in px)',
		  'default'     => '24px',
		),

		// line height
		array(
		  'id'          => 'item_gallery_line_height',
		  'type'        => 'text',
		  'title'       => 'Typography Line Height',
		  'default'     => '30px',
		),

		// font color
		array(
		  'id'      	=> 'item_gallery_item_color',
		  'type'    	=> 'color_picker',
		  'title'   	=> 'Typography Font Color',
		),

		array(
		  'type'    => 'heading',
		  'content' => 'Typography Button',
		),

		array(
		  'id'        => 'all_button_font_family',
		  'type'      => 'typography',
		  'title'     => 'Button Font Family',
		  'default'   => array(
		    'family'  => '',
		    'variant' => 'regular',
		    'font'    => 'websafe', // this is helper for output
		  ),
		),

		// font size
		array(
		  'id'          => 'all_button_font_size',
		  'type'        => 'text',
		  'title'       => 'Button Font Size (in px)',
		  'default'     => '',
		),

		// line height
		array(
		  'id'          => 'all_button_line_height',
		  'type'        => 'text',
		  'title'       => 'Button Line Height',
		  'default'     => '',
		),

		// font color
		array(
		  'id'          => 'all_button_letter_spacing',
		  'type'        => 'text',
		  'title'       => 'Letter Spacing (in px)',
		  'default' => '',
		),

		array(
		  'id'      	=> 'all_button_item_color',
		  'type'    	=> 'color_picker',
		  'title'   	=> 'Typography Font Color',
		),


		array(
		  'type'    => 'heading',
		  'content' => 'Typography Links',
		),

		array(
		  'id'        => 'all_links_font_family',
		  'type'      => 'typography',
		  'title'     => 'Button Font Family',
		  'default'   => array(
		    'family'  => '',
		    'variant' => 'regular',
		    'font'    => 'websafe', // this is helper for output
		  ),
		),

		// font size
		array(
		  'id'          => 'all_links_font_size',
		  'type'        => 'text',
		  'title'       => 'Links Font Size (in px)',
		  'default'     => '',
		),

		// line height
		array(
		  'id'          => 'all_links_line_height',
		  'type'        => 'text',
		  'title'       => 'Links Line Height',
		  'default'     => '',
		),

		// font color
		array(
		  'id'          => 'all_links_letter_spacing',
		  'type'        => 'text',
		  'title'       => 'Links Letter Spacing (in px)',
		  'default' => '',
		),

		array(
		  'id'      	=> 'all_links_item_color',
		  'type'    	=> 'color_picker',
		  'title'   	=> 'Links Font Color',
		),

	),
);



// ----------------------------------------
// Socials API Configuration
// ----------------------------------------
$options[]      = array(
	'name'        => 'socials',
	'title'       => 'Social',
	'icon'        => 'fa fa-facebook',

	// begin: fields
	'fields'      => array(
		//facebook
		array(
			'id'      => 'fb_app_id',
			'type'    => 'text',
			'title'   => 'Facebook App Id (require)',
			'default' => '985481124848356',
		),
		array(
			'id'      => 'fb_secret_id',
			'type'    => 'text',
			'title'   => 'Facebook App Secret (require)',
			'default' => 'fd6c49e5c06fe9c862201ea65fc237d9',
		),
		array(
			'id'      => 'fb_page_id',
			'type'    => 'text',
			'title'   => 'Facebook Page Id or Slug (require)',
			'default' => 'Foxthemes',
		),
		//twitter
		array(
			'id'      => 'tw_app_id',
			'type'    => 'text',
			'title'   => 'Twitter API Key (require)',
			'default' => '3302527972-k4YQXusw1hjWPmlwAwiYFOfBj15f3F2mZ0RH6tU',
		),
		array(
			'id'      => 'tw_secret_id',
			'type'    => 'text',
			'title'   => 'Twitter API Secret (require)',
			'default' => 'Sz26ApvZBMoVqfZIgRJN5Rq16GQCzwtfIT5sYwD4GM0Of',
		),
		array(
			'id'      => 'tw_consumer_key',
			'type'    => 'text',
			'title'   => 'Twitter Access Token (require)',
			'default' => 'rAtSGwiHs9xJej9uqz9iw8b4Y',
		),
		array(
			'id'      => 'tw_consumer_secret',
			'type'    => 'text',
			'title'   => 'Twitter Access Token Secret (require)',
			'default' => '7CsNQyx76tbsAQbT33pPCmF8CN4b4AZspTOPEIQp5b1I3Y9Fyt',
		),


	) // end: fields
);



// ----------------------------------------
// Custom color
// ----------------------------------------

$options[] = array(
	'name'   => 'theme_colors',
	'title'  => 'Theme Color',
	'icon'   => 'fa fa-magic',
	// begin: fields
	'fields' => array(
		array(
			'id'      => 'enable_style_black',
			'type'    => 'switcher',
			'title'   => 'Style Black',
			'default' => false
		),
		array(
			'id'      => 'menu_font_color',
			'type'    => 'color_picker',
			'title'   => 'Menu Font Color',
			'default' => '#131313',
		),
		array(
			'id'      => 'menu_bg_color',
			'type'    => 'color_picker',
			'title'   => 'Menu Background Color',
			'default' => '#ffffff',
		),
		array(
			'id'      => 'front_color',
			'type'    => 'color_picker',
			'title'   => 'Front Color',
			'default' => '#131313',
			'desc'    => 'Change text color banner, text color images, color buttons ',
		),
		array(
			'id'      => 'base_color',
			'type'    => 'color_picker',
			'title'   => 'Base Color',
			'default' => '#ffffff',
			'desc'    => 'Change color text all pages, color buttons',
		),
		array(
			'id'      => 'footer_links',
			'type'    => 'color_picker',
			'title'   => 'Footer Social Links',
			'default' => '#ffffff',
		),
		array(
			'id'      => 'footer_bg',
			'type'    => 'color_picker',
			'title'   => 'Footer Background',
			'default' => '#131313',
		),
		array(
			'id'      => 'footer_copyright',
			'type'    => 'color_picker',
			'title'   => 'Footer Copyright',
			'default' => '#ffffff',
		),


		array(
		  'type'    => 'heading',
		  'content' => 'Gallery Colors',
		),
		array(
			'id'      => 'gallery_popup_heading_color',
			'type'    => 'color_picker',
			'title'   => 'Gallery Popup Heading Color',
			'default' => '#fff',
		),
		array(
			'id'      => 'gallery_popup_text_color',
			'type'    => 'color_picker',
			'title'   => 'Gallery Popup Text Color',
			'default' => '#888888',
		),
		array(
			'id'      => 'gallery_popup_bg_color',
			'type'    => 'color_picker',
			'title'   => 'Gallery Popup Background Color',
			'default' => '#000',
		),
	), // end: fields
);

// ----------------------------------------
// Ecommerce
// ----------------------------------------
$options[] = array(
	'name'   => 'ecommerce_options',
	'title'  => 'Ecommerce',
	'icon'   => 'fa fa-shopping-cart',
	// begin: fields
	'fields' => array(
		array(
			'id'      => 'products_per_row',
			'type'    => 'select',
			'title'   => 'Products per row',
			'options' => array(
				'4'  => 'Three columns',
				'3'  => 'Four columns',
				'6'  => 'Two columns',
			),
			'default' => '4',
		),
	),
);



// ----------------------------------------
// Blog option section
// ----------------------------------------
$options[] = array(
	'name'   => 'blog',
	'title'  => 'Blog',
	'icon'   => 'fa fa-newspaper-o',
	'fields' => array(
		array(
			'id'             => 'napoli_blog_style',
			'type'           => 'select',
			'title'          => 'Blog Style',
			'options'    => array(
				'default'  => 'Default',
				'modern' => 'Modern',
			),
			'default'  => 'default',
		),
		array(
			'id'      => 'napoli_blog_filter',
			'type'    => 'switcher',
			'title'   => 'Enable filter for posts',
			'default' => false,
			'dependency' => array( 'napoli_blog_style', '==', 'modern' ),
		),
		array(
			'id'      => 'napoli_social_post',
			'type'    => 'switcher',
			'title'   => 'Social sharing in posts',
			'default' => false
		),
		array(
			'id'      => 'napoli_post_info',
			'type'    => 'switcher',
			'title'   => 'Tags and categories in posts',
			'default' => false
		),
		array(
			'id'      => 'napoli_post_author',
			'type'    => 'switcher',
			'title'   => 'Author in post details page',
			'default' => false
		),
		array(
			'id'      => 'default_post_image',
			'type'    => 'upload',
			'title'   => 'Default post preview image',
			'default' => get_template_directory_uri() . '/assets/images/post.jpg'
		),

		array(
			'id'      => 'insta_title',
			'type'    => 'text',
			'title'   => 'Instagram title',
			'default' => 'Instagram feed'
		),
		array(
			'id'      => 'insta_username',
			'type'    => 'text',
			'title'   => 'Instagram username',
			'default' => 'edi_grand'
		),
		array(
			'id'      => 'insta_count',
			'type'    => 'text',
			'title'   => 'Instagram count images',
			'default' => '6'
		),
		array(
			'id'      => 'napoli_navigation_posts',
			'type'    => 'switcher',
			'title'   => 'Navigation in post item (for all posts)',
			'default' => true
		),

	) // end: fields
);


// ----------------------------------------
// Portfolio option section
// ----------------------------------------
$options[] = array(
	'name'   => 'portfolio',
	'title'  => 'Portfolio',
	'icon'   => 'fa fa-file-text-o',
	'fields' => array(
		array(
			'id'      => 'default_portfolio_image',
			'type'    => 'upload',
			'title'   => 'Default portfolio image',
			'default' => get_template_directory_uri() . '/assets/images/portfolio.jpg'
		),
		array(
			'id'      => 'social_portfolio',
			'type'    => 'switcher',
			'title'   => 'Social sharing in portfolio (for all posts)',
			'default' => true
		),
		array(
			'id'      => 'navigation_portfolio',
			'type'    => 'switcher',
			'title'   => 'Navigation in portfolio (for all posts)',
			'default' => true
		),

		array(
			'id'      => 'portfolio_slug',
			'type'    => 'text',
			'title'   => 'Portfolio Url Slug',
			'default' => '',
			'desc'    => 'Please update <a href="'.home_url('wp-admin/options-permalink.php').'">permalinks</a> after this. ' 
		),
		array(
			'id'      => 'portfolio_category_slug',
			'type'    => 'text',
			'title'   => 'Portfolio Url Category Slug',
			'default' => '',
			'desc'    => 'Please update <a href="'.home_url('wp-admin/options-permalink.php').'">permalinks</a> after this. ' 
		),

	) // end: fields
);

// ----------------------------------------
// Footer option section                  -
// ----------------------------------------
$options[] = array(
	'name'   => 'footer',
	'title'  => 'Footer',
	'icon'   => 'fa fa-copyright',
	'fields' => array(
		// Footer with margin bottom.
		array(
			'id'       => 'footer_text',
			'type'     => 'wysiwyg',
			'title'    => 'Copyright text',
			'settings' => array(
				'textarea_rows' => 5,
				'media_buttons' => false,
			),
			'default'  => 'Napoli &copy; ' . date( 'Y' ) . '. Development with love by <a href="http://foxthemes.com">FOXTHEMES</a>'
		),
		array(
			'id'           => 'footer_social',
			'type'         => 'group',
			'title'        => 'Footer social links',
			'button_title' => 'Add New',
			'fields'       => array(
				array(
					'id'    => 'footer_social_link',
					'type'  => 'text',
					'title' => 'Link'
				),
				array(
					'id'    => 'footer_social_icon',
					'type'  => 'icon',
					'title' => 'Icon'
				)
			),
			'default'      => array(
				array(
					'footer_social_link' => 'https://www.facebook.com/',
					'footer_social_icon' => 'fa fa-facebook'
				),
				array(
					'footer_social_link' => 'https://www.pinterest.com/',
					'footer_social_icon' => 'fa fa-pinterest-p'
				),
				array(
					'footer_social_link' => 'https://twitter.com/',
					'footer_social_icon' => 'fa fa-twitter'
				),
				array(
					'footer_social_link' => 'https://dribbble.com/',
					'footer_social_icon' => 'fa fa-dribbble'
				),
			)
		),
	) // end: fields
);

// ----------------------------------------
// Custom Css and JavaScript
// ----------------------------------------
$options[] = array(
	'name'   => 'custom_css',
	'title'  => 'Custom Css and JavaScript',
	'icon'   => 'fa fa-paint-brush',
	'fields' => array(
		array(
			'id'    => 'custom_css_styles',
			'desc'  => 'Only CSS, without tag &lt;style&gt;.',
			'type'  => 'textarea',
			'title' => 'Custom css code'
		),
		array(
			'id'    => 'custom_js_scripts',
			'desc'  => 'Only JS code, without tag &lt;script&gt;.',
			'type'  => 'textarea',
			'title' => 'Custom JavaScript code'
		)
	)
);
// ----------------------------------------
// 404 Page                               -
// ----------------------------------------
$options[] = array(
	'name'   => 'error_page',
	'title'  => '404 Page',
	'icon'   => 'fa fa-bolt',

	// begin: fields
	'fields' => array(
		array(
			'id'      => 'error_logo',
			'type'    => 'switcher',
			'title'   => 'Change logo for 404 page',
			'default' => false
		),
		array(
			'id'      => 'error_site_logo',
			'type'    => 'radio',
			'title'   => 'Type of site logo',
			'options' => array(
				'txtlogo' => 'Text Logo',
				'imglogo' => 'Image Logo',
			),
			'default' => array( 'imglogo' ),
			'dependency' => array( 'error_logo', '==', true ),
		),
		array(
			'id'         => 'error_text_logo',
			'type'       => 'text',
			'title'      => 'Text Logo',
			'default'    => 'Napoli',
			'sanitize'    => 'textarea',
			'dependency' => array( 'error_site_logo_txtlogo|error_logo', '==|==', 'true|true' ),
		),
		array(
			'id'         => 'error_image_logo',
			'type'       => 'upload',
			'title'      => 'Image Logo',
			'default'    => get_template_directory_uri() . '/assets/images/logo.png',
			'desc'       => 'Upload any media using the WordPress Native Uploader.',
			'dependency' => array( 'error_site_logo_imglogo|error_logo', '==|==', 'true|true' ),
		),



		array(
			'id'      => 'error_title',
			'type'    => 'text',
			'title'   => 'Error Title',
			'default' => 'Page not found',
		),
		array(
			'id'      => 'error_btn_text',
			'type'    => 'textarea',
			'title'   => 'Error button text',
			'default' => 'Go home',
		),
		array(
			'id'      => 'image_404',
			'type'    => 'upload',
			'title'   => '404 page background',
			'default' => get_template_directory_uri() . '/assets/images/404.jpg'
		),
	) // end: fields
);
// ----------------------------------------
// Backup
// ----------------------------------------
$options[] = array(
	'name'   => 'backup_section',
	'title'  => 'Backup',
	'icon'   => 'fa fa-shield',

	// begin: fields
	'fields' => array(

		array(
			'type'    => 'notice',
			'class'   => 'warning',
			'content' => 'You can save your current options. Download a Backup and Import.',
		),

		array(
			'type' => 'backup',
		),

	)  // end: fields
);

CSFramework::instance( $settings, $options );

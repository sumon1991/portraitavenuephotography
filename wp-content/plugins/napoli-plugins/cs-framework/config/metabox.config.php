<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();
// -----------------------------------------
// POST PREVIEW OPTIONS                    -
// -----------------------------------------
$options[] = array(
    'id' => 'napoli_post_options',
    'title' => 'Post preview settings',
    'post_type' => 'post',
    'context' => 'normal',
    'priority' => 'default',
    'sections' => array(
        array(
            'name' => 'section_3',
            'fields' => array(
                array(
                    'id' => 'post_preview_style',
                    'type' => 'select',
                    'title' => 'Preview style',
                    'options' => array(
                        'image' => 'Post image',
                        'text' => 'Quote',
                        'audio' => 'Soundcloud audio',
                        'video' => 'Video',
                        'slider' => 'Image slider'
                    ),
                    'default' => array('image')
                ),
                array(
                    'id' => 'post_preview_text',
                    'type' => 'wysiwyg',
                    'title' => 'Post preview text',
                    'dependency' => array('post_preview_style', '==', 'text')
                ),
                array(
                    'id' => 'post_preview_audio',
                    'type' => 'wysiwyg',
                    'title' => 'Soundcloud iframe',
                    'dependency' => array('post_preview_style', '==', 'audio')
                ),
                array(
                    'id' => 'post_preview_video',
                    'type' => 'wysiwyg',
                    'title' => 'Video iframe code',
                    'dependency' => array('post_preview_style', '==', 'video')
                ),
                array(
                    'id' => 'post_preview_slider',
                    'type' => 'gallery',
                    'title' => 'Slider images',
                    'add_title' => 'Add Images',
                    'edit_title' => 'Edit Images',
                    'clear_title' => 'Remove Images',
                    'dependency' => array('post_preview_style', '==', 'slider')
                ),
                array(
                    'id' => 'napoli_navigation_posts',
                    'type' => 'switcher',
                    'title' => 'Navigation in post item',
                    'default' => true
                ),
            )
        )
    )
);
// -----------------------------------------
// Portfolio Options                       -
// -----------------------------------------
$options[] = array(
    'id' => 'napoli_portfolio_options',
    'title' => 'Portfolio details',
    'post_type' => 'portfolio',
    'context' => 'normal',
    'priority' => 'high',
    'sections' => array(
        array(
            'name' => 'section_4',
            'fields' => array(
                array(
                    'id' => 'slider',
                    'type' => 'gallery',
                    'title' => 'Image gallery',
                    'add_title' => 'Add Images',
                    'edit_title' => 'Edit Images',
                    'clear_title' => 'Remove Images',
                ),
                array(
                    'id' => 'portfolio_img_size',
                    'type' => 'select',
                    'title' => 'Select size for images og gallery',
                    'options' => array_merge(array('full'),get_intermediate_image_sizes()),
                    'default'  => 'full',
                ),
                array(
                    'id' => 'portfolio_style',
                    'type' => 'select',
                    'title' => 'Select style for gallery',
                    'options' => array(
                        'classic' => 'Classic Grid',
                        'modern' => 'Modern Masonry',
                        /*'fullwidth' => 'Full width',*/
                        'simple' => 'Simple',
                    ),
                ),
                array(
                    'id' => 'num_show',
                    'type' => 'switcher',
                    'title' => 'Enable load more button',
                    'default' => false,
                    'dependency' => array('portfolio_style', '==', 'modern'),
                ),
                array(
                    'id' => 'num_show_img',
                    'type' => 'number',
                    'title' => 'Count images',
                    'default' => '',
                    'dependency' => array('num_show|portfolio_style', '==|==', 'true|modern'),
                ),
                array(
                    'id' => 'hover_style',
                    'type' => 'select',
                    'title' => 'Select hover style',
                    'options' => array(
                        'default' => 'Default from gallery style',
                        'slip' => 'Slip hover'
                    ),
                    'dependency' => array('portfolio_style', '!=', 'simple')
                ),
                array(
                    'id' => 'popup_style',
                    'type' => 'select',
                    'title' => 'Select popup style',
                    'options' => array(
                        'default' => 'Default from gallery style',
                        'detail' => 'Popup detail info'
                    ),
                    'dependency' => array('portfolio_style', '!=', 'simple')
                ),
                array(
                    'id' => 'detail_style',
                    'type' => 'select',
                    'title' => 'Select detail popup type',
                    'options' => array(
                        'default' => 'Get info from images',
                        'custom' => 'Custom info from description'
                    ),
                    'dependency' => array('popup_style', '==', 'detail')
                ),
                array(
                    'id' => 'columns_number',
                    'type' => 'select',
                    'title' => 'Select count of columns',
                    'options' => array(
                        'four' => 'Four',
                        'three' => 'Three',
                        'two' => 'Two'
                    ),
                    'dependency' => array('portfolio_style', '!=', 'simple'),
                ),
                array(
                    'id' => 'napoli_social_portfolio',
                    'type' => 'switcher',
                    'title' => 'Social sharing in portfolio post',
                    'default' => true
                ),
                array(
                    'id' => 'napoli_navigation_portfolio',
                    'type' => 'switcher',
                    'title' => 'Navigation in portfolio post',
                    'default' => true
                ),
                array(
                    'id' => 'client',
                    'type' => 'text',
                    'title' => 'Client',
                    'default' => '',
                    'dependency' => array('portfolio_style', '==', 'simple'),
                ),
                array(
                    'id' => 'job_type',
                    'type' => 'text',
                    'title' => 'Job Type',
                    'default' => '',
                    'dependency' => array('portfolio_style', '==', 'simple'),
                ),
                array(
                    'id' => 'ext_link',
                    'type' => 'text',
                    'title' => 'External link',
                ),
            )
        )
    )
);

$options[] = array(
    'id' => '_custom_page_options',
    'title' => 'Custom Options',
    'post_type' => 'page', // or post or CPT
    'context' => 'normal',
    'priority' => 'default',
    'sections' => array(

        // begin section

        array(
            'name' => 'general_page_options',
            'title' => 'General Page Options',
            'fields' => array(

                array(
                    'id' => 'fixed_transparent_header',
                    'type' => 'switcher',
                    'title' => 'Fixed and tranparent header',
                    'label' => 'Do you want to it ?',
                    'default' => false
                ),

                array(
                    'id' => 'fixed_transparent_footer',
                    'type' => 'switcher',
                    'title' => 'Fixed and tranparent footer',
                    'label' => 'Do you want to it ?',
                    'default' => false
                ),

                array(
                    'id' => 'disable_container_padding',
                    'type' => 'switcher',
                    'title' => 'Disable padding container',
                    'label' => 'Do you want to it ?',
                    'default' => false
                ),

                array(
                    'id' => 'image_page_logo',
                    'type' => 'upload',
                    'title' => 'Site Logo',
                    'default' => '',
                    'desc' => 'Upload any media using the WordPress Native Uploader.',
                ),

            ),
        ),
    ),
);

$options[] = array(
    'id' => '_custom_pixpruf_gallery_options',
    'title' => 'Pixproof  Gallery (additional options)',
    'post_type' => 'proof_gallery', // or post or CPT
    'context' => 'normal',
    'priority' => 'high',
    'sections' => array(

        // begin section

        array(
            'name' => 'general_page_options',
            'fields' => array(

                array(
                    'id' => 'show_zip_button',
                    'type' => 'switcher',
                    'title' => 'Show button "Download zip"',
                    'label' => 'Do you want to it ?',
                    'default' => true
                ),

                array(
                    'id' => 'show_pdf_button',
                    'type' => 'switcher',
                    'title' => 'Show button "Download pdf"',
                    'label' => 'Do you want to it ?',
                    'default' => true
                ),

            ),
        ),
    ),
);


CSFramework_Metabox::instance($options);

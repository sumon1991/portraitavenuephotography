<?php

vc_map(array(
    'name' => esc_html__('Napoli Gallery', 'js_composer'),
    'base' => 'napoli_justified_gallery',
    'content_element' => true,
    'show_settings_on_create' => false,
    'description' => esc_html__('Simple Gallery and For Justified Gallery Plugins', 'js_composer'),
    'params' => array(

        array(
            'type' => 'dropdown',
            'heading' => __('Type Gallery', 'js_composer'),
            'param_name' => 'type',
            'value' => array(
                'Default (Justified Gallery)' => '',
                'Boxed Grid Style' => 'boxed_grid',
                'Modern Masonry Style' => 'boxed_masonry',
                'Filmstrip' => 'filmstrim',
                'Infinite Scroll Gallery' => 'infinite_gallery',
                'Infinite Scroll Full Gallery' => 'infinite_full_gallery',
                'Fullscreen with thumbnail' => 'with_thumbnile',
                'Flow gallery' => 'flow_gallery',
            )
        ),
        array(
            'type' => 'dropdown',
            'param_name' => 'popup_style_info',
            'heading' => 'Select popup style',
            'value' => array(
                'Default from gallery style' => 'default',
                'Popup detail info' => 'detail'
            ),
            'dependency' => array('element' => 'type', 'value' => array('infinite_gallery')),
        ),
        array(
            'type' => 'dropdown',
            'param_name' => 'detail_style',
            'heading' => 'Select detail popup type',
            'value' => array(
                'Get info from images' => 'default',
                'Custom info from description' => 'custom'
            ),
            'dependency' => array('element' => 'popup_style_info', 'value' => 'detail')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __('Select hover for items', 'js_composer'),
            'param_name' => 'hover',
            'value' => array(
                'Default' => 'default',
                'Zoom Out' => 'hover1',
                'Slide' => 'hover2',
                'Rotate' => 'hover3',
                'Blur' => 'hover4',
                'Gray Scale' => 'hover5',
                'Sepia' => 'hover6',
                'Blur + Gray Scale' => 'hover7',
                'Opacity' => 'hover8',
                'Shine' => 'hover9',
            ),
            'dependency' => array('element' => 'type', 'value' => array('boxed_grid'))
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Height Row',
            'param_name' => 'height_row',
            'value' => '130',
            'dependency' => array('element' => 'type', 'value' => array(''))
        ),
        array(
            'type' => 'checkbox',
            'heading' => 'Hide Image Title',
            'param_name' => 'hide_image_title',
            'value' => '',
            'dependency' => array('element' => 'type', 'value' => array('')),
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__('Hide hover on images', 'js_composer'),
            'param_name' => 'hide_hover',
            'value' => array(__('Yes', 'js_composer') => 'on'),
            'std' => 'off',
            'dependency' => array(
                'element' => 'type',
                'value' => array(''),
            )
        ),
        array(
            'type' => 'dropdown',
            'heading' => 'Image original size',
            'param_name' => 'image_original_size',
            'value' => array_merge(get_intermediate_image_sizes(), array('full')),
            'dependency' => array('element' => 'type', 'value' => array(''))
        ),


        array(
            'type' => 'attach_images',
            'heading' => 'Images',
            'param_name' => 'images',
            'admin_label' => true,
            'description' => 'Upload your images.'
        ),

        array(
            'type' => 'checkbox',
            'heading' => 'Keyboard',
            'param_name' => 'keyboard_flow',
            'value' => '',
            'dependency' => array('element' => 'type', 'value' => array('flow_gallery')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => 'Mousewheel',
            'param_name' => 'mousewheel_flow',
            'value' => '',
            'dependency' => array('element' => 'type', 'value' => array('flow_gallery')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => 'Controls',
            'param_name' => 'controls_flow',
            'value' => '',
            'dependency' => array('element' => 'type', 'value' => array('flow_gallery')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Amount of images per page',
            'param_name' => 'amount_images_per_page',
            'value' => '10',
            'dependency' => array(
                'element' => 'type',
                'value' => array('infinite_gallery', 'infinite_full_gallery')
            )
        ),

        array(
            'type' => 'checkbox',
            'heading' => 'Loop',
            'param_name' => 'loop',
            'value' => array(__('Yes', 'js_composer') => '1'),
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => 'Autoplay',
            'param_name' => 'autoplay',
            'value' => array(__('Yes', 'js_composer') => '1'),
            'std' => '0',
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => 'Direction',
            'param_name' => 'direction',
            'value' => array(
                'Right' => 'right',
                'Left' => 'left',
            ),
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Slide change time',
            'param_name' => 'slide_change_time',
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Slide animation speed',
            'param_name' => 'slide_animation_speed',
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => 'Hoverpause',
            'param_name' => 'hoverpause',
            'value' => array(__('Yes', 'js_composer') => '1'),
            'std' => '1',
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => 'Controls',
            'param_name' => 'controls',
            'value' => array(__('Yes', 'js_composer') => '1'),
            'std' => '0',
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Slide margins',
            'param_name' => 'slide_margins',
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'checkbox',
            'heading' => "Show popup image on click",
            'param_name' => 'popupimage',
            'value' => array(__('Yes', 'js_composer') => '1'),
            'std' => '0',
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'dropdown',
            'param_name' => 'popup_style_filmstrim',
            'heading' => 'Select popup style',
            'value' => array(
                'Default from gallery style' => 'default',
                'Popup detail info' => 'detail'
            ),
            'group' => esc_html__('Configuration', 'js_composer'),
            'dependency' => array('element' => 'popupimage', 'value' => array('1')),
        ),
        array(
            'type' => 'dropdown',
            'param_name' => 'detail_style_filmstrim',
            'heading' => 'Select detail popup type',
            'value' => array(
                'Get info from images' => 'default',
                'Custom info from description' => 'custom'
            ),
            'group' => esc_html__('Configuration', 'js_composer'),
            'dependency' => array('element' => 'popup_style_filmstrim', 'value' => 'detail')
        ),
        array(
            'type' => 'checkbox',
            'heading' => "Don't show full width image on click",
            'param_name' => 'fullimage',
            'value' => array(__('Yes', 'js_composer') => '1'),
            'std' => '0',
            'dependency' => array('element' => 'type', 'value' => array('filmstrim')),
            'group' => esc_html__('Configuration', 'js_composer'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Extra class name', 'js_composer'),
            'param_name' => 'el_class',

            'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer'),
            'value' => '',
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__('CSS box', 'js_composer'),
            'param_name' => 'css',
            'group' => esc_html__('Design options', 'js_composer'),
        ),
    ) //end params
));


class WPBakeryShortCode_napoli_justified_gallery extends WPBakeryShortCode
{

    protected function content($atts, $content = null)
    {

        extract(shortcode_atts(array(
            'images' => '',
            'amount_images_per_page' => '10',
            'type' => '',
            'height_row' => '',
            'image_original_size' => 'thumbnail',
            'hide_image_title' => '',
            'hover' => '',
            'loop' => '0',
            'detail_style' => 'default',
            'detail_style_filmstrim' => 'default',
            'popup_style_filmstrim' => 'default',
            'popup_style_info' => 'default',
            'autoplay' => '0',
            'direction' => 'right',
            'first_slide' => '1',
            'hoverpause' => '1',
            'keyboard_flow' => '',
            'mousewheel_flow' => '',
            'controls_flow' => '',
            'controls' => '0',
            'slide_change_time' => '3000',
            'slide_animation_speed' => '2000',
            'slide_margins' => '10',
            'gallery_style' => '',
            'hide_hover' => 'off',
            'fullimage' => 'off',
            'popupimage' => 'off',
            'el_class' => '',
            'css' => ''
        ), $atts));

        // width column

        // el class
        $css_classes = array(
            $this->getExtraClass($el_class)
        );
        $wrap_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', array_filter($css_classes)), $this->settings['base'], $atts);
        /* get custum css as class*/
        $wrap_class .= vc_shortcode_custom_css_class($css, ' ');
        $wrap_class .= !empty($el_class) ? ' ' . $el_class : '';

        $fullimage = ($fullimage == '1' || $popupimage == '1') ? '1' : '';
        // custum class
        $css_class = !empty($wrap_class) ? ' ' . $wrap_class : '';

        $container_class = 'container';

        if ($type == 'filmstrim' && !is_admin()) {
            $napoli = wp_get_theme();
            wp_enqueue_script('filmstrim.gallery', get_template_directory_uri() . '/assets/js/filmstrim.gallery.js', '', apply_filters('napoli_version_filter', $napoli->get('Version')), true);
            $container_class = 'container-fluid';
        }

        if ($type == 'infinite_gallery' || $type == 'infinite_full_gallery') {
            $container_class = 'container-fluid';

        }

        // output
        ob_start();
        ?>

        <!-- Row -->
        <?php if (!empty($images)) {

        if (!empty($type) && $type == 'with_thumbnile') :
            $images = explode(',', $images); ?>
            <div class="thumb-slider-wrapp">
                <div class="main-thumb-slider">
                    <ul class="slides">
                        <?php foreach ($images as $key => $image_id) :
                            $attachment = get_post($image_id);
                            ?>
                            <li>
                                <div class="thumb-slider-bg">
                                    <?php
                                    $url = wp_get_attachment_image_url($image_id, 'large');
                                    echo napoli_the_lazy_load_flter($url, array(
                                        'class' => 's-img-switch',
                                        'alt' => $attachment->post_excerpt
                                    ));
                                    ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="sub-thumb-slider">
                    <ul class="slides">
                        <?php foreach ($images as $key => $image_id) :
                            $attachment = get_post($image_id);
                            ?>
                            <li>
                                <div class="thumb-slider-bg">
                                    <?php
                                    $url = wp_get_attachment_image_url($image_id, 'large');
                                    echo napoli_the_lazy_load_flter($url, array(
                                        'class' => 's-img-switch',
                                        'alt' => $attachment->post_excerpt
                                    ));
                                    ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="thumb-slider-wrapp-arrow">
                    <span class="hide-images"><?php esc_html_e('Hide images', 'napoli'); ?></span>
                    <span class="show-images"><?php esc_html_e('Show images', 'napoli'); ?></span>
                </div>
            </div>
            <?php return ob_get_clean();
            exit; ?>
        <?php endif; ?>

        <?php if (!empty($type) && $type == 'flow_gallery') :
            $keyboard_flow = !empty($keyboard_flow) ? '1' : '0';
            $mousewheel_flow = !empty($mousewheel_flow) ? '1' : '0';
            $controls_flow = !empty($controls_flow) ? '1' : '0';

            $images = explode(',', $images);
            ?>
            <div class="page-calculate fullheight">
                <div class="flipster-slider" data-keyboard="<?php echo esc_attr($keyboard_flow); ?>"
                     data-mousewheel="<?php echo esc_attr($mousewheel_flow); ?>"
                     data-controls="<?php echo esc_attr($controls_flow); ?>">
                    <div class="flipster-wrapp-outer">
                        <ul class="flip-item">
                            <?php foreach ($images as $key => $image_id) :
                                $attachment = get_post($image_id);
                                ?>
                                <li>
                                    <div class="flow-item-slider">
                                        <?php
                                        echo napoli_the_lazy_load_flter(wp_get_attachment_image_url($image_id, 'large'), array(
                                            'class' => 's-img-switch',
                                            'alt' => $attachment->post_excerpt
                                        ));
                                        ?>
                                    </div>
                                    <h2 class="flow-item-title"><?php echo esc_html($attachment->post_excerpt); ?></h2>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
            exit;
        endif;

        if (empty($type)) :
            echo do_shortcode('[gallery row_height="' . esc_attr($height_row) . '" image_original_size="' . $image_original_size . '" hide_image_title="' . $hide_image_title . '"  hide_hover="' . $hide_hover . '" ids="' . $images . '"]');

            return ob_get_clean();
            exit;
        endif
        ?>

        <?php $images = explode(',', $images); ?>
        <div
            class="<?php echo esc_attr($container_class); ?> clearfix no-padd portfolio-single-content margin-lg-30b <?php echo esc_attr($css_class); ?>">
            <div class="<?php echo esc_attr($container_class); ?> clearfix no-padd">
                <?php
                if ($type == 'boxed_masonry') : ?>
                    <div class="row gallery-single margin-lg-10b margin-xs-0b">
                        <div class="izotope-container">
                            <div class="grid-sizer"></div>
                            <?php foreach ($images as $key => $image_id) :
                                $attachment = get_post($image_id);
                                ?>
                                <div
                                    class="col-md-3 col-xs-12 col-sm-6 margin-lg-30b item-single  item-single modern">
                                    <a href="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>"
                                       class="gallery-item <?php echo esc_attr($hover); ?>" title="">
                                        <?php
                                        echo napoli_the_lazy_load_flter(wp_get_attachment_image_url($image_id, 'large'),
                                            array(
                                                'class' => 'image',
                                                'alt' => $attachment->post_excerpt
                                            )
                                        );
                                        ?>
                                        <?php
                                        if (!empty($attachment->post_excerpt)) { ?>
                                            <div class="info-content">
                                                <div class="vertical-align">
                                                    <h5><?php echo esc_html($attachment->post_excerpt); ?></h5>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php elseif ($type == 'filmstrim') : ?>
                    <div class="filmstrim-gallery-outer no<?php echo esc_attr($fullimage); ?>">
                        <div class="filmstrim-gallery"
                             data-loop="<?php echo esc_attr($loop); ?>"
                             data-autoplay="<?php echo esc_attr($autoplay); ?>"
                             data-direction="<?php echo esc_attr($direction); ?>"
                             data-autospeed="<?php echo esc_attr($slide_change_time); ?>"
                             data-slidespeed="<?php echo esc_attr($slide_animation_speed); ?>"
                             data-first_slide="<?php echo esc_attr($first_slide); ?>"
                             data-hoverpause="<?php echo esc_attr($hoverpause); ?>"
                             data-controls="<?php echo esc_attr($controls); ?>"
                             data-slide_margins="<?php echo esc_attr($slide_margins); ?>"
                        >
                            <?php foreach ($images as $key => $image_id) :
                                $attachment = get_post($image_id);
                                $full_image = wp_get_attachment_image_src($image_id, 'full');
                                $full_image_url = is_array($full_image) ? $full_image[0] : $full_image;
                                $image_metadata = @exif_read_data($full_image_url);
                                $url_popup = $popup_style_filmstrim == 'detail' ? '#content' . $image_id : $full_image_url;

                                ?>
                                <div class="image-wrap" data-srcfull="<?php echo esc_url($full_image_url); ?>"
                                     data-height="<?php echo esc_attr($full_image[2]); ?>"
                                     data-width="<?php echo esc_attr($full_image[1]); ?>">
                                    <?php
                                    if ($popupimage == '1') {
                                        if ($popup_style_filmstrim == 'detail') { ?>
                                            <a href="<?php echo esc_url($url_popup); ?>" data-fancybox="images"
                                               class="gallery-item popup-details"></a>
                                            <div id="content<?php echo esc_attr($image_id); ?>"
                                                 class="popup-content-details">
                                                <div class="wrapper">
                                                    <div class="img-wrap equal">
                                                        <img src="<?php echo esc_url($full_image_url); ?>"
                                                             class="" alt="">
                                                    </div>
                                                    <div class="content equal">
                                                        <?php if (!empty($attachment->post_excerpt)) { ?>
                                                            <h5 class="img-title"><?php echo wp_kses_post($attachment->post_excerpt); ?></h5>
                                                        <?php } ?>
                                                        <div
                                                            class="img-date"><?php the_time(get_option('date_format')); ?></div>
                                                        <?php

                                                        if ($detail_style_filmstrim == 'custom') {
                                                            if (!empty($image_id)) {
                                                                $image_info = napoli_wp_get_attachment($image_id);
                                                                $description = $image_info['description']; ?>
                                                                <div class="caption-images-portfolio-item">
                                                                    <?php if (!empty($description)) {
                                                                        echo do_shortcode($description);
                                                                    } ?>
                                                                </div>
                                                            <?php }
                                                        } else {
                                                            $focal_info = wp_get_attachment_metadata($image_id);
                                                            if (!empty($image_metadata['Model']) || !empty($focal_info['image_meta']['focal_length']) || !empty($image_metadata['COMPUTED']['ApertureFNumber']) || !empty($image_metadata['ExposureTime']) || !empty($image_metadata['ISOSpeedRatings'])) {
                                                                if (!empty($image_metadata['Model'])) { ?>
                                                                    <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('Camera', 'napoli'); ?>
                                                                            :</span>
                                                                        <p><?php echo esc_html(trim($image_metadata['Model'])); ?></p>
                                                                    </div>
                                                                <?php }
                                                                if (!empty($focal_info['image_meta']['focal_length'])) {
                                                                    $focal_length = $focal_info['image_meta']['focal_length']; ?>
                                                                    <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('Focal lenght', 'napoli'); ?>
                                                                            :</span>
                                                                        <p><?php echo esc_html($focal_length); ?><?php esc_html_e('mm', 'napoli'); ?></p>
                                                                    </div>
                                                                <?php }
                                                                if (!empty($image_metadata['COMPUTED']['ApertureFNumber'])) { ?>
                                                                    <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('Aperture', 'napoli'); ?>
                                                                            :</span>
                                                                        <p><?php echo esc_html($image_metadata['COMPUTED']['ApertureFNumber']); ?></p>
                                                                    </div>
                                                                <?php }
                                                                if (!empty($image_metadata['ExposureTime'])) { ?>
                                                                    <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('Exposure time', 'napoli'); ?>
                                                                            :</span>
                                                                        <p><?php echo esc_html($image_metadata['ExposureTime']); ?></p>
                                                                    </div>
                                                                <?php }
                                                                if (!empty($image_metadata['ISOSpeedRatings'])) {
                                                                    $iso = is_array($image_metadata['ISOSpeedRatings']) ? reset($image_metadata['ISOSpeedRatings']) : $image_metadata['ISOSpeedRatings']; ?>
                                                                    <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('ISO', 'napoli'); ?>
                                                                            :</span>
                                                                        <p><?php echo esc_html(trim($iso)); ?></p>
                                                                    </div>
                                                                <?php }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <a href="<?php echo esc_url($full_image_url); ?>"
                                               class="gallery-item"></a>
                                        <?php } ?>
                                    <?php }

                                    echo napoli_the_lazy_load_flter(wp_get_attachment_image_url($image_id, 'large'),
                                        array(
                                            'class' => 'image',
                                            'alt' => $attachment->post_excerpt
                                        )
                                    );
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swipe-btn prev"></div>
                        <div class="swipe-btn next"></div>
                    </div>
                <?php elseif ($type == 'infinite_gallery' || $type == 'infinite_full_gallery'): ?>
                    <?php
                    $infinite_page = isset($_GET['infinite_page']) && is_numeric($_GET['infinite_page']) ? $_GET['infinite_page'] : 2;

                    $count_images = count($images);

                    $count_pages = ceil(count($images) / $amount_images_per_page);

                    $infinite_page = ($infinite_page >= $count_pages) ? $count_pages : $infinite_page;

                    global $wp;
                    $params = array(
                        'url_next_page' => home_url(
                            add_query_arg(
                                array(),
                                $wp->request
                            )
                        ),
                        'maxPages' => $count_pages,
                        'infinite_page' => $infinite_page,
                        'countImages' => count($images),
                        'amount_images_per_page' => $amount_images_per_page,
                    );

                    wp_localize_script(
                        'napoli_main-js',
                        'infinite_scroll',
                        $params
                    );
                    ?>
                    <div class="row gallery-single margin-lg-10b margin-xs-0b <?php echo esc_attr($type); ?>">
                        <div class="izotope-container-2">
                            <?php
                            $int = 1;
                            $ch = false;

                            $infinite_page = isset($_GET['infinite_page']) && is_numeric($_GET['infinite_page']) ? $_GET['infinite_page'] : 1;

                            //$infinite_page
                            $count_images = count($images);
                            $start = ($infinite_page - 1) * $amount_images_per_page;
                            $end = $start + $amount_images_per_page;
                            $end = ($end >= $count_images) ? $count_images : $end;
                            $images = array_slice($images, $start, $end);

                            foreach ($images as $key => $image_id) :
                                $attachment = get_post($image_id);
                                $url = wp_get_attachment_image_url($image_id, 'large');
                                $url_full = wp_get_attachment_image_url($image_id, 'full');
                                $url_popup = $popup_style_info == 'detail' ? '#content' . $image_id : $url_full;
                                ?>
                                <div class="fullwidth full-single item-single item<?php echo esc_attr($int); ?>">

                                    <?php if ($popup_style_info == 'detail') {
                                        $image_metadata = @exif_read_data($url_full); ?>
                                        <a href="<?php echo esc_url($url_popup); ?>"
                                           data-fancybox="images" class="gallery-item s-back-switch popup-details">
                                            <?php
                                            echo napoli_the_lazy_load_flter($url,
                                                array(
                                                    'class' => 's-img-switch',
                                                    'alt' => $attachment->post_excerpt
                                                )
                                            );
                                            ?>
                                            <div class="info-content">
                                                <?php if (!empty($attachment->post_excerpt)) { ?>
                                                    <div class="vertical-align">
                                                        <h5><?php echo esc_html($attachment->post_excerpt); ?></h5>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </a>
                                        <div id="content<?php echo esc_attr($image_id); ?>"
                                             class="popup-content-details">
                                            <div class="wrapper">
                                                <div class="img-wrap equal">
                                                    <img src="<?php echo esc_url($url_full); ?>"
                                                         class="" alt="">
                                                </div>
                                                <div class="content equal">
                                                    <?php if (!empty($attachment->post_excerpt)) { ?>
                                                        <h5 class="img-title"><?php echo wp_kses_post($attachment->post_excerpt); ?></h5>
                                                    <?php } ?>
                                                    <div
                                                        class="img-date"><?php the_time(get_option('date_format')); ?></div>
                                                    <?php


                                if ($detail_style == 'custom') {
                                    if (!empty($image_id)) {
                                        $image_info = napoli_wp_get_attachment($image_id);
                                        $description = $image_info['description']; ?>
                                        <div class="caption-images-portfolio-item">
                                            <?php if (!empty($description)) {
                                                echo do_shortcode($description);
                                            } ?>
                                        </div>
                                    <?php }
                                } else {

                                    $focal_info = wp_get_attachment_metadata($image_id);
                                    if (!empty($image_metadata['Model']) || !empty($focal_info['image_meta']['focal_length']) || !empty($image_metadata['COMPUTED']['ApertureFNumber']) || !empty($image_metadata['ExposureTime']) || !empty($image_metadata['ISOSpeedRatings'])) {
                                        if (!empty($image_metadata['Model'])) { ?>
                                            <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('Camera', 'napoli'); ?>
                                                                            :</span>
                                                <p><?php echo esc_html(trim($image_metadata['Model'])); ?></p>
                                            </div>
                                        <?php }
                                        if (!empty($focal_info['image_meta']['focal_length'])) {
                                            $focal_length = $focal_info['image_meta']['focal_length']; ?>
                                            <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('Focal lenght', 'napoli'); ?>
                                                                            :</span>
                                                <p><?php echo esc_html($focal_length); ?><?php esc_html_e('mm', 'napoli'); ?></p>
                                            </div>
                                        <?php }
                                        if (!empty($image_metadata['COMPUTED']['ApertureFNumber'])) { ?>
                                            <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('Aperture', 'napoli'); ?>
                                                                            :</span>
                                                <p><?php echo esc_html($image_metadata['COMPUTED']['ApertureFNumber']); ?></p>
                                            </div>
                                        <?php }
                                        if (!empty($image_metadata['ExposureTime'])) { ?>
                                            <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('Exposure time', 'napoli'); ?>
                                                                            :</span>
                                                <p><?php echo esc_html($image_metadata['ExposureTime']); ?></p>
                                            </div>
                                        <?php }
                                        if (!empty($image_metadata['ISOSpeedRatings'])) {
                                            $iso = is_array($image_metadata['ISOSpeedRatings']) ? reset($image_metadata['ISOSpeedRatings']) : $image_metadata['ISOSpeedRatings']; ?>
                                            <div class="caption-images-portfolio-item">
																		<span><?php esc_html_e('ISO', 'napoli'); ?>
                                                                            :</span>
                                                <p><?php echo esc_html(trim($iso)); ?></p>
                                            </div>
                                        <?php }
                                    }
                                }?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <a href="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>"
                                           class="gallery-item s-back-switch">
                                            <?php
                                            echo napoli_the_lazy_load_flter($url,
                                                array(
                                                    'class' => 's-img-switch',
                                                    'alt' => $attachment->post_excerpt
                                                )
                                            );
                                            ?>
                                            <div class="info-content">
                                                <?php if (!empty($attachment->post_excerpt)) { ?>
                                                    <div class="vertical-align">
                                                        <h5><?php echo esc_html($attachment->post_excerpt); ?></h5>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                                <?php
                                if ($int == 14) {
                                    $int = 0;
                                }
                                $int++;
                            endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row gallery-single margin-lg-10b margin-xs-0b">
                        <div class="izotope-container">
                            <div class="grid-sizer"></div>
                            <?php foreach ($images as $key => $image_id) :
                                $attachment = get_post($image_id);
                                ?>
                                <div class="col-md-3 col-xs-12 col-sm-6 margin-lg-30b item-single">
                                    <a href="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>"
                                       class="gallery-item <?php echo esc_attr($hover); ?>" title="">
                                        <div class="item-img">
                                            <div class="images-one s-back-switch">
                                                <?php
                                                echo napoli_the_lazy_load_flter(wp_get_attachment_image_url($image_id, 'large'),
                                                    array(
                                                        'class' => 's-img-switch',
                                                        'alt' => $attachment->post_excerpt
                                                    )
                                                );
                                                ?>
                                            </div>
                                            <?php
                                            if (!empty($attachment->post_excerpt)) { ?>
                                                <div class="info-content">
                                                    <div class="vertical-align">
                                                        <h5><?php echo esc_html($attachment->post_excerpt); ?></h5>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

        return ob_get_clean();
    }

}

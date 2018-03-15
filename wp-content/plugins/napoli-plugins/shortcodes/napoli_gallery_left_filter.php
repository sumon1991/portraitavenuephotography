<?php


// ==========================================================================================
// PORTFOLIO LIST                                                                           -
// ==========================================================================================
vc_map(
    array(
        'name' => __('Gallery with left filter', 'js_composer'),
        'base' => 'napoli_gallery_left_filter',
        'description' => __('Albums List filter with images', 'js_composer'),
        'category' => __('Content', 'js_composer'),
        'params' => array(
            array(
                'type' => 'vc_efa_chosen',
                'heading' => __('Select Albums', 'js_composer'),
                'param_name' => 'albums',
                'placeholder' => __('Select Albums', 'js_composer'),
                'value' => napoli_element_values('post', array(
                    'post_type' => 'portfolio',
                    'hide_empty' => false,
                    'numberposts' => -1
                )),
                'std' => '',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Style for gallery', 'js_composer'),
                'param_name' => 'style',
                'value' => array(
                    'Random columns' => 'random',
                    '2 columns' => 'columns2',
                    '3 columns' => 'columns3',
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
        )
    )
);

function napoli_gallery_left_filter($atts, $content = '', $id = '')
{

    extract(shortcode_atts(array(
        'albums' => '',
        'popup_style_info' => 'default',
        'detail_style' => 'default',
        'style' => ''
    ), $atts));

    if (!empty($albums)) {
        $posts = explode(',', $albums);
        ?>
        <div class="container-fluid albums-left-filter <?php echo esc_attr($style); ?>">
        <div class="row">
        <div class="col-xs-12 col-md-2 no-padd">
            <div class="button-group filters-button-group">
                <button data-filter="*"
                        class="button is-checked"><?php esc_html_e('All', 'napoli'); ?></button>
                <?php
                foreach ($posts as $item) {
                    if (!empty($item)) {
                        echo '<button data-filter=".id' . esc_attr($item) . '" class="button">' . get_the_title($item) . '</button>';
                    } else {
                        echo '<button data-filter=".id' . esc_attr($item) . '" class="button">' . get_the_title($item) . '</button>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="col-xs-12 col-md-10 no-padd">
        <?php

        // base args
        $args = array(
            'post_type' => 'portfolio',
            'post__in' => $posts
        );

        $count = 0; ?>
        <div class="portfolio-wrapper">
        <div class="portfolio clearfix">
        <?php
        ob_start();

        $q = new WP_Query($args);
        if ($q->have_posts()) {
            while ($q->have_posts()) : $q->the_post();

                global $post;

                $portfolio_meta = get_post_meta($post->ID, 'napoli_portfolio_options');
                if (!empty($portfolio_meta[0]['slider'])) {
                    $slider = explode(',', $portfolio_meta[0]['slider']);

                    foreach ($slider as $item) {
                        if ($count == 15) {
                            $count = 0;
                        }
                        ?>
                        <div
                            class="element-item img-wrap-item id<?php echo esc_attr($post->ID . ' item' . $count); ?>">
                            <?php
                            $attachment = get_post($item);
                            $image_url = wp_get_attachment_url($item);
                            $image_metadata = @exif_read_data($image_url);
                            $popup_class = $popup_style_info == 'detail' ? 'popup-details' : '';
                            $data_fancy = $popup_style_info == 'detail' ? 'data-fancybox="images"' : '';
                            $url_popup = $popup_style_info == 'detail' ? '#content' . $item : $image_url; ?>
                            <a href="<?php echo esc_attr($url_popup); ?>" <?php echo $data_fancy; ?>
                               class="gallery-item <?php echo esc_attr($popup_class); ?>">
                                <?php
                                echo napoli_the_lazy_load_flter($item, array(
                                    'class' => 's-img-switch'
                                ), true, 'large');
                                ?>
                            </a>

                            <?php if ($popup_style_info == 'detail') { ?>
                                <div id="content<?php echo esc_attr($item); ?>"
                                     class="popup-content-details">
                                    <div class="wrapper">
                                        <div class="img-wrap equal">
                                            <img src="<?php echo esc_url($image_url); ?>"
                                                 class="" alt="">
                                        </div>
                                        <div class="content equal">
                                            <?php if (!empty($attachment->post_excerpt)) { ?>
                                                <h5 class="img-title"><?php echo wp_kses_post($attachment->post_excerpt); ?></h5>
                                            <?php } ?>
                                            <div
                                                class="img-date"><?php the_time(get_option('date_format')); ?></div>
                                            <?php
                                            $focal_info = wp_get_attachment_metadata($item);

                                            if ($detail_style == 'custom') {
                                                if (!empty($item)) {
                                                    $image_info = napoli_wp_get_attachment($item);
                                                    $description = $image_info['description']; ?>
                                                    <div class="caption-images-portfolio-item">
                                                        <?php if (!empty($description)) {
                                                            echo do_shortcode($description);
                                                        } ?>
                                                    </div>
                                                <?php }
                                            } else {

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
                            <?php } ?>
                        </div>
                        <?php
                        $count++;
                    }
                }
								endwhile;
							} ?>
    <?php wp_reset_postdata(); ?>
    </div>
    </div>
    </div>
    </div>
    </div>
<?php }

return ob_get_clean();
}

add_shortcode('napoli_gallery_left_filter', 'napoli_gallery_left_filter');

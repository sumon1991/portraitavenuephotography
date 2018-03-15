<?php
if (function_exists('vc_map')) {
    vc_map(
        array(
            'name' => __('KenBurns Slider', 'js_composer'),
            'base' => 'ken_burns_slider',
            'params' => array(
                array(
                    'type' => 'attach_images',
                    'heading' => __('Images for banner', 'js_composer'),
                    'param_name' => 'images'
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Style slider', 'js_composer'),
                    'param_name' => 'type',
                    'value' => array(
                        'Zoom effect' => 'zoom',
                        'Fade effect' => 'fade-effect',
                    )
                ),
                array(
                    'type' => 'napoli_file',
                    'heading' => __('Sound Background', 'js_composer'),
                    'param_name' => 'napoli_file'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Sound Autoplay', 'js_composer'),
                    'param_name' => 'sound_autoplay',
                    'std' => '',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Extra class name', 'js_composer'),
                    'param_name' => 'el_class',
                    'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer'),
                    'value' => ''
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('CSS box', 'js_composer'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'js_composer')
                )
            ) //end params
        )
    );
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_ken_burns_slider extends WPBakeryShortCode
    {
        protected function content($atts, $content = null)
        {

            extract(shortcode_atts(array(
                'images' => '',
                'type' => 'zoom',
                'napoli_file' => '',
                'sound_autoplay' => '',
                'el_class' => '',
                'css' => '',
            ), $atts));

            $slides = explode(',', $images);

            $class = (!empty($el_class)) ? $el_class : '';
            $class .= vc_shortcode_custom_css_class($css, ' ');

            ob_start(); ?>

            <div class="kenburns-wrap <?php echo esc_attr($type); ?>">
                <div class="kenburns <?php echo esc_attr($class); ?>">

                    <?php

                    $count = 1;

                    foreach ($slides as $key => $slide) :
                        $url = (!empty($slide) && is_numeric($slide)) ? wp_get_attachment_image_src($slide, 'full') : '';
                        $url = is_array($url) ? $url[0] : $url;
                        $classimg = $count % 2 ? '' : '';
                        ?>
                        <div class="img <?php echo esc_attr($classimg); ?>"
                             style="background-image: url(<?php echo esc_attr($url); ?>);"></div>
                        <?php
                        $count++;
                    endforeach; ?>
                </div>

                <button class="kenburns-play pause"></button>


                <?php if (!empty($napoli_file)): ?>
                    <?php
                    $class_button = empty($sound_autoplay) ? '' : 'play';
                    $enable_autoplay = !empty($sound_autoplay) ? 'autoplay' : '';
                    ?>
                    <button class="napoli-sound-btn <?php echo esc_attr($class_button); ?>"></button>
                    <?php $mime_type = wp_check_filetype($napoli_file); ?>
                    <audio class="napoli-audio-file" <?php echo esc_attr($enable_autoplay); ?> preload loop>
                        <source src="<?php echo esc_url($napoli_file); ?>"
                                type="<?php echo esc_attr($mime_type['type']); ?>">
                    </audio>
                <?php endif; ?>
            </div>
            <?php return ob_get_clean();
        }
    }
}
<?php


// ==========================================================================================
// PORTFOLIO LIST                                                                           -
// ==========================================================================================
vc_map(
    array(
        'name' => __('Portfolio list', 'js_composer'),
        'base' => 'napoli_portfolio_list',
        'description' => __('List of portfolio items', 'js_composer'),
        'category' => __('Content', 'js_composer'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => __('Style', 'js_composer'),
                'param_name' => 'style',
                'value' => array(
                    'Simple' => 'sim',
                    'Classic' => 'cla',
                    'Classic Big' => 'cla_big',
                    'Grid' => 'grid',
                    'Big Gap' => 'big_gap',
                    'Masonry' => 'masonry',
                    'Slider simple' => 'slider_simple',
                    'Slider masonry' => 'slider_masonry',
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Image original size',
                'param_name' => 'image_original_size',
                'value'       => array_merge(array('full'),get_intermediate_image_sizes())
            ),
            array(
                'type' => 'vc_efa_chosen',
                'heading' => __('Select Categories', 'js_composer'),
                'param_name' => 'cats',
                'placeholder' => __('Select category', 'js_composer'),
                'value' => napoli_element_values('categories', array(
                    'sort_order' => 'ASC',
                    'taxonomy' => 'portfolio-category',
                    'hide_empty' => false,
                )),
                'std' => '',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Order by', 'js_composer'),
                'param_name' => 'orderby',
                'value' => array(
                    '',
                    __('Date', 'js_composer') => 'date',
                    __('ID', 'js_composer') => 'ID',
                    __('Author', 'js_composer') => 'author',
                    __('Title', 'js_composer') => 'title',
                    __('Modified', 'js_composer') => 'modified',
                    __('Random', 'js_composer') => 'rand',
                    __('Comment count', 'js_composer') => 'comment_count'
                ),
                'description' => sprintf(__('Select how to sort retrieved posts. More at %s.', 'js_composer'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Sort order', 'js_composer'),
                'param_name' => 'order',
                'value' => array(
                    __('Descending', 'js_composer') => 'DESC',
                    __('Ascending', 'js_composer') => 'ASC',
                ),
                'description' => sprintf(__('Select ascending or descending order. More at %s.', 'js_composer'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Autoplay', 'js_composer'),
                'description' => __('0 - off autoplay. (milliseconds)', 'js_composer'),
                'param_name' => 'autoplay',
                'value' => '0',
                'dependency' => array('element' => 'style', 'value' => array('slider_simple', 'slider_masonry'))
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Speed (milliseconds)', 'js_composer'),
                'description' => __('Speed Animation. Default 1000 milliseconds', 'js_composer'),
                'param_name' => 'speed',
                'value' => '1000',
                'dependency' => array('element' => 'style', 'value' => array('slider_simple', 'slider_masonry'))
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Loop', 'js_composer'),
                'param_name' => 'loop',
                'value' => '0',
                'dependency' => array('element' => 'style', 'value' => array('slider_simple', 'slider_masonry'))
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Select count of columns', 'js_composer'),
                'param_name' => 'columns_number',
                'value' => array(
                    'Four' => 'col-4',
                    'Three' => 'col-3',
                    'Two' => 'col-6'
                ),
                'dependency' => array('element' => 'style',
                    'value_not_equal_to' => array('slider_simple', 'slider_masonry')
                )
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
                'dependency' => array(
                    'element' => 'style',
                    'value_not_equal_to' => array('slider_simple', 'slider_masonry')
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Reverse hover', 'js_composer'),
                'param_name' => 'reverse',
                'value' => array(__('Yes, please', 'js_composer') => 'yes'),
                'dependency' => array('element' => 'style',
                    'value_not_equal_to' => array('slider_simple', 'slider_masonry')
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show Share Icons', 'js_composer'),
                'param_name' => 'show_share_icons',
                'value' => array(__('Yes', 'js_composer') => 'on'),
                'std' => 'off',
                'dependency' => array('element' => 'style', 'value' => array('big_gap'))
            ),
            array(
                'type' => 'param_group',
                'heading' => __('Social Icons', 'js_composer'),
                'param_name' => 'socials',
                'value' => urlencode(json_encode(array(
                    array(
                        'title' => __('Facebook', 'js_composer'),
                        'icon' => 'fa-facebook',
                        'link' => '-',
                    ),
                    array(
                        'title' => __('Pinterest', 'js_composer'),
                        'icon' => 'fa-pinterest-p',
                        'link' => '-',
                    ),
                    array(
                        'title' => __('Twitter', 'js_composer'),
                        'icon' => 'fa-twitter',
                        'link' => '-',
                    ),
                    array(
                        'title' => __('Linkedin', 'js_composer'),
                        'icon' => 'fa-linkedin',
                        'link' => '-',
                    ),
                    array(
                        'title' => __('Mail', 'js_composer'),
                        'icon' => 'fa-envelope-o',
                        'link' => '-',
                    ),
                ))),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Icon', 'js_composer'),
                        'param_name' => 'icon',
                        'value' => 'facebook'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Link', 'js_composer'),
                        'param_name' => 'link',
                        'value' => '-'
                    ),

                ),
                'dependency' => array('element' => 'style', 'value' => array('big_gap'))
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Add category filter?', 'js_composer'),
                'param_name' => 'filter',
                'value' => array(__('Yes, please', 'js_composer') => 'yes'),
                'dependency' => array('element' => 'style',
                    'value_not_equal_to' => array('slider_simple', 'slider_masonry')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Count items', 'js_composer'),
                'param_name' => 'count',
                'dependency' => array('element' => 'style',
                    'value_not_equal_to' => array('slider_simple', 'slider_masonry')
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Enable pager', 'js_composer'),
                'param_name' => 'pager',
                'value' => array(__('Yes, please', 'js_composer') => 'yes'),
                'dependency' => array(
                    'element' => 'style',
                    'value_not_equal_to' => array('slider_simple', 'slider_masonry')
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Linked to detail page',
                'param_name' => 'linked',
                'value' => array(
                    'Yes' => 'yes',
                    'None' => 'none'
                )
            ),
        )
    )
);

function napoli_portfolio_list($atts, $content = '', $id = '')
{

    extract(shortcode_atts(array(
        'cats' => '',
        'reverse' => '',
        'image_original_size' => 'full',
        'linked' => 'yes',
        'style' => 'sim',
        'show_share_icons' => 'off',
        'hover' => 'default',
        'socials' => '',
        'filter' => '',
        'count' => '',
        'orderby' => '',
        'order' => 'date',
        'pager' => '',
        'autoplay' => '0',
        'loop' => '0',
        'speed' => '1000',
        'columns_number' => ''
    ), $atts));


    $autoplay = is_numeric($autoplay) ? $autoplay : 0;
    $speed = is_numeric($speed) ? $speed : '1000';
    $loop = !empty($loop) ? '1' : '0';


    // base args
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => (!empty($count) && is_numeric($count)) ? $count : 9,
        'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
    );
// Order posts
    if (null !== $orderby) {
        $args['orderby'] = $orderby;
    }
    $args['order'] = $order;

    // category
    if (!empty($cats)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio-category',
                'field' => 'term_id',
                'terms' => explode(',', $cats),
            )
        );
    }

    if ($filter == 'yes' && $style != 'slider_masonry' && $style != 'slider_simple') { ?>
        <div class="filter <?php echo esc_attr($style); ?>">
            <ul>
                <li data-group="all" class="active"><?php esc_html_e('all', 'napoli'); ?></li>
                <?php
                $categories = get_terms('portfolio-category', '');
                foreach ($categories as $category) {
                    if (!empty($cats)) {
                        if (in_array($category->term_id, explode(',', $cats)) !== false) {
                            echo '<li data-group="' . $category->slug . '">' . $category->name . '</li>';
                        }
                    } else {
                        echo '<li data-group="' . $category->slug . '">' . $category->name . '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    <?php } ?>

    <?php


    if (isset($columns_number) && !empty($columns_number) && $columns_number != 'col-4' && ($style == 'sim' || $style == 'masonry')) {
        $columns_number_sim = $columns_number;
    } else {
        $columns_number_sim = 'col-4';
    }

    if (isset($columns_number) && !empty($columns_number) && $columns_number != 'col-4' && ($style == 'cla' || $style == 'cla_big' || $style == 'grid')) {
        $columns_number_cla = $columns_number;
    } else {
        $columns_number_cla = 'col-3';
    }

    if (isset($columns_number) && !empty($columns_number) && $columns_number != 'col-6' && $style == 'big_gap') {
        $columns_number_big = $columns_number;
    } else {
        $columns_number_big = 'col-6';
    }

    // classes style
    $classes = array(
        'sim' => array('clearfix', $columns_number_sim . ' simple'),
        'cla' => array('container', $columns_number_cla . ' classic'),
        'cla_big' => array('', $columns_number_cla . ' classic big'),
        'grid' => array('container', $columns_number_cla . ' grid'),
        'big_gap' => array('container', $columns_number_big . ' big_gap'),
        'masonry' => array('', $columns_number_sim . ' masonry'),
    );

    $space = ($style == 'big_gap') ? '40' : '15';

    if ($style != 'slider_masonry' && $style != 'slider_simple') { ?>
        <div class="portfolio-wrapper <?php echo esc_html($classes[$style][0]); ?>">
        <div class="portfolio no-padd <?php echo esc_html($classes[$style][1]); ?> clearfix" data-space="<?php echo esc_attr($space); ?>">
        <?php
    }
    ob_start();
    $counter = 0;

if ($style == 'slider_masonry' || $style == 'slider_simple'){
if ($style == 'slider_masonry'){ ?>
    <div class="container no-padd">
    <?php } ?>
    <div class="swiper-container portfolio-slider-wrapper <?php echo esc_attr($style); ?>"
         data-autoplay="<?php echo esc_attr($autoplay); ?>"
         data-loop="<?php echo esc_attr($loop); ?>" data-speed="<?php echo esc_attr($speed); ?>"
         data-slides-per-view="responsive" data-add-slides="1" data-xs-slides="1" data-sm-slides="1" data-md-slides="1"
         data-lg-slides="1">
    <div class="swiper-wrapper">
<?php }

    $q = new WP_Query($args);
    if ($q->have_posts()) {
        $socials_array = array();
        while ($q->have_posts()) :
            $q->the_post();

            global $post;
            $meta_data = get_post_meta(get_the_ID(), 'napoli_portfolio_options', true);
            if ($counter == 9) {
                $counter = 0;
            }

            if ($style == 'big_gap' && $counter == 7) {
                $counter = 0;
            }
            $portfolio_category_items = '';
            $portfolio_category = '';
            $categories = get_the_terms($q->ID, 'portfolio-category');
            if ($categories) {
                foreach ($categories as $categorsy) {
                    $portfolio_category .= $categorsy->slug . ' ';
                    $portfolio_category_items .= '<span>' . trim($categorsy->slug) . '</span>';
                }
            }

            $portfolio_meta = get_post_meta($post->ID, 'napoli_portfolio_options');
            $img_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
            $images = explode(',', $portfolio_meta[0]['slider']);
            ?>

            <?php if ($style != 'slider_masonry' && $style != 'slider_simple') { ?>

            <div class="item block_item_<?php echo esc_attr($counter); ?>"
                 data-groups="<?php echo esc_attr(trim($portfolio_category)); ?>">

                <?php $link = get_the_permalink();

                $target = '_self';

                if ($linked == 'none' && !empty($meta_data['ext_link'])) {
                    $link = $meta_data['ext_link'];
                    $target = '_blank';
                } ?>

                <a href="<?php echo esc_url($link); ?>"
                   class="item-link gridrotate-alb <?php echo esc_attr($hover . ' ' . $reverse); ?>" target="<?php echo esc_attr($target);?>">
                    <?php
                    if ($style == 'masonry') {
                        if (get_post_thumbnail_id($post->ID) || !empty($images[0])) {
                            $image = get_post_thumbnail_id($post->ID) ? get_post_thumbnail_id($post->ID) : $images[0];
                            $image_url = (!empty($image) && is_numeric($image)) ? wp_get_attachment_image_src($image, $image_original_size) : '';
                            $alt = get_post_meta($image, '_wp_attachment_image_alt', true);
                            echo napoli_the_lazy_load_flter($image_url[0], array(
                                'class' => 'dsds',
                                'alt' => $alt
                            ));
                        }
                    } else { ?>
                        <div class="item-img">
                            <?php
                            if (!get_post_thumbnail_id($post->ID)) {
                                if (count($images) >= 9 && $style == 'cla') {
                                    $images = array_slice($images, 0, 9);

                                    foreach ($images as $image) {
                                        $url = (!empty($image) && is_numeric($image)) ? wp_get_attachment_image_src($image, $image_original_size) : '';
                                        $alt = get_post_meta($image, '_wp_attachment_image_alt', true); ?>
                                        <div class="images">
                                            <?php echo napoli_the_lazy_load_flter($url[0], array(
                                                'class' => 's-img-switch',
                                                'alt' => $alt
                                            )); ?>
                                        </div>
                                        <?php
                                    }
                                } elseif ($style == 'sim' || $style == 'grid' || $style == 'big_gap') {
                                    $image = get_post_thumbnail_id($post->ID) ? get_post_thumbnail_id($post->ID) : $images[0];
                                    $image_url = (!empty($image) && is_numeric($image)) ? wp_get_attachment_image_src($image, $image_original_size) : '';
                                    if (!empty($image)) {
                                        $alt = get_post_meta($image, '_wp_attachment_image_alt', true);

                                        ?>
                                        <div class="images-one">
                                            <?php
                                            echo napoli_the_lazy_load_flter($image_url[0], array(
                                                'class' => 's-img-switch',
                                                'alt' => $alt
                                            ));
                                            ?>
                                        </div>
                                        <?php
                                    }
                                }
                            } else {
                                $image_id = get_post_thumbnail_id($post->ID);
                                $image = (is_numeric($image_id) && !empty($image_id)) ?wp_get_attachment_image_src($image_id, $image_original_size) : '';
                                $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true); ?>
                                <div class="images-one">
                                    <?php echo napoli_the_lazy_load_flter($image[0], array(
                                        'class' => 's-img-switch',
                                        'alt' => $alt
                                    )); ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    <?php } ?>
                    <div class="item-overlay">
                        <?php if ($style != 'grid' && $style != 'big_gap' && $style != 'masonry') { ?>
                            <?php the_title('<h5 class="portfolio-title">', '</h5>'); ?>
                        <?php } ?>

                        <?php if ($style == 'cla_big') { ?>
                            <div class="categories">
                                <?php
                                $id = $post->ID;
                                $taxonomy = 'portfolio-category';
                                $terms = get_the_terms($id, $taxonomy);

                                $links = array();

                                if (!empty($terms)) {

                                    foreach ($terms as $term) {
                                        $links[] = $term->name;
                                    }

                                    echo wp_kses_post(trim(join('/', $links)));
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($style == 'big_gap') { ?>
                        <?php the_title('<h5 class="portfolio-title">', '</h5>'); ?>
                    <?php } ?>
                    <?php if ($style == 'big_gap' && $show_share_icons == 'on')  :
                        if (!empty($socials)) :
                            $socials_array[$counter] = (array)vc_param_group_parse_atts($socials);
                            ?>
                            <ul class="big_gap_share">
                                <?php
                                foreach ($socials_array[$counter] as $key => $social) :
                                    if ($social['icon'] == 'fa-facebook') { ?>
                                        <li>
                                            <button class="fa fa-facebook"
                                                    data-share="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>"></button>
                                        </li>
                                    <?php } elseif ($social['icon'] == 'fa-pinterest-p') { ?>
                                        <li>
                                            <button class="fa fa-pinterest-p"
                                                    data-share="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                                                    echo $url; ?>"></button>
                                        </li>
                                    <?php } elseif ($social['icon'] == 'fa-twitter') { ?>
                                        <li>
                                            <button class="fa fa-twitter"
                                                    data-share="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?>"></button>
                                        </li>
                                    <?php } elseif ($social['icon'] == 'fa-linkedin') { ?>
                                        <li>
                                            <button class="fa fa-linkedin"
                                                    data-share="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>"></button>
                                        </li>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; endif; ?>

                </a>

                <?php if ($style == 'grid' || $style == 'masonry') { ?>
                    <div class="item-portfolio-content">
                        <?php the_title('<h5 class="portfolio-title"><a href="' . esc_url($link) . '">', '</a></h5>'); ?>
                        <?php if ($style == 'grid') { ?>
                            <div class="category">
                                <?php the_terms($post->ID, 'portfolio-category'); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

        <?php } ?>
            <?php if ($style == 'slider_masonry') { ?>
            <div class="swiper-slide">
                <?php if (!get_post_thumbnail_id($post->ID)) {
                    if (count($images) >= 5) {
                        $images = array_slice($images, 0, 5); ?>
                        <div class="images-slider-wrapper main izotope-container-3 clearfix">
                            <?php foreach ($images as $image) {
                                $url = (!empty($image) && is_numeric($image)) ? wp_get_attachment_image_src($image, $image_original_size) : '';
                                $alt = get_post_meta($image, '_wp_attachment_image_alt', true); ?>
                                <div class="images">
                                    <?php echo napoli_the_lazy_load_flter($url[0], array(
                                        'class' => 's-img-switch',
                                        'alt' => $alt
                                    )); ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="images-slider-wrapper clearfix">
                            <?php
                            $url = (!empty($images[0]) && is_numeric($images[0])) ? wp_get_attachment_image_src($image, $image_original_size) : '';
                            $alt = get_post_meta($images[0], '_wp_attachment_image_alt', true);
                            ?>
                            <div class="images-one">
                                <img src="<?php echo esc_url($url[0]); ?>" alt="<?php echo esc_attr($alt); ?>"
                                     class="s-img-switch">
                            </div>
                        </div>
                    <?php }
                } else {
                    $image_id = get_post_thumbnail_id($post->ID);
                    $image = (is_numeric($image_id) && !empty($image_id)) ? wp_get_attachment_image_src($image_id, $image_original_size) : '';
                    $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true); ?>
                    <div class="images-slider-wrapper clearfix">
                        <div class="images-one">
                            <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr($alt); ?>"
                                 class="s-img-switch">
                        </div>
                    </div>
                <?php } ?>
                <div class="gallery-content-wrap">
                    <?php the_title('<h5 class="portfolio-title">', '</h5>'); ?>
                    <?php the_excerpt(); ?>

                    <?php $link = get_the_permalink();

                    $target = '_self';

                    if ($linked == 'none' && !empty($meta_data['ext_link'])) {
                        $link = $meta_data['ext_link'];
                        $target = '_blank';
                    } ?>


                    <a href="<?php echo esc_url($link); ?>" class="a-btn-2" target="<?php echo esc_attr($target); ?>"><?php esc_html_e('LOOK ALBUM'); ?></a>
                </div>
            </div>
        <?php } elseif ($style == 'slider_simple') { ?>
            <div class="swiper-slide">
                <?php
                if (!get_post_thumbnail_id($post->ID)) { ?>

                    <?php $link = get_the_permalink();

                    $target = '_self';

                    if ($linked == 'none' && !empty($meta_data['ext_link'])) {
                        $link = $meta_data['ext_link'];
                        $target = '_blank';
                    } ?>
                    <a href="<?php echo esc_url($link); ?>" class="images-slider-wrapper clearfix" target="<?php echo esc_attr($target); ?>">
                        <?php
                        $url = (!empty($images[0]) && is_numeric($images[0])) ? wp_get_attachment_image_src($images[0], $image_original_size) : '';
                        $alt = get_post_meta($images[0], '_wp_attachment_image_alt', true); ?>
                        <div class="images-one">
                            <img src="<?php echo esc_url($url[0]); ?>" alt="<?php echo esc_attr($alt); ?>"
                                 class="s-img-switch">
                        </div>
                    </a>
                    <?php
                    $image_metadata = @exif_read_data($image);
                    $focal_info = wp_get_attachment_metadata($images[0]);
                } else {
                    $image_id = get_post_thumbnail_id($post->ID);
                    $image = (is_numeric($image_id) && !empty($image_id)) ? wp_get_attachment_image_src($image_id, $image_original_size) : '';
                    $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    $image_metadata = @exif_read_data($image);
                    $focal_info = wp_get_attachment_metadata($image_id);?>

                    <?php $link = get_the_permalink();

                    $target = '_self';

                    if ($linked == 'none' && !empty($meta_data['ext_link'])) {
                        $link = $meta_data['ext_link'];
                        $target = '_blank';
                    } ?>

                    <a href="<?php echo esc_url($link); ?>" class="images-slider-wrapper clearfix" target="<?php echo esc_attr($target); ?>">
                        <div class="images-one">
                            <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr($alt); ?>"
                                 class="s-img-switch">
                        </div>
                    </a>
                <?php } ?>
                <div class="gallery-content-wrap">
                    <h3 class="portfolio-category"><?php echo wp_kses_post($portfolio_category_items); ?></h3>
                    <?php the_title('<h5 class="portfolio-title">', '</h5>'); ?>
                    <?php
                    if (!empty($image_metadata['Model']) || !empty($focal_info['image_meta']['focal_length']) || !empty($image_metadata['COMPUTED']['ApertureFNumber']) || !empty($image_metadata['ExposureTime']) || !empty($image_metadata['ISOSpeedRatings'])) { ?>
                        <div class="info-wrap">
                            <span class="info">i</span>
                            <div class="caption-images-portfolio">
                                <?php if (!empty($image_metadata['Model'])) { ?>
                                    <div class="caption-images-portfolio-item">
                                        <span><img
                                                src="<?php echo get_template_directory_uri() . '/assets/images/camera.png' ?>"
                                                alt="camera"></span>
                                        <p><?php echo esc_html(trim($image_metadata['Model'])); ?></p>
                                    </div>
                                <?php }
                                if (!empty($focal_info['image_meta']['focal_length'])) {
                                    $focal_length = $focal_info['image_meta']['focal_length']; ?>
                                    <div class="caption-images-portfolio-item">
                                        <span><img
                                                src="<?php echo get_template_directory_uri() . '/assets/images/focal_length.png' ?>"
                                                alt="camera"></span>
                                        <p><?php echo esc_html($focal_length); ?><?php esc_html_e('mm', 'napoli'); ?></p>
                                    </div>
                                <?php }
                                if (!empty($image_metadata['COMPUTED']['ApertureFNumber'])) { ?>
                                    <div class="caption-images-portfolio-item">
                                        <span><img
                                                src="<?php echo get_template_directory_uri() . '/assets/images/aperture.png' ?>"
                                                alt="camera"></span>
                                        <p><?php echo esc_html($image_metadata['COMPUTED']['ApertureFNumber']); ?></p>
                                    </div>
                                <?php }
                                if (!empty($image_metadata['ExposureTime'])) { ?>
                                    <div class="caption-images-portfolio-item">
                                        <span><img
                                                src="<?php echo get_template_directory_uri() . '/assets/images/shutter_speed.png' ?>"
                                                alt="camera"></span>
                                        <p><?php echo esc_html($image_metadata['ExposureTime']); ?></p>
                                    </div>
                                <?php }
                                if (!empty($image_metadata['ISOSpeedRatings'])) {
                                    $iso = is_array($image_metadata['ISOSpeedRatings']) ? reset($image_metadata['ISOSpeedRatings']) : $image_metadata['ISOSpeedRatings']; ?>
                                    <div class="caption-images-portfolio-item">
                                        <span><img
                                                src="<?php echo get_template_directory_uri() . '/assets/images/iso.png' ?>"
                                                alt="camera"></span>
                                        <p><?php echo esc_html(trim($iso)); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        <?php }
            $counter++;
        endwhile;
    } ?>


    </div>


    <?php if ($style == 'slider_masonry' || $style == 'slider_simple'){ ?>

    <div class="pagination"></div>
    </div>
    <?php if ($style == 'slider_masonry'){ ?>
    </div>
<?php } ?>
    <div class="swiper-outer-left portfolio-pagination <?php echo esc_attr($style); ?>"></div>
    <div class="swiper-outer-right portfolio-pagination <?php echo esc_attr($style); ?>"></div>
<?php } ?>

    <?php if (!empty($pager) && $pager == 'yes') : ?>
    <div class="pager-pagination">
        <?php
        $big = 999999999;
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $q->max_num_pages,
            'prev_text' => esc_html__('Previous', 'napoli'),
            'next_text' => esc_html__('Next', 'napoli')
        ));
        ?>
    </div>
<?php endif;

    wp_reset_postdata(); ?>
    <?php if ($style != 'slider_masonry' && $style != 'slider_simple'){ ?>
    </div>
<?php } ?>
    <?php return ob_get_clean();
}

add_shortcode('napoli_portfolio_list', 'napoli_portfolio_list');

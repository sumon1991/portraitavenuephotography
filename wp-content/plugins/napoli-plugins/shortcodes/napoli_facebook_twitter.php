<?php
/**
 *
 * Instagram
 * @since 1.0.0
 * @version 1.1.0
 *
 */

// ==========================================================================================
// INSTAGRAM                                                                          -
// ==========================================================================================


$extra_class = array(
    'type' => 'textfield',
    'heading' => __('Extra class name', 'js_composer'),
    'param_name' => 'el_class',
    'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer'),
    'value' => '',
);
$css_editor = array(
    'type' => 'css_editor',
    'heading' => __('CSS box', 'js_composer'),
    'param_name' => 'css',
    'group' => __('Design options', 'js_composer'),
);

vc_map(array(
    'name' => __('Social Recent Posts', 'js_composer'),
    'base' => 'napoli_facebook',
    'content_element' => true,
    'show_settings_on_create' => true,
    'description' => __('Recent Posts from Facebook and Twitter', 'js_composer'),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __('Facebook Page Id or Slug', 'js_composer'),
            'param_name' => 'fb_page_id',
            'description' => __('Insert id or slug public facebook page. (default from Theme Options)', 'js_composer'),
            'group' => 'Facebook Column',
        ),
        //twitter
        array(
            'type' => 'textfield',
            'heading' => __('Twiiter Page Id or Slug', 'js_composer'),
            'param_name' => 'twitter_page_slug',
            'value' => '',
            'group' => 'Twitter Column',
        ),
        array(
            'type' => 'textfield',
            'heading' => __('Count Symbol Twitt', 'js_composer'),
            'param_name' => 'twitter_symbol_count',
            'value' => '',
            'group' => 'Twitter Column',
        ),

        array(
            'type' => 'textfield',
            'heading' => __('Count Posts', 'js_composer'),
            'param_name' => 'count_post',
            'description' => __('', 'js_composer'),
        ),

        $extra_class,
        $css_editor,
    ) //end params
));

require_once plugin_dir_path(__FILE__) . 'napoli_social/facebook-posts.php';

class WPBakeryShortCode_napoli_facebook extends WPBakeryShortCode
{
    protected function content($atts, $content = null)
    {

        extract(shortcode_atts(array(
            'fb_page_id' => '',
            'twitter_page_slug' => '',
            'count_post' => '6',
            'el_class' => '',
            'css' => ''
        ), $atts));

        // start class
        $width_class = 'row wp-social-margin';
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width_class, $this->settings['base'], $atts);

        // custum css
        $css_class .= vc_shortcode_custom_css_class($css, ' ');

        // custum class
        $css_class .= (!empty($el_class)) ? ' ' . $el_class : '';

        $atts = (object)$atts;


        cs_get_option();

        // for Facebook
        if (!empty($twitter_page_slug)) {
            if ($count_post % 2 != 0) {
                $fb_limit = ceil($count_post / 2);
            } else {
                $fb_limit = $count_post / 2;
            }
        } else {
            $fb_limit = $count_post;
        }

        $app_id = cs_get_option('fb_app_id');
        $app_secret = cs_get_option('fb_secret_id');
        $posts = array();
        if (!empty($fb_page_id)) {

            $fb_api = new FB_API($app_id, $app_secret, $fb_page_id, $fb_limit);
            $posts = $fb_api->get_posts();

            if ($posts) {
                foreach ($posts as $post) {
                    $post = (object)$post;
                }
            }
        }

        // for Twitter
        $twitts = array();
        if (!empty($twitter_page_slug)) {
            $access_token = cs_get_option('tw_app_id');
            $access_token_secret = cs_get_option('tw_secret_id');
            $consumer_key = cs_get_option('tw_consumer_key');
            $consumer_secret = cs_get_option('tw_consumer_secret');
            $twitter_count = (!empty($fb_page_id) && !empty($posts)) ? $count_post / 2 : $count_post;

            $twitts = json_decode(napoli_get_twitts($twitter_page_slug, $twitter_count, $access_token, $access_token_secret, $consumer_key, $consumer_secret));

            if (!isset($twitts->errors)) {
                foreach ($twitts as $twitt) {
                    $datetime = new DateTime($twitt->created_at);
                    $twitt->timestamp = $datetime->format('U');
                    $twitt->type = 'twitter';
                }
            }
        }

        //merge facebook and twitter
        if ($posts || $twitts) {
            if (!isset($twitts->errors) && $posts) {
                $posts = array_merge($posts, $twitts);
            } else {
                $posts = $twitts;
            }
            if (!function_exists('sortPosts')) {
                function sortPosts($a1, $a2)
                {
                    @$time1 = $a1->timestamp;
                    @$time2 = $a1->timestamp;
                    if ($time1 == $time2) return 0;
                    return ($time1 > $time2) ? -1 : 1;
                }
            }

            usort($posts, "sortPosts");
        }

        // output
        ob_start();

        if ((!empty($fb_page_id)) || (!empty($twitter_page_slug))) {
            ?>
            <div>
                <div class="<?php echo esc_attr($css_class); ?>">

                    <?php
                    if ($posts) {
                        foreach ($posts as $post) { ?>
                            <div class="news-entry animatedBlock col-xs-12 col-sm-6 col-md-4">
                                <?php
                                $post = (object)$post;
                                $date = date('G:i F j, Y', $post->timestamp);

                                switch ($post->type) {
                                case 'link':
                                    ?>
                                    <div class="news type-1 facebook">
                                        <h4><a class="news-title"
                                               href="<?php echo esc_url($post->url); ?>"><?php echo esc_html($post->name); ?></a>
                                        </h4>
                                        <div class="news-date"><i
                                                class="fa fa-calendar"></i> <?php echo esc_html($date); ?></div>
                                        <a class="news-type"
                                           href="<?php echo 'https://www.facebook.com/' . $fb_page_id; ?>"><i
                                                class="fa fa-facebook"></i></a>
                                        <div class="news-likes">
                                            <a href="<?php echo esc_url($post->url); ?>"><i
                                                    class="fa fa-thumbs-o-up"></i> <?php echo esc_html($post->like_count); ?>
                                            </a>
                                            <a href="<?php echo esc_url($post->url); ?>"><i
                                                    class="fa fa-comment-o"></i> <?php echo esc_html($post->comment_count); ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                break;
                                case 'status':
                                ?>
                                    <div class="news type-1 facebook">
                                        <h4><a class="news-title"
                                               href="<?php echo esc_html($post->url); ?>"><?php echo esc_html(napoli_maxsite_str_word($post->content)); ?></a>
                                        </h4>
                                        <div class="news-date"><i
                                                class="fa fa-calendar"></i> <?php echo esc_html($date); ?></div>
                                        <a class="news-type"
                                           href="<?php echo 'https://www.facebook.com/' . $fb_page_id; ?>"><i
                                                class="fa fa-facebook"></i></a>
                                        <div class="news-likes">
                                            <a href="<?php echo esc_url($post->url); ?>"><i
                                                    class="fa fa-thumbs-up"></i> <?php echo esc_html($post->like_count); ?>
                                            </a>
                                            <a href="<?php echo esc_url($post->url); ?>"><i
                                                    class="fa fa-comment"></i> <?php echo esc_html($post->comment_count); ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                break;
                                case 'photo':
                                ?>
                                    <div class="news type-2">
                                        <div class="wp-b-news-entry-wrap img-wrap">
                                            <img class="s-img-switch" src="<?php echo esc_attr($post->image); ?>"
                                                 alt="">
                                        </div>
                                        <div class="news-desc">
                                            <h4><a class="news-title"
                                                   href="<?php echo esc_html($post->url); ?>"><?php echo esc_html(napoli_maxsite_str_word($post->content)); ?></a>
                                            </h4>
                                            <div class="news-date"><i
                                                    class="fa fa-calendar"></i> <?php echo esc_html($date); ?></div>
                                        </div>
                                    </div>
                                <?php
                                break;
                                case 'twitter':
                                ?>
                                    <div class="news type-1 twitter">
                                        <?php $post->text = substr($post->text, 0, 70); ?>
                                        <h4><a class="news-title"
                                               href="<?php echo esc_url('https://twitter.com/' . $post->user->screen_name); ?>"><?php echo esc_html($post->text . '...'); ?></a>
                                        </h4>
                                        <div class="news-date"><i
                                                class="fa fa-calendar"></i> <?php echo esc_html($date); ?></div>
                                        <a class="news-type" rel="nofollow" target="_blank"
                                           href="<?php echo esc_url('https://twitter.com/' . $post->user->screen_name); ?>"><i
                                                class="fa fa-twitter"></i></a>
                                        <div class="news-likes">

                                            <?php if (!empty($post->retweet_count)) { ?>
                                                <a href="<?php echo esc_url('https://twitter.com/' . $post->user->screen_name); ?>"><i
                                                        class="fa fa-retweet"></i> <?php echo esc_html($post->retweet_count); ?>
                                                </a>
                                            <?php } ?>

                                            <?php if (!empty($post->favorite_count)) { ?>
                                                <a href="<?php echo esc_url('https://twitter.com/' . $post->user->screen_name); ?>"><i
                                                        class="fa fa-heart"></i> <?php echo esc_html($post->favorite_count); ?>
                                                </a>
                                            <?php } ?>

                                        </div>
                                    </div>
                                <?php
                                break;
                                case 'video':
                                ?>
                                    <div id="fb-root"></div>
                                    <script>(function (d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (d.getElementById(id)) return;
                                            js = d.createElement(s);
                                            js.id = id;
                                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));</script>

                                    <!-- Your embedded video player code -->
                                    <div class="news type-2">
                                        <div class="wp-b-news-entry-wrap">
                                            <div class="fb-video" data-show-captions="false" data-show-text="false"
                                                 data-href="<?php echo esc_attr($post->post_link) ?>"
                                                 data-height="121"></div>
                                        </div>
                                        <div class="news-desc">
                                            <h4><a class="news-title"
                                                   href="<?php echo esc_html($post->url); ?>"><?php echo esc_html(napoli_maxsite_str_word($post->content)); ?></a>
                                            </h4>
                                            <div class="news-date"><i
                                                    class="fa fa-calendar"></i> <?php echo esc_html($date); ?></div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                } // end switch
                                ?>
                            </div>
                            <?php
                        } //end foreach
                    } else { ?>
                        <div class="news-entry col-xs-12 col-sm-6 col-md-4">
                            <?php esc_html_e('NO DATA Facebook or Twitter', 'napoli'); ?><br>
                            <?php esc_html_e('Check Options Themes', 'napoli'); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <?php
        } else {
            ?>
            <div>
                <div class="<?php echo esc_attr($css_class); ?>">
                    <?php
                    if (empty($fb_page_id)) {
                        echo __('Not Found Facebook Page Id or Slug', 'napoli');
                    }
                    if (empty($twitter_page_slug)) {
                        echo __('Not Found Twitter Page Id or Slug', 'napoli');
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        // end output
        return ob_get_clean();

    } // end function content
}

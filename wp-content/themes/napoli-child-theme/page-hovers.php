<?php
/**
 * Template Name: Hovers
 *
 * @package WordPress
 * @subpackage Napoli
 * @since Napoli 1.0
 */

get_header();

while ( have_posts() ) : the_post();
$content = get_the_content();
if ( ! strpos( $content, 'vc_' ) ) {
    if ( get_the_title() ) { ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 select-for-hovers no-padd">
                    <div class="content">
                        <h5>You use hover:</h5>
                        <div class="hover">
                            <span>Default</span>
                            <ul class="list">
                                <li data-hover="">Default</li>
                                <li data-hover="hover1">Zoom Out</li>
                                <li data-hover="hover2">Slide</li>
                                <li data-hover="hover3">Rotate</li>
                                <li data-hover="hover4">Blur</li>
                                <li data-hover="hover5">Gray Scale</li>
                                <li data-hover="hover6">Sepia</li>
                                <li data-hover="hover7">Blur + Gray Scale</li>
                                <li data-hover="hover8">Opacity</li>
                                <li data-hover="hover9">Shine</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="portfolio-wrapper">
                    <div class="portfolio simple clearfix no-padd" data-space="15" style="margin-left: -15px; margin-right: -15px;">
                        <div class="wpb_column vc_column_container vc_col-sm-12">
                            <div class="vc_column-inner vc_custom_1472736802884"><div class="wpb_wrapper shuffle" style="position: relative; height: 783px; transition: height 250ms ease-out; margin:0px -10px;">
                                    <div class="item shuffle-item filtered" data-groups="design" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/undisclosed-desires/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-156362121.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-156362121.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Marilyn</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="design" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(326px, 0px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/panic-station/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2016/01/1jNxyjqDRXM.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2016/01/1jNxyjqDRXM.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Stonehand’s bridge</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="design nature" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(652px, 0px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/drones/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-164804713.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-164804713.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Golden section set</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="design" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(978px, 0px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/unintended/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/1-2.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/1-2.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Mirrors</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="nature" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(0px, 261px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/map-of-the-problematique/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/u2vtIV_g0k.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/u2vtIV_g0k.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Portaits</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="design" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(326px, 261px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/space-dementia/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-165894545.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-165894545.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Elizabeth and Marcus</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="fashion nature" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(652px, 261px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/follow-me/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-139453093.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-139453093.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Valkyrie</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="fashion" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(978px, 261px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/citizen-erased/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-150237317.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-150237317.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Smoking</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="fashion" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(0px, 522px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/neutron-star-collision-2/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-164619051.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/stock-photo-164619051.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>Dryad</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="design" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(326px, 522px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/redhead/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2016/10/portfolio_10.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2016/10/portfolio_10.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>REDHEAD</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="fashion" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(652px, 522px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/the-lake/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2016/10/portfolio_12.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2016/10/portfolio_12.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>THE LAKE</h5>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item  shuffle-item filtered" data-groups="nature" style="width: 25%; position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(978px, 522px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 250ms ease-out, opacity 250ms ease-out;">
                                        <a href="http://foxthemes.com/web/wp/napoli.1.8.0/portfolio-item/foggy-morning/" class="item-link gridrotate-alb" style="margin: 15px;">
                                            <div class="item-img">
                                                <div class="images-one s-back-switch" style="background-image: url(&quot;http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/7-1.jpg&quot;);">
                                                    <img src="http://foxthemes.com/web/wp/napoli.1.8.0/wp-content/uploads/2015/06/7-1.jpg" alt="" class="s-img-switch" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="item-overlay">
                                                <h5>FOGGY MORNING</h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
} else { ?>

<?php } 

endwhile;
get_footer();
?>

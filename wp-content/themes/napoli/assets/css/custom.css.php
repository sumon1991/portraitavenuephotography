<?php 
header("Content-type: text/css; charset: UTF-8");
echo cs_get_option( 'custom-css' );

$style = '';
///HEADER LOGO//////////////////////////////////////////////////////
if ( cs_get_option('site_logo') == 'txtlogo' ) {
    //Header logo text
    if ( cs_get_option('text_logo_style') == 'custom' ) {

        $style .= 'a.logo span{';
        $style .=  cs_get_option('text_logo_color') && cs_get_option('text_logo_color') !== '#fff' ? 'color:' . cs_get_option('text_logo_color') . ' !important;' : '';
        $style .=  cs_get_option('text_logo_width') ? 'width:' . cs_get_option('text_logo_width') . ' !important;' : '';
        $style .=  cs_get_option('text_logo_font_size') ? 'font-size:' . cs_get_option('text_logo_font_size') . ' !important;' : '';
        $style .= '}';
    }

} else {
    //Header logo image
    if ( cs_get_option('img_logo_style') == 'custom' ) {
        $style .= '.logo img {';
        if (cs_get_option('img_logo_width')) {
            $logo_width = is_integer(cs_get_option('img_logo_width')) ? cs_get_option('img_logo_width') . 'px' : cs_get_option('img_logo_width'); 
             $style .=  cs_get_option('img_logo_width') ? 'width:' . esc_attr($logo_width) . ' !important;' : '';
        }
        if (cs_get_option('img_logo_height')) {
            $logo_height = is_integer(cs_get_option('img_logo_height')) ? cs_get_option('img_logo_height') . 'px' : cs_get_option('img_logo_height'); 
             $style .=  cs_get_option('img_logo_height') ? 'height:' . esc_attr( $logo_height ) . ' !important;' : '';
             $style .=  cs_get_option('img_logo_height') ? 'max-height:' . cs_get_option('img_logo_height') . ' !important;' : '';
        }
       
        
        $style .= '}';
    }
}
echo esc_html($style);

?>

/*HEADER COLOR*/
<?php if (cs_get_option( 'menu_bg_color') && cs_get_option('menu_bg_color') !== '#ffffff') { ?>
.header_top_bg,
#topmenu {
  background-color: <?php echo esc_html(cs_get_option( 'menu_bg_color')) ?>;
}
<?php } ?>

<?php if (cs_get_option( 'menu_font_color') && cs_get_option('menu_font_color') !== '#131313' ) { ?>
#topmenu ul li a,
.right-menu .logo span {
  color: <?php echo esc_html(cs_get_option( 'menu_font_color')) ?>;
}
<?php } ?>

<?php // wave color
if ( cs_get_option('menu_underline_wave_color') && !cs_get_option( 'default_underline_deleted') ) :
?>
.right-menu #topmenu > ul > li > a::before,
.top-menu #topmenu > ul > li > a::before{
    background-image: url('data:image/svg+xml;utf8,<svg width="8" height="4" viewBox="0 0 8 4" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.5c-.588 0-.94.375-1.53 1C6 3.125 5.177 4 4 4c-1.294 0-1.882-.875-2.47-1.5-.47-.625-.824-1-1.53-1V0c1.294 0 1.882.875 2.47 1.5.47.625.824 1 1.53 1 .588 0 .94-.375 1.53-1C6 .875 6.823 0 8 0v1.5z" fill="<?php echo esc_attr( cs_get_option('menu_underline_wave_color') ); ?>" fill-rule="evenodd"/></svg>');
}
<?php endif; ?>

<?php if (cs_get_option( 'default_underline_deleted')) { ?>
    @media (min-width: 768px){
        .right-menu #topmenu > ul > li > a::before, .top-menu #topmenu > ul > li > a::before{
            background-image: none;
        }
        <?php if (cs_get_option( 'menu_underline_height')) { ?>
            .right-menu #topmenu > ul > li > a::before, .top-menu #topmenu > ul > li > a::before{
                height: <?php echo esc_html( cs_get_option( 'menu_underline_height') ); ?> !important;
            }
        <?php } ?>
        }
        <?php if (cs_get_option( 'menu_underline_color')) { ?>
            .right-menu #topmenu > ul > li > a::before, .top-menu #topmenu > ul > li > a::before{
                background-color: <?php echo esc_html( cs_get_option( 'menu_underline_color') ); ?> !important;
            }
        <?php } ?>
    }
<?php   }  ?>
/*HEADER COLOR*/


/*FRONT COLOR*/
<?php if (cs_get_option( 'front_color') && cs_get_option( 'front_color') !== '#131313') : ?>
body,
a,
a:hover,
a:focus,
.a-btn-2,
.banner-gallery .content-wrap .title,
.action .title,
.action .subtitle,
.about-section .title,
.about-section .a-btn-2,
.fullwidth .gallery-item .info-content .subtitle,
.single-proof_gallery .single-content > .title,
.single-proof_gallery .title,
.team-member .info .title,
.all-posts-descr h5,
.post-box .post-descr h6,
.post-box .post-descr p,
.services .content .title,
.single-post .single-content blockquote p,
.contact-info .details h5,
.contact-info .details a,
.contact-info .details h6,
.contact-form h2,
form.wpcf7-form input,
form.wpcf7-form textarea,
.wpcf7 form input[type="submit"],
form.wpcf7-form #submit,
.widget_search input[type=search],
.widget_search input[type=submit]:hover,
.sidebar-item ul li a,
.post-details .date-post,
.post-details .title,
.protected-page .protected-title,
.protected-page input[type="submit"],
#contactform h3,
.comments-form h3,
#contactform #submit,
.comments-form #submit,
.single blockquote,
.about-details .content blockquote,
.about-section .content blockquote,
.portfolio-single-content blockquote,
.about-details .content .title,
.simple-details .content .title,
.about-details .content .text blockquote p,
.titles .title,
.insta-box .insta-box-follow,
code,
kbd,
.next.page-numbers,
.prev.page-numbers,
.next.page-numbers:hover,
.prev.page-numbers:hover,
caption,
.text-dark,
.insta-box .insta-box-follow a:hover,
.comments .content .comment-reply-link:hover,
.pagination.cs-pager .page-numbers.next:after,
.pagination.cs-pager .page-numbers.prev:after {
    color: <?php echo esc_html(cs_get_option( 'front_color')) ?>;
}
.napoli_product_detail .product .summary .cart .button{
    color: <?php echo esc_html(cs_get_option( 'front_color')) ?> !important;
}


.a-btn-2:hover,
.wpcf7 form input[type="submit"]:hover,
form.wpcf7-form #submit:hover,
.widget_search input[type=search],
.widget_search input[type=submit],
.widget_tag_cloud .tagcloud a,
.sidebar-item h5,
.protected-page input[type="submit"]:hover,
#contactform #submit:hover,
.comments-form #submit:hover,
.single blockquote,
.about-details .content blockquote,
.about-section .content blockquote,
.portfolio-single-content blockquote,
.post-nav a,
.pages,
.page-numbers:not(.next),
.single blockquote,
.about-details .content blockquote,
.about-section .content blockquote,
.portfolio-single-content blockquote,
button,
html input[type=button],
input[type=reset],
input[type=submit] {
    border-color: <?php echo esc_html(cs_get_option( 'front_color')) ?>;
}
.single-proof_gallery .pixproof-data .grid__item .a-btn-2:hover,
.wpcf7 form input[type="submit"]:hover,
form.wpcf7-form #submit:hover,
.widget_search input[type=submit],
.protected-page input[type="submit"]:hover,
#contactform #submit:hover,
.comments-form #submit:hover,
.post-nav a,
.pages,
button,
html input[type=button],
input[type=reset],
input[type=submit] {
    background-color: <?php echo esc_html(cs_get_option( 'front_color')) ?>;
}
<?php endif; ?>
/*FRONT COLOR*/

/*BASE WHITE COLOR*/
<?php if (cs_get_option( 'base_color') && cs_get_option( 'base_color') !== '#ffffff') : ?>
.text-light a,
.text-light p,
.text-light,
.highlight,
.a-btn,
.a-btn-2:hover,
.top-banner .subtitle,
.top-banner .title,
.top-banner .descr,
.about-section .a-btn-2:hover,
.gallery-item .info-content h5,
.modern .gallery-item .info-content h5,
.item-overlay > h5,
.classic .item-overlay h5,
.single-proof_gallery #pixproof_gallery .proof-photo .meta__action.select-action:before,
.single-proof_gallery #pixproof_gallery .proof-photo .proof-photo__bg .proof-photo__id,
.team-member .social .wrap a,
.post-box .text h6,
.post-box .text span,
.post-content h5,
.post-content .date,
.sm-wrap-post .content .title,
.sm-wrap-post .content .post-date .date,
.wpcf7 form input[type="submit"]:hover,
form.wpcf7-form #submit:hover,
.widget_search input[type=submit],
.protected-page input[type="submit"]:hover,
.banner-slider-wrap .title,
.banner-slider-wrap .subtitle,
.banner-slider-wrap .descr,
.banner-slider-wrap .swiper-arrow-right,
#contactform #submit:hover,
.comments-form #submit:hover,
.mb_YTPPlaypause:before,
mark,
ins,
.post-nav a,
.pages,
.page-numbers:not(.next),
.post-nav a:hover,
.post-nav a:focus,
.page-numbers:hover,
.page-numbers:focus,
.post-nav .pages,
.post-nav .current,
.pager-pagination .pages,
.pager-pagination .current,
button,
html input[type=button],
input[type=reset],
input[type=submit] {
    color: <?php echo esc_html(cs_get_option( 'base_color')) ?>;
}

.a-btn:hover,
.flex-control-paging li a {
    border-color: <?php echo esc_html(cs_get_option( 'base_color')) ?>;
}

.text-light .bottom-line:after,
.white,
.a-btn:hover,
.flex-control-paging li a,
.banner-gallery .content-wrap,
.action,
.post-box .post-descr,
.img-slider .flex-next,
.img-slider .flex-prev,
.widget_search input[type=search],
.widget_search input[type=submit]:hover,
.black p.separator {
    background-color: <?php echo esc_html(cs_get_option( 'base_color')) ?>;
}
/*BASE WHITE COLOR*/

<?php
endif;

$options = apply_filters( 'cs_get_option', get_option( CS_OPTION ) );
 

function get_str_by_number($str){
    $number = preg_replace("/[0-9|\.]/", '', $str);
    return $number;
}

foreach ($options as $key => $item) {
    if (is_array($item)) {
        if (!empty($item['variant']) && $item['variant'] == 'regular') {
            $item['variant'] = 'normal';
        }
    }
    $options[$key] = $item;
}


 function calculateFontWeight( $fontWeight ) {
            $fontWeightValue = '';
            $fontStyleValue = '';

            switch( $fontWeight ) {
                case '100':
                    $fontWeightValue = '100';
                    break;
                case '100italic':
                    $fontWeightValue = '100';
                    $fontStyleValue = 'italic';
                    break;
                case '300':
                    $fontWeightValue = '300';
                    break;
                case '300italic':
                    $fontWeightValue = '300';
                    $fontStyleValue = 'italic';
                    break;
                case '500':
                    $fontWeightValue = '500';
                    break;
                case '500italic':
                    $fontWeightValue = '500';
                    $fontStyleValue = 'italic';
                    break;
                case '700':
                    $fontWeightValue = '700';
                    break;
                case '700italic':
                    $fontWeightValue = '700';
                    $fontStyleValue = 'italic';
                    break;
                case '900':
                    $fontWeightValue = '900';
                    break;
                case '900italic':
                    $fontWeightValue = '900';
                    $fontStyleValue = 'italic';
                    break;
                case 'italic':
                    $fontStyleValue = 'italic';
                    break;
            }

            return array('weight' => $fontWeightValue, 'style' => $fontStyleValue);
        }



$all_button_font = $options['all_button_font_family'];

?>
.a-btn, .a-btn-2{
    <?php echo !empty($all_button_font['family']) ? "   font-family: \"{$all_button_font['family']}\" !important;" : ''; ?>

    <?php $variant = calculateFontWeight( $all_button_font['variant'] );?>
    <?php if(!empty($variant['style'])) : ?>
        font-style:  <?php echo esc_html( $variant['style']); ?> !important;
    <?php endif; ?>
    <?php if(!empty($variant['weight'])) : ?>
        font-weight:  <?php echo esc_html( $variant['weight']); ?> !important;
    <?php endif; ?>

    <?php $button_font_style = get_str_by_number($all_button_font['variant']); 
    echo !empty($button_font_style) ? "   font-style:{$button_font_style} !important;"  : 'font-style:normal;'; ?>


    <?php $all_button_font_size = get_number_str($options['all_button_font_size']);  ?>
    <?php echo !empty($all_button_font_size) ? "  font-size: {$all_button_font_size}px !important;" : ''; ?>
    <?php echo !empty($options['one_blog_subtitle_color']) ? "  color: {$options['one_blog_subtitle_color']} !important;" : ''; ?>

    <?php $all_button_line_height = get_number_str($options['all_button_line_height']);  ?>
    <?php echo !empty($all_button_line_height) ? "   line-height:{$all_button_line_height}px !important;"  : ''; ?>

    <?php echo !empty($options['all_button_letter_spacing']) ? " letter-spacing:{$options['all_button_letter_spacing']} !important;"  : ''; ?>

    <?php echo !empty($options['all_button_item_color']) ? " color:{$options['all_button_item_color']} !important;"  : ''; ?>
}

<?php
$all_links_font= $options['all_links_font_family'];


?>
a{
    <?php echo !empty($all_links_font['family']) ? "   font-family: \"{$all_links_font['family']}\" !important;" : ''; ?>

    <?php $variant = calculateFontWeight( $all_links_font['variant'] );?>
    <?php if(!empty($variant['style'])) : ?>
        font-style:  <?php echo esc_html( $variant['style']); ?> !important;
    <?php endif; ?>
    <?php if(!empty($variant['weight'])) : ?>
        font-weight:  <?php echo esc_html( $variant['weight']); ?> !important;
    <?php endif; ?>

    <?php $links_font_family = get_str_by_number($all_links_font['variant']); 
    echo !empty($links_font_family) ? "   font-style:{$links_font_family} !important;"  : 'font-style:normal;'; ?>

    <?php $all_links_font_size = get_number_str($options['all_links_font_size']);  ?>
    <?php echo !empty($all_links_font_size) ? "  font-size: {$all_links_font_size}px !important;" : ''; ?>

    <?php echo $options['all_links_item_color'] ? "  color: {$options['all_links_item_color']} !important;" : ''; ?>

    <?php $all_links_line_height = get_number_str($options['all_links_line_height']);  ?>
    <?php echo !empty($all_links_line_height) ? "   line-height:{$all_links_line_height}px !important;"  : ''; ?>
    
     <?php $all_links_letter_spacing = get_number_str($options['all_links_letter_spacing']);  ?>
    <?php echo !empty($all_links_letter_spacing) ? " letter-spacing:{$all_links_letter_spacing} !important;"  : ''; ?>
}

 

/*FOOTER*/

<?php if (cs_get_option( 'footer_links') && cs_get_option(
'footer_links') !== '#ffffff') : ?>
#footer .social-links a{
    color: <?php echo esc_html(cs_get_option( 'footer_links')) ?>;
}
<?php endif; ?>

<?php if (cs_get_option( 'footer_bg') && cs_get_option(
'footer_bg') !== '#131313') : ?>
#footer{
    background-color: <?php echo esc_html(cs_get_option( 'footer_bg')) ?>;
}
<?php endif; ?>

<?php if (cs_get_option( 'footer_copyright') && cs_get_option(
'footer_copyright') !== '#ffffff') : ?>
#footer .copyright a{
    color: <?php echo esc_html(cs_get_option( 'footer_copyright')) ?>;
}
<?php endif; ?>
/*FOOTER*/



/*GALLERY FULL WIDTH COLORS*/
<?php if (cs_get_option( 'gallery_popup_bg_color' ) && cs_get_option(
'gallery_popup_bg_color') !== '#000' ) : ?>
.lg-backdrop{
    background-color: <?php echo esc_html(cs_get_option( 'gallery_popup_bg_color' )); ?> !important;
}
<?php endif; ?>

<?php if (cs_get_option( 'gallery_popup_heading_color' ) && cs_get_option(
'gallery_popup_heading_color') !== '#fff' ) : ?>
.lg-sub-html h4{
    color: <?php echo cs_get_option( 'gallery_popup_heading_color' ); ?> !important;
}
<?php endif; ?>

<?php if (cs_get_option( 'gallery_popup_text_color' ) && cs_get_option(
'gallery_popup_text_color') !== '#888888' ) : ?>
.lg-sub-html .dgwt-jg-item-desc{
    color: <?php echo cs_get_option( 'gallery_popup_text_color' ); ?> !important;
}
<?php endif; ?>
/*GALLERY FULL WIDTH COLORS*/

<?php function get_number_str($str){
    $number = preg_replace("/[^0-9|\.]/", '', $str);
    return $number;
}


/* FOR TITLE H1 - H6 */
if ( cs_get_option('heading') ) {
foreach (cs_get_option('heading') as $title) {
    $font_family = $title['heading_family'];
    ?>

<?php echo $title['heading_tag']; ?>,
<?php echo $title['heading_tag']; ?> a{
    <?php echo $font_family['family'] ? "   font-family: {$font_family['family']} !important;" : ''; ?>
    <?php $one_title_size = get_number_str($title['heading_size']);  ?>
    <?php echo $one_title_size ? "  font-size: {$one_title_size}px !important;\n line-height: normal;" : ''; ?>
    <?php echo $title['heading_color'] ? " color: {$title['heading_color']} !important;" : ''; ?>
}

<?php } } ?>



#topmenu ul li a{
<?php if ( cs_get_option('menu_item_family') ) { 
$font_family = cs_get_option('menu_item_family');
 ?>
font-family: "<?php echo esc_html( $font_family['family'] ); ?>", sans-serif;
<?php $variant = calculateFontWeight( $font_family['variant'] );?>
    <?php if(!empty($variant['style'])) : ?>
        font-style:  <?php echo esc_html( $variant['style']); ?> !important;
    <?php endif; ?>
    <?php if(!empty($variant['weight'])) : ?>
        font-weight:  <?php echo esc_html( $variant['weight']); ?> !important;
    <?php endif; ?>
<?php } ?>
<?php if ( cs_get_option('menu_item_color') && cs_get_option(
'submenu_item_color') !== '' ) {
 ?>
color: <?php echo esc_html( cs_get_option('menu_item_color') ); ?>;
<?php } ?>
<?php if ( cs_get_option('menu_item_size') ) {
$menu_item_size = get_number_str(cs_get_option('menu_item_size'));  ?>
font-size: <?php echo esc_html( $menu_item_size ); ?>px;
<?php } ?>
<?php if ( cs_get_option('menu_line_height') ) {
$menu_line_height = get_number_str(cs_get_option('menu_line_height'));  ?>
line-height: <?php echo esc_html( $menu_line_height ); ?>px;
<?php } ?>

}

#topmenu ul ul li a{
<?php if ( cs_get_option('submenu_item_family') ) { 
    $font_family = cs_get_option('submenu_item_family'); ?>
font-family: "<?php echo esc_html( $font_family['family'] ); ?>", sans-serif;
<?php $variant = calculateFontWeight( $font_family['variant'] );?>
<?php if(!empty($variant['style'])) : ?>
    font-style:  <?php echo esc_html( $variant['style']); ?> !important;
<?php endif; ?>
<?php if(!empty($variant['weight'])) : ?>
    font-weight:  <?php echo esc_html( $variant['weight']); ?> !important;
<?php endif; ?>
<?php } ?>
<?php if ( cs_get_option('submenu_item_color') && cs_get_option(
'submenu_item_color') !== '' ) { ?>
color: <?php echo esc_html( cs_get_option('submenu_item_color') ); ?>;
<?php } ?>
<?php if ( cs_get_option('submenu_item_size') ) {
$submenu_item_size = get_number_str(cs_get_option('submenu_item_size')); ?>
font-size: <?php echo esc_html( $submenu_item_size ); ?>px;
<?php } ?>
<?php if ( cs_get_option('submenu_line_height') ) {
$submenu_line_height = get_number_str(cs_get_option('submenu_line_height'));  ?>
line-height: <?php echo esc_html( $submenu_line_height ); ?>px;
<?php } ?>

}

.banner-gallery .content-wrap .description{
    <?php if ( cs_get_option('gallery_font_family') ) { 
        $gallery_font_family = cs_get_option('gallery_font_family'); ?>
    font-family: "<?php echo esc_html( $gallery_font_family['family'] ); ?>", sans-serif;
<?php $variant = calculateFontWeight( $gallery_font_family['variant'] );?>
<?php if(!empty($variant['style'])) : ?>
    font-style:  <?php echo esc_html( $variant['style']); ?> !important;
<?php endif; ?>
<?php if(!empty($variant['weight'])) : ?>
    font-weight:  <?php echo esc_html( $variant['weight']); ?> !important;
<?php endif; ?>
    <?php } ?>
    <?php if ( cs_get_option('gallery_item_color') && cs_get_option(
'gallery_item_color') !== '' ) { ?>
    color: <?php echo esc_html( cs_get_option('gallery_item_color') ); ?>;
    <?php } ?>
    <?php if ( cs_get_option('gallery_font_size') ) {
    $gallery_font_size = get_number_str(cs_get_option('gallery_font_size')); ?>
    font-size: <?php echo esc_html( $gallery_font_size ); ?>px;
    <?php } ?>
    <?php if ( cs_get_option('gallery_line_height') ) {
    $gallery_line_height = get_number_str(cs_get_option('gallery_line_height'));  ?>
    line-height: <?php echo esc_html( $gallery_line_height ); ?>px;
    <?php } ?>
}

#footer .copyright{
    <?php if ( cs_get_option('footer_font_family') ) { 
        $footer_font_family = cs_get_option('footer_font_family'); ?>
    font-family: "<?php echo esc_html( $footer_font_family['family'] ); ?>", sans-serif;
<?php $variant = calculateFontWeight( $footer_font_family['variant'] );?>
<?php if(!empty($variant['style'])) : ?>
    font-style:  <?php echo esc_html( $variant['style']); ?> !important;
<?php endif; ?>
<?php if(!empty($variant['weight'])) : ?>
    font-weight:  <?php echo esc_html( $variant['weight']); ?> !important;
<?php endif; ?>
    <?php } ?>
    <?php if ( cs_get_option('footer_item_color') && cs_get_option(
'footer_item_color') !== '' ) { ?>
    color: <?php echo esc_html( cs_get_option('footer_item_color') ); ?>;
    <?php } ?>
    <?php if ( cs_get_option('footer_font_size') ) {
    $footer_font_size = get_number_str(cs_get_option('footer_font_size')); ?>
    font-size: <?php echo esc_html( $footer_font_size ); ?>px;
    <?php } ?>
    <?php if ( cs_get_option('footer_line_height') ) {
    $footer_line_height = get_number_str(cs_get_option('footer_line_height'));  ?>
    line-height: <?php echo esc_html( $footer_line_height ); ?>px;
    <?php } ?>
}

.dgwt-jg-gallery.justified-gallery .dgwt-jg-caption span{
        <?php if ( cs_get_option('item_gallery_font_family') ) { 
            $item_gallery_font_family = cs_get_option('item_gallery_font_family'); 
            if (!empty( $item_gallery_font_family['family'] )) {
            ?>
        font-family: "<?php echo esc_html( $item_gallery_font_family['family'] ); ?>", sans-serif;
        <?php $variant = calculateFontWeight( $item_gallery_font_family['variant'] );?>
        <?php if(!empty($variant['style'])) : ?>
            font-style:  <?php echo esc_html( $variant['style']); ?> !important;
        <?php endif; ?>
        <?php if(!empty($variant['weight'])) : ?>
            font-weight:  <?php echo esc_html( $variant['weight']); ?> !important;
        <?php endif; ?>
        <?php } } ?>
        <?php if ( cs_get_option('item_gallery_item_color') && cs_get_option('item_gallery_item_color') !== '' ) { ?>
        color: <?php echo esc_html( cs_get_option('item_gallery_item_color') ); ?>;
        <?php } ?>
        <?php if ( cs_get_option('item_gallery_font_size') ) {
        $item_gallery_font_size = get_number_str(cs_get_option('item_gallery_font_size')); ?>
        font-size: <?php echo esc_html( $item_gallery_font_size ); ?>px;
        <?php } ?>
        <?php if ( cs_get_option('item_gallery_line_height') ) {
        $item_gallery_line_height = get_number_str(cs_get_option('item_gallery_line_height'));  ?>
        line-height: <?php echo esc_html( $item_gallery_line_height ); ?>px;
        <?php } ?>
} 

<?php if( cs_get_option( 'preloader_image' ) ) : 
$image_src = wp_get_attachment_image_url( cs_get_option( 'preloader_image' ), 'full', false );
?>
@-webkit-keyframes scaleout-image {
  0% {
    -webkit-transform: scale(0.5);
  }
  100% {
    -webkit-transform: scale(1);
    opacity: 0;
  }
}

@keyframes scaleout-image {
  0% {
    transform: scale(0.5);
    -webkit-transform: scale(0.5);
  }
  100% {
    transform: scale(1);
    -webkit-transform: scale(1);
    opacity: 0;
  }
}

.animsition-loading{
    background-image: url(<?php echo esc_url( $image_src ); ?>) !important;
    background-repeat: no-repeat !important;
    background-position: center center !important;
    -webkit-animation: scaleout-image 1.0s infinite ease-in-out;
      animation: scaleout-image 1.0s infinite ease-in-out;

}
.animsition-loading:before{
    display: none;
}


<?php endif; ?>

<?php 
if ( cs_get_option( 'custom_css_styles' ) ) {
    $custom_css_styles = str_replace('&gt;','>', cs_get_option( 'custom_css_styles' ));
    echo $custom_css_styles;
}
?>




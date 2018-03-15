<?php
/**
 * Single portfolio
 *
 * @package napoli
 * @since 1.0
 *
 */
get_header();

$protected = '';

if ( post_password_required() ) {
	$protected = 'protected-page';
}


$portfolio_meta = get_post_meta( $post->ID, 'napoli_portfolio_options' );
$size_images = 'full';
if(isset($portfolio_meta[0]['portfolio_img_size']) && $portfolio_meta[0]['portfolio_img_size'] == 1){
	$size_images = 'thumbnail';
}elseif(isset($portfolio_meta[0]['portfolio_img_size']) && $portfolio_meta[0]['portfolio_img_size'] == 2){
	$size_images = 'medium';
}elseif(isset($portfolio_meta[0]['portfolio_img_size']) && $portfolio_meta[0]['portfolio_img_size'] == 3){
	$size_images = 'medium_large';
}elseif(isset($portfolio_meta[0]['portfolio_img_size']) && $portfolio_meta[0]['portfolio_img_size'] == 4){
	$size_images = 'large';
}

$columnsclass = isset($portfolio_meta[0]['columns_number']) ? $portfolio_meta[0]['columns_number'] : '';

if(!empty($columnsclass) && $columnsclass != 'four'){
	$columnsclass = $columnsclass == 'three' ? 'col-md-4 col-xs-12 col-sm-6' : 'col-md-6 col-xs-12 col-sm-6';
}else{
	$columnsclass = 'col-md-3 col-xs-12 col-sm-6';
}

$columns_number = isset($portfolio_meta[0]['columns_number']) ? $portfolio_meta[0]['columns_number'] : '';

$popup_style = isset($portfolio_meta[0]['popup_style']) ? $portfolio_meta[0]['popup_style'] : 'default';
$detail_style = isset($portfolio_meta[0]['detail_style']) ? $portfolio_meta[0]['detail_style'] : 'default';
$hover_style = isset($portfolio_meta[0]['hover_style']) ? $portfolio_meta[0]['hover_style'] : 'default';


while ( have_posts() ) : the_post(); ?>
	<?php if ( !empty($portfolio_meta[0]['slider']) && $portfolio_meta[0]['portfolio_style'] == 'simple' ) : ?>
		<div class="container no-padd">
			<div class="port-det-slider">
				<div id="slider" class="flexslider">
		         <ul class="slides">
		           <?php $images = explode( ',', $portfolio_meta[0]['slider'] ); ?>
		           <?php foreach ( $images as $image ) :
					     $url        = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';
		                 $attachment = get_post( $image );
		           		 $alt      = $attachment->post_excerpt;
		            ?>
		           <li>
		               <div class="port-slide-bg s-back-switch">
		               		<?php 
		               		echo napoli_the_lazy_load_flter( $url, array(
		               		  'class' => 's-img-switch',
		               		  'alt'   => $alt
		               		) );
		               		?> 
		           </li>
		           <?php endforeach; ?>
		           <!-- items mirrored twice, total of 12 -->
		         </ul>
				</div>
				<div id="carousel" class="flexslider">
		         <ul class="slides">
					<?php foreach ( $images as $image ) :
						$url        = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_image_src( $image, $size_images ) : '';
						$attachment = get_post( $image );
						$alt      = $attachment->post_excerpt;
					?>
		           <li>
		               <div class="port-slide-bg s-back-switch">
		                   <?php 
		                   echo napoli_the_lazy_load_flter( $url[0], array(
		                     'class' => 's-img-switch',
		                     'alt'   => $alt
		                   ) );
		                   ?> 
		               </div>
		           </li>
		           <?php endforeach; ?>
		           <!-- items mirrored twice, total of 12 -->
		         </ul>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="container clearfix no-padd portfolio-single-content margin-lg-30b <?php echo esc_attr( $protected ); ?>">

		<?php if ( post_password_required() ) { ?>
			<?php the_title( '<h3 class="protected-title">', '</h3>' ); ?>
		<?php } ?>

		<?php
		if ( ! post_password_required( $post ) && $portfolio_meta[0]['portfolio_style'] != 'simple' ) {
			if ( cs_get_option( 'social_portfolio' ) ) {
				if ( ! empty( $portfolio_meta[0]['napoli_social_portfolio'] ) ) { ?>
					<div class="row single-share">
						<div class="ft-part margin-lg-15b">
							<ul class="social-list">
								<li><span><?php esc_html_e( 'Share:', 'napoli' ); ?></span></li>
								<li>
									<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
									   target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
								<li>
									<a href="http://pinterest.com/pin/create/link/?url=<?php echo esc_url( urlencode( get_permalink() ) ); ?>&amp;media=<?php echo esc_attr( $pinterestimage[0] ); ?>&amp;description=<?php esc_attr( the_title() ); ?>"
									   class="pinterest" target="_blank" title="Pin This Post"><i
											class="fa fa-pinterest-p"></i></a></li>
								<li>
									<a href="http://www.facebook.com/sharer.php?u=<?php esc_url( the_permalink() ); ?>&amp;t=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
									   class="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li>
									<a href="http://twitter.com/home?status=<?php echo esc_url( urlencode( the_title( '', '', false ) ) ); ?><?php esc_url( the_permalink() ); ?>"
									   class="twitter" target="_blank" title="Tweet"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="http://plus.google.com/share?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
									   target="_blank" class="gplus"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				<?php }
			}
		}


		if ( $portfolio_meta[0]['portfolio_style'] == 'simple' ) {
			?>
			<div class="portfolio-categories">
			<?php the_terms( get_the_ID(), 'portfolio-category' ); ?>
			</div>
			<?php the_title( '<h3 class="portfolio-title">', '</h3>');
		}

		the_content();

		if ( $portfolio_meta[0]['portfolio_style'] == 'simple' ) { ?>
			<div class="napoli-portfolio-footer-line">
				<div class="row">
					<?php if ($portfolio_meta[0]['client']){ ?>
					<div class="col-md-3">
						<div class="portfolio-client">
							<label class="client-title">
							<?php esc_html_e('CLIENT:', 'napoli'); ?>
							</label>
							<div class="client-value">
							<?php echo esc_html(  $portfolio_meta[0]['client'] ); ?>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php if ($portfolio_meta[0]['job_type']){ ?>
					<div class="col-md-3">
						<div class="portfolio-jop-type">
							<label class="title-job-type">
								<?php esc_html_e('JOB TYPE:', 'napoli'); ?>
							</label>
							<div class="job-type-value">
							<?php echo esc_html(  $portfolio_meta[0]['job_type'] ); ?>
							</div>
						</div>
					</div>
					<?php } ?>
					<div class="col-md-3">
						<label class="title-date">
							<?php esc_html_e('DATE:', 'napoli'); ?>
						</label>
						<div class="date-value">
							<?php the_time(get_option('date_format')); ?>
						</div>
					</div>
					<?php if ( ! empty( $portfolio_meta[0]['napoli_social_portfolio'] ) && cs_get_option( 'social_portfolio' ) ) { ?>
					<div class="col-md-3">
						<label class="title-date">
							<?php esc_html_e('SHARE TO:', 'napoli'); ?>
						</label>
						<?php napoli_the_share_posts($post); ?>
					</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<?php
		if ( $portfolio_meta[0]['portfolio_style'] != 'simple' ) {
			if ( ! post_password_required( $post ) ) {
				if ( ! empty( $portfolio_meta[0]['slider'] ) && ! empty( $portfolio_meta[0]['portfolio_style'] ) ) {
					$images = explode( ',', $portfolio_meta[0]['slider'] );
					$output = '';

					if ( $portfolio_meta[0]['portfolio_style'] == 'classic' ) {
						$output .= '<div class="container clearfix no-padd">';
						$output .= '<div class="row gallery-single ' . esc_attr($popup_style) . ' margin-lg-10b margin-xs-0b">';
						$output .= '<div class="izotope-container">';
						$output .= '<div class="grid-sizer"></div>';

						$counter = 0;
						foreach ( $images as $image ) {
							$url        = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';
							$url_size        = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_image_src( $image, $size_images ) : '';
							$attachment = get_post( $image );
							$title      = $attachment->post_excerpt;
							$url_popup = $popup_style == 'detail' ? '#content' . $image : $url;
							$popup_class = $popup_style == 'detail' ? 'popup-details' : '';
							$hover_style = $hover_style == 'slip' ? 'slip' : '';
							$data_fancy = $popup_style == 'detail' ? 'data-fancybox="images"' : '';

							$output .= '<div class="' . esc_attr($columnsclass) . ' margin-lg-30b item-single">';
							if($popup_style == 'detail'){
								$output .= '<a '. $data_fancy .' href="' . esc_url( $url_popup ) . '" class="gallery-item ' . esc_attr($columns_number . ' ' . $popup_class . ' ' . $hover_style) .'" title="' . esc_attr( $title ) . '">';
							}else{
								$output .= '<a '. $data_fancy .' href="' . esc_url( $url_popup ) . '" class="gallery-item ' . esc_attr($columns_number . ' ' . $popup_class . ' ' . $hover_style) .'" data-title="' . esc_attr( $title ) . '">';
							}

							$output .= napoli_the_lazy_load_flter( $url_size[0], array(
							  'class' => 's-img-switch',
							  'alt'   => $attachment->post_excerpt 
							) ); 
							$output .= '<div class="info-content" data-content="' . wp_kses_post( $attachment->post_excerpt ) . '">';
							$output .= '<div class="vertical-align">';
							if ( ! empty( $attachment->post_excerpt ) ) {
								$output .= '<h5>' . wp_kses_post( $attachment->post_excerpt ) . '</h5>';
							}
							$output .= '</div>';
							$output .= '</div>';
							$output .= '</a>';


							if($popup_style == 'detail'){
								$image_metadata = @exif_read_data($url);
								$output .= '<div id="content' . esc_attr($image) . '" class="popup-content-details">';
								$output .= '<div class="wrapper">';
								$output .= '<div class="img-wrap equal">';
								$output .= '<img src="'. esc_url($url) .'" class="" alt="">';
								$output .= '</div>';
								$output .= '<div class="content equal">';
								if ( ! empty( $attachment->post_excerpt ) ) {
									$output .= '<h5 class="img-title">' . wp_kses_post( $attachment->post_excerpt ) . '</h5>';
								}
								$output .= '<div class="img-date">' . get_the_time(get_option('date_format')) . '</div>';

								$focal_info = wp_get_attachment_metadata( $image );

								if($detail_style == 'custom'){
									if(!empty($image)){
										$image_info = napoli_wp_get_attachment($image);
										$description = $image_info['description'];
										$output .= '<div class="caption-images-portfolio-item">';
										$output .= !empty($description) ? do_shortcode($description) : '';
										$output .= '</div>';
									}
								}else{
									if(!empty($image_metadata['Model']) || !empty($focal_info['image_meta']['focal_length']) || !empty($image_metadata['COMPUTED']['ApertureFNumber']) || !empty($image_metadata['ExposureTime']) || !empty($image_metadata['ISOSpeedRatings'])){
										if(!empty($image_metadata['Model'])){
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('Camera', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html(trim($image_metadata['Model'])) . '</p>';
											$output .= '</div>';
										}
										if(!empty($focal_info['image_meta']['focal_length'])){
											$focal_length = $focal_info['image_meta']['focal_length'];
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('Focal lenght', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html( $focal_length) . ' ' . esc_html__('mm', 'napoli') . '</p>';
											$output .= '</div>';
										}
										if(!empty($image_metadata['COMPUTED']['ApertureFNumber'])){
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('Aperture', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html($image_metadata['COMPUTED']['ApertureFNumber']) . '</p>';
											$output .= '</div>';
										}
										if(!empty($image_metadata['ExposureTime'])){
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('Exposure time', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html($image_metadata['ExposureTime']) . '</p>';
											$output .= '</div>';
										}
										if(!empty($image_metadata['ISOSpeedRatings'])){
											$iso = is_array( $image_metadata['ISOSpeedRatings'] ) ? reset( $image_metadata['ISOSpeedRatings'] ) : $image_metadata['ISOSpeedRatings'];
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('ISO', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html(trim($iso)) . '</p>';
											$output .= '</div>';
										}

									}
								}
								$output .= '</div>';
								$output .= '</div>';
								$output .= '</div>';
							}
							$output .= '</div>';
							$counter ++;
						}

						$output .= '</div>';

						$output .= '</div>';
						$output .= '</div>';

					} elseif ( $portfolio_meta[0]['portfolio_style'] == 'modern' ) {
						$wrap_class = '';
						if(!empty($portfolio_meta[0]['num_show_img'])){
							$wrap_class = ' counter-wrap-port';
						}

						$output .= '<div class="container clearfix no-padd' . esc_attr($wrap_class) . '">';
						$output .= '<div class="row gallery-single ' . esc_attr($popup_style) . ' margin-lg-10b margin-xs-0b">';
						$output .= '<div class="izotope-container">';
						$output .= '<div class="grid-sizer"></div>';

						$counter = 0;
						foreach ( $images as $image ) {
							$url  = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';
							$url_size        = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_image_src( $image, $size_images ) : '';
							$attachment = get_post( $image );
							$title      = $attachment->post_excerpt ;
							$url_popup = $popup_style == 'detail' ? '#content' . $image : $url;
							$popup_class = $popup_style == 'detail' ? 'popup-details' : '';
							$data_fancy = $popup_style == 'detail' ? 'data-fancybox="images"' : '';
							$hover_style = $hover_style == 'slip' ? 'slip' : '';


							if(isset($portfolio_meta[0]['num_show']) && $portfolio_meta[0]['num_show'] == true && !empty($portfolio_meta[0]['num_show_img']) && $counter < ($portfolio_meta[0]['num_show_img'])){
								$count_class = ' count-show';
							}else{
								$count_class = '';
							}

							$output .= '<div class="' . esc_attr($columnsclass) . ' margin-lg-30b ' . esc_attr( $portfolio_meta[0]['portfolio_style'] ) . esc_attr($count_class) . ' item-single ">';

							if($popup_style == 'detail'){
								$output .= '<a href="' . esc_url( $url_popup ) . '" '. $data_fancy .' class="gallery-item ' . esc_attr($popup_class . ' ' . $hover_style) . '" title="' . esc_attr( $title ) . '">';
							}else{
								$output .= '<a href="' . esc_url( $url_popup ) . '" '. $data_fancy .' class="gallery-item ' . esc_attr($popup_class . ' ' . $hover_style) . '" data-title="' . esc_attr( $title ) . '">';
							}

							$output .= napoli_the_lazy_load_flter( $url_size[0], array(
							  'class' => '',
							  'alt'   => $attachment->post_excerpt 
							) ); 
							$output .= '<div class="info-content" data-content="' . wp_kses_post( $attachment->post_excerpt ) . '">';
							$output .= '<div class="vertical-align">';
							if ( ! empty( $attachment->post_excerpt ) ) {
								$output .= '<h5>' . wp_kses_post( $attachment->post_excerpt ) . '</h5>';
							}
							$output .= '</div>';
							$output .= '</div>';
							$output .= '</a>';


							if($popup_style == 'detail'){
								$image_metadata = @exif_read_data($url);
								$output .= '<div id="content' . esc_attr($image) . '" class="popup-content-details">';
								$output .= '<div class="wrapper">';
								$output .= '<div class="img-wrap equal">';
								$output .= '<img src="'. esc_url($url) .'" class="" alt="">';
								$output .= '</div>';
								$output .= '<div class="content equal">';
								if ( ! empty( $attachment->post_excerpt ) ) {
									$output .= '<h5 class="img-title">' . wp_kses_post( $attachment->post_excerpt ) . '</h5>';
								}
								$output .= '<div class="img-date">' . get_the_time(get_option('date_format')) . '</div>';
								$focal_info = wp_get_attachment_metadata( $image );
								if($detail_style == 'custom'){
									if(!empty($image)){
										$image_info = napoli_wp_get_attachment($image);
										$description = $image_info['description'];
										$output .= '<div class="caption-images-portfolio-item">';
										$output .= !empty($description) ? do_shortcode($description) : '';
										$output .= '</div>';
									}
								}else{
									if(!empty($image_metadata['Model']) || !empty($focal_info['image_meta']['focal_length']) || !empty($image_metadata['COMPUTED']['ApertureFNumber']) || !empty($image_metadata['ExposureTime']) || !empty($image_metadata['ISOSpeedRatings'])){
										if(!empty($image_metadata['Model'])){
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('Camera', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html(trim($image_metadata['Model'])) . '</p>';
											$output .= '</div>';
										}
										if(!empty($focal_info['image_meta']['focal_length'])){
											$focal_length = $focal_info['image_meta']['focal_length'];
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('Focal lenght', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html( $focal_length) . ' ' . esc_html__('mm', 'napoli') . '</p>';
											$output .= '</div>';
										}
										if(!empty($image_metadata['COMPUTED']['ApertureFNumber'])){
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('Aperture', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html($image_metadata['COMPUTED']['ApertureFNumber']) . '</p>';
											$output .= '</div>';
										}
										if(!empty($image_metadata['ExposureTime'])){
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('Exposure time', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html($image_metadata['ExposureTime']) . '</p>';
											$output .= '</div>';
										}
										if(!empty($image_metadata['ISOSpeedRatings'])){
											$iso = is_array( $image_metadata['ISOSpeedRatings'] ) ? reset( $image_metadata['ISOSpeedRatings'] ) : $image_metadata['ISOSpeedRatings'];
											$output .= '<div class="caption-images-portfolio-item">';
											$output .= '<span>' . esc_html__('ISO', 'napoli') . ':</span>';
											$output .= '<p>' . esc_html(trim($iso)) . '</p>';
											$output .= '</div>';
										}

									}
								}
								$output .= '</div>';
								$output .= '</div>';
								$output .= '</div>';
							}


							$output .= '</div>';

							$counter ++;
						}

						$output .= '</div>';

						$output .= '</div>';

						if(isset($portfolio_meta[0]['num_show']) && $portfolio_meta[0]['num_show'] == true && !empty($portfolio_meta[0]['num_show_img'])){
							$output .= '<div class="row margin-lg-60t margin-sm-30t text-center">';
							$output .= '<a href="#" class="portfolio-load-more a-btn-2" data-num="'. esc_attr($portfolio_meta[0]['num_show_img']) . '">' . esc_html__('load more', 'napoli') . '</a>';
							$output .= '</div>';
						}
						$output .= '</div>';

					} else {
						$sizes = array( 'item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'item7' );

						$output .= '<div class="container">';
						$output .= '<div class="row gallery-single margin-lg-40b margin-xs-10b">';
						$output .= '<div class="izotope-container-2">';
						$output .= '<div class="grid-sizer"></div>';

						$counter = 0;

						foreach ( $images as $image ) {
							$url        = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';
							$url_size        = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_image_src( $image, $size_images ) : '';
							$attachment = get_post( $image );
							$title      = $attachment->post_excerpt;
							$output .= '<div class="' . esc_attr( $portfolio_meta[0]['portfolio_style'] ) . ' full-single item-single ' . esc_attr($sizes[ $counter ]) . '">';

							$output .= '<a href="' . esc_url( $url ) . '" class="gallery-item" data-title="' . esc_attr( $title ) . '">';
							$output .= napoli_the_lazy_load_flter( $url_size[0], array(
							  'class' => 's-img-switch',
							  'alt'   => $attachment->post_excerpt 
							) ); 
							$output .= '<div class="info-content">';
							$output .= '<div class="vertical-align">';
							if ( ! empty( $attachment->post_excerpt ) ) {
								$output .= '<h5>' . wp_kses_post( $attachment->post_excerpt ) . '</h5>';
							}
							$output .= '<div class="subtitle">' . esc_html__( 'view', 'napoli' ) . '</div>';
							$output .= '</div>';
							$output .= '</div>';
							$output .= '</a>';
							$output .= '</div>';

							$counter++;
							if ($counter >= count($sizes)) {
								$counter = 0;
							}
						}

						$output .= '</div>';

						$output .= '</div>';
						$output .= '</div>';
					}
					echo $output;
				}
			}
		}
		?>

		<?php
		if ( cs_get_option( 'navigation_portfolio' ) ) {
			if ( $portfolio_meta[0]['napoli_navigation_portfolio'] ) { ?>
				<div class="container">
					<div class="row">
						<div class="single-pagination">
							<?php
							$prev_post = get_previous_post();
							if ( ! empty( $prev_post ) ) :
								?>
								<div class="pag-prev">
									<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="content">
										<i class="fa fa-angle-left" aria-hidden="true"></i>
										<?php esc_html_e( 'Previous gallery', 'napoli' ); ?>
									</a>
								</div>
							<?php endif;
							$next_post = get_next_post();
							if ( ! empty( $next_post ) ) :
								?>
								<div class="pag-next">
									<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="content">
										<?php esc_html_e( 'Next gallery', 'napoli' ); ?>
										<i class="fa fa-angle-right"  aria-hidden="true"></i>
									</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php }

		}

		?>

	</div>
	<?php
endwhile;
get_footer(); 
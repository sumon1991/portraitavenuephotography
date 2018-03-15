<?php
/**
 * Index Page
 *
 * @package napoli
 * @since 1.0
 *
 */

$content_size_class = !function_exists( 'cs_framework_init' )  || cs_get_option( 'sidebar' ) && in_array( 'blog', cs_get_option( 'sidebar' ) ) ? ' col-md-9' : '';
$post_size_class    = !function_exists( 'cs_framework_init' ) && cs_get_option( 'sidebar' ) && in_array( 'blog', cs_get_option( 'sidebar' ) ) ? 6 : 4;
$counter = 0;
get_header();

$row_class = cs_get_option('napoli_blog_style') && cs_get_option('napoli_blog_style') == 'modern' ? 'grid enable_fullheight' : '';
$page_url = home_url( '/' );
$page_url_all = home_url( '/' ) . 'blog/';

?>
<?php if ( have_posts() ) : ?>
	<div class="container no-padd">
		<div class="row">
			<div class="blog<?php echo esc_attr( $content_size_class ); ?> no-padd">
				<div class="row <?php echo esc_attr($row_class); ?>">

					<?php if(cs_get_option('napoli_blog_filter') && cs_get_option('napoli_blog_style') && cs_get_option('napoli_blog_style') == 'modern'){ ?>
						<div class="filter grid">
							<ul>
								<li class="active"><a href="<?php echo esc_url($page_url_all); ?>"><?php esc_html_e('all', 'napoli'); ?></a></li>
								<?php
								$categories = get_terms( 'category', '' );
								foreach ( $categories as $category ) {
									echo '<li><a href="'. esc_url($page_url . 'category/' . $category->slug . '/') .'">' . $category->name . '</a></li>';
								} ?>
							</ul>
						</div>
					<?php } ?>


					<?php if(cs_get_option('napoli_blog_style') && cs_get_option('napoli_blog_style') == 'modern'){ ?>
						<div class="portfolio-wrapper container"></div>
							<div class="portfolio no-padd col-3 grid clearfix" data-space="15">
								<div class="wpb_column vc_column_container vc_col-sm-12  margin-lg-50b margin-xs-10b">
									<div class="vc_column-inner no-padd">
										<div class="wpb_wrapper shuffle">
					<?php } ?>


					<?php while ( have_posts() ) : the_post();
						$no_image = !has_post_thumbnail() ? ' no-image' : '';
						$post_options = get_post_meta( $post->ID, 'napoli_post_options' ); ?>

						<?php if(cs_get_option('napoli_blog_style') && cs_get_option('napoli_blog_style') == 'modern'){
							$blog_category = '';
							$categories         = get_the_terms( $post->ID, 'category' );
							if ( $categories ) {
								foreach ( $categories as $categorsy ) {
									$blog_category .= $categorsy->slug . ' ';
								}
							}
							$img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID) );

							?>
							<div class="item block_item_<?php echo esc_attr( $counter); ?>" data-groups="<?php echo esc_attr( trim( $blog_category ) ); ?>">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="item-link gridrotate-alb default ">
									<div class="item-img">
										<div class="images-one">
											<?php if ( ! empty( $img_url ) ) {
												echo napoli_the_lazy_load_flter( $img_url, array(
													'class' => 's-img-switch',
													'alt'   => ''
												) );
											} ?>
										</div>
									</div>
									<div class="item-overlay"></div>
								</a>
								<div class="item-portfolio-content">
									<?php the_title('<h5 class="portfolio-title"><a href="' . get_the_permalink() . '">','</a></h5>'); ?>
									<div class="category">
										<?php the_terms($post->ID,'category'); ?>
									</div>
								</div>
							</div>
						<?php }else{ ?>
							<div class="post col-md-<?php echo esc_attr( $post_size_class . ' ' . $no_image ); ?> col-sm-6">
								<a href="<?php the_permalink(); ?>">
									<?php if ( isset( $post_options[0]['post_preview_style'] ) && $post_options[0]['post_preview_style'] != 'text' && ( get_post_format( $post->ID ) != 'quote' ) || ! isset( $post_options[0]['post_preview_style'] ) ) {
										napoli_blog_item_hedeader( $post_options, $post->ID );
									} ?>
									<div <?php post_class( 'post-content' ); ?>>
										<?php the_title( '<h5 class="title">', '</h5>' ); ?>
										<p class="date"><?php the_time( get_option( 'date_format' ) ); ?></p>
										<?php if ( isset( $post_options[0]['post_preview_style'] ) && $post_options[0]['post_preview_style'] == 'text' || ( get_post_format( $post->ID ) == 'quote' ) ) {
											napoli_blog_item_hedeader( $post_options, $post->ID );
										} ?>
									</div>
								</a>
							</div>
						<?php } ?>

					<?php endwhile; ?>

				<?php if(cs_get_option('napoli_blog_style') && cs_get_option('napoli_blog_style') == 'modern'){ ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				</div>
				<div class="pager-pagination">
					<?php echo paginate_links(); ?>
				</div>
			</div>
			<?php if ( ! function_exists( 'cs_framework_init' ) || cs_get_option( 'sidebar' ) && in_array( 'blog', cs_get_option( 'sidebar' ) ) ) { ?>
				<div class="col-md-3 pl30md">
					<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'sidebar' ) ) {
						;
					} ?>
				</div>
			<?php } ?>
			
		</div>
	</div>
<?php else : ?>
	<div class="empty-post-list">
		<?php esc_html_e( 'Sorry, no posts matched your criteria.', 'napoli' ); ?>
		<?php get_search_form( true ); ?>
	</div>
<?php endif; ?>

	<div class="container no-padd">
		<div class="row">

			<?php
			$username = cs_get_option( 'insta_username' );
			$count    = cs_get_option( 'insta_count' );
			$title    = cs_get_option( 'insta_title' );

			if ( ! empty( $username ) && ! empty( $count ) ) {
				$instagram_images = napoli_get_imstagram( $username, $count );


				$output = '<div class="insta-box margin-lg-35t margin-xs-15t margin-lg-40b margin-xs-20b col-xs-12">';
				if ( ! empty( $title ) ) {
					$output .= '<div class="insta-box-follow">' . esc_html( $title ) . '<a href="https://instagram.com/' . $username  . '" class="insta-acc">@' . esc_html( $username ) . '</a></div>';
				}

				$output .= '<div class="insta-img-wrap">';
				if ( ! empty( $instagram_images ) ) {
					foreach ( $instagram_images as $image ) {
						$output .= '<a href="' . esc_url( 'https://instagram.com/p/' . $image['link'] ) . '" target="_blank"><img src="' . esc_url( 'https://instagram.com/p/' . $image['link'] . '/media/?size=t' ) . '" class="img-responsive img" alt=""></a>';
					}
				}

				$output .= '</div>';

				$output .= '</div>';

				echo $output;
			}
			?>

		</div>
	</div>

<?php get_footer();

<?php
/**
 * Single
 *
 * @package Napoli
 * @since 1.0
 *
 */
get_header();

$protected = '';

if ( post_password_required() ) {
	$protected = 'protected-page';
}

$post_meta = get_post_meta( $post->ID, 'napoli_post_options' );


$content_size_class = ( ! function_exists( 'cs_framework_init' ) || ( cs_get_option( 'sidebar' ) && in_array( 'post', cs_get_option( 'sidebar' ) ) ) ) ? 'col-md-9' : 'col-md-12';
while ( have_posts() ) :
	the_post();
	if ( has_post_thumbnail() ) {
		?>
		<div class="container-fluid post-details no-padd">
			<div class="post-banner">
				<?php the_post_thumbnail( 'full', array( 'class' => 's-img-switch' ) ); ?>
			</div>
		</div>
		<div class="container no-padd">
			<div class="row">
				<div class="col-xs-12 ">
					<div class="date-post"><?php the_time( get_option( 'date_format' ) ); ?></div>
					<?php the_title( '<h2 class="title">', '</h2>' ); ?>
					<?php if ( function_exists( 'cs_framework_init' ) ) { ?>
						<div class="post-info">
							<?php if(cs_get_option('napoli_post_author')){ ?>
								<span class="author"><?php esc_html_e('Written by: ', 'napoli'); the_author_link(); ?></span></br>
							<?php }
							if(cs_get_option( 'napoli_post_info' ) == 'true'){ ?>
								<span><?php the_category( ', ' ); ?></span>
								<span><?php the_tags(); ?></span>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="container">
		<div class="row">
		<div
		class="single-content no-padd-md <?php echo esc_attr( $protected ); ?> <?php echo esc_attr( $content_size_class ); ?>">
	<?php } else { ?>
		<div class="container no-padd-md">
		<div class="row">
		<div class="single-content <?php echo esc_attr( $protected ); ?> <?php echo esc_attr( $content_size_class ); ?>">
		<?php if ( post_password_required() && get_post_type() == "proof_gallery" ) { ?>
			<h2 class='protected-title'><?php echo wp_kses_post( cs_get_option( 'protected_title' ) ); ?></h2>
		<?php } else { ?>
			<div class="date-post"><?php the_date(); ?></div>
			<?php the_title( '<h3 class="title">', '</h3>' ); ?>
		<?php } ?>

		<?php if ( ! function_exists( 'cs_framework_init' ) || cs_get_option( 'napoli_post_info' ) ) { ?>
			<div class="post-info">
				<span><?php the_category( ', ' ); ?></span>
				<span><?php the_tags(); ?></span>
			</div>
		<?php } ?>
	<?php } ?>
	<?php the_content(); ?>
	<?php wp_link_pages( 'link_before=<span class="pages">&link_after=</span>&before=<div class="post-nav"> <span>' . esc_html__( "Page:", 'napoli' ) . ' </span> &after=</div>' ); ?>
	<?php if ( cs_get_option( 'napoli_social_post' ) ) { ?>
	<div class="ft-part">
		<ul class="social-list">
			<li><i><?php esc_html_e( 'Share:', 'napoli' ); ?></i></li>
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
				   class="twitter" target="_blank" title="Tweet"><i
						class="fa fa-twitter"></i></a></li>
			<li>
				<a href="http://plus.google.com/share?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
				   target="_blank" class="gplus"><i class="fa fa-google-plus"></i></a></li>
		</ul>
	</div>
<?php } ?>


	<div class="recent-post-single clearfix">

		<h4 class="recent-title"><?php esc_html_e( 'RECENT POSTS', 'napoli' ) ?></h4>

		<div class="row">
			<?php
			$my_cat = get_query_var( 'cat' );

			$args = array(
				'posts_per_page'      => 3,
				'cat'                 => $my_cat,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'ignore_sticky_posts' => true,
				'post__not_in'        => array($post->ID)
			);


			$query = new WP_Query( $args );


			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$imagerec = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );
					
					$no_image = !has_post_thumbnail() ? ' no-image' : ''; ?>

					<div class="col-sm-4 recent-simple-post <?php echo esc_html( $no_image ); ?>">
						<div class="sm-wrap-post">
							<div class="overlay-dark-2x"></div>
							<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"
							   class="img s-back-switch">
							   <?php 
							   	  echo napoli_the_lazy_load_flter(
							   	  	$imagerec[0],
							   	  	array('class'=>'s-img-switch')
							   	  );
							   ?>
								<div class="content">
									<div
										class="title"><?php echo esc_html( $post->post_title ); ?></div>
									<div class="post-date"><span
											class="date"><?php echo esc_html( get_the_time( get_option( 'date_format' ), $post->ID ) ); ?></span>
									</div>
								</div>
							</a>

						</div>
					</div>
					<?php
				}
			}
			wp_reset_postdata();
			?>
		</div>
	</div>

	<?php
	if ( (cs_get_option( 'napoli_navigation_posts' ) && !isset($post_meta[0]['napoli_navigation_posts'])) 
		|| ( isset($post_meta[0]['napoli_navigation_posts']) && $post_meta[0]['napoli_navigation_posts'])) { ?>
			<div class="single-pagination">
				<?php
				$prev_post = get_previous_post();
				if ( ! empty( $prev_post ) ) :
					?>
					<div class="pag-prev">
						<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="content">
							<i class="fa fa-angle-left" aria-hidden="true"></i>
							<?php esc_html_e( 'Previous post', 'napoli' ); ?>
						</a>
					</div>
				<?php endif;
				$next_post = get_next_post();
				if ( ! empty( $next_post ) ) :
					?>
					<div class="pag-next">
						<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="content">
							<?php esc_html_e( 'Next post', 'napoli' ); ?>
							<i class="fa fa-angle-right"  aria-hidden="true"></i>
						</a>
					</div>
				<?php endif; ?>
			</div>
		<?php 

	}
	?>


	<ul class="comments">
		<?php
		if ( comments_open() || '0' != get_comments_number() && wp_count_comments( $post->ID ) ) {
			comments_template( '', true );
		}
		?>
	</ul>
	</div>
	<?php if ( ! function_exists( 'cs_framework_init' ) || ( cs_get_option( 'sidebar' ) && in_array( 'post', cs_get_option( 'sidebar' ) ) ) ) { ?>
		<div class="col-md-3 pl30md">
			<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'sidebar' ) ) ?>
		</div>
	<?php } ?>
	</div>
	</div>
	<?php
endwhile;
get_footer();
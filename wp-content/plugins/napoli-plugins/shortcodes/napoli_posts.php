<?php
 
// remove default post types
$post_types = array_diff( get_post_types(), array(
	'revision',
	'attachment',
	'nav_menu_item',
	'booked_appointments',
	'wpcf7_contact_form'
));


function get_napoli_post_types($post_types){
	$list = array();
	foreach ( $post_types as $post_type ) {
		$list[$post_type] = $post_type;
	}
	return $list;
}

/* Params (part 1) */
$params = array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'js_composer' ),
				'param_name' => 'style',
				'value'      => array(
					__( 'Default', 'js_composer' ) => '',
					__( 'Post List', 'js_composer' ) => 'post_list',
					__( 'Post List & Text preview', 'js_composer' ) => 'post_list_text',
					__( 'Simple', 'js_composer' ) => 'simple',
					__( 'Grid', 'js_composer' ) => 'grid',
					__( 'Big Gap', 'js_composer' ) => 'gap',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Add category filter?', 'js_composer' ),
				'param_name' => 'filter',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'dependency' => array('element' => 'style',	'value' => array('grid'))
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Add share buttons?', 'js_composer' ),
				'param_name' => 'share',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'dependency' => array('element' => 'style',	'value' => array('gap'))
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Post types', 'js_composer' ),
				'param_name' => 'posttypes',
				'value'      => get_napoli_post_types($post_types),
				'description' => __( 'Select source for slider.', 'js_composer' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Enable pager', 'js_composer' ),
				'param_name' => 'pager',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Count posts', 'js_composer' ),
				'param_name'  => 'count',
				'description' => 'Only number'
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Custom Height', 'js_composer' ),
				'param_name'  => 'custom_height',
				'dependency' => array( 'element' => 'style', 'value' => array('simple') ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order by', 'js_composer' ),
				'param_name' => 'orderby',
				'value' => array(
					'',
					__( 'Date', 'js_composer' ) => 'date',
					__( 'ID', 'js_composer' ) => 'ID',
					__( 'Author', 'js_composer' ) => 'author',
					__( 'Title', 'js_composer' ) => 'title',
					__( 'Modified', 'js_composer' ) => 'modified',
					__( 'Random', 'js_composer' ) => 'rand',
					__( 'Comment count', 'js_composer' ) => 'comment_count',
					__( 'Menu order', 'js_composer' ) => 'menu_order',
				),
				'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Sort order', 'js_composer' ),
				'param_name' => 'order',
				'value' => array(
					__( 'Descending', 'js_composer' ) => 'DESC',
					__( 'Ascending', 'js_composer' ) => 'ASC',
				),
				'description' => sprintf( __( 'Select ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			),
		);

/* Params (part 2) */
$params2 = array(
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Add small banner to this section?', 'js_composer' ),
				'param_name' => 'active',
				'value'      => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'dependency' => array( 'element' => 'style', 'value_not_equal_to' => array('grid', 'gap') ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Subtitle', 'js_composer' ),
				'param_name' => 'subtitle',
				'value'      => '',
				'dependency' => array( 'element' => 'active', 'value' => array( 'yes' ) ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', 'js_composer' ),
				'param_name' => 'title',
				'value'      => '',
				'dependency' => array( 'element' => 'active', 'value' => array( 'yes' ) ),
			),
			array(
				'type'       => 'textarea',
				'heading'    => __( 'Text', 'js_composer' ),
				'param_name' => 'text',
				'value'      => '',
				'dependency' => array( 'element' => 'active', 'value' => array( 'yes' ) ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button text', 'js_composer' ),
				'param_name' => 'btn_txt',
				'value'      => '',
				'dependency' => array( 'element' => 'active', 'value' => array( 'yes' ) ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Button url', 'js_composer' ),
				'param_name' => 'btn_url',
				'value'      => '',
				'dependency' => array( 'element' => 'active', 'value' => array( 'yes' ) ),
			),
		);
 
 
/* Params categories (part 3) */
$params_tax = array();
foreach ($post_types as $key => $type) {
	
	$heading = __( 'Select Categories', 'js_composer' );
	if ($type != 'post') {
		$heading = __( 'Select Terms', 'js_composer' );
	}

	$taxonomies = get_taxonomies(array('object_type' => array($type) ), 'names','and');

	if (!empty($taxonomies)) {

		if ($type == 'post') {
			$params_value = array(
					'sort_order' => 'ASC',
					'taxonomy'   => array_shift($taxonomies),
					'hide_empty' => false,
			);
		} else {
			$params_value = array(
					'sort_order' => 'ASC',
					'taxonomies'   => array_shift($taxonomies),
					'hide_empty' => false,
			);
		}

		$type_functions = ($type == 'post') ? 'categories' : 'tags';


		$params_tax[] = array(
			'type'        => 'vc_efa_chosen',
			'heading'     => $heading,
			'param_name'  => 'cats_' . $type,
			'placeholder' => $heading,
			'value'       => napoli_element_values( $type_functions, $params_value ),
			'std'         => '',
			'description' => __( 'you can choose spesific categories for portfolio, default is all categories', 'js_composer' ),
			'dependency' => array( 'element' => 'posttypes', 'value' => array($type) ),
		);
	}
}

/* Init Visual Composer Map */
if (function_exists('vc_map')) {
	vc_map( array(
			'name'        => __( 'Posts List', 'js_composer' ),
			'base'        => 'napoli_posts',
			'description' => __( 'This outputs list shows any of the post-type items', 'js_composer' ),
			'params'      => array_merge(
								array_values($params),
								$params_tax,
								array_values($params2)
							)
		)
	);
}


/* Output */
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_napoli_posts extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			extract( shortcode_atts( array(
				'style'    	=> '',
				'filter'   	=> '',
				'active'   	=> '',
				'share'   	=> '',
				'count'    	=> '',
				'subtitle' 	=> '',
				'posttypes' => 'post',
				'pager' 	=> '',
				'orderby' 	=> '',
				'custom_height' => '',
				'order' 	=> '',
				'title'    	=> '',
				'text'     	=> '',
				'btn_txt'  	=> '',
				'btn_url'  	=> ''
			), $atts ) );

			$category = '';

			if ( ! empty( $atts['cats_' . $posttypes] ) ) {

				$cats = $atts['cats_' . $posttypes]; 

				$taxonomies = get_taxonomies(array('object_type' => array($posttypes) ), 'names','and');

				if ($posttypes != 'post') {
					$category = array(
						'taxonomy' => array_shift($taxonomies),
						'field'    => 'term_id',
						'terms'    => explode( ',', $cats )
					);
				}
			
				$args = array(
					'tax_query' => array(
						$category
					)
				);
		 	
				if ($posttypes == 'post') {
					$args['category__in'] = explode( ',', $cats );
				}

			}

			// Order posts
			if ( null !== $orderby ) {
				$args['orderby'] = $orderby;
			}
			$args['order'] = $order;

			// Post types
			$pt = array();

			$args['post_type'] = $posttypes;


			if ( ! empty( $count ) && is_numeric( $count ) ) {
				$args['posts_per_page'] = $count;
			}

			if( $pager == 'yes' ) {
		       $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		       $args['paged'] = $paged;
		   }


			$i     = 1;
			$class = '';
			include ABSPATH . 'wp-content/plugins/napoli-plugins/lib/aq_resizer.php';

			$posts = new WP_Query( $args );

			$custom_height = is_numeric($custom_height) ? $custom_height . 'px' : $custom_height;
			$custom_css = !empty($custom_height) ? 'height:' . $custom_height . ';' : '';
			$custom_css = ' style="' . $custom_css . '"';

			$wrapper_class = $style;
			if ($style == 'post_list_text') {
				$wrapper_class = 'post_list';
			}
			
			if ( empty($custom_height) ) {
				$wrapper_class .= ' enable_fullheight';
			}
			ob_start();
			?>

			<div class="row grid-wrapper <?php echo esc_attr( $wrapper_class ); ?>" <?php echo $custom_css; ?> data-url="<?php echo get_pagenum_link(); ?>">
			
				<?php if ( $active == 'yes' ) :

					if (!empty($style) && ($style == 'post_list' || $style == 'post_list_text')) {
						$colons_header = 'col-lg-12 col-sm-12 col-xs-12';
					} else {
						$colons_header = 'col-lg-4 col-sm-6 col-xs-12';
					} ?>
				<div class="<?php echo esc_attr( $colons_header ); ?>">
					<div class="all-posts-descr">
						<div class="wrap">
						<?php if ( ! empty( $subtitle ) ) : ?>
							<h6><?php echo esc_html( $subtitle ); ?></h6>
						<?php endif; ?>

						<?php if ( ! empty( $title ) ) : ?>
							<h5><?php echo esc_html( $title ); ?></h5>
						<?php endif; ?>

						<?php if ( ! empty( $text ) ) : ?>
							<p><?php echo esc_attr( $text ); ?></p>
						<?php endif;

						if ( ! empty( $btn_txt ) ) : ?>
							<a href="<?php echo esc_url( $btn_url ); ?>" class="a-btn-2">
								<?php echo esc_html( $btn_txt ); ?>
							</a>
						<?php endif; ?>

						</div>
					</div>
				</div>
				<?php endif; ?>

				<?php if($style == 'grid' || $style == 'gap'){
				if ( $filter == 'yes' && $style == 'grid') { ?>
					<div class="filter <?php echo esc_attr( $style ); ?>">
						<ul>
							<li data-group="all" class="active" data-count="<?php echo esc_html( $count ); ?>"><?php esc_html_e('all', 'napoli'); ?></li>
							<?php
							$categories = get_terms( 'category', '' );
							foreach ( $categories as $category ) {
								if ( ! empty( $cats ) ) {
									if ( in_array( $category->term_id, explode( ',', $cats ) ) !== false ) {
										echo '<li data-group="' . $category->slug . '" data-count="'.$count.'" data-group-name="' . $category->name . '">' . $category->name . '</li>';
									}
								} else {
									echo '<li data-group="' . $category->slug . '" data-count="'.$count.'" data-group-name="' . $category->name . '">' . $category->name . '</li>';
								}
							} ?>
						</ul>
					</div>
					<?php } ?>
					<div class="portfolio-wrapper container">
					<?php if($style == 'grid'){ ?>
						<div class="portfolio no-padd col-3 grid clearfix" data-space="15">
					<?php }else{ ?>
						<div class="portfolio no-padd col-6 big_gap clearfix" data-space="40">
					<?php } ?>
							<div class="wpb_column vc_column_container vc_col-sm-12  margin-lg-50b margin-xs-10b">
								<div class="vc_column-inner no-padd">
									<div class="wpb_wrapper shuffle">
				<?php }

				$counter = 0; ?>

				<?php if ( $posts->have_posts() ) {
					while ( $posts->have_posts() ) : $posts->the_post();

						$img_url = wp_get_attachment_url( get_post_thumbnail_id( $posts->ID) );
						if (empty($style) && $style != 'post_list' && $style != 'post_list_text'){
							$img_url = aq_resize( $img_url, 350, 218, true, true, true );
						}

						if ( $counter == 9 ) {
							$counter = 0;
						}

						if ( $style == 'gap' && $counter == 7 ) {
							$counter = 0;
						}

						$blog_category = '';
						$categories         = get_the_terms( $posts->ID, 'category' );
						if ( $categories ) {
							foreach ( $categories as $categorsy ) {
								$blog_category .= $categorsy->slug . ' ';
							}
						}

						if ( !empty($style) && ($style == 'post_list' || $style == 'post_list_text')) : ?>
						
						<?php // post_list ?>
						<div class="col-lg-12 col-sm-12 col-xs-12">
						    <div class="post-box">
						        <a class="post-box-img-wrapp" href="<?php the_permalink(); ?>">
						            <?php if ( ! empty( $img_url ) ) {
						            	echo napoli_the_lazy_load_flter( $img_url, array(
						            		'class' => 'res-img s-img-switch',
						            		'alt'   => ''
						            	) );
						            } ?>
						        </a>
						        <div class="text text-dark">
						        	<?php the_title( '<h2 class="post-box-title"><a href="' . get_the_permalink() . '">', '</a></h2>' ); ?>
						            <span class="post-box-date"><?php the_time( 'j M, Y' ); ?></span>
							        <?php if ( $style == 'post_list_text' ): ?>
							        	<?php the_excerpt(); ?>
							        <?php endif ?>
						        </div>
						    </div>
						</div>

						<?php
						elseif (!empty($style) && $style == 'simple') : ?>

						<?php // simple ?>
						<div class="col-lg-12 col-sm-12 col-xs-12">
						    <div class="post-box">
						        <div class="text text-dark">
						            <span class="post-box-date"><?php the_time( 'j M, Y' ); ?></span>
						           <?php the_title( '<h4 class="post-box-title"><a href="' . get_the_permalink() . '">', '</a></h4>' ); ?>
						            <div class="post-box-desc">
						               <?php the_excerpt(); ?>
						            </div>
						        </div>
						    </div>
						</div>

						<?php
						elseif (!empty($style) && $style == 'grid') : ?>
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
										<?php the_terms($posts->ID,'category'); ?>
									</div>
								</div>
							</div>

						<?php
						elseif(!empty($style) && $style == 'gap') : ?>
							<div class="item block_item_<?php echo esc_attr( $counter); ?>">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="item-link gridrotate-alb hover5">
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
									<?php the_title('<h5 class="portfolio-title">','</h5>'); ?>
									<?php if($share == 'yes'){ ?>
										<ul class="big_gap_share">
											<li><button class="fa fa-facebook" data-share="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>"></button></li>
											<li><button class="fa fa-pinterest-p" data-share="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $url = wp_get_attachment_url( get_post_thumbnail_id($posts->ID) ); echo $url; ?>"></button></li>
											<li><button class="fa fa-twitter" data-share="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?>"></button></li>
											<li><button class="fa fa-linkedin" data-share="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>"></button></li>
											<li><button class="fa fa-google-plus" data-share="http://plus.google.com/share?url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"></button></li>
										</ul>
									<?php } ?>
								</a>

							</div>

						<?php
						else: ?>

						<?php // default ?>
						<div class="col-lg-4 col-sm-6 col-xs-12">
							<a href="<?php the_permalink(); ?>" class="post-box <?php echo esc_attr( $class ); ?>">
								<?php if ( ! empty( $img_url ) ) {
									echo napoli_the_lazy_load_flter( $img_url, array(
										'class' => 'res-img s-img-switch',
										'alt'   => ''
									) );
								} ?>

								<div class="text text-light">
									<?php the_title( '<h6>', '</h6>' ); ?>
									<span><?php the_time( 'j M, Y' ); ?></span>
								</div>
							</a>
						</div>

						<?php endif; ?>

						<?php $i++;
						$counter++;
					endwhile;
				}




			 if($style == 'grid' || $style == 'gap'){ ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			 <?php }


				if( !empty($pager) && $pager == 'yes' ) : ?>
					<div class="pager-pagination">
						  <?php
						  $big = 999999999;
						  echo paginate_links( array(
							 'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							 'format'    => '?paged=%#%',
							 'current'   => max( 1, get_query_var('paged') ),
							 'total'     => $posts->max_num_pages,
							 'prev_text' => esc_html__( 'Previous page', 'napoli' ),
							 'next_text' => esc_html__( 'Next page', 'napoli' )
						   ) );
						  ?>
					</div>
				<?php endif;

				wp_reset_postdata();
			?>
			</div>

			<?php 
			return ob_get_clean();

		}
	}
}
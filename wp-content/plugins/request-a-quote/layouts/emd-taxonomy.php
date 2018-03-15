<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

get_header('emdplugins');
$container = apply_filters('emd_change_container','container','request_a_quote', 'taxonomy');  
?>
<div id="emd-temp-tax-container" class="emd-container emd-wrap">
<div class="<?php echo $container; ?>">
<div id="emd-primary" class="emd-site-content emd-row row" role="main">
<?php 
	$has_sidebar = apply_filters( 'emd_show_temp_sidebar', 'right', 'request_a_quote', 'taxonomy');
	if($has_sidebar ==  'left'){
		do_action( 'emd_sidebar', 'request_a_quote' );
	}
	if($has_sidebar == 'full'){
?>
<div class="col-sm-12">
<?php
	}
	else {
?>
<div class="col-sm-8">
<?php
	}
	$queried_object = get_queried_object();
	while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" style="padding:10px;" <?php post_class(); ?>>
			<?php emd_get_template_part('request-a-quote', 'taxonomy', str_replace("_","-",$queried_object->taxonomy . '-' . $post->post_type)); ?>
			</div>
                <?php endwhile; // end of the loop. ?>
<?php	$has_navigation = apply_filters( 'emd_show_temp_navigation', true, 'request_a_quote', 'taxonomy');
	if($has_navigation){	
		global $wp_query;
		$big = 999999999; // need an unlikely integer

?>
		<nav role="navigation" id="nav-below" class="site-navigation paging-navigation">
		<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'wpas' ); ?></h3>

	<?php	if ( $wp_query->max_num_pages > 1 ) { ?>

		<?php $pages = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total' => $wp_query->max_num_pages,
			'type' => 'array',
			'prev_text' => wp_kses( __( '<i class="fa fa-angle-left"></i> Previous', 'wpas' ), array( 'i' => array( 
			'class' => array() ) ) ),
			'next_text' => wp_kses( __( 'Next <i class="fa fa-angle-right"></i>', 'wpas' ), array( 'i' => array( 
			'class' => array() ) ) )
		) );
		if(is_array($pages)){
			$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
			echo '<div class="pagination-wrap"><ul class="pagination">';
			foreach ( $pages as $page ) {
				$paging_html = "<li";
				if(strpos($page,'page-numbers current') !== false){
					$paging_html.= " class='active'";
				}
				$paging_html.= ">" . $page . "</li>";
				echo $paging_html;
			}
			echo '</ul></div>';
		}
	} ?>
		</nav>
<?php	}
?>
</div>
<?php if($has_sidebar ==  'right'){
?>
<?php
	do_action( 'emd_sidebar', 'request_a_quote' );
?>
<?php
}
?>
</div>
</div>
</div>
<?php get_footer('emdplugins'); ?>

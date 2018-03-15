<?php
/**
 * Requried functions for theme backend.
 *
 * @package napoli
 * @subpackage Template
 */

// cs framework missing
if ( ! function_exists( 'cs_get_option' ) ) {
	function cs_get_option() {
		return '';
	}

	function cs_get_customize_option() {
		return '';
	}
}

if ( ! function_exists( 'add_default_cs_websafe_fonts' )) {
	function add_default_cs_websafe_fonts($params)
	{
		return array_merge(array(''),$params);
	}
}
add_filter( 'cs_websafe_fonts', 'add_default_cs_websafe_fonts' );

/**
 * Сustom napoli menu.
 */
if ( ! function_exists( 'napoli_custom_menu' ) ) {
	function napoli_custom_menu() {
		if ( has_nav_menu( 'primary-menu' ) ) {
			wp_nav_menu( array( 'container' => '', 'theme_location' => 'primary-menu' ) );
		} else {
			echo '<span class="no-menu">' . esc_html__( 'Please register Top Navigation from', 'napoli' ) . ' <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance &gt; Menus', 'napoli' ) . '</a></span>';
		}
	}
}


/**
 *
 * element values post, page, categories
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'napoli_element_values' ) ) {
	function napoli_element_values( $type = '', $query_args = array() ) {

		$options = array();

		switch ( $type ) {

			case 'pages':
			case 'page':
				$pages = get_pages( $query_args );

				if ( ! empty( $pages ) ) {
					foreach ( $pages as $page ) {
						$options[ $page->post_title ] = $page->ID;
					}
				}
				break;

			case 'posts':
			case 'post':
				$posts = get_posts( $query_args );

				if ( ! empty( $posts ) ) {
					foreach ( $posts as $post ) {
						$options[ $post->post_title ] = $post->ID  /*lcfirst( $post->post_title )*/;
					}
				}
				break;

			case 'tags':
			case 'tag':

				$tags = get_terms( $query_args['taxonomies'] );
				if ( ! empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						$options[ $tag->name ] = $tag->term_id;
					}
				}
				break;

			case 'categories':
			case 'category':

				$categories = get_categories( $query_args );

				if ( ! empty( $categories ) ) {

					if ( is_array( $categories ) ) {
						foreach ( $categories as $category ) {
							$options[ $category->name ] = $category->term_id;
						}
					}

				}
				break;

			case 'custom':
			case 'callback':

				if ( is_callable( $query_args['function'] ) ) {
					$options = call_user_func( $query_args['function'], $query_args['args'] );
				}

				break;

		}

		return $options;

	}
}


/**
 *
 * Get first "url" from post content or string
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'napoli_get_first_url_from_string' ) ) {
	function napoli_get_first_url_from_string( $string ) {
		$pattern = "/^\b(?:(?:https?|ftp):\/\/)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		preg_match( $pattern, $string, $link );

		return ( ! empty( $link[0] ) ) ? $link[0] : false;
	}
}

/**
 *
 * Custom Regular Expression
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'napoli_get_shortcode_regex' ) ) {
	function napoli_get_shortcode_regex( $tagregexp = '' ) {
		// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
		// Also, see shortcode_unautop() and shortcode.js.
		return
			'\\['                                // Opening bracket
			. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
			. "($tagregexp)"                     // 2: Shortcode name
			. '(?![\\w-])'                       // Not followed by word character or hyphen
			. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
			. '[^\\]\\/]*'                   // Not a closing bracket or forward slash
			. '(?:'
			. '\\/(?!\\])'               // A forward slash not followed by a closing bracket
			. '[^\\]\\/]*'               // Not a closing bracket or forward slash
			. ')*?'
			. ')'
			. '(?:'
			. '(\\/)'                        // 4: Self closing tag ...
			. '\\]'                          // ... and closing bracket
			. '|'
			. '\\]'                          // Closing bracket
			. '(?:'
			. '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
			. '[^\\[]*+'             // Not an opening bracket
			. '(?:'
			. '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
			. '[^\\[]*+'         // Not an opening bracket
			. ')*+'
			. ')'
			. '\\[\\/\\2\\]'             // Closing shortcode tag
			. ')?'
			. ')'
			. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
	}
}

/**
 *
 * Tag Regular Expression
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'napoli_tagregexp' ) ) {
	function napoli_tagregexp() {
		return apply_filters( 'napoli_custom_tagregexp', 'video|audio|playlist|video-playlist|embed|cs_media' );
	}
}

/**
 *
 * POST FORMAT: VIDEO & AUDIO
 *
 */
if ( ! function_exists( 'napoli_post_media' ) ) {
	function napoli_post_media( $content ) {
		$result = strpos( $content, 'iframe' );
		if ( $result === false ) {
			$media = napoli_get_first_url_from_string( $content );
			if ( ! empty( $media ) ) {
				global $wp_embed;
				$content = do_shortcode( $wp_embed->run_shortcode( '[embed]' . $media . '[/embed]' ) );
			} else {
				$pattern = napoli_get_shortcode_regex( napoli_tagregexp() );
				preg_match( '/' . $pattern . '/s', $content, $media );
				if ( ! empty( $media[2] ) ) {
					if ( $media[2] == 'embed' ) {
						global $wp_embed;
						$content = do_shortcode( $wp_embed->run_shortcode( $media[0] ) );
					} else {
						$content = do_shortcode( $media[0] );
					}
				}
			}
			if ( ! empty( $media ) ) {
				$output = $content;

				return $output;
			}

			return false;
		} else {
			return $content;
		}
	}
}

/**
 *
 * Create custom html structure for comments
 *
 */
if ( ! function_exists( 'napoli_comment' ) ) {
	function napoli_comment( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;

		$reply_class = ( $comment->comment_parent ) ? 'indented' : '';
		switch ( $comment->comment_type ):
			case 'pingback':
			case 'trackback':
				?>
				<p>
					<?php esc_html_e( 'Pingback:', 'napoli' ); ?><?php comment_author_link(); ?>
					<?php edit_comment_link( esc_html__( '(Edit)', 'napoli' ), '<span class="edit-link">', '</span>' ); ?>
				</p>
				<?php
				break;
			default:
				// generate comments
				?>
				<li <?php comment_class( 'ct-part' ); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>">
					<div class="content">
						<div class="person">
							<?php echo get_avatar( $comment, '70', '', '', array( 'class' => 'img-person' ) ); ?>
							<a href="#" class="author">
								<?php comment_author(); ?>
							</a>
              <span class="comment-date">
                <?php comment_date( get_option( 'date_format' ) ); ?>
              </span>
						</div>
						<?php
						comment_reply_link(
							array_merge( $args,
								array(
									'reply_text' => esc_html__( 'Reply', 'napoli' ),
									'after'      => '',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth']
								)
							)
						);
						?>
						<div class="text">
							<?php comment_text(); ?>
						</div>
					</div>
				</div>
				<?php
				break;
		endswitch;
	}
}

/*
 * Site logo function.
 */
if ( ! function_exists( 'napoli_site_logo' ) ) {
	function napoli_site_logo() {
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">

			<?php
			if(is_404() && cs_get_option('error_logo')){
				if ( apply_filters( 'napoli_type_logo', cs_get_option( 'error_site_logo' )) == 'txtlogo'  ) {
					echo ' <span> ' . esc_html( cs_get_option( 'error_text_logo' ) ) . '</span>';
				} else {
					$logo = '';
					if (cs_get_option( 'error_image_logo' )) {
						$logo = cs_get_option('error_image_logo');
					}

					// logo for page
					?>
					<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo get_option( 'blogname' ); ?>">

				<?php }
			}else{
				$meta_data = get_post_meta( get_the_ID(), '_custom_page_options', true );
				if ( empty($meta_data['image_page_logo']) && apply_filters( 'napoli_type_logo', cs_get_option( 'site_logo' )) == 'txtlogo'  ) {
					echo ' <span> ' . esc_html( cs_get_option( 'text_logo' ) ) . '</span>';
				} else {
					$logo = '';
					if ( cs_get_option( 'menu_style' ) == 'right' ) {
						$logo = cs_get_option( 'image_logo' );
					} elseif ( cs_get_option( 'menu_style' ) == 'center' ) {
						$logo = cs_get_option( 'image_logo2' );
					}

					// logo for page

					$logo = !empty($meta_data['image_page_logo']) ? $meta_data['image_page_logo'] : $logo;

					$image_logo = apply_filters( 'napoli_header_logo', $logo );
					$img_src = ! empty( $image_logo ) ? $image_logo : T_URI . '/assets/images/logo.png'; ?>
					<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo get_option( 'blogname' ); ?>">

				<?php } 
			} ?>
		</a>
	<?php }
}

/*
 * Blog item header.
 */
if ( ! function_exists( 'napoli_blog_item_hedeader' ) ) {
	function napoli_blog_item_hedeader( $option, $post_id ) {
		$format = get_post_format( $post_id );
		if ( isset( $option[0]['post_preview_style'] ) ) {
			switch ( $option[0]['post_preview_style'] ) {
				case 'image':
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
					if ( empty( $image ) && ( $format != 'quote' ) ) {
						$image[0] = cs_get_option( 'default_post_image' );
					}
					$output = '<div class="post-media">';
					$output .= napoli_the_lazy_load_flter( $image[0], array(
						'class' => 's-img-switch',
						'alt'   => ''
					) ); 
					$output .= '</div>';
					break;
				case 'video':
					$output = '<div class="post-media video-container">';
					$output .= wp_kses_post( napoli_post_media( $option[0]['post_preview_video'] ) );
					$output .= '</div>';
					break;
				case 'slider':
					$output = '<div class="post-media">';
					$output .= '<div class="img-slider">';
					$output .= '<ul class="slides">';
					$images = explode( ',', $option[0]['post_preview_slider'] );
					foreach ( $images as $image ) {
						$url = ( is_numeric( $image ) && ! empty( $image ) ) ? wp_get_attachment_url( $image ) : '';
						if ( ! empty( $url ) ) {
							$output .= '<li class="post-slider-img">';
							$output .= napoli_the_lazy_load_flter( $url, array(
								'class' => 's-img-switch',
								'alt'   => ''
							) ); 
							$output .= '</li>';
						}
					}
					$output .= '</ul>';
					$output .= '</div>';
					$output .= '</div>';
					break;
				case 'text':
					$output = '<i class="fa fa-quote-right fa-2x"></i><blockquote>';
					$output .= wp_kses_post( $option[0]['post_preview_text'] );
					$output .= '</blockquote>';
					break;
				case 'audio':
					$output = '<div class="post-media">';
					$output .= wp_kses_post( napoli_post_media( $option[0]['post_preview_audio'] ) );
					$output .= '</div>';
					break;
			}

			if ( $format == 'quote' ) {
				$post_preview_text = $option[0]['post_preview_text'] ? $option[0]['post_preview_text'] : get_the_excerpt();
				$output            = '<i class="fa fa-quote-right fa-2x"></i><blockquote>';
				$output .= wp_kses_post( $post_preview_text );
				$output .= '</blockquote>';
			}

		} else {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
			if ( empty( $image ) ) {
				$image[0] = cs_get_option( 'default_post_image' );
			}
			$output = '<div class="post-media">';
			$output .= napoli_the_lazy_load_flter( $image[0], array(
				'class' => 's-img-switch',
				'alt'   => ''
			) );  
			$output .= '</div>';
		}
		echo $output;
	}
}


/*
* Get Page For Navi
*/
if ( ! function_exists( 'napoli_get_pages_for_navi' ) ) {
	function napoli_get_pages_for_navi() {
		$posts = get_posts( "post_type=page&post_status=publish&numberposts=99999&orderby=menu_order" );
		$pages = get_page_hierarchy( $posts );
		$pages = array_keys( $pages );

		return $pages;
	}
}
/**
 *
 * Get categories for shortcode.
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'napoli_categories' ) ) {
	function napoli_categories() {

		$args = array(
			'type'     => 'post',
			'taxonomy' => 'category'
		);

		$categories = get_categories( $args );
		$list       = array();

		foreach ( $categories as $category ) {
			$list[ $category->name ] = $category->slug;
		}

		return $list;
	}
}

/**
 *
 * Get instagram images.
 * @since 1.0.0
 * @version 1.0.0
 *
 **/
if ( ! function_exists( 'napoli_get_imstagram' ) ) {
	function napoli_get_imstagram( $username, $count_photos = 7 ) {
		$error       = false;
		$media_array = '';
		if ( false === ( $instagram = get_transient( 'instagram-media-' . sanitize_title_with_dashes( $username ) ) ) ) {

			$remote = wp_remote_get( 'http://instagram.com/' . trim( $username ) );
			if ( is_wp_error( $remote ) ) {
				$error = esc_html__( 'Unable to communicate with Instagram.', 'napoli' );
			}
			if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
				$error = esc_html__( 'Instagram error.', 'napoli' );
			}
			$shared      = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json  = explode( ';</script>', $shared[1] );
			$insta_array = json_decode( $insta_json[0], true );
			if ( ! $insta_array ) {
				$error = esc_html__( 'Instagram has returned invalid data.', 'napoli' );
			}
			if ( ! $error ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];

				$instagram = array();
				foreach ( $images as $image ) {
					$image['link']        = $image['code'];
					$image['display_src'] = $image['display_src'];
					$instagram[]          = array(
						'link'  => $image['link'],
						'large' => $image['display_src']
					);
				}
				$instagram = serialize( $instagram );
				set_transient( 'instagram-media-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}
		if ( $error ) {
			$output = $error;
		} else {
			$instagram    = unserialize( $instagram );
			$count_photos = ( ! empty( $count_photos ) && is_numeric( $count_photos ) ) ? $count_photos : 7;
			$media_array  = array_slice( $instagram, 0, $count_photos );
		}

		return $media_array;
	}
}

// Custom row styles for onepage site type+-.
if ( ! function_exists('napoli_dynamic_css' ) ) {
  function napoli_dynamic_css() {
    require_once get_template_directory() . '/assets/css/custom.css.php';
    wp_die();
  }
}
add_action( 'wp_ajax_nopriv_napoli_dynamic_css', 'napoli_dynamic_css' );
add_action( 'wp_ajax_napoli_dynamic_css', 'napoli_dynamic_css' );



/*
* Napoli Mini Cart for Woocommerce
*/
if (! function_exists('napoli_mini_cart' ) ) {
	function napoli_mini_cart(){

		if ( class_exists( 'WooCommerce' ) ){

			ob_start();
			?>
			<div class="napoli_mini_cart">

				<?php do_action( 'woocommerce_before_mini_cart' ); ?>

				<ul class="cart_list product_list_widget">

					<?php if ( ! WC()->cart->is_empty() ) : ?>

						<?php
							foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
								$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

								if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
									$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->post->post_title );
									$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
									$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
									?> 
									<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
										<div class="mini_cart_item_thumbnail">
											<?php if ( ! $_product->is_visible() ) : ?>
												<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
											<?php else : ?>
												<a href="<?php echo esc_url( $product_permalink ); ?>">
													<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
												</a>
											<?php endif; ?>
										</div>

										<div class="mini-cart-data">
											<a href="<?php echo esc_url( $product_permalink ); ?>" class="mini_cart_item_name">
												<?php echo wp_kses_post( $product_name ); ?>
											</a>

											<div class="mini_cart_item_quantity">
												<?php esc_html_e('x', 'napoli'); ?> 
												<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . $cart_item['quantity'] . '</span>', $cart_item, $cart_item_key ); ?>
											</div>

											<div class="mini_cart_item_price">
												<?php if ($cart_item['data']->price > 0) {
													echo wp_kses_post( $product_price );
												} else {
													esc_html_e( 'Free', 'napoli' );
												} ?>
											</div>
										</div>
										
									</li>
									<?php
								}
							}
						?>

					<?php else : ?>

						<li class="empty"><?php esc_html_e( 'No products in the cart.', 'napoli' ); ?></li>

					<?php endif; ?>

				</ul><!-- end product list -->

				<?php if ( ! WC()->cart->is_empty() ) : ?>

					<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

					<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'napoli' ); ?></a>

				<?php endif; ?>

				<?php do_action( 'woocommerce_after_mini_cart' ); ?>

			</div>

			<?php 
			return ob_get_clean();
		}
	}
}

if (! function_exists('napoli_the_share_posts')) {
	function napoli_the_share_posts($post,$show_title = '')
	{	
		if ( cs_get_option( 'social_portfolio' ) ) { 
			ob_start();  ?>
				<div class="row single-share">
					<div class="ft-part margin-lg-15b">
						<ul class="social-list">
							<?php if (!empty($show_title)) { ?>
							<li><span><?php esc_html_e( 'Share:', 'napoli' ); ?></span></li>
							<?php } ?>
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
			<?php 
			echo ob_get_clean();
		}
	} 
}


if (! function_exists('napoli_portfolio_page_template')) {
	function napoli_portfolio_page_template( $template ) {
		if (isset($_GET['download']) && $_GET['download'] == 'pdf') {
			$new_template = locate_template( array( 'page-pdf.php' ) );
			if ( '' != $new_template ) {
				return $new_template ;
			}
		}
		return $template;
	}
}
add_filter( 'template_include', 'napoli_portfolio_page_template', 99 );


if ( ! function_exists( 'napoli_get_post_shortcode_params' ) ) {
	function napoli_get_post_shortcode_params($tag_shortcode, $string = '', $all = false)
	{

		if (empty($tag_shortcode)) return false;

		if (empty($string)) {
			global $post;
			$string = $post->post_content;
		}
		
		preg_match_all( "/" . get_shortcode_regex(array($tag_shortcode)) . "/si" ,
					$string,
					$matchs );
		if (!empty($matchs[0])) {

			if ($all) {
				$params = array();
				foreach ($matchs[0] as $key => $param) {
					$this_param = str_replace('"]', '" ]', $matchs[$key][0]);
					$atts = shortcode_parse_atts($this_param);
					if (is_array($atts)) {
					$this_param = array_slice($atts, 1, -1);
						$params[] = $this_param;
					}
				}
				return $params;
			}

			$params = str_replace('"]', '" ]', $matchs[0][0]);
			$params = array_slice(shortcode_parse_atts($params), 1, -1);
			if (is_array($params)) {
				return $params;
			}
			return false;
		}
		return false;

	}
}

if (!function_exists('napoli_include_fonts')) {
	function napoli_include_fonts($fonts = '')
	{
		if ( empty($fonts) ) return ''; 

		if ( !is_array($fonts) ) {
			$fonts = array( $name_option );
		}

		foreach ($fonts as $key => $font) {
			if ( cs_get_option($font) ) { 

				$font_family = cs_get_option($font);
				if(! empty($font_family['family']) ) {
					wp_enqueue_style( sanitize_title_with_dashes($font_family['family']), '//fonts.googleapis.com/css?family=' . $font_family['family'] . ':' . $font_family['variant'] .'' );
				}
			}
		}

	}
}


// functions max word in string
if ( ! function_exists( 'napoli_maxsite_str_word' ) ) {
	function napoli_maxsite_str_word( $text, $counttext = 10, $sep = ' ' ) {
		$words = explode( $sep, $text );
		if ( count( $words ) > $counttext )
			$text = join( $sep, array_slice( $words, 0, $counttext ) );
		return $text;
	}
}

// functions max word in string
if ( ! function_exists( 'napoli_wp_get_attachment' ) ) {
	function napoli_wp_get_attachment($attachment_id)
	{

		$attachment = get_post($attachment_id);
		return array(
			'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href' => get_permalink($attachment->ID),
			'src' => $attachment->guid,
			'title' => $attachment->post_title
		);
	}
}
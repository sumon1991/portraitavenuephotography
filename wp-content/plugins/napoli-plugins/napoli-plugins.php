<?php
/*
Plugin Name: Napoli Plugins
Plugin URI: http://foxthemes.com/
Author: FOXTHEMES
Author URI: http://foxthemes.com/
Version: 1.9.4
Description: Includes Portfolio Custom Post Type and Visual Composer Shortcodes
Text Domain: napoli
*/

// Define Constants
defined( 'EF_ROOT' ) or define( 'EF_ROOT', dirname( __FILE__ ) );
defined( 'EF_VERSION' ) or define( 'EF_VERSION', '1.0' );

if ( ! class_exists( 'Napoli_Plugins' ) ) {

	require_once EF_ROOT . '/cs-framework/cs-framework.php';
	require_once EF_ROOT . '/lib/aq_resizer.php';
	require_once EF_ROOT . '/lib/napoli-justified-gallery/napoli-justified-gallery.php';
	// include functions
	require_once EF_ROOT .'/includes/functions_plugins.php';

	// wp update
	require_once EF_ROOT . '/lib/wp-updates-plugin.php';
	new WPUpdatesPluginUpdater_1638( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));

	/* For Help */
	add_action( 'admin_print_scripts', 'prague_add_help_script', 10, 1 );
	function prague_add_help_script()
	{

		?>
		<script>!function(e,o,n){window.HSCW=o,window.HS=n,n.beacon=n.beacon||{};var t=n.beacon;t.userConfig={},t.readyQueue=[],t.config=function(e){this.userConfig=e},t.ready=function(e){this.readyQueue.push(e)},o.config={docs:{enabled:!0,baseUrl:"//foxthemes.helpscoutdocs.com/"},contact:{enabled:!0,formId:"e754a0af-250c-11e7-9841-0ab63ef01522"}};var r=e.getElementsByTagName("script")[0],c=e.createElement("script");c.type="text/javascript",c.async=!0,c.src="https://djtflbt20bdde.cloudfront.net/",r.parentNode.insertBefore(c,r)}(document,window.HSCW||{},window.HS||{});</script>

		<script>
		  HS.beacon.config({
		    color: '#104787',
		  	<?php 
		  	$theme = wp_get_theme();
		  	?>
		    topics: [
				{ val: 'custom', label: 'I would Like to get Customization' },
				{ val: 'napoli', label: 'Napoli - Modern Photography Portfolio Theme' }
		    ],
		    collection: "58edd660dd8c8e5c5731510d",  /* Id documentation Prague */
		    icon: "message",
		    showSubject: true,
		    showContactFields : true,
		    attachment: true,
		    instructions:'Please submit your question, and we will do our best to help.'
		  });
		</script>

		<?php
	}

	class Napoli_Plugins {

		private $assets_js;

		public function __construct() {
			$this->assets_js  = plugins_url( '/composer/js', __FILE__ );
			$this->assets_css = plugins_url( '/composer/css', __FILE__ );
			add_action( 'init', array( $this, 'napoli_register_portfolio' ), 0 );
			add_action( 'admin_init', array( $this, 'napoli_load_map' ) );
			add_action( 'admin_print_scripts-post.php', array( $this, 'vc_enqueue_scripts' ), 99 );
			add_action( 'admin_print_scripts-post-new.php', array( $this, 'vc_enqueue_scripts' ), 99 );

			// add new params
			add_action( 'admin_init', array( $this, 'napoli_load_new_params' ) );

			add_action( 'admin_init', array( $this, 'napoli_load_shortcodes' ) );
			add_action( 'wp', array( $this, 'napoli_load_shortcodes' ) );


		}

		public function napoli_register_portfolio() {

			$portfolio_url_slug = cs_get_option('portfolio_slug') ? cs_get_option('portfolio_slug') : 'portfolio-item';
			$portfolio_category_url_slug = cs_get_option('portfolio_category_slug') ? cs_get_option('portfolio_category_slug') : 'portfolio-category';

			$taxonomy_labels = array(
				'name'                       => 'Category',
				'singular_name'              => 'Category',
				'menu_name'                  => 'Categories',
				'all_items'                  => 'All Categories',
				'parent_item'                => 'Parent Category',
				'parent_item_colon'          => 'Parent Category:',
				'new_item_name'              => 'New Category Name',
				'add_new_item'               => 'Add New Category',
				'edit_item'                  => 'Edit Category',
				'update_item'                => 'Update Category',
				'separate_items_with_commas' => 'Separate categories with commas',
				'search_items'               => 'Search categories',
				'add_or_remove_items'        => 'Add or remove categories',
				'choose_from_most_used'      => 'Choose from the most used categories',
			);

			$taxonomy_rewrite = array(
				'slug'         => $portfolio_category_url_slug,
				'with_front'   => true,
				'hierarchical' => true,
			);

			$taxonomy_args = array(
				'labels'            => $taxonomy_labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'show_tagcloud'     => true,
				'rewrite'           => $taxonomy_rewrite,
			);
			register_taxonomy( 'portfolio-category', array( 'portfolio' ), $taxonomy_args );

			$taxonomy_labels = array(
				'name'                       => 'Tag',
				'singular_name'              => 'Tag',
				'menu_name'                  => 'Tags',
				'all_items'                  => 'All Tags',
				'parent_item'                => 'Parent Tag',
				'parent_item_colon'          => 'Parent Tag:',
				'new_item_name'              => 'New Tag Name',
				'add_new_item'               => 'Add New Tag',
				'edit_item'                  => 'Edit Tag',
				'update_item'                => 'Update Tag',
				'separate_items_with_commas' => 'Separate categories with commas',
				'search_items'               => 'Search categories',
				'add_or_remove_items'        => 'Add or remove categories',
				'choose_from_most_used'      => 'Choose from the most used categories',
			);

			$taxonomy_rewrite = array(
				'slug'         => 'portfolio-tag',
				'with_front'   => true,
				'hierarchical' => true,
			);

			$taxonomy_args = array(
				'labels'            => $taxonomy_labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'show_tagcloud'     => true,
				'rewrite'           => $taxonomy_rewrite,
			);
			register_taxonomy( 'portfolio-tag', array( 'portfolio' ), $taxonomy_args );

			//Register new post type
			$post_type_labels = array(
				'name'               => 'Portfolio',
				'singular_name'      => 'Portfolio',
				'menu_name'          => 'Portfolio',
				'parent_item_colon'  => 'Parent Portfolio:',
				'all_items'          => 'All Portfolios',
				'view_item'          => 'View Portfolio',
				'add_new_item'       => 'Add New Portfolio',
				'add_new'            => 'Add New',
				'edit_item'          => 'Edit Portfolio',
				'update_item'        => 'Update Portfolio',
				'search_items'       => 'Search portfolios',
				'not_found'          => 'No portfolios found',
				'not_found_in_trash' => 'No portfolios found in Trash',
			);

			$post_type_rewrite = array(
				'slug'       => 'portfolio-item',
				'with_front' => true,
				'pages'      => true,
				'feeds'      => true,
			);

			$post_type_args = array(
				'label'              => 'portfolio',
				'description'        => 'Portfolio information pages',
				'labels'             => $post_type_labels,
				'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions'),
				'taxonomies'         => array( 'post' ),
				'hierarchical'       => false,
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'menu_icon'          => 'dashicons-format-gallery',
				'has_archive'        => true,
				'publicly_queryable' => true,
				'rewrite'            => array( 'slug' => $portfolio_url_slug ),
				'capability_type'    => 'post',
			);

			register_post_type( 'portfolio', $post_type_args );

		}

		public function napoli_load_map() {
			if ( class_exists( 'Vc_Manager' ) ) {
				require_once( EF_ROOT . '/' . 'composer/map.php' );
				require_once( EF_ROOT . '/' . 'composer/init.php' );
			}
		}

		public function napoli_load_shortcodes() {

			if ( class_exists( 'Vc_Manager' ) ) {
				foreach ( glob( EF_ROOT . '/' . 'shortcodes/napoli_*.php' ) as $shortcode ) {
					require_once( EF_ROOT . '/' . 'shortcodes/' . basename( $shortcode ) );
				}
				foreach ( glob( EF_ROOT . '/' . 'shortcodes/vc_*.php' ) as $shortcode ) {
					require_once( EF_ROOT . '/' . 'shortcodes/' . basename( $shortcode ) );
				}
			}

		}

		public function napoli_load_new_params() {
			$params = glob( dirname( __FILE__ ) . '/params/*' , GLOB_ONLYDIR);
			foreach ( $params as $key => $name ) {
				require_once( __DIR__ . "/params/" . basename($name) . "/" . basename($name) . ".php" );
			}
		}

		public function vc_enqueue_scripts() {
			wp_enqueue_script( 'vc-script', $this->assets_js . '/vc-script.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_style( 'rs-vc-custom', $this->assets_css . '/vc-style.css' );
		}

		

	} // end of class

	new Napoli_Plugins;

	if ( function_exists('vc_add_shortcode_param') ) {

		if (!function_exists('napoli_wpc_date')) {
			function napoli_wpc_date($settings, $value) {
			    return '<div class="date-group">'
			           . '<input name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-date ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" type="text" value="' . $value . '"/>'
			           . '</div>';
			}
		}
		vc_add_shortcode_param('wpc_date', 'napoli_wpc_date', get_template_directory_uri() . '/assets/js/date.js');
	}
 

	function napoli_wpc_date_style() {
	    wp_enqueue_script('jquery-ui-datepicker' );
	}
	add_action( 'admin_enqueue_scripts', 'napoli_wpc_date_style' );

} // end of class_exists



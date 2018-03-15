<?php
/**
 * The template for requried actions hooks.
 *
 * @package napoli
 * @since 1.0
 */

add_action( 'wp_enqueue_scripts', 'napoli_enqueue_scripts' );
add_action( 'widgets_init', 'napoli_register_widgets' );
add_action( 'tgmpa_register', 'napoli_include_required_plugins' );

define( 'CS_ACTIVE_FRAMEWORK', true );
define( 'CS_ACTIVE_METABOX', true );
define( 'CS_ACTIVE_SHORTCODE', false );
define( 'CS_ACTIVE_CUSTOMIZE', false );

/*
 * Register sidebar.
 */
if ( ! function_exists( 'napoli_register_widgets' ) ) {
	function napoli_register_widgets() {
		// register sidebars
		register_sidebar(
			array(
				'id'            => 'sidebar',
				'name'          => esc_attr__( 'Sidebar', 'napoli' ),
				'before_widget' => '<div id="%1$s" class="sidebar-item %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5>',
				'after_title'   => '</h5>',
				'description'   => esc_attr__( 'Drag the widgets for sidebars.', 'napoli' )
			)
		);
	}
}

if ( ! function_exists( 'napoli_fonts_url' ) ) {
	function napoli_fonts_url() {
		$font_url = '';

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== esc_html_x( 'on', 'Google font: on or off', 'napoli' ) ) {
			$fonts = array(
				'Raleway:400,100,300,500,600,700,800,900',
				'Roboto:400,100,300,700,900,300italic',
				'Libre Baskerville:400,400i,700',
				'Lora:400,700',
				'Roboto Slab:400,300,700,100',
				'Ubuntu:400,300,500,700',
				'Droid Serif:400,400italic,700,700italic',
				'Great Vibes',
				'Montserrat:400,700',
				'Noto Sans:400,700,400italic,700italic',
				'Open Sans'
			);

			$font_url = add_query_arg( 'family',
				urlencode( implode( '|', $fonts ) . "&subset=latin,latin-ext" ), "//fonts.googleapis.com/css" );
		}

		return $font_url;
	}
}

/**
 * @ return null
 * @ param none
 * @ loads all the js and css script to frontend
 **/
if ( ! function_exists( 'napoli_enqueue_scripts' ) ) {
	function napoli_enqueue_scripts() {

		// napoli options
		$napoli = wp_get_theme();

		// general settings
		if ( ( is_admin() ) ) {
			return;
		}



		wp_enqueue_script( 'modernizr', T_URI . '/assets/js/lib/modernizr-2.6.2.min.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), false );
		wp_enqueue_script( 'napoli_scripts', T_URI . '/assets/js/lib/scripts.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), false );
		wp_enqueue_script( 'jquery.countdown', get_template_directory_uri() . '/assets/js/jquery.countdown.min.js', '',  apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'napoli_modernizrcust', T_URI . '/assets/js/lib/modernizr.custom.26633.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'swiper', T_URI . '/assets/js/lib/idangerous.swiper.min_.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'flipster', T_URI . '/assets/js/jquery.flipster.min.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'napoli_foxlazy', T_URI . '/assets/js/foxlazy.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'jquery.easings', get_template_directory_uri() . '/assets/js/jquery.easings.min.js','',  apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'jquery.multiscroll', get_template_directory_uri() . '/assets/js/jquery.multiscroll.min.js','',  apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );

		wp_enqueue_script( 'cloudflare', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js','',  apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'kenburning', T_URI . '/assets/js/kenburning.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'equalHeightsPlugin', T_URI . '/assets/js/equalHeightsPlugin.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'fancybox', T_URI . '/assets/js/jquery.fancybox.min.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'fitvids', T_URI . '/assets/js/jquery.fitvids.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'sliphover', T_URI . '/assets/js/jquery.sliphover.min.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );
		wp_enqueue_script( 'napoli_main-js', T_URI . '/assets/js/script.js', array( 'jquery' ), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ), true );


		// add TinyMCE style
		add_editor_style();

		// including jQuery plugins
		wp_localize_script( 'jquery', 'myajax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'siteurl' => get_template_directory_uri(),
			)
		);

		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_style( 'napoli-fonts', napoli_fonts_url(), array(), apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );

		// register style
		wp_enqueue_style( 'napoli_base-css', T_URI . '/style.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );

		wp_enqueue_style( 'animsition', T_URI . '/assets/css/animsition.min.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		wp_enqueue_style( 'flipster', T_URI . '/assets/css/jquery.flipster.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		wp_enqueue_style( 'bootstrap', T_URI . '/assets/css/bootstrap.min.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		wp_enqueue_style( 'magnific-popup', T_URI . '/assets/css/magnific-popup.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		wp_enqueue_style( 'animate-css', T_URI . '/assets/css/animate.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		wp_enqueue_style( 'kenburning', T_URI . '/assets/css/kenburning.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		wp_enqueue_style( 'font-awesome', T_URI . '/assets/css/font-awesome.min.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		wp_enqueue_style( 'pe-icon-7-stroke', T_URI . '/assets/css/pe-icon-7-stroke.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		wp_enqueue_style( 'fancybox', T_URI . '/assets/css/jquery.fancybox.min.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );

		wp_enqueue_style( 'napoli_wp-css', T_URI . '/assets/css/main.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );

		
		if ( cs_get_option('enable_style_black') ) { 
			wp_enqueue_style( 'napoli_black_css', T_URI . '/assets/css/black.css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );
		}

		wp_enqueue_style( 'napoli_dynamic-css', admin_url( 'admin-ajax.php' ) . '?action=napoli_dynamic_css', '', apply_filters( 'napoli_version_filter', $napoli->get( 'Version' ) ) );

		/* Add Custom JS */
		if ( cs_get_option( 'custom_js_scripts' ) ) {
			wp_add_inline_script( 'napoli_main-js', cs_get_option( 'custom_js_scripts' ) );
		}

		if ( cs_get_option( 'enable_lazy_load' ) ) {
			wp_localize_script( 'napoli_main-js', 'enable_foxlazy', '' );
		}

		if ( cs_get_option('heading') ) {
			foreach (cs_get_option('heading') as $key => $title) {
				if ( empty( $title['heading_family'] )) continue;
				$font_family = $title['heading_family'];
				if(! empty($font_family['family']) ) { 
					wp_enqueue_style( sanitize_title_with_dashes($font_family['family']), '//fonts.googleapis.com/css?family=' . $font_family['family'] . ':' . $title['heading_family']['variant'].'' );
				}
			}
		}

		// include font family
		if ( function_exists('napoli_include_fonts') ) {
			napoli_include_fonts(
				array(
					'menu_item_family',
					'submenu_item_family',
					'gallery_font_family',
					'all_button_font_family',
					'all_button_font_family',
					'footer_font_family',
					'item_gallery_font_family',
					) // all options name 
			);
		}

	}
}

/**
 * Filter the page title.
 */
if ( ! function_exists( 'napoli_wp_title' ) ) {
	function napoli_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ) {
			return $title;
		}

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}

		// Add a page number if necessary.
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'napoli' ), max( $paged, $page ) );
		}

		return $title;
	}
}
add_filter( 'wp_title', 'napoli_wp_title', 10, 2 );

/**
 * Include plugins
 **/
if ( ! function_exists( 'napoli_include_required_plugins' ) ) {
	function napoli_include_required_plugins() {

		$plugins = array(
			array(
				'name'               => esc_html__( 'Napoli Plugins', 'napoli' ),
				// The plugin name
				'slug'               => 'napoli-plugins',
				// The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://foxthemes.com/web/wp/napoli.1.9.0/wp-content/plugins/napoli-plugins.zip' ),
				// The plugin source
				'required'           => true,
				// If false, the plugin is only 'recommended' instead of required
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'version'            => '1.9.4',
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Contact Form 7', 'napoli' ),
				// The plugin name
				'slug'               => 'contact-form-7',
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Woocommerce', 'napoli' ),
				// The plugin name
				'slug'               => 'woocommerce',
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Lunar', 'napoli' ),
				// The plugin name
				'slug'               => 'napoli-lunar-sell-photos-online',
				'source'             => esc_url( 'http://foxthemes.com/web/wp/napoli.1.4.0/wp-content/plugins/napoli-lunar-sell-photos-online.zip' ),
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Visual Composer', 'napoli' ),
				// The plugin name
				'slug'               => 'js_composer',
				// The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://foxthemes.com/web/wp/plugins/js_composer.zip' ),
				// The plugin source
				'required'           => true,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Booked Appointments', 'napoli' ),
				// The plugin name
				'slug'               => 'booked',
				// The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://foxthemes.com/web/wp/plugins/booked.zip' ),
				// The plugin source
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Revolution Slider', 'napoli' ),
				// The plugin name
				'slug'               => 'revslider',
				// The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://foxthemes.com/web/wp/plugins/revslider.zip' ),
				// The plugin source
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Contact Form 7', 'napoli' ),
				// The plugin name
				'slug'               => 'contact-form-7',
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'PixProof', 'napoli' ),
				// The plugin name
				'slug'               => 'pixproof',
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
		);

		// Change this to your theme text domain, used for internationalising strings

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       => 'napoli',                    // Text domain - likely want to be the same as your theme.
			'default_path' => '',                            // Default absolute path to pre-packaged plugins
			'menu'         => 'tgmpa-install-plugins',    // Menu slug
			'has_notices'  => true,                        // Show admin notices or not
			'is_automatic' => true,                        // Automatically activate plugins after installation or not
			'message'      => '',                            // Message to output right before the plugins table
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'napoli' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'napoli' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'napoli' ),
				// %1$s = plugin name
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'napoli' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'napoli' ),
				// %1$s = plugin name(s)
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'napoli' ),
				// %1$s = plugin name(s)
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'napoli' ),
				// %1$s = plugin name(s)
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'napoli' ),
				// %1$s = plugin name(s)
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'napoli' ),
				// %1$s = plugin name(s)
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'napoli' ),
				// %1$s = plugin name(s)
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'napoli' ),
				// %1$s = plugin name(s)
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'napoli' ),
				// %1$s = plugin name(s)
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'napoli' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'napoli' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'napoli' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'napoli' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'napoli' ),
				// %1$s = dashboard link
				'nag_type'                        => 'updated'
				// Determines admin notice type - can only be 'updated' or 'error'
			)
		);

		tgmpa( $plugins, $config );
	}
}


/* Automagical updates */
if (!function_exists('napoli_autoupdate')) {
	function napoli_autoupdate( $transient ) {
		// Nothing to do here if the checked transient entry is empty
		if ( empty( $transient->checked ) ) {
			return $transient;
		}


		// Let's start gathering data about the theme
		// First get the theme directory name (the theme slug - unique)
		$slug = basename( get_template_directory() );
		// Then WordPress version
		include ABSPATH . WPINC . '/version.php';
		$http_args = array(
			'body'       => array(
				'slug'        => $slug,
				'url'         => home_url(), //the site's home URL
				'version'     => 0,
				'locale'      => get_locale(),
				'phpv'        => phpversion(),
				'child_theme' => is_child_theme(),
				'data'        => null, //no optional data is sent by default
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
		);

		// If the theme has been checked for updates before, get the checked version
		if ( isset( $transient->checked[ $slug ] ) && $transient->checked[ $slug ] ) {
			$http_args['body']['version'] = $transient->checked[ $slug ];
		}

		// Use this filter to add optional data to send
		// Make sure you return an associative array - do not encode it in any way
		$optional_data = apply_filters( 'wupdates_call_data_request', $http_args['body']['data'], $slug, $http_args['body']['version'] );

		// Encrypting optional data with private key, just to keep your data a little safer
		// You should not edit the code bellow
		$optional_data = json_encode( $optional_data );
		$w             = array();
		$re            = "";
		$s             = array();
		$sa            = md5( '5bf482d52df4a008fb75b09aef54bf9b9a3e2e15' );
		$l             = strlen( $sa );
		$d             = $optional_data;
		$ii            = - 1;
		while ( ++ $ii < 256 ) {
			$w[ $ii ] = ord( substr( $sa, ( ( $ii % $l ) + 1 ), 1 ) );
			$s[ $ii ] = $ii;
		}
		$ii = - 1;
		$j  = 0;
		while ( ++ $ii < 256 ) {
			$j        = ( $j + $w[ $ii ] + $s[ $ii ] ) % 255;
			$t        = $s[ $j ];
			$s[ $ii ] = $s[ $j ];
			$s[ $j ]  = $t;
		}
		$l  = strlen( $d );
		$ii = - 1;
		$j  = 0;
		$k  = 0;
		while ( ++ $ii < $l ) {
			$j       = ( $j + 1 ) % 256;
			$k       = ( $k + $s[ $j ] ) % 255;
			$t       = $w[ $j ];
			$s[ $j ] = $s[ $k ];
			$s[ $k ] = $t;
			$x       = $s[ ( ( $s[ $j ] + $s[ $k ] ) % 255 ) ];
			$re .= chr( ord( $d[ $ii ] ) ^ $x );
		}
		$optional_data = bin2hex( $re );

		// Save the encrypted optional data so it can be sent to the updates server
		$http_args['body']['data'] = $optional_data;

		// Check for an available update
		$url = $http_url = set_url_scheme( 'https://wupdates.com/wp-json/wup/v1/themes/check_version/Jyzgj', 'http' );
		if ( $ssl = wp_http_supports( array( 'ssl' ) ) ) {
			$url = set_url_scheme( $url, 'https' );
		}

		$raw_response = wp_remote_post( $url, $http_args );
		if ( $ssl && is_wp_error( $raw_response ) ) {
			$raw_response = wp_remote_post( $http_url, $http_args );
		}
		// We stop in case we haven't received a proper response
		if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ) {
			return $transient;
		}

		$response = (array) json_decode( $raw_response['body'] );
		if ( ! empty( $response ) ) {
			// You can use this action to show notifications or take other action
			do_action( 'wupdates_before_response', $response, $transient );
			if ( isset( $response['allow_update'] ) && $response['allow_update'] && isset( $response['transient'] ) ) {
				$transient->response[ $slug ] = (array) $response['transient'];
			}
			do_action( 'wupdates_after_response', $response, $transient );
		}

		return $transient;
	}
}
add_filter( 'pre_set_site_transient_update_themes', 'napoli_autoupdate' );

if ( ! function_exists( 'napoli_password_form' ) ) {
	function napoli_password_form() {
		global $post;
		$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
		$o     = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
  ' . esc_html__( 'ENTER PASSWORD BELOW:', 'napoli' ) . '
  <label for="' . esc_attr( $label ) . '"></label><input placeholder="' . esc_attr__( "Password:", 'napoli' ) . '" name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" maxlength="20" /><input type="submit" name="' . esc_attr__( 'Submit', 'napoli' ) . '" value="' . esc_attr__( 'ACCEPT', 'napoli' ) . '" />
  </form>
  ';

		return $o;
	}
}
add_filter( 'the_password_form', 'napoli_password_form' );

// for woocommerce
add_filter('loop_shop_columns', 'napoli_loop_columns');
if (!function_exists('napoli_loop_columns')) {
	function napoli_loop_columns() {
		if (cs_get_option('products_per_row')) {
			return cs_get_option('products_per_row');
		} else {
			return 4; // 4 products per row
		}
	}
}

/* For Woocommerce */
if (!function_exists('napoli_add_to_cart_fragment')) {
	function napoli_add_to_cart_fragment( $fragments ) {
	
		ob_start();
		$count = WC()->cart->cart_contents_count;
		?> 
		<a class="napoli-shop-icon fa fa-shopping-cart" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart','napoli' ); ?>"> 
		   <?php  if ( $count > 0 ) { ?>
		        <div class="cart-contents">
		        	<span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
		        </div>
		   <?php } ?>
		</a>
		<?php $fragments['a.napoli-shop-icon'] = ob_get_clean();

		$fragments['div.napoli_mini_cart'] = napoli_mini_cart();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'napoli_add_to_cart_fragment' );

if (!function_exists('napoli_redirect_coming_soon')) {
	function napoli_redirect_coming_soon() {
		if ( cs_get_option('napoli_enable_coming_soon') && cs_get_option('napoli_page_coming_soon') && !is_admin_bar_showing() ) {

			$redirect_permalink = get_permalink( cs_get_option('napoli_page_coming_soon') );
			if ( get_permalink() != $redirect_permalink ){
				wp_redirect( get_permalink( cs_get_option('napoli_page_coming_soon') ) );
				exit();
			}
		}
	}
}
add_action( 'template_redirect', 'napoli_redirect_coming_soon' ); 


/*
 * Check need minimal requirements (PHP and WordPress version)
 */
if ( version_compare( $GLOBALS['wp_version'], '4.3', '<' ) || version_compare( PHP_VERSION, '5.3', '<' ) ) {
	if ( ! function_exists( 'napoli_requirements_notice' ) ) {
		function napoli_requirements_notice() {
			$message = sprintf( esc_html__( 'Napoli theme needs minimal WordPress version 4.3 and PHP 5.3<br>You are running version WordPress - %s, PHP - %s.<br>Please upgrade need module and try again.', 'napoli' ), $GLOBALS['wp_version'], PHP_VERSION );
			printf( '<div class="notice-warning notice"><p><strong>%s</strong></p></div>', $message );
		}
	}
	add_action( 'admin_notices', 'napoli_requirements_notice' );
}


/*
 * Check need minimal requirements (PHP and WordPress version)
 */
if ( ! function_exists( 'napoli_coming_soon_notice' ) ) {
	function napoli_coming_soon_notice() {
		if ( cs_get_option('napoli_enable_coming_soon') ) {
			?>
			<div class="notice-warning notice">
				<p><strong>
				<?php echo esc_html__( 'Your "Coming Soon" option is enabled now.', 'napoli' );
				?></strong></p></div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'napoli_coming_soon_notice' );

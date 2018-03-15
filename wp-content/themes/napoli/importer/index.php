<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!defined('ENVATO_THEME_VERSION')){
	define('ENVATO_THEME_VERSION', 1.0 );
}

/**
 * Napoli_Setup class
 */
if (!class_exists('Napoli_Setup')) {
	class Napoli_Setup {


		/** @var string Currenct Step */
		private $step   = '';


		/** @var array Steps for the setup wizard */
		private $steps  = array();


		/** @var string url for this plugin folder, used when enquing scripts */
		private $public_base_url = ''; // set in construct

		/** @var string Current theme name, used as namespace in actions. */
		private $theme_name = ''; // set in construct

		/**
		 * Hook in tabs.
		 */
		public function __construct() {
			$current_theme = wp_get_theme();
			$this->theme_name = strtolower(preg_replace('#[^a-zA-Z]#','',$current_theme->get('Name')));
			if ( apply_filters( $this->theme_name . '_enable_setup_wizard', true ) && current_user_can( 'manage_options' )  ) {
				$this->public_base_url = get_template_directory_uri().'/importer';
				add_action( 'after_switch_theme', array( $this, 'switch_theme' ) );
				add_action( 'admin_menu', array( $this, 'admin_menus' ) );
				add_action( 'admin_init', array( $this, 'admin_redirects' ), 30 );
				add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1);
				add_action( 'wp_ajax_envato_setup_plugins', array($this, 'ajax_plugins') );
				add_action( 'wp_ajax_envato_setup_content', array($this, 'ajax_content') );
			}
		}

		public function tgmpa_load($status){
			return is_admin() || current_user_can( 'install_themes' );
		}

		public function switch_theme(){
			set_transient( '_'.$this->theme_name.'_activation_redirect', 1 );
		}
		public function admin_redirects() {
			ob_start();
			if ( !get_transient( '_'.$this->theme_name.'_activation_redirect' ) ) {
				return;
			}
			delete_transient( '_'.$this->theme_name.'_activation_redirect' );
			wp_safe_redirect( admin_url( 'themes.php?page='.$this->theme_name.'-setup' ) );
			exit;
		}
			/**
		 * Add admin menus/screens.
		 */
		public function admin_menus() {
			add_theme_page(esc_html__('Import Demo Data','napoli'), esc_html__('Import Demo Data','napoli'), 'manage_options', $this->theme_name.'-setup', array($this,'setup_wizard') );
		}

		/**
		 * Show the setup wizard
		 */
		public function setup_wizard() {

			if ( empty( $_GET['page'] ) || $this->theme_name.'-setup' !== $_GET['page'] ) {
				return;
			}

			wp_enqueue_script( 'jquery-blockui', $this->public_base_url . '/js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
			wp_enqueue_script( 'envato-setup', $this->public_base_url . '/js/envato-setup.js', array( 'jquery', 'jquery-blockui' ), ENVATO_THEME_VERSION );
			wp_localize_script( 'envato-setup', 'envato_setup_params', array(
				'tgm_plugin_nonce'            => array(
					'update' => wp_create_nonce( 'tgmpa-update' ),
					'install' => wp_create_nonce( 'tgmpa-install' ),
				),
				'tgm_bulk_url' => admin_url('themes.php?page=tgmpa-install-plugins'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				'wpnonce' => wp_create_nonce('envato_setup_nonce'),
				'verify_text' => esc_html__('...verifying','napoli'),
			) );

			wp_enqueue_style( 'envato-setup', $this->public_base_url . '/css/envato-setup.css', array( 'dashicons' ), ENVATO_THEME_VERSION );

			wp_enqueue_media();
			wp_enqueue_script( 'media' );

			$this->steps = array(
				'introduction' => array(
					'name'    =>  esc_html__( 'Introduction', 'napoli' ),
					'view'    => array( $this, 'envato_setup_introduction' ),
					'handler' => ''
				),
			);
			if(class_exists( 'TGM_Plugin_Activation' ) && isset($GLOBALS['tgmpa'])) {
				$this->steps['default_plugins'] = array(
					'name' => esc_html__( 'Plugins', 'napoli' ),
					'view' => array( $this, 'envato_setup_default_plugins' ),
					'handler' => ''
				);
			}
			$this->steps['default_content'] = array(
				'name'    =>  esc_html__( 'Content', 'napoli' ),
				'view'    => array( $this, 'envato_setup_default_content' ),
				'handler' => ''
			);
			$this->steps['customize'] = array(
				'name'    =>  esc_html__( 'Customize', 'napoli' ),
				'view'    => array( $this, 'envato_setup_customize' ),
				'handler' => '',
			);
			$this->steps['next_steps'] = array(
				'name'    =>  esc_html__( 'Ready!', 'napoli' ),
				'view'    => array( $this, 'envato_setup_ready' ),
				'handler' => ''
			);
			$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			echo '<div class="envato-setup-wrapper">';
			$this->setup_wizard_steps();
			$show_content = true;
			echo '<div class="envato-setup-content">';
			if ( ! empty( $_REQUEST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
				$show_content = call_user_func( $this->steps[ $this->step ]['handler'] );
			}
			if($show_content){
				$this->setup_wizard_content();
			}
			echo '</div>';
			echo '</div>';
		}

		public function get_step_link($step) {
			return  add_query_arg( 'step', $step, admin_url('admin.php?page=' .$this->theme_name.'-setup') );
		}
		public function get_next_step_link() {
			$keys = array_keys( $this->steps );
			return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ], remove_query_arg( 'translation_updated' ) );
		}

		/**
		 * Setup Wizard Footer
		 */
		public function setup_wizard_footer() {
				?>
					<?php if ( 'next_steps' === $this->step ) : ?>
					<a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to the WordPress Dashboard', 'napoli' ); ?></a>
					<?php endif; ?>
				</body>
				<?php
					@do_action( 'admin_footer' ); // this was spitting out some errors in some admin templates. quick @ fix until I have time to find out what's causing errors.
					do_action( 'admin_print_footer_scripts' );
				?>
				</html>
			<?php
		}


	/**
	 * Output the steps
	 */
	public function setup_wizard_steps() {
		$ouput_steps = $this->steps;
		array_shift( $ouput_steps );
		?>
		<ol class="envato-setup-steps">
			<?php foreach ( $ouput_steps as $step_key => $step ) : ?>
				<li class="<?php
				$show_link = false;
				if ( $step_key === $this->step ) {
					echo 'active';
				} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
					echo 'done';
					$show_link = true;
				}
				?>"><?php
					if($show_link){
						?>
						<a href="<?php echo esc_url($this->get_step_link($step_key));?>"><?php echo esc_html( $step['name'] );?></a>
						<?php
					}else{
						echo esc_html( $step['name'] );
					}
					?></li>
			<?php endforeach; ?>
		</ol>
		<?php
	}

	/**
	 * Output the content for the current step
	 */
	public function setup_wizard_content() {
		isset($this->steps[ $this->step ]) ? call_user_func( $this->steps[ $this->step ]['view'] ) : false;
	}

	/**
	 * Introduction step
	 */
	public function envato_setup_introduction() {
		if(isset($_REQUEST['export'])){

			// find the ID of our menu names so we can import them into default menu locations and also the widget positions below.
			$menus = get_terms('nav_menu');
			$menu_ids = array();
			foreach($menus as $menu){
				if($menu->name == 'Main Menu'){
					$menu_ids['primary'] = $menu->term_id;
				}else if($menu->name == 'Quick Links'){
					$menu_ids['footer_quick'] = $menu->term_id;
				}
			}
			// used for me to export my widget settings.
			$widget_positions = get_option('sidebars_widgets');
			$widget_options = array();
			$my_options = array();
			foreach($widget_positions as $sidebar_name => $widgets){
				if(is_array($widgets)){
					foreach($widgets as $widget_name){
						$widget_name_strip = preg_replace('#-\d+$#','',$widget_name);
						$widget_options[$widget_name_strip] = get_option('widget_'.$widget_name_strip);
					}
				}
			}
			// choose which custom options to load into defaults
			$all_options = wp_load_alloptions();
			foreach( $all_options as $name => $value ) {
				if(stristr($name, '_widget_area_manager')) $my_options[$name] = $value;
			}
			$my_options['travel_settings'] = array('api_key'=>'AIzaSyBsnYWO4SSibatp0SjsU9D2aZ6urI-_cJ8');
			$my_options['tt-font-google-api-key'] = 'AIzaSyBsnYWO4SSibatp0SjsU9D2aZ6urI-_cJ8';
			?>
			<h1><?php esc_html_e( 'Current Settings:','napoli'); ?></h1>
			<p><?php esc_html_e( 'Widget Positions:','napoli'); ?></p>
			<textarea style="width:100%; height:80px;"><?php echo json_encode($widget_positions);?></textarea>
			<p><?php esc_html_e( 'Widget Options:','napoli'); ?></p>
			<textarea style="width:100%; height:80px;"><?php echo json_encode($widget_options);?></textarea>
			<p><?php esc_html_e( 'Menu IDs:','napoli'); ?></p>
			<textarea style="width:100%; height:80px;"><?php echo json_encode($menu_ids);?></textarea>
			<p><?php esc_html_e( 'Custom Options:','napoli'); ?></p>
			<textarea style="width:100%; height:80px;"><?php echo json_encode($my_options);?></textarea>
			<p><?php esc_html_e( 'Copy these values into your PHP code when distributing/updating the theme.','napoli'); ?></p>
			<?php
		}else {
			?>
			<h1><?php esc_html_e( 'Welcome to Napoli install!', 'napoli' ); ?></h1>
			<p><?php  esc_html_e( "Everyone hates to install-but you will love this! Our rocket-fast install wizard will do most of the work for you. We'll have a couple of questions along the way, but right now you are ", 'napoli');?><u><?php esc_html_e('only minutes','napoli'); ?></u><?php esc_html_e( " away from having an awesome looking blog for the whole world to see.", 'napoli' ); ?></p>
			<p><?php esc_html_e( 'By the way, if you are slammed for time and can\'t spare 5 minutes right now, no problem! Come back to this "dashboard" page when you have a little more time and we\'ll be waiting right here-ready to go!', 'napoli' ); ?></p>
			<p class="envato-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
				   class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!', 'napoli' ); ?></a>
				<a href="<?php echo esc_url( wp_get_referer() ? wp_get_referer() : admin_url( '' ) ); ?>"
				   class="button button-large"><?php esc_html_e( 'Not right now', 'napoli' ); ?></a>
			</p>
			<?php
		}
	}


	private function _get_plugins(){
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$plugins = array(
			'all'      => array(), // Meaning: all plugins which still have open actions.
			'install'  => array(),
			'update'   => array(),
			'activate' => array(),
		);

		foreach ( $instance->plugins as $slug => $plugin ) {
			if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
				// No need to display plugins if they are installed, up-to-date and active.
				continue;
			} else {
				$plugins['all'][ $slug ] = $plugin;

				if ( ! $instance->is_plugin_installed( $slug ) ) {
					$plugins['install'][ $slug ] = $plugin;
				} else {
					if ( false !== $instance->does_plugin_have_update( $slug ) ) {
						$plugins['update'][ $slug ] = $plugin;
					}

					if ( $instance->can_plugin_activate( $slug ) ) {
						$plugins['activate'][ $slug ] = $plugin;
					}
				}
			}
		}
		return $plugins;
	}

	/**
	 * Page setup
	 */
	public function envato_setup_default_plugins() {

		tgmpa_load_bulk_installer();
		// install plugins with TGM.
		if(!class_exists( 'TGM_Plugin_Activation' ) || !isset($GLOBALS['tgmpa'])){
			die('Failed to find TGM');
		}
		$url = wp_nonce_url( add_query_arg( array('plugins'=>'go')), 'envato-setup' );
		$plugins = $this->_get_plugins();

		// copied from TGM

		$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
		$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

		if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
			return true; // Stop the normal page form from displaying, credential request form will be shown.
		}

		// Now we have some credentials, setup WP_Filesystem.
		if ( ! WP_Filesystem( $creds ) ) {
			// Our credentials were no good, ask the user for them again.
			request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

			return true;
		}

		/* If we arrive here, we have the filesystem */

		?>
		<h1><?php esc_html_e( 'Default Plugins', 'napoli' ); ?></h1>
		<form method="post">

			<?php
			$plugins = $this->_get_plugins();
			if(count($plugins['all'])){
			?>
				<p><?php esc_html_e( 'Some of these you Must Have and some of them you\'ll Want to Have...', 'napoli' ); ?></p>
				<ul class="envato-wizard-plugins">
					<?php foreach($plugins['all'] as $slug => $plugin){ ?>
						<li data-slug="<?php echo esc_attr($slug);?>"><?php echo esc_html($plugin['name']);?>
							<span>
								<?php
								$keys = array();
								if(isset($plugins['install'][$slug]))$keys[] = 'Installation';
								if(isset($plugins['update'][$slug]))$keys[] = 'Update';
								if(isset($plugins['activate'][$slug]))$keys[] = 'Activation';
								echo implode(' and ',$keys).' required';
								?>
							</span>
							<div class="spinner"></div>
						</li>
					<?php } ?>
				</ul>
				<?php
			}else{
				echo '<p><strong>'.esc_html__('Good news! All plugins are already installed and up to date. Please continue.','napoli').'</strong></p>';
			} ?>

			<p class="envato-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_plugins"><?php esc_html_e( 'Continue', 'napoli' ); ?></a>
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'napoli' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
			</p>
		</form>
		<?php
	}


	public function ajax_plugins(){
		if(!check_ajax_referer( 'envato_setup_nonce', 'wpnonce') || empty($_POST['slug'])){
			wp_send_json_error(array('error'=>1,'message'=>esc_html__('No Slug Found','napoli')));
		}
		$json = array();
		// send back some json we use to hit up TGM
		$plugins = $this->_get_plugins();
		// what are we doing with this plugin?
		foreach($plugins['activate'] as $slug => $plugin){
			if($_POST['slug'] == $slug){
				$json = array(
					'url' => admin_url('themes.php?page=tgmpa-install-plugins'),
					'plugin' => array($slug),
					'tgmpa-page' => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
					'action' => 'tgmpa-bulk-activate',
					'action2' => -1,
					'message' => esc_html__('Activating Plugin','napoli'),
				);
				break;
			}
		}
		foreach($plugins['update'] as $slug => $plugin){
			if($_POST['slug'] == $slug){
				$json = array(
					'url' => admin_url('themes.php?page=tgmpa-install-plugins'),
					'plugin' => array($slug),
					'tgmpa-page' => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
					'action' => 'tgmpa-bulk-update',
					'action2' => -1,
					'message' => esc_html__('Updating Plugin','napoli'),
				);
				break;
			}
		}
		foreach($plugins['install'] as $slug => $plugin){
			if($_POST['slug'] == $slug){
				$json = array(
					'url' => admin_url('themes.php?page=tgmpa-install-plugins'),
					'plugin' => array($slug),
					'tgmpa-page' => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
					'action' => 'tgmpa-bulk-install',
					'action2' => -1,
					'message' => esc_html__('Installing Plugin','napoli'),
				);
				break;
			}
		}

		if($json){
			$json['hash'] = md5(serialize($json)); // used for checking if duplicates happen, move to next plugin
			wp_send_json($json);
		}else{
			wp_send_json(array('done'=>1,'message'=>esc_html__('Success','napoli')));
		}
		exit;

	}


	private function _content_default_get(){

		$content = array();

		$content['pages'] = array(
			'title' => esc_html__( 'White Demo', 'napoli' ),
			'description' => esc_html__( 'Creates a new "blank" page for you to use.', 'napoli' ),
			'pending' => esc_html__( 'Pending.', 'napoli' ),
			'installing' => __( "Default--It's not your fault!", 'napoli' ),
			'success' => esc_html__( 'Success.', 'napoli' ),
			'install_callback' => '_content_install_pages',
		);
		$content['pages2'] = array(
			'title' => esc_html__( 'Black Demo', 'napoli' ),
			'description' => esc_html__( 'Creates a new "blank" page for you to use.', 'napoli' ),
			'pending' => esc_html__( 'Pending.', 'napoli' ),
			'installing' => __( "Default--It's not your fault!", 'napoli' ),
			'success' => esc_html__( 'Success.', 'napoli' ),
			'install_callback' => '_content_install_black_pages',
		);
		/*$content['widgets'] = array(
			'title' => esc_html__( 'Widgets', 'napoli' ),
			'description' => esc_html__( 'Cool "widgets" on your sidebar that you will make your page come alive with options.', 'napoli' ),
			'pending' => esc_html__( 'Pending.', 'napoli' ),
			'installing' => esc_html__( 'Installing Default Widgets.', 'napoli' ),
			'success' => esc_html__( 'Success.', 'napoli' ),
			'install_callback' => '_content_install_widgets',
		);*/
		$content['codestar'] = array(
			'title' => esc_html__( 'Enable default options', 'napoli' ),
			'description' => esc_html__( 'Change logo colors, fonts, layout... you know, the cool stuff.','napoli' ),
			'pending' => esc_html__( 'Pending.','napoli' ),
			'installing' => esc_html__( 'Installing Default Theme Settings.','napoli' ),
			'success' => esc_html__( 'Success.','napoli' ),
			'install_callback' => '_content_install_codestar',
		);
		
		$content['codestar2'] = array(
			'title' => esc_html__( 'Enable black options', 'napoli' ),
			'description' => esc_html__( 'Change logo colors, fonts, layout... you know, the cool stuff.','napoli' ),
			'pending' => esc_html__( 'Pending.','napoli' ),
			'installing' => esc_html__( 'Installing Default Theme Settings.','napoli' ),
			'success' => esc_html__( 'Success.','napoli' ),
			'install_callback' => '_content_install_codestar_black',
		);
		$content['settings'] = array(
			'title' => esc_html__( 'Settings', 'napoli' ),
			'description' => esc_html__( 'General settings help you to customize your site.', 'napoli' ),
			'pending' => esc_html__( 'Pending.', 'napoli' ),
			'installing' => esc_html__( 'Installing Default Settings.', 'napoli' ),
			'success' => esc_html__( 'Success.', 'napoli' ),
			'install_callback' => '_content_install_settings',
		);
		$content['customize'] = array(
			'title' => esc_html__( 'Customize options', 'napoli' ),
			'description' => esc_html__( "You'll see-more cool stuff to play with.", 'napoli' ),
			'pending' => esc_html__( 'Pending.', 'napoli' ),
			'installing' => esc_html__( 'Installing Default Customize Settings.', 'napoli' ),
			'success' => esc_html__( 'Success.', 'napoli' ),
			'install_callback' => '_content_install_customize',
		);


		return $content;

	}

	/**
	 * Page setup
	 */
	public function envato_setup_default_content() {
		?>
		<h1><?php esc_html_e( 'Default Content', 'napoli' ); ?></h1>
		<form method="post">
			<p><?php printf( esc_html__( "Most theme's come with some \"Lorem ipsum...\" type of text that sounds like a language from Mars. Napoli is different (but you know that by now!). We've handpicked some interesting articles that you can use or discard. Read them--they'll help you improve your blog. And have fun playing with the different options below. ", 'napoli' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '" target="_blank">', '</a>' ); ?></p>
			<table class="envato-setup-pages" cellspacing="0">
				<thead>
				<tr>
					<td class="check"> </td>
					<th class="item"><?php esc_html_e( 'Item', 'napoli' ); ?></th>
					<th class="description"><?php esc_html_e( 'Description', 'napoli' ); ?></th>
					<th class="status"><?php esc_html_e( 'Status', 'napoli' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($this->_content_default_get() as $slug => $default){ 
					?>
				<tr class="envato_default_content <?php echo esc_attr( $slug ); ?>" data-content="<?php echo esc_attr($slug);?>">
					<td>
						<?php if ($slug == "pages") :?>
							<input type="radio" name="default_content[pages]" class="envato_default_content" id="default_content_<?php echo esc_attr($slug);?>" value="1" checked>
						<?php elseif($slug == "pages2"): ?>
							<input type="radio" name="default_content[pages]" class="envato_default_content" id="default_content_<?php echo esc_attr($slug);?>" value="2">
						<?php elseif ($slug == "codestar") :?>
							<input type="radio" name="default_content[codestar]" class="envato_default_content" id="default_content_<?php echo esc_attr($slug);?>" value="1" checked>
						<?php elseif ($slug == "codestar2") :?>
							<input type="radio" name="default_content[codestar]" class="envato_default_content" id="default_content_<?php echo esc_attr($slug);?>" value="2">
						<?php else: ?>
							<input type="checkbox" name="default_content[pages]" class="envato_default_content" id="default_content_<?php echo esc_attr($slug);?>" value="1" checked>
						<?php endif; ?>
					</td>
					<td><label for="default_content_<?php echo esc_attr($slug);?>"><?php echo esc_html( $default['title'] ); ?></label></td>
					<td class="description"><?php echo wp_kses_post( $default['description'] ); ?></td>
					<td class="status"> <span><?php echo wp_kses_post( $default['pending'] );?></span> <div class="spinner"></div></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>

			<p class="envato-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_content"><?php esc_html_e( 'Continue', 'napoli' ); ?></a>
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'napoli' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
			</p>
		</form>
		<?php
	}


	public function ajax_content(){
		$content = $this->_content_default_get();
		if(!check_ajax_referer( 'envato_setup_nonce', 'wpnonce') || empty($_POST['content']) && isset($content[$_POST['content']])){
			wp_send_json_error(array('error'=>1,'message'=>esc_html__('No content Found','napoli')));
		}

		$json = false;
		$this_content = $content[$_POST['content']];



		if(isset($_POST['proceed'])){
			// install the content!

			if(!empty($this_content['install_callback'])){
				if($result = $this->{$this_content['install_callback']}() ){
					$json = array(
						'done' => 1,
						'message' => $this_content['success'],
						'debug' => $result,
					);
				}
			}

		}else {

			$json = array(
				'url' => admin_url( 'admin-ajax.php' ),
				'action' => 'envato_setup_content',
				'proceed' => 'true',
				'content' => $_POST['content'],
				'_wpnonce' => wp_create_nonce( 'envato_setup_nonce' ),
				'message' => $this_content['installing'],
			);

		}

		if(! empty($json) ){
			$json['hash'] = md5(serialize($json)); // used for checking if duplicates happen, move to next plugin
			wp_send_json($json);
		}else{
			wp_send_json(array('error'=>1,'message'=>esc_html__('Error','napoli')));
		}

		exit;

	}

	private function _import_wordpress_xml_file($xml_file_path){
		global $wpdb;

		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if ( ! class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if ( file_exists( $class_wp_importer ) )
			{
				require $class_wp_importer;
			}
		}

		if ( ! class_exists( 'WP_Import' )) {
			$class_wp_importer = __DIR__ ."/importer/wordpress-importer.php";
			if ( file_exists( $class_wp_importer ) )
				require_once get_template_directory() . '/importer/importer/wordpress-importer.php';
		}

		if ( class_exists( 'WP_Import' ) )
		{
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			ob_start();
			$wp_import->import($xml_file_path);
			$message = ob_get_clean();
			return $message;
		}
		return false;
	}

	private function _content_install_pages(){
		return $this->_import_wordpress_xml_file(__DIR__ ."/content/all.xml");
	}
	private function _content_install_black_pages(){
		return $this->_import_wordpress_xml_file(__DIR__ ."/content/black_all.xml");
	}
	private function _content_install_products(){
		if($this->_import_wordpress_xml_file(__DIR__ ."/content/products.xml")){
			return $this->_import_wordpress_xml_file(__DIR__ ."/content/variations.xml");
		}
		return false;
	}

	private function _content_install_widgets(){

	    global $wp_registered_sidebars, $wp_registered_widget_controls;
	    $widget_controls = $wp_registered_widget_controls;
		
		// remove locations widgets
	    update_option( 'sidebars_widgets', '' );
	    
	    $available_widgets = array();
	
	    foreach ( $widget_controls as $widget ) {
	
	        if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { 
	
	            $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
	            $available_widgets[$widget['id_base']]['name'] = $widget['name'];
	
	        }
	
	    }


	    $data = $this->_get_json('widget_options.json');

	    // Get all existing widget instances
	    $widget_instances = array();
	    foreach ( $available_widgets as $widget_data ) {
	        $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	    }
	    // Begin results
	    $results = array();

	    // Loop import data's sidebars
	    foreach ( $data as $sidebar_id => $widgets ) {

	        // Skip inactive widgets
	        // (should not be in export file)
	        if ( 'wp_inactive_widgets' == $sidebar_id ) {
	            continue;
	        }

	        // Check if sidebar is available on this site
	        // Otherwise add widgets to inactive, and say so
	        if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
	            $sidebar_available = true;
	            $use_sidebar_id = $sidebar_id;
	            $sidebar_message_type = 'success';
	            $sidebar_message = '';
	        } else {
	            $sidebar_available = false;
	            $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
	            $sidebar_message_type = 'error';
	            $sidebar_message = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'napoli');
	        }

	        // Result for sidebar
	        $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
	        $results[$sidebar_id]['message_type'] = $sidebar_message_type;
	        $results[$sidebar_id]['message'] = $sidebar_message;
	        $results[$sidebar_id]['widgets'] = array();

	        // Loop widgets
	        foreach ( $widgets as $widget_instance_id => $widget ) {

	            $fail = false;

	            // Get id_base (remove -# from end) and instance ID number
	            $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
	            $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

	            // Does site support this widget?
	            if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
	                $fail = true;
	                $widget_message_type = 'error';
	                $widget_message = esc_html__( 'Site does not support widget', 'napoli'); // explain why widget not imported
	            }

	            // Filter to modify settings before import
	            // Do before identical check because changes may make it identical to end result (such as URL replacements)
	            $widget = apply_filters( 'wie_widget_settings', $widget );

	            // Does widget with identical settings already exist in same sidebar?
	            if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

	                // Get existing widgets in this sidebar
	                $sidebars_widgets = get_option( 'sidebars_widgets' );
	                $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

	                // Loop widgets with ID base
	                $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
	                foreach ( $single_widget_instances as $check_id => $check_widget ) {

	                    // Is widget in same sidebar and has identical settings?
	                    if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

	                        $fail = true;
	                        $widget_message_type = 'warning';
	                        $widget_message = esc_html__( 'Widget already exists', 'napoli'); // explain why widget not imported

	                        break;

	                    }

	                }

	            }

	            // No failure
	            if ( ! $fail ) {

	                // Add widget instance
	                $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
	                $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
	                $single_widget_instances[] = (array) $widget; // add it

	                    // Get the key it was given
	                    end( $single_widget_instances );
	                    $new_instance_id_number = key( $single_widget_instances );

	                    // If key is 0, make it 1
	                    // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
	                    if ( '0' === strval( $new_instance_id_number ) ) {
	                        $new_instance_id_number = 1;
	                        $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
	                        unset( $single_widget_instances[0] );
	                    }

	                    // Move _multiwidget to end of array for uniformity
	                    if ( isset( $single_widget_instances['_multiwidget'] ) ) {
	                        $multiwidget = $single_widget_instances['_multiwidget'];
	                        unset( $single_widget_instances['_multiwidget'] );
	                        $single_widget_instances['_multiwidget'] = $multiwidget;
	                    }

	                    // Update option with new widget
	                    update_option( 'widget_' . $id_base, $single_widget_instances );

	                // Assign widget instance to sidebar
	                $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
	                $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
	                $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
	                update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

	                // Success message
	                if ( $sidebar_available ) {
	                    $widget_message_type = 'success';
	                    $widget_message = esc_html__( 'Imported', 'napoli');
	                } else {
	                    $widget_message_type = 'warning';
	                    $widget_message = esc_html__( 'Imported to Inactive', 'napoli');
	                }

	            }

	            // Result for widget instance
	            $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
	            $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : esc_html__( 'No Title', 'napoli'); // show "No Title" if widget instance is untitled
	            $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
	            $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;
	        }
	    }

	    return true;
	}

	// settings codestar
	private function _content_install_codestar(){
		$theme_options = $this->_get_json('theme_options.json');
		if (function_exists('cs_decode_string')) {
			update_option( '_cs_options', cs_decode_string($theme_options['data']) );
		}
		return true;
	}
	private function _content_install_codestar_black(){
		$theme_options = $this->_get_json('theme_options_black.json');
		if (function_exists('cs_decode_string')) {
			update_option( '_cs_options', cs_decode_string($theme_options['data']) );
		}
		return true;
	}


	private function _content_install_settings(){

		$custom_options = $this->_get_json('options.json');

		// we also want to update the widget area manager options.
		foreach($custom_options as $option => $value){
			update_option($option, $value);
		}
		return true;
	}
	private function _content_install_customize(){

		$customize_options = $this->_get_json('customize.json');

		
		$menus = get_terms('nav_menu');
		$menu_ids = array();
		foreach($menus as $menu){
			if($menu->slug == 'top-menu'){
				$menu_ids['primary_menu'] = $menu->term_id;
			}
		}

		// adjust the widget settings to match our menu ID's which we discovered above.
		if(is_array($customize_options) && isset($customize_options['nav_menu_locations'])){
			foreach($customize_options['nav_menu_locations'] as $key => $val){
				if ($key == 'primary-menu' && $val != $menu_ids['primary_menu']) {
					$customize_options['nav_menu_locations'][$key] = $menu_ids['primary_menu'];
				}
			}
		}

		if (!empty($customize_options)) {
			foreach($customize_options as $option => $value){
				set_theme_mod( $option, $value );
			}
		}
		return true;
	}
	private function _get_json($file){
		if(is_file(__DIR__.'/content/'.basename($file))) {
			WP_Filesystem();
			global $wp_filesystem;
			return json_decode( $wp_filesystem->get_contents( __DIR__ . '/content/' . basename( $file )), true  );
		}
		return array();
	}

	/**
	 * Logo & Design
	 */
	public function envato_setup_logo_design() {

		?>
		<h1><?php esc_html_e( 'Logo &amp; Design', 'napoli' ); ?></h1>
		<form method="post">
			<p><?php esc_html_e('Please add your logo below. For best results, the logo should be a transparent PNG ( 190 by 35 pixels). The logo can be changed at any time from the Appearance > Customize area in your dashboard.', 'napoli' ); ?> </p>
			<table>
				<tr>
					<td>
						<div id="current-logo">
							<?php $image_url = get_theme_mod('logo_header_image', get_template_directory_uri().'/assets/img/logo_dark.png');
							if($image_url){
								$image = '<img class="site-logo" src="%s" alt="%s" style="width:%s; height:auto" />';
								printf(
									$image,
									esc_url($image_url),
									esc_attr(get_bloginfo('name')),
									'200px'
								);
							} ?>
						</div>
					</td>
					<td>
						<a href="#" class="button button-upload"><?php esc_html_e( 'Upload New Logo', 'napoli' ); ?></a>
					</td>
				</tr>
			</table>


			<p><?php esc_html_e('Please choose the color scheme for this website. The color scheme (along with font colors &amp; styles) can be changed at any time from the Appearance > Customize area in your dashboard.' ,'napoli' ); ?></p>

			<div class="theme-presets">
				<ul>
					<?php
					$current_demo = get_theme_mod('theme_style','pink');
					$demo_styles = apply_filters('beautiful_default_styles',array());
					foreach($demo_styles as $demo_name => $demo_style){
						?>
						<li<?php echo esc_attr( $demo_name==$current_demo ? ' class="current" ' : ''); ?>>
							<a href="#" data-style="<?php echo esc_attr($demo_name);?>"><img src="<?php echo esc_url($demo_style['image']);?>"></a>
						</li>
					<?php } ?>
				</ul>
			</div>

			<input type="hidden" name="new_logo_id" id="new_logo_id" value="">
			<input type="hidden" name="new_style" id="new_style" value="">

			<p class="envato-setup-actions step">
				<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'napoli' ); ?>" name="save_step" />
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'napoli' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
			</p>
		</form>
		<?php
	}

	/**
	 * Save logo & design options
	 */
	public function envato_setup_logo_design_save() {
		check_admin_referer( 'envato-setup' );


		$new_logo_id = (int)$_POST['new_logo_id'];
		// save this new logo url into the database and calculate the desired height based off the logo width.
		// copied from dtbaker.theme_options.php
		if($new_logo_id) {
			$attr = wp_get_attachment_image_src( $new_logo_id, 'full' );
			if ( $attr && !empty( $attr[1] ) && !empty( $attr[2] ) ) {
				set_theme_mod('logo_header_image',$attr[0]);
				// we have a width and height for this image. awesome.
				$logo_width = (int) get_theme_mod( 'logo_header_image_width', '467' );
				$scale = $logo_width / $attr[1];
				$logo_height = $attr[2] * $scale;
				if ( $logo_height > 0 ) {
					set_theme_mod( 'logo_header_image_height', $logo_height );
				}
			}
		}

		$new_style = $_POST['new_style'];
		$demo_styles = apply_filters('beautiful_default_styles',array());
		if(isset($demo_styles[$new_style])){
			set_theme_mod('theme_style',$new_style);
		}

		wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
		exit;
	}

	/**
	 * Payments Step save
	 */
	public function envato_setup_updates_save() {
		check_admin_referer( 'envato-setup' );

		// redirect to our custom login URL to get a copy of this token.
		$url = $this->get_oauth_login_url($this->get_step_link('updates'));

		wp_redirect( esc_url_raw( $url ) );
		exit;
	}


	public function envato_setup_customize(){
		?>

		<h1><?php esc_html_e( 'Theme Customization', 'napoli' ); ?></h1>
		<p>
			<?php esc_html_e( 'To change the Sidebars go to Appearance > Widgets. You can "drag & drop" the widgets into your sidebar. To control which "widget areas" appear, go to an individual page and look for the "Left/Right Column" menu. Here widgets can be chosen for display on the left or right of a page. More details in documentation.', 'napoli' ); ?>
		</p>
		<p>
			<em>
			<?php echo sprintf(esc_html__( 'Advanced Users: If you are going to make changes to the theme source code please use a %s rather than modifying the main theme HTML/CSS/PHP code.', 'napoli' ), '<a href="https://codex.wordpress.org/Child_Themes" target="_blank">Child Theme</a>'); ?>
			<?php echo sprintf(esc_html__( 'This allows the parent theme to receive updates without overwriting your source code changes.%s See %s in the main folder for a sample.', 'napoli' ), '<br/>', '<code>child-theme.zip</code>'); ?>
			</em>
		</p>

		<p class="envato-setup-actions step">
			<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-primary button-large button-next"><?php esc_html_e( 'Continue', 'napoli' ); ?></a>
		</p>

		<?php
	}

	/**
	 * Final step
	 */
	public function envato_setup_ready() {
		?>
	
		<h1><?php esc_html_e( 'Your Website is Ready!', 'napoli' ); ?></h1>

		<p><?php esc_html_e( 'In the future, if you would like to modify your theme, simply login to your WordPress dashboard, and away you go!', 'napoli' ); ?></p>

		<div class="envato-setup-next-steps">
			<div class="envato-setup-next-steps-first">
				<h2><?php esc_html_e( 'Next Steps', 'napoli' ); ?></h2>
				<ul>
					<li class="setup-product"><a class="button button-primary button-large" target="_blank" href="<?php echo esc_url( home_url('/') ); ?>"><b><?php esc_html_e( 'VIEW YOUR NEW WEBSITE!', 'napoli' ); ?></b></a></li>
				</ul>
			</div>
			<div class="envato-setup-next-steps-last">
				<h2><?php esc_html_e( 'More Resources', 'napoli' ); ?></h2>
				<ul>
					<li class="documentation"><a href="<?php echo esc_url('http://foxthemes.com/help/article-categories/napoli-wordpress-theme-documentation/'); ?>" target="_blank"><?php esc_html_e( 'Read the Theme Documentation', 'napoli' ); ?></a></li>
					<li class="howto"><a href="https://wordpress.org/support/" target="_blank"><?php esc_html_e( 'Learn how to use WordPress', 'napoli' ); ?></a></li>
				</ul>
			</div>
		</div>
		<?php
	}


	}
}
new Napoli_Setup();

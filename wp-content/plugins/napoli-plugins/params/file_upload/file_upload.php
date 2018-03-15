<?php
/**
 * Napoli File Params
 *
 * @version 1.0
 * @since   1.0.0
 */
 
if ( ! class_exists('Napoli_File_Params')) {
	class Napoli_File_Params {

		function __construct() {
			add_action( 'vc_load_default_params', array( &$this, 'load_custom_param' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'backend__enqueue_scripts' ) );
		}

		/* load js */
		public function load_custom_param() {
			vc_add_shortcode_param( 'napoli_file', array( $this, 'render' ), 
				plugins_url( 'js/file.js', __FILE__ ) );
		}

		public function backend__enqueue_scripts($value='')
		{
			wp_enqueue_style( 'napoli_file_css', 
				plugins_url( 'css/file.css', __FILE__ ) );

			wp_enqueue_script('jquery');
			wp_enqueue_media();
		}

		/* render */
		public function render( $settings, $value ) {
			vc_generate_dependencies_attributes($settings);
			ob_start();
			?>
			<div class="vc_file_param">
			    <input type="text" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $settings['param_name'] ); ?>"  id="<?php echo esc_attr( $settings['param_name'] ); ?>" class="wpb_vc_param_value regular-text 
						<?php echo esc_attr( $settings['param_name'] ); ?> 
						<?php echo esc_attr( $settings['type'] ); ?>">
			    <input type="button" name="upload-btn" class="vc_upload_btn button-secondary" value="<?php esc_html_e('Upload File', 'napoli'); ?>">
			</div> 
			<?php
			return ob_get_clean();
		}

	}

}
new Napoli_File_Params();
<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'EMD_MB_Thickbox_Image_Field' ) )
{
	class EMD_MB_Thickbox_Image_Field extends EMD_MB_Image_Field
	{
		public static $field = Array();
		
		static function set_field($field){
			self::$field = $field;
		}
		static function add_actions(){
			parent::add_actions();
			add_filter('plupload_init',array(__CLASS__, 'emd_plupload_init'));
			add_filter('media_upload_tabs', array(__CLASS__, 'remove_media_library_tab'));
			add_action('post-upload-ui', array(__CLASS__, 'remove_media_notice'));
		}
		static function remove_media_notice(){
			echo '<script type="text/javascript">
				jQuery(document).ready(function($){
					$(".max-upload-size").hide();
				});
				</script>
			';
		}
		static function remove_media_library_tab($tabs) {
            		unset($tabs['gallery']);
            		unset($tabs['type_url']);
			return $tabs;
		}
		static function emd_plupload_init($plupload_init){
			if(!empty(self::$field['id'])){
				if(!empty(self::$field['max_file_size'])){
					$plupload_init['filters']['max_file_size'] = self::$field['max_file_size'] . 'KB';
				}
				if(!empty(self::$field['mime_type'])){
					$plupload_init['filters']['mime_types'][]= Array('title'=> self::$field['name'],
					'extensions' => self::$field['mime_type']);
				}	
				if(!empty(self::$field['max_file_uploads'])){
					$plupload_init['max_files'] = self::$field['max_file_uploads'];	
				}	
				if($plupload_init['max_files'] == 1){
					$plupload_init['multi_selection'] = false;
				}
				else {
					$plupload_init['multi_selection'] = true;
				}
			}
			return $plupload_init;
		}
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			parent::admin_enqueue_scripts();

			add_thickbox();
			wp_enqueue_script( 'media-upload' );

			wp_enqueue_script( 'emd-mb-thickbox-image', EMD_MB_JS_URL . 'thickbox-image.js', array( 'jquery' ), EMD_MB_VER, true );
		}

		/**
		 * Get field HTML
		 *
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$i18n_title = apply_filters( 'emd_mb_thickbox_image_upload_string', _x( 'Upload Images', 'image upload', 'emd-plugins' ), $field );

			// Uploaded images
			$html = self::get_uploaded_images( $meta, $field );

			// Show form upload
			if(!empty($field['max_file_uploads']) && $field['max_file_uploads'] == 1 && count($meta) > 0){
				$html .= "<a href='#' style='display:none;' class='button emd-mb-thickbox-upload' data-field_id='{$field['id']}'>{$i18n_title}</a>";

			}
			else {
				$html .= "<a href='#' class='button emd-mb-thickbox-upload' data-field_id='{$field['id']}'>{$i18n_title}</a>";
			}
			$file_settings = "";
			if(!empty($field['max_file_uploads'])){
				$file_settings .= sprintf(__('Max number of files: %s','emd-plugins'),$field['max_file_uploads']);           
			}
			if(!empty($field['max_file_size'])){
				$file_settings .= '<br> ' . sprintf(__('Max file size: %s','emd-plugins'),$field['max_file_size']) . ' KB';
			}
			if(!empty($field['mime_type'])){
				$file_settings .= '<br> ' . sprintf(__('File extensions allowed: %s','emd-plugins'),$field['mime_type']);
			}
			$html .= '<div class="small text-muted" style="margin:0.75rem 0 0.50rem;">' . $file_settings . '</div>';
			return $html;
		}

		/**
		 * Get field value
		 * It's the combination of new (uploaded) images and saved images
		 *
		 * @param array $new
		 * @param array $old
		 * @param int   $post_id
		 * @param array $field
		 *
		 * @return array|mixed
		 */
		static function value( $new, $old, $post_id, $field )
		{
			return array_unique( array_merge( $old, $new ) );
		}
	}
}

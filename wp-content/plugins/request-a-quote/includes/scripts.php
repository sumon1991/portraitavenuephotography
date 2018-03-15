<?php
/**
 * Enqueue Scripts Functions
 *
 * @package REQUEST_A_QUOTE
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
add_action('admin_enqueue_scripts', 'request_a_quote_load_admin_enq');
/**
 * Enqueue style and js for each admin entity pages and settings
 *
 * @since WPAS 4.0
 * @param string $hook
 *
 */
function request_a_quote_load_admin_enq($hook) {
	global $typenow;
	$dir_url = REQUEST_A_QUOTE_PLUGIN_URL;
	do_action('emd_ext_admin_enq', 'request_a_quote', $hook);
	$min_trigger = get_option('request_a_quote_show_rateme_plugin_min', 0);
	$tracking_optin = get_option('request_a_quote_tracking_optin', 0);
	if (-1 !== intval($tracking_optin) || - 1 !== intval($min_trigger)) {
		wp_enqueue_style('emd-plugin-rateme-css', $dir_url . 'assets/css/emd-plugin-rateme.css');
		wp_enqueue_script('emd-plugin-rateme-js', $dir_url . 'assets/js/emd-plugin-rateme.js');
	}
	if ($hook == 'edit-tags.php') {
		return;
	}
	if (isset($_GET['page']) && $_GET['page'] == 'request_a_quote_settings') {
		wp_enqueue_script('accordion');
		wp_enqueue_style('codemirror-css', $dir_url . 'assets/ext/codemirror/codemirror.min.css');
		wp_enqueue_script('codemirror-js', $dir_url . 'assets/ext/codemirror/codemirror.min.js', array() , '', true);
		wp_enqueue_script('codemirror-css-js', $dir_url . 'assets/ext/codemirror/css.min.js', array() , '', true);
		wp_enqueue_script('codemirror-jvs-js', $dir_url . 'assets/ext/codemirror/javascript.min.js', array() , '', true);
		return;
	} else if (isset($_GET['page']) && in_array($_GET['page'], Array(
		'request_a_quote_notify',
		'request_a_quote_glossary'
	))) {
		wp_enqueue_script('accordion');
		return;
	} else if (isset($_GET['page']) && $_GET['page'] == 'request_a_quote') {
		wp_enqueue_style('lazyYT-css', $dir_url . 'assets/ext/lazyyt/lazyYT.min.css');
		wp_enqueue_script('lazyYT-js', $dir_url . 'assets/ext/lazyyt/lazyYT.min.js');
		wp_enqueue_script('getting-started-js', $dir_url . 'assets/js/getting-started.js');
		return;
	} else if (isset($_GET['page']) && in_array($_GET['page'], Array(
		'request_a_quote_store',
		'request_a_quote_support'
	))) {
		wp_enqueue_style('admin-tabs', $dir_url . 'assets/css/admin-store.css');
		return;
	} else if (isset($_GET['page']) && $_GET['page'] == 'request_a_quote_licenses') {
		wp_enqueue_style('admin-css', $dir_url . 'assets/css/emd-admin.min.css');
		return;
	}
	if (in_array($typenow, Array(
		'emd_quote'
	))) {
		$theme_changer_enq = 1;
		$sing_enq = 0;
		$tab_enq = 0;
		if ($hook == 'post.php' || $hook == 'post-new.php') {
			$unique_vars['msg'] = __('Please enter a unique value.', 'request-a-quote');
			$unique_vars['reqtxt'] = __('required', 'request-a-quote');
			$unique_vars['app_name'] = 'request_a_quote';
			$ent_list = get_option('request_a_quote_ent_list');
			if (!empty($ent_list[$typenow])) {
				$unique_vars['keys'] = $ent_list[$typenow]['unique_keys'];
				if (!empty($ent_list[$typenow]['req_blt'])) {
					$unique_vars['req_blt_tax'] = $ent_list[$typenow]['req_blt'];
				}
			}
			$tax_list = get_option('request_a_quote_tax_list');
			if (!empty($tax_list[$typenow])) {
				foreach ($tax_list[$typenow] as $txn_name => $txn_val) {
					if ($txn_val['required'] == 1) {
						$unique_vars['req_blt_tax'][$txn_name] = Array(
							'hier' => $txn_val['hier'],
							'type' => $txn_val['type'],
							'label' => $txn_val['label'] . ' ' . __('Taxonomy', 'request-a-quote')
						);
					}
				}
			}
			wp_enqueue_script('unique_validate-js', $dir_url . 'assets/js/unique_validate.js', array(
				'jquery',
				'jquery-validate'
			) , REQUEST_A_QUOTE_VERSION, true);
			wp_localize_script("unique_validate-js", 'unique_vars', $unique_vars);
		} elseif ($hook == 'edit.php') {
			wp_enqueue_style('request-a-quote-allview-css', REQUEST_A_QUOTE_PLUGIN_URL . '/assets/css/allview.css');
		}
		switch ($typenow) {
			case 'emd_quote':
			break;
		}
	}
}
add_action('wp_enqueue_scripts', 'request_a_quote_frontend_scripts');
/**
 * Enqueue style and js for each frontend entity pages and components
 *
 * @since WPAS 4.0
 *
 */
function request_a_quote_frontend_scripts() {
	$dir_url = REQUEST_A_QUOTE_PLUGIN_URL;
	wp_register_style('emd-pagination', $dir_url . 'assets/css/emd-pagination.min.css');
	wp_register_style('request-a-quote-allview-css', $dir_url . '/assets/css/allview.css');
	$grid_vars = Array();
	$local_vars['ajax_url'] = admin_url('admin-ajax.php');
	$local_vars['validate_msg']['required'] = __('This field is required.', 'emd-plugins');
	$local_vars['validate_msg']['remote'] = __('Please fix this field.', 'emd-plugins');
	$local_vars['validate_msg']['email'] = __('Please enter a valid email address.', 'emd-plugins');
	$local_vars['validate_msg']['url'] = __('Please enter a valid URL.', 'emd-plugins');
	$local_vars['validate_msg']['date'] = __('Please enter a valid date.', 'emd-plugins');
	$local_vars['validate_msg']['dateISO'] = __('Please enter a valid date ( ISO )', 'emd-plugins');
	$local_vars['validate_msg']['number'] = __('Please enter a valid number.', 'emd-plugins');
	$local_vars['validate_msg']['digits'] = __('Please enter only digits.', 'emd-plugins');
	$local_vars['validate_msg']['creditcard'] = __('Please enter a valid credit card number.', 'emd-plugins');
	$local_vars['validate_msg']['equalTo'] = __('Please enter the same value again.', 'emd-plugins');
	$local_vars['validate_msg']['maxlength'] = __('Please enter no more than {0} characters.', 'emd-plugins');
	$local_vars['validate_msg']['minlength'] = __('Please enter at least {0} characters.', 'emd-plugins');
	$local_vars['validate_msg']['rangelength'] = __('Please enter a value between {0} and {1} characters long.', 'emd-plugins');
	$local_vars['validate_msg']['range'] = __('Please enter a value between {0} and {1}.', 'emd-plugins');
	$local_vars['validate_msg']['max'] = __('Please enter a value less than or equal to {0}.', 'emd-plugins');
	$local_vars['validate_msg']['min'] = __('Please enter a value greater than or equal to {0}.', 'emd-plugins');
	$local_vars['unique_msg'] = __('Please enter a unique value.', 'emd-plugins');
	$wpas_shc_list = get_option('request_a_quote_shc_list');
	$attr_list = get_option('request_a_quote_attr_list');
	$tax_list = get_option('request_a_quote_tax_list');
	if (!empty($attr_list['emd_quote'])) {
		foreach ($attr_list['emd_quote'] as $attr => $attr_val) {
			if (!empty($attr_val['conditional'])) {
				$local_vars['conditional_rules'][$attr] = $attr_val['conditional'];
				$local_vars['conditional_rules'][$attr]['type'] = $attr_val['display_type'];
			}
		}
	}
	if (!empty($tax_list['emd_quote'])) {
		foreach ($tax_list['emd_quote'] as $tax => $tax_val) {
			if (!empty($tax_val['conditional'])) {
				$local_vars['conditional_rules'][$tax] = $tax_val['conditional'];
				$local_vars['conditional_rules'][$tax]['type'] = $tax_val['cond_type'];
			}
		}
	}
	$local_vars['emd_contact_attachment']['theme'] = 'Bootstrap';
	$local_vars['emd_contact_attachment']['btnText'] = __('Attachments', 'request-a-quote');
	$local_vars['emd_contact_attachment']['url'] = admin_url('admin-ajax.php');
	$local_vars['emd_contact_attachment']['path'] = 'REQUEST_A_QUOTE_PLUGIN_DIR';
	$local_vars['emd_contact_attachment']['nonce'] = wp_create_nonce('emd_load_file');
	$local_vars['emd_contact_attachment']['del_nonce'] = wp_create_nonce('emd_delete_file');
	$local_vars['emd_contact_attachment']['errorMsg'] = __('ERROR:', 'request-a-quote');
	$local_vars['emd_contact_attachment']['invalidExtError'] = __('Invalid file type.', 'request-a-quote');
	$local_vars['emd_contact_attachment']['sizeError'] = __('File size is greater than allowed limit.', 'request-a-quote');
	$local_vars['emd_contact_attachment']['maxUploadError'] = __('Maximum number of allowable file uploads has been exceeded.', 'request-a-quote');
	$ent_map_list = get_option('request_a_quote_ent_map_list', Array());
	if (!empty($ent_map_list['emd_quote']['max_files']['emd_contact_attachment'])) {
		$local_vars['emd_contact_attachment']['maxFileCount'] = $ent_map_list['emd_quote']['max_files']['emd_contact_attachment'];
	}
	if (!empty($ent_map_list['emd_quote']['max_file_size']['emd_contact_attachment'])) {
		$local_vars['emd_contact_attachment']['maxSize'] = $ent_map_list['emd_quote']['max_file_size']['emd_contact_attachment'];
	} else {
		$server_size = ini_get('upload_max_filesize');
		if (preg_match('/M$/', $server_size)) {
			$server_size = preg_replace('/M$/', '', $server_size);
			$server_size = $server_size * 1000;
		}
		$local_vars['emd_contact_attachment']['maxSize'] = $server_size;
	}
	if (!empty($ent_map_list['emd_quote']['file_exts']['emd_contact_attachment'])) {
		$local_vars['emd_contact_attachment']['allowedExtensions'] = $ent_map_list['emd_quote']['file_exts']['emd_contact_attachment'];
	}
	$local_vars['request_a_quote'] = emd_get_form_req_hide_vars('request_a_quote', 'request_a_quote');
	wp_register_style('request-a-quote-forms', $dir_url . 'assets/css/request-a-quote-forms.css');
	wp_register_script('request-a-quote-forms-js', $dir_url . 'assets/js/request-a-quote-forms.js');
	wp_localize_script('request-a-quote-forms-js', 'request_a_quote_vars', $local_vars);
	wp_register_script('cond-js', $dir_url . 'assets/js/cond-forms.js');
	wp_register_style('wpas-boot', $dir_url . 'assets/ext/wpas/wpas-bootstrap.min.css');
	wp_register_script('wpas-boot-js', $dir_url . 'assets/ext/wpas/wpas-bootstrap.min.js', array(
		'jquery'
	));
	wp_register_script('wpas-jvalidate-js', $dir_url . 'assets/ext/jvalidate1160/wpas.validate.min.js', array(
		'jquery'
	));
	wp_register_style('wpas-select2', $dir_url . 'assets/ext/bselect24/select2.min.css');
	wp_register_script('wpas-select2-js', $dir_url . 'assets/ext/bselect24/select2.full.min.js');
	wp_register_style("request-a-quote-default-single-css", REQUEST_A_QUOTE_PLUGIN_URL . 'assets/css/request-a-quote-default-single.css');
	wp_register_script('wpas-filepicker-js', $dir_url . 'assets/ext/filepicker/filepicker.min.js');
	wp_register_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_register_style('wpas-bootsel', $dir_url . 'assets/ext/bootstrap-select/bootstrap-select.min.css');
	wp_register_script('wpas-bootsel-js', $dir_url . 'assets/ext/bootstrap-select/bootstrap-select.min.js');
	wp_register_script('emd-std-paging-js', $dir_url . 'assets/js/emd-std-paging.js');
	if (is_single() && get_post_type() == 'emd_quote') {
		wp_enqueue_style("request-a-quote-default-single-css");
		request_a_quote_enq_custom_css_js();
	}
}
function request_a_quote_enq_bootstrap($type = '') {
	$misc_settings = get_option('request_a_quote_misc_settings');
	if ($type == 'css' || $type == '') {
		if (empty($misc_settings) || (isset($misc_settings['disable_bs_css']) && $misc_settings['disable_bs_css'] == 0)) {
			wp_enqueue_style('wpas-boot');
		}
	}
	if ($type == 'js' || $type == '') {
		if (empty($misc_settings) || (isset($misc_settings['disable_bs_js']) && $misc_settings['disable_bs_js'] == 0)) {
			wp_enqueue_script('wpas-boot-js');
		}
	}
}
/**
 * Enqueue custom css if set in settings tool tab
 *
 * @since WPAS 5.3
 *
 */
function request_a_quote_enq_custom_css_js() {
	$tools = get_option('request_a_quote_tools');
	if (!empty($tools['custom_css'])) {
		$url = home_url();
		if (is_ssl()) {
			$url = home_url('/', 'https');
		}
		wp_enqueue_style('request-a-quote-custom', add_query_arg(array(
			'request-a-quote-css' => 1
		) , $url));
	}
	if (!empty($tools['custom_js'])) {
		$url = home_url();
		if (is_ssl()) {
			$url = home_url('/', 'https');
		}
		wp_enqueue_script('request-a-quote-custom', add_query_arg(array(
			'request-a-quote-js' => 1
		) , $url));
	}
}
/**
 * If app custom css query var is set, print custom css
 */
function request_a_quote_print_css() {
	// Only print CSS if this is a stylesheet request
	if (!isset($_GET['request-a-quote-css']) || intval($_GET['request-a-quote-css']) !== 1) {
		return;
	}
	ob_start();
	header('Content-type: text/css');
	$tools = get_option('request_a_quote_tools');
	$raw_content = isset($tools['custom_css']) ? $tools['custom_css'] : '';
	$content = wp_kses($raw_content, array(
		'\'',
		'\"'
	));
	$content = str_replace('&gt;', '>', $content);
	echo $content; //xss okay
	die();
}
function request_a_quote_print_js() {
	// Only print CSS if this is a stylesheet request
	if (!isset($_GET['request-a-quote-js']) || intval($_GET['request-a-quote-js']) !== 1) {
		return;
	}
	ob_start();
	header('Content-type: text/javascript');
	$tools = get_option('request_a_quote_tools');
	$raw_content = isset($tools['custom_js']) ? $tools['custom_js'] : '';
	$content = wp_kses($raw_content, array(
		'\'',
		'\"'
	));
	$content = str_replace('&gt;', '>', $content);
	echo $content;
	die();
}
function request_a_quote_print_css_js() {
	request_a_quote_print_js();
	request_a_quote_print_css();
}
add_action('plugins_loaded', 'request_a_quote_print_css_js');
/**
 * Enqueue if allview css is not enqueued
 *
 * @since WPAS 4.5
 *
 */
function request_a_quote_enq_allview() {
	if (!wp_style_is('request-a-quote-allview-css', 'enqueued')) {
		wp_enqueue_style('request-a-quote-allview-css');
	}
}

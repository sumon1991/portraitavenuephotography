<?php
/**
 * Setup and Process submit and search forms
 * @package REQUEST_A_QUOTE
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
if (is_admin()) {
	add_action('wp_ajax_nopriv_emd_check_unique', 'emd_check_unique');
}
add_action('init', 'request_a_quote_form_shortcodes', -2);
/**
 * Start session and setup upload idr and current user id
 * @since WPAS 4.0
 *
 */
function request_a_quote_form_shortcodes() {
	global $file_upload_dir;
	$upload_dir = wp_upload_dir();
	$file_upload_dir = $upload_dir['basedir'];
	if (!empty($_POST['emd_action'])) {
		if ($_POST['emd_action'] == 'request_a_quote_user_login' && wp_verify_nonce($_POST['emd_login_nonce'], 'emd-login-nonce')) {
			emd_process_login($_POST, 'request_a_quote');
		} elseif ($_POST['emd_action'] == 'request_a_quote_user_register' && wp_verify_nonce($_POST['emd_register_nonce'], 'emd-register-nonce')) {
			emd_process_register($_POST, 'request_a_quote');
		}
	}
}
add_shortcode('request_a_quote', 'request_a_quote_process_request_a_quote');
/**
 * Set each form field(attr,tax and rels) and render form
 *
 * @since WPAS 4.0
 *
 * @return object $form
 */
function request_a_quote_set_request_a_quote($atts) {
	global $file_upload_dir;
	$show_captcha = 0;
	$form_variables = get_option('request_a_quote_glob_forms_list');
	$form_init_variables = get_option('request_a_quote_glob_forms_init_list');
	$current_user = wp_get_current_user();
	if (!empty($atts['set'])) {
		$set_arrs = emd_parse_set_filter($atts['set']);
	}
	if (!empty($form_variables['request_a_quote']['captcha'])) {
		switch ($form_variables['request_a_quote']['captcha']) {
			case 'never-show':
				$show_captcha = 0;
			break;
			case 'show-always':
				$show_captcha = 1;
			break;
			case 'show-to-visitors':
				if (is_user_logged_in()) {
					$show_captcha = 0;
				} else {
					$show_captcha = 1;
				}
			break;
		}
	}
	$req_hide_vars = emd_get_form_req_hide_vars('request_a_quote', 'request_a_quote');
	$fname_id = 'request_a_quote';
	if (!empty($atts['id'])) {
		$fname_id = 'request_a_quote_' . $atts['id'];
	}
	$form = new Zebra_Form($fname_id, 0, 'POST', '', array(
		'class' => 'request_a_quote form-container',
		'session_obj' => REQUEST_A_QUOTE()->session
	));
	$csrf_storage_method = (isset($form_variables['request_a_quote']['csrf']) ? $form_variables['request_a_quote']['csrf'] : $form_init_variables['request_a_quote']['csrf']);
	if ($csrf_storage_method == 0) {
		$form->form_properties['csrf_storage_method'] = false;
	}
	if (!in_array('raq_services', $req_hide_vars['hide'])) {
		$form->add('label', 'label_raq_services', 'raq_services', __('Service', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'multiple' => 'multiple',
			'class' => 'input-md'
		);
		if (!empty($_GET['raq_services'])) {
			$attrs['value'] = sanitize_text_field($_GET['raq_services']);
		} elseif (!empty($set_arrs['tax']['raq_services'])) {
			$attrs['value'] = $set_arrs['tax']['raq_services'];
		}
		$obj = $form->add('selectadv', 'raq_services[]', __('Please Select', 'request-a-quote') , $attrs, '', '{"allowClear":true,"placeholder":"' . __("Please Select", "request-a-quote") . '","placeholderOption":"first"}');
		//get taxonomy values
		$txn_arr = Array();
		$txn_obj = get_terms('raq_services', array(
			'hide_empty' => 0
		));
		foreach ($txn_obj as $txn) {
			$txn_arr[$txn->slug] = $txn->name;
		}
		$obj->add_options($txn_arr);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('raq_services', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Service is required!', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_first_name', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_first_name', 'emd_contact_first_name', __('First Name', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('First Name', 'request-a-quote')
		);
		if (!empty($_GET['emd_contact_first_name'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_first_name']);
		} elseif (!empty($set_arrs['attr']['emd_contact_first_name'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_first_name'];
		}
		$obj = $form->add('text', 'emd_contact_first_name', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_first_name', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('First Name is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_last_name', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_last_name', 'emd_contact_last_name', __('Last Name', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Last Name', 'request-a-quote')
		);
		if (!empty($_GET['emd_contact_last_name'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_last_name']);
		} elseif (!empty($set_arrs['attr']['emd_contact_last_name'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_last_name'];
		}
		$obj = $form->add('text', 'emd_contact_last_name', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_last_name', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Last Name is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_address', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_address', 'emd_contact_address', __('Address', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Address', 'request-a-quote')
		);
		if (!empty($_GET['emd_contact_address'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_address']);
		} elseif (!empty($set_arrs['attr']['emd_contact_address'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_address'];
		}
		$obj = $form->add('text', 'emd_contact_address', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_address', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Address is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_city', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_city', 'emd_contact_city', __('City', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('City', 'request-a-quote')
		);
		if (!empty($_GET['emd_contact_city'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_city']);
		} elseif (!empty($set_arrs['attr']['emd_contact_city'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_city'];
		}
		$obj = $form->add('text', 'emd_contact_city', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_city', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('City is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_state', $req_hide_vars['hide'])) {
		//select
		$form->add('label', 'label_emd_contact_state', 'emd_contact_state', __('State', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'selectpicker',
			'data-style' => 'btn-default btn-md'
		);
		if (!empty($_GET['emd_contact_state'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_state']);
		} elseif (!empty($set_arrs['attr']['emd_contact_state'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_state'];
		}
		$obj = $form->add('select', 'emd_contact_state', '', $attrs, '', '{"allowClear":true,"placeholder":" ' . __('Please Select', 'request-a-quote') . ' ","placeholderOption":"first"}');
		$obj->add_options(array(
			'' => __('Please Select', 'request-a-quote') ,
			'ak' => esc_attr(__('AK', 'request-a-quote')) ,
			'al' => esc_attr(__('AL', 'request-a-quote')) ,
			'ar' => esc_attr(__('AR', 'request-a-quote')) ,
			'az' => esc_attr(__('AZ', 'request-a-quote')) ,
			'ca' => esc_attr(__('CA', 'request-a-quote')) ,
			'co' => esc_attr(__('CO', 'request-a-quote')) ,
			'ct' => esc_attr(__('CT', 'request-a-quote')) ,
			'dc' => esc_attr(__('DC', 'request-a-quote')) ,
			'de' => esc_attr(__('DE', 'request-a-quote')) ,
			'fl' => esc_attr(__('FL', 'request-a-quote')) ,
			'ga' => esc_attr(__('GA', 'request-a-quote')) ,
			'hi' => esc_attr(__('HI', 'request-a-quote')) ,
			'ia' => esc_attr(__('IA', 'request-a-quote')) ,
			'id' => esc_attr(__('ID', 'request-a-quote')) ,
			'il' => esc_attr(__('IL', 'request-a-quote')) ,
			'in' => esc_attr(__('IN', 'request-a-quote')) ,
			'ks' => esc_attr(__('KS', 'request-a-quote')) ,
			'ky' => esc_attr(__('KY', 'request-a-quote')) ,
			'la' => esc_attr(__('LA', 'request-a-quote')) ,
			'ma' => esc_attr(__('MA', 'request-a-quote')) ,
			'md' => esc_attr(__('MD', 'request-a-quote')) ,
			'me' => esc_attr(__('ME', 'request-a-quote')) ,
			'mi' => esc_attr(__('MI', 'request-a-quote')) ,
			'mn' => esc_attr(__('MN', 'request-a-quote')) ,
			'mo' => esc_attr(__('MO', 'request-a-quote')) ,
			'ms' => esc_attr(__('MS', 'request-a-quote')) ,
			'mt' => esc_attr(__('MT', 'request-a-quote')) ,
			'nc' => esc_attr(__('NC', 'request-a-quote')) ,
			'nd' => esc_attr(__('ND', 'request-a-quote')) ,
			'ne' => esc_attr(__('NE', 'request-a-quote')) ,
			'nh' => esc_attr(__('NH', 'request-a-quote')) ,
			'nj' => esc_attr(__('NJ', 'request-a-quote')) ,
			'nm' => esc_attr(__('NM', 'request-a-quote')) ,
			'nv' => esc_attr(__('NV', 'request-a-quote')) ,
			'ny' => esc_attr(__('NY', 'request-a-quote')) ,
			'oh' => esc_attr(__('OH', 'request-a-quote')) ,
			'ok' => esc_attr(__('OK', 'request-a-quote')) ,
			'or' => esc_attr(__('OR', 'request-a-quote')) ,
			'pa' => esc_attr(__('PA', 'request-a-quote')) ,
			'ri' => esc_attr(__('RI', 'request-a-quote')) ,
			'sc' => esc_attr(__('SC', 'request-a-quote')) ,
			'sd' => esc_attr(__('SD', 'request-a-quote')) ,
			'tn' => esc_attr(__('TN', 'request-a-quote')) ,
			'tx' => esc_attr(__('TX', 'request-a-quote')) ,
			'ut' => esc_attr(__('UT', 'request-a-quote')) ,
			'va' => esc_attr(__('VA', 'request-a-quote')) ,
			'vt' => esc_attr(__('VT', 'request-a-quote')) ,
			'wa' => esc_attr(__('WA', 'request-a-quote')) ,
			'wi' => esc_attr(__('WI', 'request-a-quote')) ,
			'wv' => esc_attr(__('WV', 'request-a-quote')) ,
			'wy' => esc_attr(__('WY', 'request-a-quote'))
		) , true);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_state', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('State is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_zip', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_zip', 'emd_contact_zip', __('Zipcode', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Zipcode', 'request-a-quote')
		);
		if (!empty($_GET['emd_contact_zip'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_zip']);
		} elseif (!empty($set_arrs['attr']['emd_contact_zip'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_zip'];
		}
		$obj = $form->add('text', 'emd_contact_zip', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_zip', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Zipcode is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_pref', $req_hide_vars['hide'])) {
		//radios
		$form->add('label', 'label_emd_contact_pref', 'emd_contact_pref', __('Contact Preference', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('radios', 'emd_contact_pref', array(
			'email' => esc_attr(__('Email', 'request-a-quote')) ,
			'telephone' => esc_attr(__('Telephone', 'request-a-quote'))
		) , array(
			'Email'
		) , array(
			'class' => 'input_emd_contact_pref'
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_pref', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Contact Preference is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_email', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_email', 'emd_contact_email', __('Email', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Email', 'request-a-quote')
		);
		if (!empty($current_user) && !empty($current_user->user_email)) {
			$attrs['value'] = (string)$current_user->user_email;
		}
		if (!empty($_GET['emd_contact_email'])) {
			$attrs['value'] = sanitize_email($_GET['emd_contact_email']);
		} elseif (!empty($set_arrs['attr']['emd_contact_email'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_email'];
		}
		$obj = $form->add('text', 'emd_contact_email', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
			'email' => array(
				'error',
				__('Email: Please enter a valid email address', 'request-a-quote')
			) ,
		);
		if (in_array('emd_contact_email', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Email is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_phone', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_phone', 'emd_contact_phone', __('Phone', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Phone', 'request-a-quote')
		);
		if (!empty($_GET['emd_contact_phone'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_phone']);
		} elseif (!empty($set_arrs['attr']['emd_contact_phone'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_phone'];
		}
		$obj = $form->add('text', 'emd_contact_phone', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_phone', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Phone is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_callback_time', $req_hide_vars['hide'])) {
		//select
		$form->add('label', 'label_emd_contact_callback_time', 'emd_contact_callback_time', __('Callback Time', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'selectpicker',
			'data-style' => 'btn-default btn-md'
		);
		if (!empty($_GET['emd_contact_callback_time'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_callback_time']);
		} elseif (!empty($set_arrs['attr']['emd_contact_callback_time'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_callback_time'];
		}
		$obj = $form->add('select', 'emd_contact_callback_time', '', $attrs, '', '{"allowClear":true,"placeholder":" ' . __('Please Select', 'request-a-quote') . ' ","placeholderOption":"first"}');
		$obj->add_options(array(
			'' => __('Please Select', 'request-a-quote') ,
			'em' => esc_attr(__('5 to 8am', 'request-a-quote')) ,
			'lm' => esc_attr(__('11am to 12pm', 'request-a-quote')) ,
			'ea' => esc_attr(__('1 to 3pm', 'request-a-quote')) ,
			'la' => esc_attr(__('4 to 5pm', 'request-a-quote')) ,
			'ee' => esc_attr(__('5 to 7 pm', 'request-a-quote')) ,
			'le' => esc_attr(__('9pm to 4am', 'request-a-quote'))
		) , true);
		$zrule = Array(
			'dependencies' => array(
				'emd_contact_pref' => 'Telephone',
			) ,
		);
		if (in_array('emd_contact_callback_time', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Callback Time is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_budget', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_budget', 'emd_contact_budget', __('Budget', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$attrs = array(
			'class' => 'input-md form-control',
			'placeholder' => __('Budget', 'request-a-quote')
		);
		if (!empty($_GET['emd_contact_budget'])) {
			$attrs['value'] = sanitize_text_field($_GET['emd_contact_budget']);
		} elseif (!empty($set_arrs['attr']['emd_contact_budget'])) {
			$attrs['value'] = $set_arrs['attr']['emd_contact_budget'];
		}
		$obj = $form->add('text', 'emd_contact_budget', '', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
			'number' => array(
				'.',
				'error',
				__('Budget: Please enter a valid number', 'request-a-quote')
			) ,
		);
		if (in_array('emd_contact_budget', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Budget is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_extrainfo', $req_hide_vars['hide'])) {
		//textarea
		$form->add('label', 'label_emd_contact_extrainfo', 'emd_contact_extrainfo', __('Additional details', 'request-a-quote') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('textarea', 'emd_contact_extrainfo', '', array(
			'class' => 'input-md form-control',
			'placeholder' => __('Additional details', 'request-a-quote')
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_extrainfo', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Additional details is required', 'request-a-quote')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_attachment', $req_hide_vars['hide'])) {
		//file
		$attrs = Array();
		$obj = $form->add('file', 'emd_contact_attachment', $attrs);
		$zrule = Array(
			'dependencies' => array() ,
			'upload' => array(
				$file_upload_dir,
				true,
				'error',
				'File could not be uploaded.'
			) ,
		);
		$obj->set_rule($zrule);
	}
	//hidden_func
	$emd_contact_id = emd_get_hidden_func('unique_id');
	$form->add('hidden', 'emd_contact_id', $emd_contact_id);
	//hidden
	$obj = $form->add('hidden', 'wpas_form_name', 'request_a_quote');
	//hidden_func
	$wpas_form_submitted_by = emd_get_hidden_func('user_login');
	$form->add('hidden', 'wpas_form_submitted_by', $wpas_form_submitted_by);
	//hidden_func
	$wpas_form_submitted_ip = emd_get_hidden_func('user_ip');
	$form->add('hidden', 'wpas_form_submitted_ip', $wpas_form_submitted_ip);
	$ext_inputs = Array();
	$ext_inputs = apply_filters('emd_ext_form_inputs', $ext_inputs, 'request_a_quote', 'request_a_quote');
	foreach ($ext_inputs as $input_param) {
		$inp_name = $input_param['name'];
		if (!in_array($input_param['name'], $req_hide_vars['hide'])) {
			if ($input_param['type'] == 'hidden') {
				$obj = $form->add('hidden', $input_param['name'], $input_param['vals']);
			} elseif ($input_param['type'] == 'select') {
				$form->add('label', 'label_' . $input_param['name'], $input_param['name'], $input_param['label'], array(
					'class' => 'control-label'
				));
				$ext_class['class'] = 'input-md';
				if (!empty($input_param['multiple'])) {
					$ext_class['multiple'] = 'multiple';
					$input_param['name'] = $input_param['name'] . '[]';
				}
				$obj = $form->add('select', $input_param['name'], '', $ext_class, '', '{"allowClear":true,"placeholder":"' . __("Please Select", "request-a-quote") . '","placeholderOption":"first"}');
				$obj->add_options($input_param['vals']);
				$obj->disable_spam_filter();
			} elseif ($input_param['type'] == 'text') {
				$form->add('label', 'label_' . $input_param['name'], $input_param['name'], $input_param['label'], array(
					'class' => 'control-label'
				));
				$obj = $form->add('text', $input_param['name'], '', array(
					'class' => 'input-md form-control',
					'placeholder' => $input_param['label']
				));
			} elseif ($input_param['type'] == 'checkbox') {
				$form->add('label', 'label_' . $input_param['name'] . '_1', $input_param['name'] . '_1', $input_param['label'], array(
					'class' => 'control-label'
				));
				$obj = $form->add('checkbox', $input_param['name'], 1, $input_param['default']);
				$obj->set_attributes(array(
					'class' => 'input_' . $input_param['name'] . ' control checkbox',
				));
			}
			if ($input_param['type'] != 'hidden' && in_array($inp_name, $req_hide_vars['req'])) {
				$zrule = Array(
					'dependencies' => $input_param['dependencies'],
					'required' => array(
						'error',
						$input_param['label'] . __(' is required', 'request-a-quote')
					)
				);
				$obj->set_rule($zrule);
			}
		}
	}
	$form->assign('show_captcha', $show_captcha);
	if ($show_captcha == 1) {
		//Captcha
		$form->add('captcha', 'captcha_image', 'captcha_code', '', '<i class="fa fa-refresh"></i>', 'btn btn-xs');
		$form->add('label', 'label_captcha_code', 'captcha_code', __('Please enter the characters with black color.', 'request-a-quote'));
		$obj = $form->add('text', 'captcha_code', '', array(
			'placeholder' => __('Code', 'request-a-quote')
		));
		$obj->set_rule(array(
			'required' => array(
				'error',
				__('Captcha is required', 'request-a-quote')
			) ,
			'captcha' => array(
				'error',
				__('Characters from captcha image entered incorrectly!', 'request-a-quote')
			)
		));
	}
	$form->add('submit', 'singlebutton_request_a_quote', '' . __('Send a request', 'request-a-quote') . ' ', array(
		'class' => 'btn btn-primary btn-lg  col-md-12 col-lg-12 col-xs-12 col-sm-12'
	));
	return $form;
}
/**
 * Process each form and show error or success
 *
 * @since WPAS 4.0
 *
 * @return html
 */
function request_a_quote_process_request_a_quote($atts) {
	$show_form = 1;
	$access_views = get_option('request_a_quote_access_views', Array());
	if (!current_user_can('view_request_a_quote') && !empty($access_views['forms']) && in_array('request_a_quote', $access_views['forms'])) {
		$show_form = 0;
	}
	$form_init_variables = get_option('request_a_quote_glob_forms_init_list');
	$form_variables = get_option('request_a_quote_glob_forms_list');
	if ($show_form == 1) {
		if (!empty($form_init_variables['request_a_quote']['login_reg'])) {
			$show_login_register = (isset($form_variables['request_a_quote']['login_reg']) ? $form_variables['request_a_quote']['login_reg'] : $form_init_variables['request_a_quote']['login_reg']);
			if (!is_user_logged_in() && $show_login_register != 'none') {
				do_action('emd_show_login_register_forms', 'request_a_quote', 'request_a_quote', $show_login_register);
				return;
			}
		}
		wp_enqueue_script('wpas-jvalidate-js');
		request_a_quote_enq_bootstrap();
		wp_enqueue_style('font-awesome');
		wp_enqueue_script('wpas-filepicker-js');
		wp_enqueue_style('wpas-bootsel');
		wp_enqueue_script('wpas-bootsel-js');
		wp_enqueue_style('wpas-select2');
		wp_enqueue_script('wpas-select2-js');
		wp_enqueue_script('cond-js');
		wp_enqueue_style('request-a-quote-forms');
		wp_enqueue_script('request-a-quote-forms-js');
		request_a_quote_enq_custom_css_js();
		do_action('emd_ext_form_enq', 'request_a_quote', 'request_a_quote');
		$success_msg = (isset($form_variables['request_a_quote']['success_msg']) ? $form_variables['request_a_quote']['success_msg'] : $form_init_variables['request_a_quote']['success_msg']);
		$error_msg = (isset($form_variables['request_a_quote']['error_msg']) ? $form_variables['request_a_quote']['error_msg'] : $form_init_variables['request_a_quote']['error_msg']);
		return emd_submit_php_form('request_a_quote', 'request_a_quote', 'emd_quote', 'publish', 'publish', $success_msg, $error_msg, 0, 1, $atts);
	} else {
		$noaccess_msg = (isset($form_variables['request_a_quote']['noaccess_msg']) ? $form_variables['request_a_quote']['noaccess_msg'] : $form_init_variables['request_a_quote']['noaccess_msg']);
		return "<div class='alert alert-info not-authorized'>" . $noaccess_msg . "</div>";
	}
}

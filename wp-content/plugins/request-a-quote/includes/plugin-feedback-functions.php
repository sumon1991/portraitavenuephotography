<?php
/**
 * Plugin Page Feedback Functions
 *
 * @package REQUEST_A_QUOTE
 * @since WPAS 5.3
 */
if (!defined('ABSPATH')) exit;
add_filter('plugin_row_meta', 'request_a_quote_plugin_row_meta', 10, 2);
add_filter('plugin_action_links', 'request_a_quote_plugin_action_links', 10, 2);
add_action('wp_ajax_request_a_quote_send_deactivate_reason', 'request_a_quote_send_deactivate_reason');
global $pagenow;
if ('plugins.php' === $pagenow) {
	add_action('admin_footer', 'request_a_quote_deactivation_feedback_box');
}
add_action('wp_ajax_request_a_quote_show_rateme', 'request_a_quote_show_rateme_action');
if (isset($_GET['request_a_quote_optin'])) {
	if (!function_exists('wp_get_current_user')) {
		require_once (ABSPATH . 'wp-includes/pluggable.php');
	}
	if ($_GET['request_a_quote_optin'] == 1) {
		//opt-in
		$data['plugin_name'] = 'request_a_quote';
		$data['plugin_version'] = REQUEST_A_QUOTE_VERSION;
		$data['wp_version'] = get_bloginfo('version');
		$data['php_version'] = phpversion();
		$data['server'] = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '';
		$current_user = wp_get_current_user();
		$data['first_name'] = $current_user->user_firstname;
		$data['last_name'] = $current_user->user_lastname;
		$data['nick_name'] = $current_user->user_nicename;
		$data['email'] = $current_user->user_email;
		$data['site_name'] = get_bloginfo('name');
		$data['site_url'] = home_url();
		$data['language'] = get_bloginfo('language');
		$resp = wp_remote_post('https://api.emarketdesign.com/optin_info.php', array(
			'body' => $data,
		));
		update_option('request_a_quote_tracking_optin', 1);
	} else {
		//opt-out
		update_option('request_a_quote_tracking_optin', -1);
	}
	wp_redirect(esc_url(remove_query_arg('request_a_quote_optin')));
	exit;
} else {
	add_action('admin_notices', 'request_a_quote_show_optin');
}
function request_a_quote_show_optin() {
	if (!current_user_can('manage_options')) {
		return;
	}
	if (!get_option('request_a_quote_tracking_optin')) {
		$tr_title = __('Please help us improve Request a quote', 'request-a-quote');
		$tr_msg = implode('<br />', array(
			__('Allow eMDPlugins to collect your usage of Request a quote. This will help you to get a better, more compatible plugin in the future.', 'request-a-quote') ,
			__('If you skip this, that\'s okay! Request a quote will still work just fine.', 'request-a-quote') ,
		));
		$tr_link = implode(' ', array(
			sprintf(__('%sDo not allow%s', 'request-a-quote') , '<a href="' . admin_url('admin.php?page=request_a_quote&request_a_quote_optin=0') . '" class="button-secondary" id="request-a-quote-do-not-allow-tracking">', '</a>') ,
			sprintf(__('%sAllow%s', 'request-a-quote') , '<a href="' . admin_url('admin.php?page=request_a_quote&request_a_quote_optin=1') . '" class="button-primary" id="request-a-quote-allow-tracking">', '</a>') ,
		));
		echo '<div class="update-nag emd-admin-notice">';
		echo '<h3 class="emd-notice-title"><span class="dashicons dashicons-smiley"></span>' . $tr_title . '<span class="dashicons dashicons-smiley"></span></h3><p class="emd-notice-body">';
		echo $tr_msg . '</p><ul class="emd-notice-body nf-red">';
		echo $tr_link . '</ul><div class="emd-permissions"><a href="#" class="emd-perm-trigger"><span class="dashicons dashicons-info" style="text-decoration:none;"></span>' . __('What permissions are being granted?', 'request-a-quote') . '</a><ul class="emd-permissions-list" style="display:none;">';
		echo '<li class="emd-permission"><i class="dashicons dashicons-nametag"></i><div><span>' . __('Your Profile Overview', 'request-a-quote') . '</span><p>' . __('Name and email address', 'request-a-quote') . '</p></div></li>';
		echo '<li class="emd-permission"><i class="dashicons dashicons-admin-settings"></i><div><span>' . __('Your Site Overview', 'request-a-quote') . '</span><p>' . __('Site URL, WP version and PHP info', 'request-a-quote') . '</p></div></li>';
		echo '<li class="emd-permission"><i class="dashicons dashicons-email-alt"></i><div><span>' . __('Newsletter', 'request-a-quote') . '</span><p>' . __('Updates, announcements, marketing, no spam', 'request-a-quote') . ', <a href="https://emdplugins.com/subscription-preferences/" target="_blank">unsubscribe anytime</a></p></div></li>';
		echo '</ul></div></div>';
	} else {
		//check min entity count if its not -1 then show notice
		$min_trigger = get_option('request_a_quote_show_rateme_plugin_min', 5);
		if ($min_trigger != - 1) {
			request_a_quote_show_rateme_notice();
		}
	}
}
function request_a_quote_show_rateme_action() {
	if (!wp_verify_nonce($_POST['rateme_nonce'], 'request_a_quote_rateme_nonce')) {
		exit;
	}
	$min_trigger = get_option('request_a_quote_show_rateme_plugin_min', 5);
	if ($min_trigger == - 1) {
		die;
	}
	if (5 === $min_trigger) {
		$response['redirect'] = "https://wordpress.org/support/plugin/request-a-quote/reviews/#postform";
		$min_trigger = 10;
	} else {
		$response['redirect'] = "https://emdplugins.com/plugin_tag/request-a-quote";
		$min_trigger = - 1;
	}
	update_option('request_a_quote_show_rateme_plugin_min', $min_trigger);
	echo json_encode($response);
	die;
}
function request_a_quote_show_rateme_notice() {
	if (!current_user_can('manage_options')) {
		return;
	}
	$min_count = 0;
	$ent_list = get_option('request_a_quote_ent_list');
	$min_trigger = get_option('request_a_quote_show_rateme_plugin_min', 5);
	$triggerdate = get_option('request_a_quote_activation_date', false);
	$installed_date = (!empty($triggerdate) ? $triggerdate : '999999999999999');
	$today = mktime(0, 0, 0, date('m') , date('d') , date('Y'));
	$label = $ent_list['emd_quote']['label'];
	$count_posts = wp_count_posts('emd_quote');
	if ($count_posts->publish > $min_trigger) {
		$min_count = $count_posts->publish;
	}
	if ($min_count > 5 || ($min_trigger == 5 && $installed_date <= $today)) {
		$message_start = '<div class="emd-show-rateme update-nag success">
                        <span class=""><b>Request a quote</b></span>
                        <div>';
		if ($min_count > 5) {
			$message_start.= sprintf(__("Hi, I noticed you just crossed the %d %s milestone on Request a quote - that's awesome!", "request-a-quote") , $min_trigger, $label);
		} elseif ($installed_date <= $today) {
			$message_start.= __("Hi, I just noticed you have been using Request a quote for about a week now - that's awesome!", "request-a-quote");
		}
		$message_level1 = __('Could you please do me a <span style="color:red" class="dashicons dashicons-heart"></span> BIG favor <span style="color:red" class="dashicons dashicons-heart"></span> and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.', "request-a-quote");
		$message_level2 = sprintf(__("Would you like to upgrade now to get more out of your %s?", "request-a-quote") , $label);
		$message_end = '<br/><br/>
                        <strong>Safiye Duman</strong><br>eMarket Design Cofounder<br><a data-rate-action="twitter" style="text-decoration:none" href="https://twitter.com/safiye_emd" target="_blank"><span class="dashicons dashicons-twitter"></span>@safiye_emd</a>
                        </div>
                        <div style="background-color: #f0f8ff;padding: 0 0 10px 10px;width: 300px;border: 1px solid;border-radius: 10px;margin: 14px 0;"><br><strong>Thank you</strong> <span class="dashicons dashicons-smiley"></span>
                        <ul data-nonce="' . wp_create_nonce('request_a_quote_rateme_nonce') . '">';
		$message_end1 = '<li><a data-rate-action="do-rate" data-plugin="request_a_quote" href="#">' . __('Ok, you deserve it', 'request-a-quote') . '</a>
       </li>
        <li><a data-rate-action="done-rating" data-plugin="request_a_quote" href="#">' . __('I already did', 'request-a-quote') . '</a></li>
        <li><a data-rate-action="not-enough" data-plugin="request_a_quote" href="#">' . __('Maybe later', 'request-a-quote') . '</a></li>';
		$message_end2 = '<li><a data-rate-action="upgrade-now" data-plugin="request_a_quote" href="#">' . __('I want to upgrade', 'request-a-quote') . '</a>
       </li>
        <li><a data-rate-action="not-enough" data-plugin="request_a_quote" href="#">' . __('Maybe later', 'request-a-quote') . '</a></li>';
	}
	if ($min_count > 10 && $min_trigger == 10) {
		echo $message_start . '<br>' . $message_level2 . ' ' . $message_end . ' ' . $message_end2 . '</ul></div></div>';
	} elseif ($min_count > 5 || ($min_trigger == 5 && $installed_date <= $today)) {
		echo $message_start . '<br>' . $message_level1 . ' ' . $message_end . ' ' . $message_end1 . '</ul></div></div>';
	}
}
/**
 * Adds links under plugin description
 *
 * @since WPAS 5.3
 * @param array $input
 * @param string $file
 * @return array $input
 */
function request_a_quote_plugin_row_meta($input, $file) {
	if ($file != 'request-a-quote/request-a-quote.php') return $input;
	$links = array(
		'<a href="https://docs.emdplugins.com/docs/request-a-quote-community-documentation/">' . __('Docs', 'request-a-quote') . '</a>',
		'<a href="https://emdplugins.com/plugin_tag/request-a-quote">' . __('Pro Version', 'request-a-quote') . '</a>'
	);
	$input = array_merge($input, $links);
	return $input;
}
/**
 * Adds links under plugin description
 *
 * @since WPAS 5.3
 * @param array $input
 * @param string $file
 * @return array $input
 */
function request_a_quote_plugin_action_links($links, $file) {
	if ($file != 'request-a-quote/request-a-quote.php') return $links;
	foreach ($links as $key => $link) {
		if ('deactivate' === $key) {
			$links[$key] = $link . '<i class="request_a_quote-deactivate-slug" data-slug="request_a_quote-deactivate-slug"></i>';
		}
	}
	$new_links['settings'] = '<a href="' . admin_url('admin.php?page=request_a_quote_settings') . '">' . __('Settings', 'request-a-quote') . '</a>';
	$links = array_merge($new_links, $links);
	return $links;
}
function request_a_quote_deactivation_feedback_box() {
	$is_long_term_user = true;
	$feedback_vars['utype'] = 0;
	$trigger_time = get_option('request_a_quote_activation_date');
	//7 days before trigger
	$activation_time = $trigger_time - 604800;
	$date_diff = time() - $activation_time;
	$date_diff_days = floor($date_diff / (60 * 60 * 24));
	if ($date_diff_days < 2) {
		$feedback_vars['utype'] = 1;
		$is_long_term_user = false;
	}
	wp_enqueue_style("emd-plugin-modal", REQUEST_A_QUOTE_PLUGIN_URL . 'assets/css/emd-plugin-modal.css');
	$feedback_vars['header'] = __('If you have a moment, please let us know why you are deactivating', 'request-a-quote');
	$feedback_vars['submit'] = __('Submit & Deactivate', 'request-a-quote');
	$feedback_vars['skip'] = __('Skip & Deactivate', 'request-a-quote');
	$feedback_vars['cancel'] = __('Cancel', 'request-a-quote');
	$feedback_vars['ask_reason'] = __('Please share the reason so we can improve', 'request-a-quote');
	$feedback_vars['nonce'] = wp_create_nonce('request_a_quote_deactivate_nonce');
	if ($is_long_term_user) {
		$reasons[1] = __('I no longer need the plugin', 'request-a-quote');
		$reasons[3] = __('I only needed the plugin for a short period', 'request-a-quote');
		$reasons[9] = __('The plugin update did not work as expected', 'request-a-quote');
		$reasons[5] = __('The plugin suddenly stopped working', 'request-a-quote');
		$reasons[2] = __('I found a better plugin', 'request-a-quote');
	} else {
		$reasons[21] = __('I couldn\'t understand how to make it work', 'request-a-quote');
		$reasons[22] = __('The plugin is not working', 'request-a-quote');
		$reasons[23] = __('It\'s not what I was looking for', 'request-a-quote');
		$reasons[24] = __('The plugin didn\'t work as expected', 'request-a-quote');
		$reasons[8] = __('The plugin is great, but I need a specific feature that is not currently supported', 'request-a-quote');
		$reasons[2] = __('I found a better plugin', 'request-a-quote');
	}
	$shuffle_keys = array_keys($reasons);
	shuffle($shuffle_keys);
	foreach ($shuffle_keys as $key) {
		$new_reasons[$key] = $reasons[$key];
	}
	$reasons = $new_reasons;
	//all
	$reasons[6] = __('It\'s a temporary deactivation. I\'m just debugging an issue', 'request-a-quote');
	$reasons[7] = __('Other', 'wp-easy-contact');
	$feedback_vars['disclaimer'] = __('No private information is sent during your submission. Thank you very much for your help improving our plugin.', 'request-a-quote');
	$feedback_vars['reasons'] = '';
	foreach ($reasons as $key => $reason) {
		$feedback_vars['reasons'].= '<li class="reason';
		if (in_array($key, Array(
			2,
			7,
			8,
			9,
			5,
			22,
			23,
			24
		))) {
			$feedback_vars['reasons'].= ' has-input';
		}
		$feedback_vars['reasons'].= '"';
		switch ($key) {
			case 2:
				$feedback_vars['reasons'].= 'data-input-type="textfield"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share the plugin name', 'request-a-quote') . '"';
			break;
			case 8:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share the feature that you were looking for so that we can develop it in the future releases', 'request-a-quote') . '"';
			break;
			case 9:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('We are sorry to hear that. Please share your previous version number before update, new updated version number and what happened', 'request-a-quote') . '"';
			break;
			case 5:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('We are sorry to hear that. Please share what happened', 'request-a-quote') . '"';
			break;
			case 22:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share what didn\'t work so we can fix it in the future releases', 'request-a-quote') . '"';
			break;
			case 23:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share what you were looking for', 'request-a-quote') . '"';
			break;
			case 24:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share what you expected', 'request-a-quote') . '"';
			break;
			default:
			break;
		}
		$feedback_vars['reasons'].= '><label><span>
                                        <input type="radio" name="selected-reason" value="' . $key . '"/>
                                        </span><span>' . $reason . '</span></label></li>';
	}
	wp_enqueue_script('emd-plugin-feedback', REQUEST_A_QUOTE_PLUGIN_URL . 'assets/js/emd-plugin-feedback.js');
	wp_localize_script("emd-plugin-feedback", 'plugin_feedback_vars', $feedback_vars);
	wp_enqueue_script('request-a-quote-feedback', REQUEST_A_QUOTE_PLUGIN_URL . 'assets/js/request-a-quote-feedback.js');
	$request_a_quote_vars['plugin'] = 'request_a_quote';
	wp_localize_script("request-a-quote-feedback", 'request_a_quote_vars', $request_a_quote_vars);
}
function request_a_quote_send_deactivate_reason() {
	if (empty($_POST['deactivate_nonce']) || !isset($_POST['reason_id'])) {
		exit;
	}
	if (!wp_verify_nonce($_POST['deactivate_nonce'], 'request_a_quote_deactivate_nonce')) {
		exit;
	}
	$reason_info = isset($_POST['reason_info']) ? sanitize_text_field($_POST['reason_info']) : '';
	$postfields['utype'] = intval($_POST['utype']);
	$postfields['reason_id'] = intval($_POST['reason_id']);
	$postfields['plugin_name'] = sanitize_text_field($_POST['plugin_name']);
	if (!empty($reason_info)) {
		$postfields['reason_info'] = $reason_info;
	}
	$args = array(
		'body' => $postfields,
		'sslverify' => false,
		'timeout' => 15,
	);
	$resp = wp_remote_post('https://api.emarketdesign.com/deactivate_info.php', $args);
	echo 1;
	exit;
}

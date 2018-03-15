
<div class="form-alerts">
<?php
echo (isset($zf_error) ? $zf_error : (isset($error) ? $error : ''));
$form_list = get_option('request_a_quote_glob_forms_list');
$form_list_init = get_option('request_a_quote_glob_forms_init_list');
if (!empty($form_list['request_a_quote'])) {
	$form_variables = $form_list['request_a_quote'];
}
$form_variables_init = $form_list_init['request_a_quote'];
$max_row = count($form_variables_init);
foreach ($form_variables_init as $fkey => $fval) {
	if (empty($form_variables[$fkey])) {
		$form_variables[$fkey] = $form_variables_init[$fkey];
	}
}
$ext_inputs = Array();
$ext_inputs = apply_filters('emd_ext_form_inputs', $ext_inputs, 'request_a_quote', 'request_a_quote');
$form_variables = apply_filters('emd_ext_form_var_init', $form_variables, 'request_a_quote', 'request_a_quote');
$req_hide_vars = emd_get_form_req_hide_vars('request_a_quote', 'request_a_quote');
$glob_list = get_option('request_a_quote_glob_list');
?>
</div>
<fieldset>
<?php wp_nonce_field('request_a_quote', 'request_a_quote_nonce'); ?>
<input type="hidden" name="form_name" id="form_name" value="request_a_quote">
<div class="request_a_quote-btn-fields container-fluid">
<!-- request_a_quote Form Attributes -->
<div class="request_a_quote_attributes">
<div id="row1" class="row ">
<!-- Taxonomy input-->
<?php if ($form_variables['raq_services']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['raq_services']['size']; ?>">
<div class="form-group">
<label id="label_raq_services" class="control-label" for="raq_services">
<?php _e('Service', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('raq_services', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Service field is required', 'request-a-quote'); ?>" id="info_raq_services" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<div id="input_raq_services">
<?php echo $raq_services; ?>
</div>
</div>
</div>
<?php
} ?>
</div>
<div id="row2" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_contact_first_name']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_first_name']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_first_name" class="control-label" for="emd_contact_first_name">
<?php _e('First Name', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_first_name', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('First Name field is required', 'request-a-quote'); ?>" id="info_emd_contact_first_name" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_first_name; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row3" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_contact_last_name']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_last_name']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_last_name" class="control-label" for="emd_contact_last_name">
<?php _e('Last Name', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_last_name', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Last Name field is required', 'request-a-quote'); ?>" id="info_emd_contact_last_name" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_last_name; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row4" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_contact_address']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_address']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_address" class="control-label" for="emd_contact_address">
<?php _e('Address', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_address', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Address field is required', 'request-a-quote'); ?>" id="info_emd_contact_address" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_address; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row5" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_contact_city']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_city']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_city" class="control-label" for="emd_contact_city">
<?php _e('City', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_city', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('City field is required', 'request-a-quote'); ?>" id="info_emd_contact_city" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_city; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row6" class="row ">
<!-- select input-->
<?php if ($form_variables['emd_contact_state']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_state']['size']; ?>">
<div class="form-group">
<label id="label_emd_contact_state" class="control-label" for="emd_contact_state">
<?php _e('State', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;"> 
<?php if (in_array('emd_contact_state', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('State field is required', 'request-a-quote'); ?>" id="info_emd_contact_state" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?> </span>
</label>
<div id="input_emd_contact_state">
<?php echo $emd_contact_state; ?>
</div>
</div>
</div>
<?php
} ?>
</div>
<div id="row7" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_contact_zip']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_zip']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_zip" class="control-label" for="emd_contact_zip">
<?php _e('Zipcode', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_zip', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Zipcode field is required', 'request-a-quote'); ?>" id="info_emd_contact_zip" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_zip; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row8" class="row ">
<!-- radios-->
<?php if ($form_variables['emd_contact_pref']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_pref']['size']; ?>">
<div class="form-group">
<label id="label_emd_contact_pref" class="control-label" for="emd_contact_pref">
<?php _e('Contact Preference', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_pref', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Contact Preference field is required', 'request-a-quote'); ?>" id="info_emd_contact_pref" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<div class="radio fa ">
<?php echo $emd_contact_pref_email . $label_emd_contact_pref_email ?>
</div>
<div class="radio fa ">
<?php echo $emd_contact_pref_telephone . $label_emd_contact_pref_telephone ?>
</div>
</div>
</div>
<?php
} ?>
</div>
<div id="row9" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_contact_email']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_email']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_email" class="control-label" for="emd_contact_email">
<?php _e('Email', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_email', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Email field is required', 'request-a-quote'); ?>" id="info_emd_contact_email" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_email; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row10" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_contact_phone']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_phone']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_phone" class="control-label" for="emd_contact_phone">
<?php _e('Phone', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_phone', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Phone field is required', 'request-a-quote'); ?>" id="info_emd_contact_phone" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_phone; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row11" class="row ">
<!-- select input-->
<?php if ($form_variables['emd_contact_callback_time']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_callback_time']['size']; ?>">
<div class="form-group">
<label id="label_emd_contact_callback_time" class="control-label" for="emd_contact_callback_time">
<?php _e('Callback Time', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;"> 
<?php if (in_array('emd_contact_callback_time', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Callback Time field is required', 'request-a-quote'); ?>" id="info_emd_contact_callback_time" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?> </span>
</label>
<div id="input_emd_contact_callback_time">
<?php echo $emd_contact_callback_time; ?>
</div>
</div>
</div>
<?php
} ?>
</div>
<div id="row12" class="row ">
<!-- text input-->
<?php if ($form_variables['emd_contact_budget']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_budget']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_budget" class="control-label" for="emd_contact_budget">
<?php _e('Budget', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_budget', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Budget field is required', 'request-a-quote'); ?>" id="info_emd_contact_budget" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_budget; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row13" class="row ">
<!-- textarea input-->
<?php if ($form_variables['emd_contact_extrainfo']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_extrainfo']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_extrainfo" class="control-label" for="emd_contact_extrainfo">
<?php _e('Additional details', 'request-a-quote'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('emd_contact_extrainfo', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Additional details field is required', 'request-a-quote'); ?>" id="info_emd_contact_extrainfo" class="helptip">
<i class="field-icons fa fa-star required"></i>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_extrainfo; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row14" class="row ">
<!-- file input-->
<?php if ($form_variables['emd_contact_attachment']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_attachment']['size']; ?>">
<div class="small text-muted" style="margin:0.75rem 0 0.50rem;">
<?php
	$ent_map_list = get_option('request_a_quote_ent_map_list', Array());
	if (!empty($ent_map_list['emd_quote']['max_files']['emd_contact_attachment'])) {
		echo sprintf(__('Max number of files: %s', 'request-a-quote') , $ent_map_list['emd_quote']['max_files']['emd_contact_attachment']);
	}
	if (!empty($ent_map_list['emd_quote']['max_file_size']['emd_contact_attachment'])) {
		echo '<br> ' . sprintf(__('Max file size: %s', 'request-a-quote') , $ent_map_list['emd_quote']['max_file_size']['emd_contact_attachment']) . ' KB';
	}
	if (!empty($ent_map_list['emd_quote']['file_exts']['emd_contact_attachment'])) {
		echo '<br> ' . sprintf(__('File extensions allowed: %s', 'request-a-quote') , $ent_map_list['emd_quote']['file_exts']['emd_contact_attachment']);
	}
?>
</div>
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Attach related files to the quote.', 'request-a-quote'); ?>" id="info_emd_contact_attachment" class="helptip"><i class="field-icons fa fa-info-circle"></i></a>
<div class="form-group">
<?php echo $emd_contact_attachment; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row15" class="row ext-row">
<?php if (!empty($form_variables['mailchimp_optin']) && $form_variables['mailchimp_optin']['show'] == 1) { ?>
<div class="col-sm-12">
<div class="form-group">
<div class="col-md-<?php echo $form_variables['mailchimp_optin']['size']; ?> ">
<span class="mailchimp_optin-option">
<?php echo $mailchimp_optin_1; ?>
<label style="padding-bottom:10px;" id="label_mailchimp_optin_1" class="option" for="mailchimp_optin_1">
<?php echo $form_variables['mailchimp_optin']['label']; ?>
</label>
</span>
</div>
</div>
</div>
<?php
} ?>
</div>
 
 
 
 
</div><!--form-attributes-->
<?php if ($show_captcha == 1) { ?>
<div class="row">
<div class="col-xs-12">
<div id="captcha-group" class="form-group">
<?php echo $captcha_image; ?>
<label style="padding:0px;" id="label_captcha_code" class="control-label" for="captcha_code">
<a id="info_captcha_code_help" class="helptip" data-html="true" data-toggle="tooltip" href="#" title="<?php _e('Please enter the characters with black color in the image above.', 'request-a-quote'); ?>">
<i class="field-icons fa fa-info-circle"></i>
</a>
<a id="info_captcha_code_req" class="helptip" title="<?php _e('Security Code field is required', 'request-a-quote'); ?>" data-toggle="tooltip" href="#">
<i class="field-icons fa fa-star required"></i>
</a>
</label>
<?php echo $captcha_code; ?>
</div>
</div>
</div>
<?php
} ?>
<!-- Button -->
<div class="row">
<div class="col-md-12">
<div class="wpas-form-actions">
<?php echo $singlebutton_request_a_quote; ?>
</div>
</div>
</div>
</div><!--form-btn-fields-->
</fieldset>
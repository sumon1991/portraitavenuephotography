<?php $ent_attrs = get_option('request_a_quote_attr_list'); ?>
<div class="emd-container">
<?php
if (emd_is_item_visible('emd_contact_first_name', 'request_a_quote', 'attribute')) {
	$emd_contact_first_name = emd_mb_meta('emd_contact_first_name');
	if (!empty($emd_contact_first_name)) { ?>
   <div id="emd-quote-emd-contact-first-name-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-first-name-key" class="emd-single-title">
<?php _e('First Name', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-first-name-val" class="emd-single-val">
<?php echo $emd_contact_first_name; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_last_name', 'request_a_quote', 'attribute')) {
	$emd_contact_last_name = emd_mb_meta('emd_contact_last_name');
	if (!empty($emd_contact_last_name)) { ?>
   <div id="emd-quote-emd-contact-last-name-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-last-name-key" class="emd-single-title">
<?php _e('Last Name', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-last-name-val" class="emd-single-val">
<?php echo $emd_contact_last_name; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_address', 'request_a_quote', 'attribute')) {
	$emd_contact_address = emd_mb_meta('emd_contact_address');
	if (!empty($emd_contact_address)) { ?>
   <div id="emd-quote-emd-contact-address-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-address-key" class="emd-single-title">
<?php _e('Address', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-address-val" class="emd-single-val">
<?php echo $emd_contact_address; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_city', 'request_a_quote', 'attribute')) {
	$emd_contact_city = emd_mb_meta('emd_contact_city');
	if (!empty($emd_contact_city)) { ?>
   <div id="emd-quote-emd-contact-city-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-city-key" class="emd-single-title">
<?php _e('City', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-city-val" class="emd-single-val">
<?php echo $emd_contact_city; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_zip', 'request_a_quote', 'attribute')) {
	$emd_contact_zip = emd_mb_meta('emd_contact_zip');
	if (!empty($emd_contact_zip)) { ?>
   <div id="emd-quote-emd-contact-zip-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-zip-key" class="emd-single-title">
<?php _e('Zipcode', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-zip-val" class="emd-single-val">
<?php echo $emd_contact_zip; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
$emd_contact_state = emd_get_attr_val(str_replace("-", "_", 'request-a-quote') , $post->ID, 'emd_quote', 'emd_contact_state');
if (!empty($emd_contact_state)) { ?>
   <div id="emd-quote-emd-contact-state-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-state-key" class="emd-single-title">
<?php _e('State', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-state-val" class="emd-single-val">
<?php echo $emd_contact_state; ?>
   </div>
   </div>
<?php
} ?>
<?php
if (emd_is_item_visible('emd_contact_email', 'request_a_quote', 'attribute')) {
	$emd_contact_email = emd_mb_meta('emd_contact_email');
	if (!empty($emd_contact_email)) { ?>
   <div id="emd-quote-emd-contact-email-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-email-key" class="emd-single-title">
<?php _e('Email', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-email-val" class="emd-single-val">
<?php echo $emd_contact_email; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_phone', 'request_a_quote', 'attribute')) {
	$emd_contact_phone = emd_mb_meta('emd_contact_phone');
	if (!empty($emd_contact_phone)) { ?>
   <div id="emd-quote-emd-contact-phone-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-phone-key" class="emd-single-title">
<?php _e('Phone', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-phone-val" class="emd-single-val">
<?php echo $emd_contact_phone; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_pref', 'request_a_quote', 'attribute')) {
	$emd_contact_pref = emd_mb_meta('emd_contact_pref');
	if (!empty($emd_contact_pref)) { ?>
   <div id="emd-quote-emd-contact-pref-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-pref-key" class="emd-single-title">
<?php _e('Contact Preference', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-pref-val" class="emd-single-val">
<?php echo $emd_contact_pref; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
$emd_contact_callback_time = emd_get_attr_val(str_replace("-", "_", 'request-a-quote') , $post->ID, 'emd_quote', 'emd_contact_callback_time');
if (!empty($emd_contact_callback_time)) { ?>
   <div id="emd-quote-emd-contact-callback-time-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-callback-time-key" class="emd-single-title">
<?php _e('Callback Time', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-callback-time-val" class="emd-single-val">
<?php echo $emd_contact_callback_time; ?>
   </div>
   </div>
<?php
} ?>
<?php
if (emd_is_item_visible('emd_contact_budget', 'request_a_quote', 'attribute')) {
	$emd_contact_budget = emd_mb_meta('emd_contact_budget');
	if (!empty($emd_contact_budget)) { ?>
   <div id="emd-quote-emd-contact-budget-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-budget-key" class="emd-single-title">
<?php _e('Budget', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-budget-val" class="emd-single-val">
<?php echo $emd_contact_budget; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_extrainfo', 'request_a_quote', 'attribute')) {
	$emd_contact_extrainfo = emd_mb_meta('emd_contact_extrainfo');
	if (!empty($emd_contact_extrainfo)) { ?>
   <div id="emd-quote-emd-contact-extrainfo-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-extrainfo-key" class="emd-single-title">
<?php _e('Additional details', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-extrainfo-val" class="emd-single-val">
<?php echo $emd_contact_extrainfo; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_id', 'request_a_quote', 'attribute')) {
	$emd_contact_id = emd_mb_meta('emd_contact_id');
	if (!empty($emd_contact_id)) { ?>
   <div id="emd-quote-emd-contact-id-div" class="emd-single-div">
   <div id="emd-quote-emd-contact-id-key" class="emd-single-title">
<?php _e('ID', 'request-a-quote'); ?>
   </div>
   <div id="emd-quote-emd-contact-id-val" class="emd-single-val">
<?php echo $emd_contact_id; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_attachment', 'request_a_quote', 'attribute')) {
	$emd_mb_file = emd_mb_meta('emd_contact_attachment', 'type=file');
	if (!empty($emd_mb_file)) { ?>
  <div id="emd-quote-emd-contact-attachment-div" class="emd-single-div">
  <div id="emd-quote-emd-contact-attachment-key" class="emd-single-title">
  <?php _e('Attachments', 'request-a-quote'); ?>
  </div>
  <div id="emd-quote-emd-contact-attachment-val" class="emd-single-val">
  <?php foreach ($emd_mb_file as $info) {
			$fsrc = wp_mime_type_icon($info['ID']);
?>
  <a href='<?php echo esc_url($info['url']); ?>' target='_blank' title='<?php echo esc_attr($info['title']); ?>'><img src='<?php echo $fsrc; ?>' title='<?php echo esc_html($info['name']); ?>' width='20' />
   </a>
  <?php
		} ?>
  </div>
  </div>
<?php
	}
}
?>
<?php
$taxlist = get_object_taxonomies(get_post_type() , 'objects');
foreach ($taxlist as $taxkey => $mytax) {
	$termlist = get_the_term_list(get_the_ID() , $taxkey, '', ' , ', '');
	if (!empty($termlist)) {
		if (emd_is_item_visible('tax_' . $taxkey, 'request_a_quote', 'taxonomy')) { ?>
      <div id="emd-quote-<?php echo esc_attr($taxkey); ?>-div" class="emd-single-div">
      <div id="emd-quote-<?php echo esc_attr($taxkey); ?>-key" class="emd-single-title">
      <?php echo esc_html($mytax->labels->singular_name); ?>
      </div>
      <div id="emd-quote-<?php echo esc_attr($taxkey); ?>-val" class="emd-single-val">
      <?php echo $termlist; ?>
      </div>
      </div>
   <?php
		}
	}
} ?>
</div><!--container-end-->
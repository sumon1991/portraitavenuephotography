jQuery(document).ready(function() {
$=jQuery;
var $captcha_container = $('.captcha-container');
if ($captcha_container.length > 0) {
        var $image = $('img', $captcha_container),
        $anchor = $('a', $captcha_container);
        $anchor.bind('click', function(e) {
                e.preventDefault();
                $image.attr('src', $image.attr('src').replace(/nocache=[0-9]+/, 'nocache=' + +new Date()));
        });
}
$('#request_a_quote .helptip').tooltip({viewport: {selector: '#request_a_quote', padding: 0}});
$('button[data-select2-open]').click(function(){
$('#' + $(this).data('select2-open')).select2('open');
});
$.validator.setDefaults({
    ignore: [],
});
$.extend($.validator.messages,request_a_quote_vars.validate_msg);
$('#emd_contact_state').selectpicker({noneSelectedText:"Please Select"});
$('#emd_contact_callback_time').selectpicker({noneSelectedText:"Please Select"});
$("#emd_contact_attachment").filepicker(request_a_quote_vars.emd_contact_attachment);
$('#raq_services').select2($('#raq_services').data('options'));
$.validator.addMethod('uniqueAttr',function(val,element){
  var unique = true;
  var data_input = $("form").serialize();
  $.ajax({
    type: 'GET',
    url: request_a_quote_vars.ajax_url,
    cache: false,
    async: false,
    data: {action:'emd_check_unique',data_input:data_input, ptype:'emd_quote',myapp:'request_a_quote'},
    success: function(response)
    {
      unique = response;
    },
  });
  return unique;                
}, request_a_quote_vars.unique_msg);
$('.request_a_quote').validate({
onfocusout: false,
onkeyup: false,
onclick: false,
errorClass: 'text-danger',
rules: {
  emd_contact_first_name:{
},
emd_contact_last_name:{
},
emd_contact_address:{
},
emd_contact_city:{
},
emd_contact_state:{
},
emd_contact_zip:{
},
emd_contact_pref:{
},
emd_contact_email:{
email  : true,
},
emd_contact_phone:{
},
emd_contact_callback_time:{
},
emd_contact_budget:{
number : true,
},
emd_contact_extrainfo:{
},
emd_contact_attachment:{
},
},
success: function(label) {
label.remove();
},
errorPlacement: function(error, element) {
if (typeof(element.parent().attr("class")) != "undefined" && element.parent().attr("class").search(/date|time/) != -1) {
error.insertAfter(element.parent().parent());
}
else if(element.attr("class").search("radio") != -1){
error.insertAfter(element.parent().parent());
}
else if(element.attr("class").search("select2-offscreen") != -1){
error.insertAfter(element.parent().parent());
}
else if(element.attr("class").search("selectpicker") != -1 && element.parent().parent().attr("class").search("form-group") == -1){
error.insertAfter(element.parent().find('.bootstrap-select').parent());
} 
else if(element.parent().parent().attr("class").search("pure-g") != -1){
error.insertAfter(element);
}
else {
error.insertAfter(element.parent());
}
},
});
$(document).on('click','#singlebutton_request_a_quote',function(event){
     var form_id = $(this).closest('form').attr('id');
     $.each(request_a_quote_vars.request_a_quote.req, function (ind, val){
         if(!$('input[name='+val+'],#'+ val).closest('.row').is(":hidden")){
             $('input[name='+val+'],#'+ val).rules("add","required"); 
         }
     });
     var valid = $('#' + form_id).valid();
     if(!valid) {
        event.preventDefault();
        return false;
     }
});
if(request_a_quote_vars.conditional_rules.length != 0){
        $.fn.conditionalCheck(request_a_quote_vars.conditional_rules);
}
});

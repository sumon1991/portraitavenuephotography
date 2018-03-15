;(function( $ ) {

    /*$('#vc_edit-form-tabs .js_el_switcher').change(function(e){
        e.preventDefault();

        var $this = $(this),
        	new_val = 0; 

        if( $this.prop('checked')  ) {
        	new_val = 1;
        } 

        $this.val(new_val);

    });*/

    jQuery(document).ready(function($){
	    $('.vc_upload_btn').on('click', function(e) {
	        e.preventDefault();
	        var image = wp.media({ 
	            title: 'Upload File',
	            // mutiple: true if you want to upload multiple files at once
	            multiple: false
	        }).open()
	        .on('select', function(e){
	            // This will return the selected image from the Media Uploader, the result is an object
	            var uploaded_file = image.state().get('selection').first();
	            // We convert uploaded_file to a JSON object to make accessing it easier
	            // Output to the console uploaded_file
 
	            var file = uploaded_file.toJSON().url;
	            // Let's assign the url value to the input field
	            $('.vc_file_param .regular-text').val(file);
	        });
	    });
	});

})( jQuery);
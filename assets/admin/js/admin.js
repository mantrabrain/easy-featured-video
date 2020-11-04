jQuery(function($){
	// Selecting video
	$('body').on('click', '.upload_video_button', function(e){
		e.preventDefault();
    		var button = $(this),
    		custom_uploader = wp.media({
			title: 'Insert Video',
			library : {
				type : 'video'
			},
			button: {
				text: 'Use this Video' // button label text
			},
			multiple: false // for multiple image selection set to true
		}).on('select', function() { // it also has "open" and "close" events 
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$(button).removeClass('button').html('<video controls="" src="' + attachment.url + '"></video>').next().val(attachment.id).next().show();
				})
		.open();
	});
	// Removing video
	$('body').on('click', '.remove_image', function(){
		$(this).hide().prev().val('').prev().addClass('button').html('Upload Video');
		return false;
	});
});
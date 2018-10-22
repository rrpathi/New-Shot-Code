jQuery(document).ready(function(){
	var $j = jQuery.noConflict();
	jQuery("#form-submit").click(function(e){
		$j.ajax({ 
			type: 'post',
			url:ajaxurl,
			data: {
				action:"my_ajax_function",
			},
			success: function(data) {
				console.log(data);
				location. reload(true);
			},
			error: function(errorThrown){
				location. reload(true);
			} 
		});
	});

	jQuery("#add_dropbox_account_details").click(function(e){
		var app_key = jQuery("#app_key").val();
		var app_secret = jQuery("#app_secret").val();
		var access_token = jQuery("#access_token").val();
		$j.ajax({
			type: 'post',
			url:ajaxurl,
			data: {
				action:"add_dropbox_account_details",
				app_key:app_key,app_secret:app_secret,access_token:access_token,
			},
			success: function(data) {
				console.log(data);
				location. reload(true);
			},
			error: function(errorThrown){
				location. reload(true);
			} 
		});

	});

	jQuery(".delete_short_code_value").click(function(e){
		e.preventDefault();
		var shortcode_value_id = jQuery(this).attr('id');
		jQuery.ajax({
			type:"post",
			url:ajaxurl,
			data:{
				action:"delete_short_code_value",
				shortcode_value_id:shortcode_value_id,
			},
			success:function(data){
				location. reload(true);
			}
		});

	});

	
});
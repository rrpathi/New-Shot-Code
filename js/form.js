jQuery(document).ready(function(){
	jQuery("#add_more").click(function(e){
		e.preventDefault();
		jQuery(".custome_form").append('<div class="single-short-code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]"></div><div class="form-group col-md-5"><label for="pwd">Field Name</label><input type="text" class="form-control field_name" placeholder="text,password" name="field[]"></div><div class="form-group col-md-2"><input class="btn btn-danger remove-short-code" style="margin-top:25px" type="button" value="Delete"></div></div>');
	});

	jQuery("#submit").click(function(e){
		e.preventDefault();
		var field_name = jQuery(".field_name").map(function(){
			return jQuery(this).val();
		}).get();

		var label_name = jQuery(".label_name").map(function(){
			return jQuery(this).val();
		}).get();
         var shortcode_name = jQuery("#shot_code_name").val();  
		var stringData = JSON.stringify({field_name:field_name,label_name:label_name,shortcode_name:shortcode_name});

         	jQuery.ajax({
			type: 'post',
			url:ajaxurl,
			data: {
				action:"shot_code_register",
				shot_code:stringData,
			},
			success: function(data) {
				console.log(data);
				// location. reload(true);

			},
			error: function(errorThrown){
				// location. reload(true);
				
			} 
		});
	});

	jQuery(".edit_short_code").click(function(){
		var short_code_id = jQuery(this).attr("value");
		jQuery.ajax({
		type:"post",
		url:ajaxurl,
		data:{
			action:"edit_short_code",
			short_code_id:short_code_id,
		},
		success:function(data){
			jQuery(".show-form-hide").hide();
			jQuery(".edit-form").html(data);
			jQuery("#add_add_more_field").click(function(){
				jQuery(".custome_form").append('<div class="single-short-code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]"></div><div class="form-group col-md-5"><label for="pwd">Field Name</label><input type="text" class="form-control field_name" placeholder="text,password" name="field[]"></div><div class="form-group col-md-2"><input class="btn btn-danger remove-short-code" style="margin-top:25px" type="button" value="Delete"></div></div>');
			});
			jQuery("#update_add_more_details").click(function(e){
				e.preventDefault();
				var short_code_id = jQuery("#hidden_shotcode_id").val();
				var shortcode_name = jQuery("#shot_code_name").val();  
				var field_name = jQuery(".field_name").map(function(){
				return jQuery(this).val();
				}).get();
				var label_name = jQuery(".label_name").map(function(){
				return jQuery(this).val();
				}).get();
				var stringData = JSON.stringify({field_name:field_name,label_name:label_name,shortcode_name:shortcode_name,short_code_id:short_code_id});

				// console.log("ready Next ajax call");
				jQuery.ajax({
					type:"post",
					url:ajaxurl,
					data:{
					action:"update_short_code_details",
					update_short_code_details:stringData,
					},
					success:function(data){
						if(data['status'] =='1'){
							location. reload(true);
						}else{
							location. reload(true);
						}
					}
				});
			});
		}
		});
	});

	jQuery(".delete_short_code").click(function(){
		var short_code_id = jQuery(this).attr("value");
		jQuery.ajax({
			type:"post",
			url:ajaxurl,
			data:{
				action:"delete_short_code",
				short_code_id:short_code_id,
			},
			success:function(data){
				console.log(data);
				var data = jQuery.parseJSON(data);
				if(data['status'] =='1'){
					// jQuery(".response").html("<h2>Shot Code Deleted Successfully</h2>");
					location. reload(true);
				}else{
					location. reload(true);
					console.log("Shot Code Not Deleted ");

				}
			}
		});
	});

	jQuery("body").on("click",".remove-short-code",function(){
		 jQuery(this).closest('div.single-short-code').remove();
	});
	
	jQuery("body").on("click",".remove",function(){
	var parent = jQuery(this).closest(".hack");
	var id = parent.attr("id");
	console.log(id);
	jQuery("#"+id).remove();
});


});
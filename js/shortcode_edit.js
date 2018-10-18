jQuery(document).ready(function(){
	
	jQuery(".edit_short_code").click(function(){
		var short_code_id = jQuery(this).attr("value");
		console.log(short_code_id);
		jQuery.ajax({
		type:"post",
		url:ajaxurl,
		data:{
			action:"edit_short_code",
			short_code_id:short_code_id,
		},
		success:function(data){
			console.log(data);
			jQuery(".show-form-hide").hide();
			jQuery(".edit-form").html(data);
			// jQuery("#add_add_more_field").click(function(){
			// 	jQuery(".custome_form").append('<div class="single-short-code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]"></div><div class="form-group col-md-5"><label for="pwd">Field Name</label><input type="text" class="form-control field_name" placeholder="text,password" name="field[]"></div><div class="form-group col-md-2"><input class="btn btn-danger remove-short-code" style="margin-top:25px" type="button" value="Delete"></div></div>');
			// });
			// jQuery("#update_add_more_details").click(function(e){
			// 	e.preventDefault();
			// 	var short_code_id = jQuery("#hidden_shotcode_id").val();
			// 	var shortcode_name = jQuery("#shot_code_name").val();  
			// 	var field_name = jQuery(".field_name").map(function(){
			// 	return jQuery(this).val();
			// 	}).get();
			// 	var label_name = jQuery(".label_name").map(function(){
			// 	return jQuery(this).val();
			// 	}).get();
			// 	var stringData = JSON.stringify({field_name:field_name,label_name:label_name,shortcode_name:shortcode_name,short_code_id:short_code_id});

			// 	// console.log("ready Next ajax call");
			// 	jQuery.ajax({
			// 		type:"post",
			// 		url:ajaxurl,
			// 		data:{
			// 		action:"update_short_code_details",
			// 		update_short_code_details:stringData,
			// 		},
			// 		success:function(data){
			// 			if(data['status'] =='1'){
			// 				location. reload(true);
			// 			}else{
			// 				location. reload(true);
			// 			}
			// 		}
			// 	});
			// });
		}
		});
	});

});
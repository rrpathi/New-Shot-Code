jQuery(document).ready(function(){
		var i=0;
		jQuery("body").on("change",".wp_shot_add_shot_code_option",function(){
		var iValue = jQuery(this).attr('id');
		var shot_code_option_class_name = jQuery(this).find('option:selected').attr('class');
		if(shot_code_option_class_name =='wp_checkbox'){
		var wp_checkbox_option = '<div class="row"><div class="form-group col-md-10"><label for="text">Checkbox Field Name</label><input type="text" class="form-control checkbox_field_name " id="text" placeholder="Enter text"></div><div class="col-md-2"><button class="Add_more_checkbox" id="'+iValue+'" type="button">Add</button></div></div><div class="wp_checkbox_Addmore'+iValue+'"></div>';
		jQuery(".wp_append_checkbox"+iValue).append(wp_checkbox_option);
		}

		if(shot_code_option_class_name =='wp_radio'){
		var wp_radio_button_option = '<div class="row"><div class="form-group col-md-10"><label for="text">Radio Button Field Name</label><input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]"></div><div class="col-md-2"><button class="add_more_radio_button" id="'+iValue+'" type="button">Add</button></div></div><div class="wp_radio_button_Addmore'+iValue+'"></div>';
		jQuery(".wp_append_radio"+iValue).append(wp_radio_button_option);
		}
		});

		// End Onchange option value

		jQuery("body").on("click",".add_more_radio_button",function(){
			var iValue = jQuery(this).attr('id');
			var wp_radio_button_add_more = '<div class="row single_set_radio_button_remove"><div class="form-group col-md-10"><label for="text">Radio Button Field Name</label><input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]"></div><div class="col-md-2"><button class="remove_radio_button">Delete</button></div></div>';
			jQuery(".wp_radio_button_Addmore"+iValue).append(wp_radio_button_add_more);
			// console.log(add_more_radio_button_id);

		});

		jQuery("body").on("click",".Add_more_checkbox",function(){
			var Ivalue = jQuery(this).attr('id');
			console.log(Ivalue);
			var wp_checkbox_options = '<div class="row single_set_checkbox_remove"><div class="form-group col-md-10"><label for="text">Checkbox Field Name</label><input type="text" class="form-control checkbox_field_name" id="text" placeholder="Enter text" name="checkbox_field_name[]"></div><div class="col-md-2"><button class="remove_check_box">Delete</button></div></div>';
			jQuery(".wp_checkbox_Addmore"+Ivalue).append(wp_checkbox_options);
		})


		jQuery("body").on("click",".remove_check_box",function(){
			jQuery(this).closest('div.single_set_checkbox_remove').remove();
		});

		jQuery("body").on("click",".remove_radio_button",function(){
			jQuery(this).closest('div.single_set_radio_button_remove').remove();
		});



	jQuery("#wp_add_more").click(function(){
		var append_add_more = '<div class="row wp_main_short_code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name" id="text" placeholder="Enter text" ></div><div class="form-group  col-md-5"><label for="exampleSelect1">Field Type</label><select class="form-control wp_shot_add_shot_code_option field_type" style="height:34px;" id="'+i+'"><option value="text" class="wp_text">Text</option><option class="wp_email" value="email">Email</option><option class="wp_password" value="password">Password</option><option class="wp_checkbox" value="checkbox">Check Box</option><option class="wp_radio" value="radio">Radio Button</option></select></div><div class="col-md-2"><button type="button" class="wp_main_short_code_remove">Delete</button></div><div class="wp_append_checkbox'+i+'"></div><div class="wp_append_radio'+i+'"></div>';
		jQuery(".wp_single_set_short_code").append(append_add_more);
		i++
	});

	// jQuery(".wp_main_short_code_remove").click(function(){
	// 	console.log("hello World");
	// });

	jQuery("body").on("click",".wp_main_short_code_remove",function(){
		jQuery(this).closest('div.wp_main_short_code').remove();
	});

	jQuery("#short_code_submit").click(function(e){
		e.preventDefault();
		var label_name = jQuery(".label_name").map(function(){
			return jQuery(this).val();
		}).get();

		var field_type = jQuery(".field_type").map(function(){
			return jQuery(this).val();
		}).get();


		// console.log(field_type);

		// var check_box_field_name = jQuery(".checkbox_field_name").map(function(){
		// 	return jQuery(this).val();
		// }).get();

		// console.log(check_box_field_name);


		// var options = jQuery('.field_type option');
		// var values = jQuery.map(options ,function(option) {

		// 	return option.value;
		// });
		// var field_type = jQuery(".field_type").map(function(){
		// 	return jQuery(this).text();
		// }).get();
		// console.log(field_type);
	});

	// jQuery("#add_more").click(function(e){
	// 	e.preventDefault();
	// 	jQuery(".custome_form").append('<div class="single-short-code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]"></div><div class="form-group col-md-5"><label for="pwd">Field Name</label><input type="text" class="form-control field_name" placeholder="text,password" name="field[]"></div><div class="form-group col-md-2"><input class="btn btn-danger remove-short-code" style="margin-top:25px" type="button" value="Delete"></div></div>');
	// });

	// jQuery("#submit").click(function(e){
	// 	e.preventDefault();
	// 	var field_name = jQuery(".field_name").map(function(){
	// 		return jQuery(this).val();
	// 	}).get();

	// 	var label_name = jQuery(".label_name").map(function(){
	// 		return jQuery(this).val();
	// 	}).get();
 //         var shortcode_name = jQuery("#shot_code_name").val();  
	// 	var stringData = JSON.stringify({field_name:field_name,label_name:label_name,shortcode_name:shortcode_name});

 //         	jQuery.ajax({
	// 		type: 'post',
	// 		url:ajaxurl,
	// 		data: {
	// 			action:"shot_code_register",
	// 			shot_code:stringData,
	// 		},
	// 		success: function(data) {
	// 			console.log(data);
	// 			// location. reload(true);

	// 		},
	// 		error: function(errorThrown){
	// 			// location. reload(true);
				
	// 		} 
	// 	});
	// });

	// jQuery(".edit_short_code").click(function(){
	// 	var short_code_id = jQuery(this).attr("value");
	// 	jQuery.ajax({
	// 	type:"post",
	// 	url:ajaxurl,
	// 	data:{
	// 		action:"edit_short_code",
	// 		short_code_id:short_code_id,
	// 	},
	// 	success:function(data){
	// 		jQuery(".show-form-hide").hide();
	// 		jQuery(".edit-form").html(data);
	// 		jQuery("#add_add_more_field").click(function(){
	// 			jQuery(".custome_form").append('<div class="single-short-code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]"></div><div class="form-group col-md-5"><label for="pwd">Field Name</label><input type="text" class="form-control field_name" placeholder="text,password" name="field[]"></div><div class="form-group col-md-2"><input class="btn btn-danger remove-short-code" style="margin-top:25px" type="button" value="Delete"></div></div>');
	// 		});
	// 		jQuery("#update_add_more_details").click(function(e){
	// 			e.preventDefault();
	// 			var short_code_id = jQuery("#hidden_shotcode_id").val();
	// 			var shortcode_name = jQuery("#shot_code_name").val();  
	// 			var field_name = jQuery(".field_name").map(function(){
	// 			return jQuery(this).val();
	// 			}).get();
	// 			var label_name = jQuery(".label_name").map(function(){
	// 			return jQuery(this).val();
	// 			}).get();
	// 			var stringData = JSON.stringify({field_name:field_name,label_name:label_name,shortcode_name:shortcode_name,short_code_id:short_code_id});

	// 			// console.log("ready Next ajax call");
	// 			jQuery.ajax({
	// 				type:"post",
	// 				url:ajaxurl,
	// 				data:{
	// 				action:"update_short_code_details",
	// 				update_short_code_details:stringData,
	// 				},
	// 				success:function(data){
	// 					if(data['status'] =='1'){
	// 						location. reload(true);
	// 					}else{
	// 						location. reload(true);
	// 					}
	// 				}
	// 			});
	// 		});
	// 	}
	// 	});
	// });

	// jQuery(".delete_short_code").click(function(){
	// 	var short_code_id = jQuery(this).attr("value");
	// 	jQuery.ajax({
	// 		type:"post",
	// 		url:ajaxurl,
	// 		data:{
	// 			action:"delete_short_code",
	// 			short_code_id:short_code_id,
	// 		},
	// 		success:function(data){
	// 			console.log(data);
	// 			var data = jQuery.parseJSON(data);
	// 			if(data['status'] =='1'){
	// 				// jQuery(".response").html("<h2>Shot Code Deleted Successfully</h2>");
	// 				location. reload(true);
	// 			}else{
	// 				location. reload(true);
	// 				console.log("Shot Code Not Deleted ");

	// 			}
	// 		}
	// 	});
	// });

// 	jQuery("body").on("click",".remove-short-code",function(){
// 		 jQuery(this).closest('div.single-short-code').remove();
// 	});
	
// 	jQuery("body").on("click",".remove",function(){
// 	var parent = jQuery(this).closest(".hack");
// 	var id = parent.attr("id");
// 	console.log(id);
// 	jQuery("#"+id).remove();
// });


});
jQuery(document).ready(function(){
		jQuery("body").on("change",".wp_shot_add_shot_code_option",function(){
			// console.log("Hello World");
		var iValue = jQuery(this).attr('id');
		var shot_code_option_class_name = jQuery(this).find('option:selected').attr('class');
			jQuery('.wp_append_checkbox'+iValue).empty();
			jQuery('.wp_append_radio'+iValue).empty();
		if(shot_code_option_class_name =='wp_checkbox'){
		var wp_checkbox_option = '<div class="row"><div class="form-group col-md-10"><label for="text">Checkbox Field Name</label><input type="text" class="form-control checkbox_field_name " id="text" placeholder="Enter text"></div><div class="col-md-2"><button class="Add_more_checkbox btn btn-primary" id="'+iValue+'" type="button">Add</button></div></div><div class="wp_checkbox_Addmore'+iValue+'"></div>';
		jQuery(".wp_append_checkbox"+iValue).append(wp_checkbox_option);
		}

		if(shot_code_option_class_name =='wp_radio'){
		var wp_radio_button_option = '<div class="row single_set_radio_button_remove"><div class="form-group col-md-10"><label for="text">Radio Button Field Name</label><input type="text" class="form-control label_name radio_button_child" id="text" placeholder="Enter text" name="label[]"></div><div class="col-md-2"><button class="add_more_radio_button btn btn-primary" id="'+iValue+'" type="button">Add</button></div></div><div class="wp_radio_button_Addmore'+iValue+'"></div>';
		jQuery(".wp_append_radio"+iValue).append(wp_radio_button_option);
		}
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
			jQuery("#wp_add_more1").click(function(e){
				e.preventDefault();
				var data = jQuery('#output').html(function(i, val) { return val*1+1 });
				var node = document.getElementById('output');
				var i  = node.textContent || node.innerText;
				// console.log(i);
				var append_add_more = '<div class="row wp_main_short_code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name "   id="text" placeholder="Enter text" ></div><div class="form-group  col-md-5"><label for="exampleSelect1">Field Type</label><select class="form-control wp_shot_add_shot_code_option field_type" style="height:34px;" id="'+i+'"><option value="text" class="wp_text">Text</option><option class="wp_email" value="email">Email</option><option class="wp_password" value="password">Password</option><option class="wp_checkbox" value="checkbox">Check Box</option><option class="wp_radio" value="radio">Radio Button</option><option class="" value="file">File Upload</option></select></div><div class="col-md-2"><button type="button" class="wp_main_short_code_remove btn btn-danger">Delete</button></div><div class="wp_append_checkbox'+i+'"></div><div class="wp_append_radio'+i+'"></div>';
			jQuery(".wp_single_set_short_code").append(append_add_more);
		i++
			});



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

	jQuery("body").on("click","#short_code_update",function(e){
		e.preventDefault();
	var short_code_id = jQuery("#sample_id").val();
	var output = [];
	var shot_code_name = jQuery("#shot_code_name").val();
	jQuery('.wp_main_short_code').each(function(){
	var temp_obj = {};
	var label_name = jQuery(this).find('.label_name').val();
	var field_type = jQuery(this).find('.field_type').val();
	var checkbox = jQuery(this).find('.checkbox_field_name').val();
	var radio_button_child = jQuery(this).find('.radio_button_child');	
	temp_obj.label_name = label_name;
	temp_obj.field_type = field_type;
	temp_obj.checkbox = checkbox;
	temp_obj.radio_button = radio_button_child;
	var checkbox_field = jQuery(this).find('.checkbox_field_name');	
	child = [];
	jQuery(checkbox_field).each(function(i,v){
		var value =  jQuery(v).val();
		child.push(value);
		});
	var radio_button_child = jQuery(this).find('.radio_button_child');	
	radio_child = [];
	jQuery(radio_button_child).each(function(i,v){
	var value =  jQuery(v).val();
	radio_child.push(value);
	});
	// temp_obj.shot_code_name = shot_code_name;
	temp_obj.radio_button = radio_child;
	temp_obj.checkbox = child;
	output.push(temp_obj);
    });
	var stringData = JSON.stringify({form_data:output,shortcode_name:shot_code_name});
	// 	console.log(stringData);
	jQuery.ajax({
		type: 'post',	
		url:ajaxurl,
		data: {
			action:"update_short_code_details",
			shot_code:stringData,short_code_id:short_code_id,
		},
		success: function(data) {
			// console.log(data);
		location. reload(true);

		},
		error: function(errorThrown){
		location. reload(true);

		} 
	});        
    // console.log(output);
});

		// jQuery("body").on("click",".Add_more_checkbox",function(){
		// 	var Ivalue = jQuery(this).attr('id');
		// 	console.log(Ivalue);
		// 	console.log("Hello Ragupathi");

		// 	// console.log(Ivalue);
		// 	// var wp_checkbox_options = '<div class="row single_set_checkbox_remove add_more_checkbox"><div class="form-group col-md-10"><label for="text">Checkbox Field Name</label><input type="text" class="form-control checkbox_field_name" id="text" placeholder="Enter text" name="checkbox_field_name[]"></div><div class="col-md-2"><button class="remove_check_box btn btn-danger">Delete</button></div></div>';
		// 	// jQuery(".wp_checkbox_Addmore"+Ivalue).append(wp_checkbox_options);
		// });




});
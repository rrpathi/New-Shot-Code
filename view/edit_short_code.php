<?php 
	
	$shortcode_form_input = $edit_short_code['string'];
	$data = json_decode(json_encode(unserialize($shortcode_form_input)),true);
	foreach($data['form_data'] as $key =>$value){
		$add_more_db_data .='<div class="row wp_main_short_code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name " value='.$value['label_name'].'  id="text" placeholder="Enter text" ></div><div class="form-group  col-md-5"><label for="exampleSelect1">Field Type</label><select class="form-control wp_shot_add_shot_code_option field_type"   style="height:34px;"><option value="text" '.($value['field_type'] =='text' ? 'selected' : '').'  class="wp_text">Text</option><option class="wp_email" value="email" '.($value['field_type'] =='email' ? 'selected' : '').' >Email</option><option class="wp_password" value="password" '.($value['field_type'] =='password' ? 'selected' : '').'>Password</option><option class="wp_checkbox" value="checkbox" '.($value['field_type'] =='checkbox' ? 'selected' : '').'>Check Box</option><option class="wp_radio" value="radio" '.($value['field_type'] =='radio' ? 'selected' : '').'>Radio Button</option><option class="" value="file" '.($value['field_type'] =='file' ? 'selected' : '').' >File Upload</option></select></div></div>'; 
	}
	echo '<div class="container">
	<form >
		<div class="form-group col-md-12">
			<label for="text">Shot Code Name</label>
			<input type="text" class="form-control" value='.$data['shortcode_name'].' required="" id="shot_code_name" placeholder="Enter text" name="shot_code_name">
		</div>
		<div class="wp_single_set_short_code">'.$add_more_db_data.'
		</div>
		<input type="button" id="wp_add_more" class="btn btn-default" value="Add More">
		<button type="submit" id="short_code_submit" class="btn btn-default">Submit</button> 
	</form>
</div>';
 ?>


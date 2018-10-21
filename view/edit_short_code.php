<?php 
	$short_code_id = $edit_short_code['id'];
	$shortcode_form_input = $edit_short_code['string'];
	$data = json_decode(json_encode(unserialize($shortcode_form_input)),true);
	$i = 0;$addMoreI=0;
	foreach($data['form_data'] as $key =>$value){
		$checkboxData = ''; $radioButtonData='';
		if($value['field_type']=='checkbox'){
			foreach ($value['checkbox'] as $key => $chechdat) {
				$checkboxData=$checkboxData.'<div class="row"><div class="form-group col-md-10"><label for="text">Checkbox Field Name</label><input type="text" class="form-control checkbox_field_name " value="'.$chechdat.'" id="text" placeholder="Enter text"></div></div>';
			}
			$checkboxData.='<div class="col-md-2"><button class="Add_more_checkbox btn btn-primary" id="'.$addMoreI.'" type="button">Add</button></div><div class="wp_checkbox_Addmore'.$addMoreI.'"></div>';
			
		}

		if($value['field_type']=='radio'){
			foreach ($value['radio_button'] as $key => $raddata) {
			$radioButtonData = $radioButtonData.'<div class="row"><div class="form-group col-md-10"><label for="text">Radio Button Field Name</label><input type="text" class="form-control label_name radio_button_child" id="text" value="'.$raddata.'" placeholder="Enter text" name="label[]"></div></div>';
			}
			$radioButtonData.='<div class="col-md-2"><button class="add_more_radio_button btn btn-primary" id="'.$addMoreI.'" type="button">Add</button></div><div class="wp_radio_button_Addmore'.$addMoreI.'"></div>';
		}
		$addMoreI++;


		$add_more_db_data .='<div class="row wp_main_short_code"><div class="form-group col-md-5"><label for="text">Label Name</label><input type="text" class="form-control label_name " value='.$value['label_name'].'  id="text" placeholder="Enter text" ></div><div class="form-group  col-md-5"><label for="exampleSelect1">Field Type</label><select class="form-control wp_shot_add_shot_code_option field_type" id='.$i.'  style="height:34px;"><option value="text" '.($value['field_type'] =='text' ? 'selected' : '').'  class="wp_text">Text</option><option class="wp_email" value="email" '.($value['field_type'] =='email' ? 'selected' : '').' >Email</option><option class="wp_password" value="password" '.($value['field_type'] =='password' ? 'selected' : '').'>Password</option><option class="wp_checkbox" value="checkbox" '.($value['field_type'] =='checkbox' ? 'selected' : '').'>Check Box</option><option class="wp_radio" value="radio" '.($value['field_type'] =='radio' ? 'selected' : '').'>Radio Button</option><option class="" value="file" '.($value['field_type'] =='file' ? 'selected' : '').' >File Upload</option></select>



		</div>

<div class="wp_append_radio'.$i.'">'.$radioButtonData.'</div>
<div class="wp_append_checkbox'.$i.'">'.$checkboxData.'</div>



		</div>'; 
		$i++;
	}
	echo '<div class="container">
	<form method="post" action="#">
		<div class="form-group col-md-12">
			<label for="text">Shot Code Name</label>
			<input type="text" class="form-control" value='.$data['shortcode_name'].' required="" id="shot_code_name" placeholder="Enter text" name="shot_code_name">
		</div>
		<div class="wp_single_set_short_code">'.$add_more_db_data.'
		</div>
		<div id="output" style="display:none">'.($i-1).'</div>
		<input type="hidden" value="'.$short_code_id.'" id="sample_id">
		<input type="button"  id="wp_add_more1" increment_id="" iValue='.$i.' class="btn btn-default" value="Add More">
		<button type="submit" id="short_code_update" class="btn btn-default">Submit</button> 
	</form>
</div>';
 ?>


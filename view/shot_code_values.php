<?php 
	global $wpdb;
	$table_name = $wpdb->prefix.'shortcode_values';
	$shot_code_list = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A);
?>
<div class="container">
	<h2>Short Code Datas</h2>
	<?php foreach ($shot_code_list as $key => $value) { $short_code_value_id = $value['id']?>
		<div class="panel-group" id="accordion<?php echo $key ?>">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion<?php echo $key ?>" href="#collapse<?php echo $key ?>">Short Code List <?php echo $key ?></a>
						<!-- <a href="#" id="delete_short_code_value" class="pull-right">Delete</a> -->
					</h4>
				</div>
				<div id="collapse<?php echo $key ?>" class="panel-collapse collapse in">
					<div class="panel-body">
						<?php $data = unserialize($value['shortcode_form_data']);
						// unset($data['register']); 
						$table_head = array_keys($data);
						$table_body	= array_values($data); ?>
						<table class="table">
							<thead><tr><?php foreach($table_head as $key =>$value){
							echo "<td>$value<td>";
							}?>
							<button class="pull-right btn btn-primary delete_short_code_value" id="<?php echo $short_code_value_id;?>">Delete</button>
							</tr></thead>
							<tbody><tr><?php foreach($table_body as $key =>$value){ if(is_array($value)){
								$value = implode(", ",$value);
								echo "<td>$value<td>";
							}else{

							echo "<td>$value<td>";
							}
							}?></tr></tbody>
						</table>
					</div>
				</div>
			</div>
		</div> 
	<?php }?>
</div>
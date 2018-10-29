<?php 
/*
Plugin Name:  WP Form Plugin
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Basic WordPress Plugin Header Comment
Version:      2.0
Author:       WordPress.org
Author URI:   https://developer.wordpress.org/
*/


// include_once 'vendor/autoload.php';
// use Kunnu\Dropbox\Dropbox;
// use Kunnu\Dropbox\DropboxApp;
// use Kunnu\Dropbox\DropboxFile;
// use Kunnu\Dropbox\Exceptions\DropboxClientException;
class DropboxUpload{
	// public $folder =  WP_CONTENT_DIR.'/to_upload';
	public function __construct(){
		$this->initial();
	}
	public function initial(){
		$this->pre_define();
		$this->hooks();
		$this->action();
		$this->apply_filter();
	}
	public function pre_define(){
		define('PLUGIN_DIR_URL',plugin_dir_url(__FILE__));
		define('PLUGIN_DIR_PATH',plugin_dir_path(__FILE__));
		// http://localhost/dropbox-wordpress/wp-content/plugins/Dropbox/
	}
	
	public function action(){
		add_action('init',array($this,'store_form_data'));
		add_action('admin_enqueue_scripts',array($this,'script'));
		add_action('wp_enqueue_scripts',array($this,'common_stylesheet'));

		// add_action('wp_ajax_add_dropbox_account_details',array($this,'credentials'));
		// add_action('wp_ajax_my_ajax_function',array($this,'dropbox_sdk'));
		add_action('wp_ajax_shot_code_register',array($this,'add_new_shotcode'));
		add_action('wp_ajax_edit_short_code',array($this,'edit_short_code'));
		add_action('wp_ajax_delete_short_code',array($this,'delete_short_code'));
		add_action('wp_ajax_update_short_code_details',array($this,'update_short_code_details'));
		add_filter('shot-code',array($this,'shot_code_callback'));
		add_action('wp_ajax_delete_short_code_value',array($this,'delete_short_code_value'));

		add_action('admin_menu',array($this,'menu'));
		// add_action( 'plugins_loaded', array($this,'speedup')); 
		add_action('admin_init', array($this,'speedup'));
		add_action('load-plugins.php',array($this,'plugin_notification'));
		add_action('wp_ajax_plugin_key_activation',array($this,'plugin_key_activation'));
	}
	public function plugin_notification(){
		add_action('admin_notices',array($this,'admin_notice_success'));
		
	}


	public function store_form_data(){
		if(isset($_POST['register'])){
			if(!empty($_FILES)){
				foreach($_FILES as $key=>$value){
					if(!empty($value['tmp_name'])){
						$tmp_name = $value['tmp_name'];
						$name = $value['name'];
						$dir   = PLUGIN_DIR_PATH."uploads/$name";
						$url  = PLUGIN_DIR_URL."uploads/$name";
						if(move_uploaded_file($tmp_name,$dir)){
							// $_POST["$key"] = $dir;
							$_POST["$key"] ='<a href='.$url.' target="_blank">'.$name.'</a>';
						}
					}
				}
			}
			global $wpdb;
			unset($_POST['register']);
			$table_name  = $this->db_prefix()."shortcode_values";
			$column_values = array('shortcode_form_data'=>serialize($_POST));
			$wpdb->insert($table_name,$column_values);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
			
		}
	}



	public function speedup(){

		add_filter('site_transient_update_plugins',array($this,'push_update'));

	}

	public function push_update($transient){
		if(empty(get_option('plugin_activation_key')) || (get_option('plugin_verification_status') !='1')){
			return $transient;
		}
		 $plugin_slug = basename(dirname(__FILE__)).'/'.basename(__FILE__);
		 $localplugin_version =  $transient->checked[$plugin_slug];
		// // Remote Url
		// // $url = plugin_dir_url(__FILE__).'info.json';
		$url = 'http://localhost/wp-form.json';
		$server_data = wp_remote_get( $url);
		$latest_plugin_version = json_decode($server_data['body']);
		$server_plugin_version = $latest_plugin_version->version;
		if($server_plugin_version >$localplugin_version){
			$res = new stdClass();
			// type casting
			$res->slug = $latest_plugin_version->slug;
			$res->new_version = $latest_plugin_version->version;
			$res->plugin = $plugin_slug;
			$res->package = $latest_plugin_version->download_url;
			$transient->response[$plugin_slug] = $res;
			return $transient;
		}else{
			return $transient;
		}
	}

	public function delete_short_code(){
		global $wpdb;
		$table_post = $this->db_prefix().'posts';
		$table_post_meta = $this->db_prefix().'postmeta';
		$result = $wpdb->delete( $table_post, array( 'id' =>$_POST['short_code_id']));
		$result = $wpdb->delete( $table_post_meta, array( 'post_id' =>$_POST['short_code_id']));
		if($result){
			echo json_encode(array('status'=>'1'));
			wp_die();
		}else{
			echo json_encode(array('status'=>'0'));
			wp_die();
			
		}
		
	}
	public function add_new_shotcode(){
		global $wpdb;
		$table_name = $this->db_prefix().'postmeta';
		$shot_code = json_decode(stripslashes($_POST['shot_code']));
		$form_array = serialize($shot_code);
		$post_title = $shot_code->shortcode_name;
		$post_content = str_replace(" ", "-",$shot_code->shortcode_name);
		$id = wp_insert_post(array('post_title'=>$post_title, 'post_type'=>'wps_custom_post', 'post_content'=>$post_content,'post_status' =>'publish'));
		$column_values = array('post_id'=>$id,'meta_key'=>$post_title,'meta_value'=>$form_array);
		$add_post_meta = $wpdb->insert($table_name,$column_values);
		if($add_post_meta){
			echo json_encode(array('status'=>'1'));
			wp_die();
		}else{
			echo json_encode(array('status'=>'0'));
			wp_die();
		}
		// if(add_post_meta( $id,$post_title, $form_array, false )){
		// 	echo json_encode(array('status'=>'1'));
		// 	wp_die();
		// }else{
		// 	echo json_encode(array('status'=>'0'));
		// 	wp_die();
		// }
	}
	public function menu(){
		add_menu_page('Form Page','Form','manage_options','create-form');
		add_submenu_page('create-form','Create Form','Add Shot Code','manage_options','create-form',array($this,'custome_form'));
		add_submenu_page('create-form','List Short Code','List Short Code','manage_options','list-shot-code',array($this,'list_shot_code'));
		add_submenu_page('create-form','Short Values','View Short Code Data','manage_options','view_short_code_value',array($this,'view_short_code_value'));

		// add_submenu_page('create-form','File Upload','Dropbox Upload','manage_options','dropbox_view',array($this,'dropbox_view'));

	}
	public function custome_form(){
		include PLUGIN_DIR_PATH.'view/custome_form.php';
	}
	public function list_shot_code(){
		include PLUGIN_DIR_PATH.'view/list_shot_code.php';
	}

	public function dropbox_view(){
		include PLUGIN_DIR_PATH.'view/upload.php';
	}
	public function script(){
		wp_enqueue_style( 'bootstrap.min.css',PLUGIN_DIR_URL.'css/bootstrap.min.css');
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'custome_style.css',PLUGIN_DIR_URL.'css/custome_style.css');
		wp_enqueue_script('bootstrap.min.js',PLUGIN_DIR_URL.'js/bootstrap.min.js');   
		wp_enqueue_script('custome.js',PLUGIN_DIR_URL.'js/custome.js');   
		wp_enqueue_script('form-js',PLUGIN_DIR_URL.'js/form.js');
		wp_enqueue_script('edit-short-code',PLUGIN_DIR_URL.'js/shortcode_edit.js');
		wp_enqueue_script('validation-js',PLUGIN_DIR_URL.'js/jquery.validate.js');
	}

	public  function common_stylesheet(){
		wp_enqueue_style( 'custome_style.css',PLUGIN_DIR_URL.'css/custome_style.css');
		
	}
	public function db_prefix(){
		global $wpdb;
		$this->wpdb = $wpdb;
		return $this->wpdb->prefix;
	}

	// public function shot_code_callback($value){
	// 	foreach ($value as $key => $stored_data) {
	// 		$shortcode[$stored_data['form_id']] = json_decode(json_encode(unserialize($stored_data['string'])),true);
	// 	}
	// 	return $shortcode;
	// }

	public function view_short_code_value(){
		include PLUGIN_DIR_PATH.'view/shot_code_values.php';
	}

 	public function apply_filter(){
        global $wpdb;
        // $table_name  = $this->db_prefix()."custome_form";
         $value = $wpdb->get_results('SELECT postmeta.meta_value,posts.post_content  FROM '.$wpdb->prefix.'postmeta AS postmeta  INNER JOIN '. $wpdb->prefix.'posts AS posts ON postmeta.post_id =  posts.id WHERE posts.post_type ="wps_custom_post"',ARRAY_A);

        if(!empty($value)){
            // $apply_filter = apply_filters('shot-code',$value);
            foreach ($value as $key => $stored_data) {
			$shortcode[$stored_data['post_content']] = json_decode(json_encode(unserialize($stored_data['meta_value'])),true);
			}
            foreach ($shortcode as  $shortcode_name => $shortcode_value) {
                unset($shortcode_value['shortcode_name']);
                add_shortcode($shortcode_name,function() use ($shortcode_value){
                foreach ($shortcode_value as $key => $new_value) {
                    foreach ($new_value as $key => $value) {
                    if($value['field_type'] =="radio"){
                    $result.=$value['label_name']."<br />";
                    foreach ($value['radio_button'] as $key => $radio_value) {
                    // $result .= "$radio_value:<input type='".$value['field_type']."' value='".$radio_value."' name='".str_replace(' ','',$value['label_name'])."'><br>";
                   $result .= "<label class='short_code_checkbox_inline'><input type='".$value['field_type']."' value='".$radio_value."' name='".str_replace(' ','',$value['label_name'])."' >$radio_value</label>";
                    }
                   $result .="<br />"; 
                    }
                    if(($value['field_type'] !="radio")&&($value['field_type'] !='checkbox')){
                    $label_name = $value['label_name'];
                    $type = $value['field_type'];
                    $result .= "$label_name:<input class='short_code_form_design' type='".$type."' name='".str_replace(' ','',$label_name)."'>";
                    // $result .= <label class="checkbox-inline"><input type="checkbox" value="">Option 1</label>
                    }
                    if($value['field_type']=='checkbox'){
                    $result.=$value['label_name']."<br />";
                    foreach ($value['checkbox'] as $key => $checkbox_name) {
                    // $result .= "$checkbox_name<input type='".$value['field_type']."' value='".$checkbox_name."' class='short_code_checkbox_inline' name='".str_replace(' ','',$value['label_name'])."[]'><br>";
                    $result .= "<label class='short_code_checkbox_inline'><input type='".$value['field_type']."' value='".$checkbox_name."' name='".str_replace(' ','',$value['label_name'])."[]' >$checkbox_name</label>";
                    	}
                    }
                    $result .="<br />"; 
                    }
                }
                echo "<form action='#' method='POST' id='form_data' enctype='multipart/form-data'>
                $result.<br /><input type='submit' id='store_form_value' name='register'>
                </form>";
                });
            }
        }
    }
	

	public function hooks(){
		register_activation_hook(__FILE__,array($this,'activation_table'));
		register_deactivation_hook( __FILE__,array($this,'deactivation_hook'));
		// __FILE__  current file location (index.php)
	}

	public function deactivation_hook(){
		$this->delete_options();
		global $wpdb;
		// $table_name  = $this->db_prefix()."dropbox_details";
		// $table_name_short_code = $this->db_prefix()."custome_form";
		$shortcode_values = $this->db_prefix()."shortcode_values";
		$wpdb->query("TRUNCATE TABLE $table_name ");
		$wpdb->query("TRUNCATE TABLE $table_name_short_code ");
		$wpdb->query("TRUNCATE TABLE $shortcode_values ");
	}

	public function activation_table(){
		$this->add_options();
		$shortcode_values = $this->db_prefix()."shortcode_values";
		$sql2 ="CREATE TABLE `$shortcode_values` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`shortcode_form_data` varchar(500) NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql2 );
	}
		// ABSPATH is current project Directory dropbox-wordpress
	public function edit_short_code(){
		global $wpdb;
		$table_name = $this->db_prefix().'postmeta';
		$edit_short_code = $wpdb->get_results('SELECT *  FROM '.$wpdb->prefix.'postmeta AS postmeta  INNER JOIN '. $wpdb->prefix.'posts AS posts ON postmeta.post_id =  posts.id WHERE posts.post_type ="wps_custom_post" AND postmeta.post_id ='.$_POST['short_code_id'] ,ARRAY_A)[0];
		if(!empty($edit_short_code)){
			include PLUGIN_DIR_PATH.'view/edit_short_code.php';
			wp_die();
		}
		
	}

	public function update_short_code_details(){
		global $wpdb;
		// echo $short_code_id;
		$table_name = $this->db_prefix().'postmeta';
		$shot_code = json_decode(stripslashes($_POST['shot_code']));
		$form_array = serialize($shot_code);
		$short_code_id = $_POST['short_code_id'];
		$post_title = $shot_code->shortcode_name;
		$post_content = str_replace(" ", "-",$shot_code->shortcode_name);
		$column_values = array('meta_key'=>$shortcode_name,'meta_value'=>$form_array);
		$where = array('post_id'=>$short_code_id);
		$shotcode = $wpdb->update($table_name,$column_values,$where);
		 $my_post = array('ID'=> $short_code_id,'post_title'=>$post_title,'post_content' => $post_content);
  		wp_update_post( $my_post );


		if($shotcode){
			echo json_encode(array('status'=>'1'));
			wp_die();
		}else{
			echo json_encode(array('status'=>'0'));
			wp_die();
		}
	}



	public function delete_short_code_value(){
		global $wpdb;
		$table_name = $this->db_prefix().'shortcode_values';
		$delete = $wpdb->delete($table_name, array( 'id' =>$_POST['shortcode_value_id']));
		if($delete){
			echo json_encode(array('status'=>'1'));
			wp_die();
		}else{
			echo json_encode(array('status'=>'0'));
			wp_die();
		}
	}

		public function admin_notice_success(){
			echo '<div class="notice notice-success is-dismissible"><p style="text-align:center";><strong>Activation Key:</strong><input  type="text" id="activation_key" ><input style="margin-left:10px" type="submit" name="submit" id="activate_button" class="button button-primary" value="Acivate Code"></p></div>';
			// echo '<div class=""><input type="text" name="first_name" id="first_name" value="" class="regular-text"></div>';
		// if(!empty(get_option('plugin_activation_key')) && (get_option('plugin_verification_status') !='1')){
		// 	echo '<div class="updated" style="text-align: center; display:block !important; "><p style="color: green; font-size: 14px; font-weight: bold;">Plugin Activation Key : <span style="color:black;"> '.get_option("plugin_activation_key").'</span></p><button id="plugin_activation_key" class="button button-primary">Activate</button></div>';
		// }else{
		// 	echo '<div class="updated" style="text-align: center; display:block !important; "><p style="color: green; font-size: 14px; font-weight: bold;">Plugin Activated Successfully - '.get_option("plugin_activation_key").'</div>';


		// }
	}

	public function add_options(){
		add_option('plugin_activation_key',sha1(uniqid()));
		add_option('plugin_verification_status','0');
	}	
	public function delete_options(){
		delete_option('plugin_activation_key');
		delete_option('plugin_verification_status');
	}

	public function plugin_key_activation(){
		$activation_key = $_POST['activation_key'];
		$communication_key = get_option('communication_key');
		$url = 'http://localhost/response_check.php';
		$response = wp_remote_post( $url, array(
		'method' => 'POST',
		'timeout' => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => true,
		'headers' => array(),
		'body' => array( 'username' => 'bob', 'password' => '1234xyz' ),
		'cookies' => array()
		)
		);

		echo "<pre>";
		print_r($response);
	}

	


	// public function update_short_code_details(){
	// 		 global $wpdb;
	// 	 $shot_code = json_decode(stripslashes($_POST['update_short_code_details']));
	// 	 $shortcode_name = $shot_code->shortcode_name;
	// 	 $shortcode_id = $shot_code->short_code_id;
	// 	 $new_label_data['label_name'] = $shot_code->label_name;
	// 	 $new_field_data['field_name'] = $shot_code->field_name;
	// 	 foreach ($new_label_data as $key => $value) {
	// 	 	foreach ($value as $key => $label_value) {
	// 	 		$newlabel_value[] = $label_value; 
	// 	 	}
	// 	 }
	// 	  foreach ($new_field_data as $key => $value) {
	// 	 	foreach ($value as $key => $field_value) {
	// 	 		$newfield_value[] = $field_value; 
	// 	 	}
	// 	 }
		 
	// 	$form_array = serialize(array_combine(array_filter($newlabel_value),array_filter($newfield_value)));
	// 	if(!empty($form_array) && !empty($shortcode_name)){
	// 		$column_values = array('form_id'=>$shortcode_name,'string'=>$form_array);
	// 		$where = array('id'=>$shortcode_id);
	// 		$table_name = $this->db_prefix().'custome_form';
	// 		$update = $wpdb->update($table_name,$column_values,$where);
	// 		if($update){
	// 			echo json_encode(array('status'=>'1'));
	// 			wp_die();
	// 		}else{
	// 			echo json_encode(array('status'=>'0'));
	// 			wp_die();
	// 		}
	// 	}else{
	// 		echo json_encode(array('status'=>'0'));
	// 			wp_die();
	// 	}
		
	// }

		// public function credentials(){
	// 	unset($_POST['action']);
	// 	global $wpdb;
	// 	function example_callback($string){
	// 		return array('app_key' =>'2qc3n2l4gqwb7uc','app_secret'=>'v7k9uce68lf85ch','access_token'=>'pUmE_WvIvEAAAAAAAAABHrijcymlbi0ed8vh5m3U5ua9pQhgGVVLkv23YlZAvDeD');
	// 	}
	// 	add_filter( 'example_filter', 'example_callback',10,1);
	// 	$sample = apply_filters( 'example_filter', $_POST);
	// 	$table_name = $this->db_prefix().'dropbox_details';
	// 	$insert = $wpdb->insert($table_name,$sample);
	// 	if($insert){
	// 		echo json_encode(array('status'=>'1'));
	// 		wp_die();
	// 	}else{
	// 		echo json_encode(array('status'=>'0'));
	// 		wp_die();
	// 	}
	// 	// die();
	// }
	// public function dropbox_sdk(){
	// 	$dir  = $this->folder;
	// 	$option =$this->folder;
	// 	return $this->recursiveScan($dir,$option); 
	// }

		// public function recursiveScan($dir,$option){
	// 	global $wpdb;
	// 	$table_name = $this->db_prefix().'dropbox_details';
	// 	$data = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A)[0];
	// 	$app = new DropboxApp($data['app_key'],$data['app_secret'],$data['access_token']);
	// 	$dropbox = new Dropbox($app);
	// 	$tree = glob(rtrim($dir, '/') . '/*');
	// 	if (is_array($tree)) {
	// 		foreach($tree as $file) {
	// 			if(is_file($file)){
	// 				$folder_file_name = str_replace($option, '', $file);
	// 				$file = new DropboxFile($file);
	// 				$uploadedFile = $dropbox->upload($file,$folder_file_name);
	// 				if($uploadedFile){
	// 				}
	// 			}elseif (is_dir($file)) {
	// 				$this->recursiveScan($file,$option);
	// 			}
	// 		}
	// 	}
	// }

}
$obj = new DropboxUpload();
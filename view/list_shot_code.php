<?php
global $wpdb;
// $table_name = $wpdb->prefix . 'custome_form';
// $shot_code_list = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
   $shot_code_list = $wpdb->get_results('SELECT posts.id as id, postmeta.meta_value,posts.post_content  FROM '.$wpdb->prefix.'postmeta AS postmeta  INNER JOIN '. $wpdb->prefix.'posts AS posts ON postmeta.post_id =  posts.id WHERE posts.post_type ="wps_custom_post"',ARRAY_A);

if (!empty($shot_code_list)) { ?>
    <div class="container show-form-hide">
      <div class="response"></div>
      <h2>Shot Code List</h2>
        <a href="admin.php?page=create-form" class="btn btn-primary">Add New Shot Code</a>
      <table class="table">
        <thead>
          <tr>
          <th>Shot Code Name</th>
          <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
    foreach ($shot_code_list as $key => $value) { ?>
            <tr>
            <td><?php echo $value['post_content'] ?></td>
            <td>
              <a class="btn btn-primary edit_short_code" value="<?php echo $value['id'] ?>" href="#">Edit</a>
              <a class="btn btn-danger delete_short_code" value="<?php echo $value['id'] ?>" href="#">Delete</a></td>
            </tr>
          <?php
    }
?>
        </tbody>
      </table>
    </div>
  <?php
} else {
    echo '<a href="admin.php?page=create-form" class="btn btn-primary">Add New Shot Code</a>';
    echo "<h1>No Shot Code Found</h1>";
}
?>
<div class="edit-form"></div>

<!-- <a class="btn btn-primary edit_short_code" value="<?php echo $value['id'] ?>" href="#">Edit</a> -->
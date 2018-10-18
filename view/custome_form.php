<!-- <body>
<div class="container">
  <center><h2>Create New Short Code</h2></center>
      <div class="form-group col-md-12">
      <label for="text">Shot Code Name</label>
      <input type="text" class="form-control" id="shot_code_name" placeholder="Enter text" name="shot_code_name">
    </div>
    <div class="form-group col-md-6">
      <label for="text">Label Name</label>
      <input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]">
    </div>
    <div class="form-group col-md-6">
      <label for="pwd">Field Name</label>
      <input type="text" class="form-control field_name" id="field" placeholder="text,password" name="field[]">
    </div>
    <div class="custome_form"></div>
    <center><input type="button" id="add_more" class="btn btn-default" value="Add More">
    <button type="submit" id="submit" class="btn btn-default">Submit</button></center>
</div>
</body>
</html>
 -->

<body>
<div class="container">
  <form id="ShortCodeForm_validate">
  <div class="form-group col-md-12">
    <label for="text">Shot Code Name</label>
    <input type="text" class="form-control" required="" id="shot_code_name" placeholder="Enter text" name="shot_code_name">
  </div>
  <div class="wp_single_set_short_code">
    <!-- <div class="form-group col-md-6">
      <label for="text">Label Name</label>
      <input type="text" class="form-control label_name" id="text" placeholder="Enter text" name="label[]">
    </div>
    <div class="form-group  col-md-6">
      <label for="exampleSelect1">Field Type</label>
      <select class="form-control wp_shot_add_shot_code_option" id="exampleSelect1" style="height: 34px;">
      <option class="wp_text">Text</option>
      <option class="wp_email">Email</option>
      <option class="wp_password">Password</option>
      <option class="wp_checkbox">Check Box</option>
      <option class="wp_radio">Radio Button</option>
      </select>
    </div> -->
  </div>
  
  <input type="button" id="wp_add_more" class="btn btn-default" value="Add More">
  <button type="submit" id="short_code_submit" class="btn btn-default">Submit</button> 
  </form>
</div>


</body>
<?php
    include_once(ROOT_PATH.'system/header-footer/data.php');
    include_once(ROOT_PATH.'system/admin/user-management/profile/service.php');
?>
<?php
    main_header();

    @$user_account = $query->get_user($_GET['id']);
    @$user_position = $query->get_position();
    //var_dump($user_account);
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">

          <!-- /widget -->
         <div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>USER MANAGEMENT > PROFILE</h3>
                <a class="btn btn-small pull-right back-btn" href="<?php echo root_url()?>system/admin/user-management  " role="button"><i class="fa fa-arrow-alt-circle-left"></i> BACK</a>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">
          <div class="container" style="">
            <div class="row">
              <div class="span3">
                <div id="user_profile_update_picture">

                  <img src="<?php echo root_url()?>/assets/img/user/<?php echo @!empty($user_account->Image_file) ? $user_account->Image_file : "no_photo_available.png"; ?>" width="250" alt="user" style="border: solid 1px black; padding: 5px;">

                </div>
                  <div class="upload-btn-wrapper">
                    <button class="btn-upload">Upload a photo</button>
                    <form id="user_picture_form" method="post" enctype="multipart/form-data">
                      <input class="file-upload" type="file" id="user_picture" name="user_picture" accept="image/png, image/jpeg" />
                      <input type="text" class="form-control" name="User_id" value="<?php echo $user_account->ID;?>" style="display:none" />
                      <input type="text" class="form-control" name="from" value="admin-user-management-profile" style="display:none" />
                      <input type="text" class="form-control" name="action" value="update-user-picture" style="display:none" />
                    </form>
                  </div>
                <p id="picture_message">Must have a 600x600 pixels and 5MB maximum and PNG or JPEG file format, otherwise won't upload.</p>
              </div>
              <div class="span4" style="margin-left:5%;">
                <div class="control-group">
                  <label class="control-label" for="  ">Status:</label>
                  <div class="controls">
                    <input type="text" class="span4 " id="user_profile_update_status" style="color: <?php echo (@$user_account->Active==1)? "green" : "red"?>; font-weight:bold;"value="<?php echo (@$user_account->Active==1)? "ACTIVE" : "DEACTIVATED -  ".date("F j, Y  g:i A", strtotime(@$user_account->Datetime_deactivated))?>" readonly>
                  </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                  <label class="control-label" for=" ">Position:</label>
                  <div class="controls">
                    <select class="select span4" id="user_profile_update_position_id" >
                      <option value="0">Select position</option>
                      <?php foreach($user_position as $item){?>
                      <option value="<?php echo $item->ID;?>" <?php echo ($user_account->User_position_id ==  $item->ID)? "selected" : "";?> ><?php echo $item->Position;?></option>
                      <?php }?>
                    </select>
                  </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                  <label class="control-label" for="  ">First name:</label>
                  <div class="controls">
                    <input type="text" class="span4 " id="user_profile_update_first_name" value="<?php echo @$user_account->First_name?>" >
                  </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                  <label class="control-label" for="  ">Middle name:</label>
                  <div class="controls">
                    <input type="text" class="span4 " id="user_profile_update_middle_name" value="<?php echo @$user_account->Middle_name?>" >
                  </div> <!-- /controls -->
                </div> <!-- /control-group -->
              </div>

              <div class="span4">
              <div class="control-group">
                  <label class="control-label" for="  ">Last name:</label>
                  <div class="controls">
                    <input type="text" class="span4 " id="user_profile_update_last_name" value="<?php echo @$user_account->Last_name?>" >
                  </div> <!-- /controls -->
                </div> <!-- /control-group -->
                <div class="control-group">
                  <label class="control-label" for="">Date of birth:</label>
                  <div class="controls">
                    <input type="date" class="span4 " id="user_profile_update_date_of_birth" value="<?php echo @$user_account->Date_of_birth?>" >
                  </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
									<label class="control-label">Gender:</label>
                    <div class="controls">

                    <label class="radio inline">
                      <input type="radio" name="sex" <?php echo (@$user_account->Sex=="Male") ? "checked" : "unchecked" ?> value="Male"> Male
                    </label>

                    <label class="radio inline">
                      <input type="radio" name="sex"  <?php echo (@$user_account->Sex=="Female") ? "checked" : "unchecked" ?> value="Female"> Female
                    </label>

                  </div>	<!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                  <label class="control-label" for="">Phone number:</label>
                  <div class="controls">
                    <input type="text" class="span4 " id="user_profile_update_phone_number" value="<?php echo @$user_account->Phone_number?>" >
                  </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <button class="btn btn-success pull-right" id="update_user_details" style="margin-left:12%;"><i class="fa fa-save"></i> UPDATE USER DETAILS </button>
                <button class="btn btn-<?php echo (@$user_account->Active==0)? "success" : "danger"?> pull-left" id="user_deactivition"><i class="fa fa-<?php echo (@$user_account->Active==0)? "check" : "ban"?>"></i>  <?php echo (@$user_account->Active==0)? "ACTIVATE" : "DEACTIVATED" ?> </button>

              </div>
            </div>
          </div>

					</div> <!-- /widget-content -->

				</div> <!-- /widget -->
        </div>
        <!-- /span6 -->
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /main-inner -->
</div>
<!-- /main -->
<?php
    main_footer ();
?>

<?php 
    include_once(ROOT_PATH.'system/header-footer/data.php');
?>
<?php 
    main_header();
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">

          <div class="widget widget-nopad">
              <div class="widget-header"> 
                <h3> <i class="fa fa-user-cog"></i> USER ACCOUNT SETTINGS</h3>
              </div>
              <!-- /widget-header -->
              <div class="widget-content">

                
                    <div class="widget-content">
                      
                    <fieldset class="form-horizontal" style="margin-top:2% !important;">

                    <div class="control-group">											
                      <label class="control-label"><b>Change password</b> </label>
              

                    </div> <!-- /control-group -->
                    <hr>  
                    <div class="control-group">											
                      <label class="control-label" for="old-password">Old password:</label>
                      <div class="controls">
                        <input type="password" class="span10 " id="old-password" value="" autofocus>
                      </div> <!-- /controls -->				
                    </div> <!-- /control-group -->


                    <div class="control-group">											
                      <label class="control-label" for="new-password">New password:</label>
                      <div class="controls">
                        <input type="password" class="span10 " id="new-password" value="" autofocus>
                      </div> <!-- /controls -->				
                    </div> <!-- /control-group -->

                    <div class="control-group">											
                      <label class="control-label" for="retype-new-password">Retype new password:</label>
                      <div class="controls">
                        <input type="password" class="span10 " id="retype-new-password" value="" autofocus>
                      </div> <!-- /controls -->				
                    </div> <!-- /control-group -->

                    <button class="btn btn-success pull-right" style="margin-bottom:2%; margin-right:3%;" id="change_password"><i class="fa fa-edit"></i> SUBMIT</button>
                </fieldset>

                </div>
              </div>
          </div>

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


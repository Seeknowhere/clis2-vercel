<?php 
    include_once(ROOT_PATH.'system/header-footer/data.php');
    include_once(ROOT_PATH.'system/laboratory/patient-records/patient-details/service.php');
?>
<?php 
    main_header();
    @$patient_record = $query->get_patient_record($_GET['id']);
    $get_labtest = $query->get_labtest($_GET['id']);
    // var_dump($get_labtest);
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
	      				<h3>LABORATORY > PATIENT RECORD (VIEW ONLY)</h3>
                <a class="btn btn-small pull-right back-btn" href="<?php echo root_url()?>system/laboratory/patient-records  " role="button"><i class="fa fa-arrow-alt-circle-left"></i> BACK</a>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
          <div class="container" style="">
            <div class="row">
              
              <div class="span3" style="margin-left:13%;">
                <div class="control-group">											
                  <label class="control-label" for="  ">First name:</label>
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_first_name" disabled value="<?php echo @$patient_record->First_name?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                  <label class="control-label" for="  ">Middle name:</label> 
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_middle_name" disabled value="<?php echo @$patient_record->Middle_name?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                  <label class="control-label" for="  ">Last name:</label> 
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_last_name" disabled value="<?php echo @$patient_record->Last_name?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->
              </div>

              <div class="span3">
                
                <div class="control-group">											
                  <label class="control-label" for="">Age:</label>
                  <div class="controls">
                    <input type="number" class="span3 "  disabled value="<?php echo floor((time() - strtotime(@$patient_record->Date_of_birth)) / 31556926)?>" readonly >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                  <label class="control-label" for="">Date of birth:</label>
                  <div class="controls">
                    <input type="date" class="span3 " id="patient_record_update_date_of_birth"  disabled value="<?php echo @$patient_record->Date_of_birth?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">
									<label class="control-label">Gender:</label>
                    <div class="controls">
                    
                    <label class="radio inline">
                      <input type="radio" name="sex" disabled <?php echo (@$patient_record->Sex=="Male") ? "checked" : "unchecked" ?> value="Male"> Male
                    </label>
                    
                    <label class="radio inline">
                      <input type="radio" name="sex" disabled <?php echo (@$patient_record->Sex=="Female") ? "checked" : "unchecked" ?> value="Female"> Female
                    </label>

                  </div>	<!-- /controls -->
                </div> <!-- /control-group -->

              </div>
              <div class="span3 ">

              <div class="control-group">											
                  <label class="control-label" for="">Phone number:</label>
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_phone_number"  disabled value="<?php echo @$patient_record->Phone_number?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                  <label class="control-label" for="  ">Email Address:</label> 
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_email_address" disabled value="<?php echo @$patient_record->Email_address?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                  <label class="control-label" for="  ">Date and time created:</label> 
                  <div class="controls">
                    <input type="text" class="span3 "  disabled value="<?php echo date("F j, Y  g:i A", strtotime(@$patient_record->Datetime_created))?>" readonly >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->
              
              </div>
            </div>
          </div>
        
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->
        </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
       <div class="row">
        <div class="span12">
          <!-- /widget -->
         <div class="widget ">
	      			<div class="widget-header">
	      				<i style="position: relative; left:15px; margin-right:10px;" class="fas fa-tasks"></i>
	      				<h3>SEARCH RECENT LABORATORY TEST RESULT</h3>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
          <div class="container" style="">
              <div class="span11  " >
                <fieldset class="form-horizontal">
                    <div class="control-group">											
                      <label class="control-label" for="search_patient">Lab test:</label>
                      <div class="controls">
                        <input type="text" class="" id="patient_id" value="<?=$_GET['id'];?>" style="display:none">

                        <select class="span9 " name="" id="search_lab_logs">
                          <option value="">Select lab test</option>
                          <?php foreach($get_labtest as $item){?>
                            <option value="<?=$item->ID.','.$item->lab_id?>"><?=@$item->Abbreviation?></option>
                          <?php }?>
                        </select>
                      </div> 
                      <!-- /controls -->				
                    </div> <!-- /control-group -->  
                    <table class="table table-striped table-bordered action-table" id="patient-search-result-table" hidden>
                      <thead>
                        <tr>
                          <th> Exam </th>
                          <th> Coordinate </th>
                          <th> Result </th>
                          <th> Date created </th>
                        </tr>
                      </thead>
                      <tbody id="patient-lab-result">
                      </tbody>
                    </table>
                </fieldset>
            </div>
          </div>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
        </div>
        <!-- /span12 --> 
      </div>
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


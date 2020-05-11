<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/header-footer/data.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/reception/patient-details/service.php');
?>
<?php 
    main_header();

    @$patient_record = $query->get_patient_record($_GET['id']);
    @$patient_medical_history = $query->get_patient_medical_history($_GET['id']);
    @$patient_transaction_logs = $query->get_patient_transaction_logs($_GET['id']);
    // var_dump($patient_transaction_logs);
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
	      				<h3>RECEPTION > PATIENT RECORD</h3>
                <a class="btn btn-small pull-right back-btn" href="<?php echo root_url()?>system/reception  " role="button"><i class="fa fa-arrow-alt-circle-left"></i> BACK</a>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
          <div class="container" style="">
            <div class="row">
              
              <div class="span3" style="margin-left:13%;">
                <div class="control-group">											
                  <label class="control-label" for="  ">First name:</label>
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_first_name" value="<?php echo @$patient_record->First_name?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                  <label class="control-label" for="  ">Middle name:</label> 
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_middle_name" value="<?php echo @$patient_record->Middle_name?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                  <label class="control-label" for="  ">Last name:</label> 
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_last_name" value="<?php echo @$patient_record->Last_name?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->
              </div>

              <div class="span3">
                
                <div class="control-group">											
                  <label class="control-label" for="">Date of birth:</label>
                  <div class="controls">
                    <input type="date" class="span3 " id="patient_record_update_date_of_birth" value="<?php echo @$patient_record->Date_of_birth?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">
									<label class="control-label">Gender:</label>
                    <div class="controls">
                    
                    <label class="radio inline">
                      <input type="radio" name="sex" <?php echo (@$patient_record->Sex=="Male") ? "checked" : "unchecked" ?> value="Male"> Male
                    </label>
                    
                    <label class="radio inline">
                      <input type="radio" name="sex"  <?php echo (@$patient_record->Sex=="Female") ? "checked" : "unchecked" ?> value="Female"> Female
                    </label>

                  </div>	<!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">											
                  <label class="control-label" for="">Phone number:</label>
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_phone_number" value="<?php echo @$patient_record->Phone_number?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
              
              </div>
              <div class="span3 ">
                <div class="control-group">											
                  <label class="control-label" for="  ">Email Address:</label> 
                  <div class="controls">
                    <input type="text" class="span3 " id="patient_record_update_email_address" value="<?php echo @$patient_record->Email_address?>" >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                  <label class="control-label" for="  ">Date and time created:</label> 
                  <div class="controls">
                    <input type="text" class="span3 " value="<?php echo date("F j, Y  g:i A", strtotime(@$patient_record->Datetime_created))?>" readonly >
                  </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <button class="btn btn-success pull-right" id="update_patient_details" style="margin-left:12%; margin-top:15%"><i class="fa fa-save"></i> UPDATE PATIENT DETAILS </button>

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
	      				<i style="position: relative; left:15px; margin-right:10px;" class="fas fa-history"></i>
	      				<h3>PATIENT MEDICAL LABORATORY HISTORY</h3>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
          <div class="container" style="">
              <div class="span11  " >
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> Transaction number </th>
                      <th> Laboratory test </th>
                      <th> Status </th>
                      <th> Mode of test </th>
                      
                      <th class="th-actions"> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(empty($patient_medical_history)) {?>
                      <tr>
                        <td colspan="7"> NO MEDICAL HISTORY FOUND</td>
                      </tr>
                    <?php } else {?>
                      <?php foreach($patient_medical_history as $key => $item) {?>
                        <tr>
                          <td> <?php echo ($key+1) ?></td>
                          <td > <?php echo ($item->Transaction_number) ?></td>
                          <td> <?php echo @strtoupper($item->Abbreviation).' ('.$item->Description.')' ?></td>
                          <td> <?php echo @strtoupper($item->Status) ?></td>
                          <td> 
                            <?php if($item->Mode_of_test_id==2){?>
                            <?php echo @strtoupper($item->Mode).' ('.$item->Package_name.')' ?>
                            <?php } else {?>
                              <?php echo @strtoupper($item->Mode) ?>
                            <?php }?>
                          </td>
                          <td class="td-actions" style="width: 136px">  
                            <button class="btn btn-small btn-success reprint-receipt"  data-transaction-number="<?php echo $item->Transaction_number?>"><i class="fa fa-print"></i> RE-PRINT RECEIPT</button>
                          </td>
                        </tr>
                      <?php }?>
                    <?php }?>
                  </tbody>
                </table>
            </div>
          </div>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
        </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
       <!-- /row --> 
       <div class="row">
        <div class="span12">
          <!-- /widget -->
         <div class="widget ">
	      			<div class="widget-header">
	      				<i style="position: relative; left:15px; margin-right:10px;" class="fas fa-tasks"></i>
	      				<h3>PATIENT TRANSACTION LOGS</h3>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
          <div class="container" style="">
              <div class="span11  " >
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> User-in-charge</th>
                      <th> Position-in-charge</th>
                      <th> Transaction number </th>
                      <th> Laboratory test </th>
                      <th> Status </th>
                      <th> Mode of test </th>
                      <th> Date and time created</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(empty($patient_transaction_logs)) {?>
                      <tr>
                        <td colspan="8"> NO TRANSACTION LOG FOUND</td>
                      </tr>
                    <?php } else {?>
                      <?php foreach($patient_transaction_logs as $key => $item) {?>
                        <tr>
                          <td> <?php echo ($key+1) ?></td>
                          <td > <?php echo strtoupper(@$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name)  ?></td>
                          <td > <?php echo strtoupper(@$item->Position) ?></td>
                          <td > <?php echo (@$item->Transaction_number) ?></td>
                          <td> <?php echo @strtoupper($item->Abbreviation).' ('.$item->Description.')' ?></td>
                          <td> <?php echo @strtoupper($item->Status) ?></td>
                          <td> 
                            <?php if($item->Mode_of_test_id==2){?>
                            <?php echo @strtoupper($item->Mode).' ('.$item->Package_name.')' ?>
                            <?php } else {?>
                              <?php echo @strtoupper($item->Mode) ?>
                            <?php }?>
                          </td>
                          <td> <?php echo date("F j, Y  g:i A", strtotime(@$item->Datetime_created)) ?></td>
                          
                        </tr>
                      <?php }?>
                    <?php }?>
                  </tbody>
                </table>
            </div>
          </div>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
        </div>
        <!-- /span12 --> 
      </div>
      <!-- /row -->
       <!-- Modal -->
      <div id="reprint_receipt" class="modal hide fade modal-extra-width modal-print-receipt receipt-fade-in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">RECEIPT AND PATIENT NAME: <span id="requesting_receipt_patient_name"></span></h3>
        </div>

        <div class="modal-body modal-body-print-receipt">
          <iframe id="load_reprint_receipt" height="700" width="100%"></iframe>
        </div>

        <div class="modal-footer">  
          <div class="row">
            <div class="span5">
              &nbsp;                      
            </div>
            <div class="span4">
              <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
              <button class="btn btn-primary request_patient_btn"><i class="fa fa-print"></i>Print receipt</button> -->
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<?php 
    main_footer ();
?>


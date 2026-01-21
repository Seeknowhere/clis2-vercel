  <?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/header-footer/data.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/laboratory/transaction/service.php');
?>
<?php 
    main_header();

    @$get_request_lab_transaction = $query->get_request_lab_transaction();
    @$get_ongoing_lab_transaction = $query->get_ongoing_lab_transaction();
    @$get_release_lab_transaction = $query->get_release_lab_transaction();
    @$get_pickup_lab_transaction = $query->get_pickup_lab_transaction();

    @$count_request_lab_transaction = count($get_request_lab_transaction);
    @$count_ongoing_lab_transaction = count($get_ongoing_lab_transaction);
    @$count_release_lab_transaction = count($get_release_lab_transaction);
    @$count_pickup_lab_transaction = count($get_pickup_lab_transaction);

    

    // var_dump($_SESSION['user_data']);
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">

         <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> DAILY OPERATION MONITORING</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                    <div class="stat stat-lab " data-id="1"> LAB REQUEST <i class="fa fa-paper-plane"></i> <span class="value"><?php echo $count_request_lab_transaction?></span> </div>
                    <!-- .stat -->
                    <div class="stat stat-lab " data-id="2"> LAB ONGOING <i class="fas fa-sync"></i> <span class="value"><?php echo $count_ongoing_lab_transaction?></span> </div>
                    <!-- .stat -->
                    <div class="stat stat-lab stat-lab-active" data-id="3"> LAB RELEASE <i class="icon-bullhorn"></i> <span class="value"><?php echo $count_release_lab_transaction?></span> </div>
                    <!-- .stat --> 
                    <div class="stat stat-lab" data-id="4"> PATIENT PICK UP <i class="icon-bullhorn"></i> <span class="value"><?php echo $count_pickup_lab_transaction?></span> </div>
                    <!-- .stat --> 
                  </div>
                </div>
                <!-- /widget-content --> 
              </div>
            </div>
          </div>
          <!-- /widget -->
         <div class="widget" id="widget-content">
	      			
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3><span id="request_type_label"></span> PATIENT RECORD </h3>
                <button type="button " class="pull-right close-table-daily-operation-monitoring">×</button>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
          <table class="table table-striped table-bordered action-table" id="lab-request-patient" hidden>
              <thead>
                <tr>
                  <th> # </th>
                  <th> Patient name </th>
                  <th> Status </th>
                  <th> Mode of test </th>
                  <th> Request type </th>
                  <th class="td-actions"> </th>
                </tr>
              </thead>
              <tbody>
               <?php if(empty($count_request_lab_transaction)) {?>
                  <tr>
                    <td colspan="6"> NO REQUEST FOUND</td>
                  </tr>
                <?php } else {?>
                <?php foreach($get_request_lab_transaction as $key => $item) {?>
                    <tr>
                      <td> <?php echo ($key+1) ?></td>
                      <td> <?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?></td>
                      <td> <?php echo @strtoupper($item->Status) ?></td>
                      <td> 
                        <?php if($item->Mode_of_test_id==2){?>
                        <?php echo @strtoupper($item->Mode).' ('.$item->Package_name.')' ?>
                        <?php } else {?>
                          <?php echo @strtoupper($item->Mode) ?>
                        <?php }?>
                      </td>
                      <td> <?php echo ($item->Abbreviation) ?></td>
                      <td class="td-actions">
                        <button class="btn btn-small btn-success confirming" data-confirm-type="accept" data-lab-test-id="<?php echo $item->Lab_test_id?>" data-patient-id="<?php echo $item->Patient_id?>" data-lab-test-id="<?php echo $item->Lab_test_id?>" data-patient-name="<?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-check"></i> ACCEPT</button>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>

            <table class="table table-striped table-bordered action-table" id="lab-ongoing-patient" hidden>
              <thead>
                <tr>
                  <th> # </th>
                  <th> Patient name </th>
                  <th> Status </th>
                  <th> Mode of test </th>
                  <th> Request type </th>
                  <th class="td-actions"> </th>
                </tr>
              </thead>
              <tbody>
              <?php if(empty($count_ongoing_lab_transaction)) {?>
                  <tr>
                    <td colspan="6"> NO ONGOING FOUND</td>
                  </tr>
                <?php } else {?>
                  <?php foreach($get_ongoing_lab_transaction as $key => $item) {?>
                    <tr>
                      <td> <?php echo ($key+1) ?></td>
                      <td> <?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?></td>
                      <td> <?php echo @strtoupper($item->Status) ?></td>
                      <td> 
                        <?php if($item->Mode_of_test_id==2){?>
                        <?php echo @strtoupper($item->Mode).' ('.$item->Package_name.')' ?>
                        <?php } else {?>
                          <?php echo @strtoupper($item->Mode) ?>
                        <?php }?>
                      </td>
                      <td> <?php echo ($item->Abbreviation) ?></td>
                      <td class="td-actions td-more-actions">
                        <!-- <button class="btn btn-small btn-default redo" data-redo-type="accept" data-patient-id="<?php echo $item->Patient_id?>" data-lab-test-id="<?php echo $item->Lab_test_id?>" data-patient-name="<?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-redo"></i> REDO</button> -->
                        <button class="btn btn-small btn-success lab_release" data-lab-test-id="<?php echo $item->Lab_test_id?>" data-patient-id="<?php echo $item->Patient_id?>" data-lab-test-id="<?php echo $item->Lab_test_id?>" data-patient-name="<?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-edit"></i> EDIT</button>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>

            <table class="table table-striped table-bordered action-table" id="lab-release-patient" >
              <thead>
                <tr>
                  <th> # </th>
                  <th> Patient name </th>
                  <th> Status </th>
                  <th> Mode of test </th>
                  <th> Request type </th>
                  <th class="td-actions"> </th>
                </tr>
              </thead>
              <tbody>
                <?php if(empty($count_release_lab_transaction)) {?>
                  <tr>
                    <td colspan="6"> NO RELEASE FOUND</td>
                  </tr>
                <?php } else {?>
                  <?php foreach($get_release_lab_transaction as $key => $item) {?>
                    <tr>
                      <td> <?php echo ($key+1) ?></td>
                      <td> <?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?></td>
                      <td> <?php echo @strtoupper($item->Status) ?></td>
                      <td> 
                        <?php if($item->Mode_of_test_id==2){?>
                        <?php echo @strtoupper($item->Mode).' ('.$item->Package_name.')' ?>
                        <?php } else {?>
                          <?php echo @strtoupper($item->Mode) ?>
                        <?php }?>
                      </td>
                      <td> <?php echo ($item->Abbreviation) ?></td>
                      <td class="td-actions" style="width:300px !important">
                        <button class="btn btn-small btn-default redo" data-redo-type="ongoing" data-patient-id="<?php echo $item->Patient_id?>" data-lab-test-id="<?php echo $item->Lab_test_id?>" data-patient-name="<?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-redo"></i> REDO</button>
                        <button class="btn btn-small btn-primary lab_ready_to_pick_up_preview" data-patient-name="<?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?>" data-patient-id="<?php echo $item->Patient_id?>"  data-lab-test-id="<?php echo $item->Lab_test_id?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-eye"></i> PREVIEW</button>
                        <!-- <button class="btn btn-small btn-success notify" data-patient-id="<?php echo $item->Patient_id?>"  data-lab-test-id="<?php echo $item->Lab_test_id?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-bell"></i> NOTIFY</button> -->
                        <button class="btn btn-small btn-success lab_ready_to_pick_up" data-patient-id="<?php echo $item->Patient_id?>"  data-lab-test-id="<?php echo $item->Lab_test_id?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-download"></i> DOWNLOAD</button>
                        <!-- <button class="btn btn-small btn-success lab_ready_to_pick_up" data-patient-id="<?php echo $item->Patient_id?>"  data-lab-test-id="<?php echo $item->Lab_test_id?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-print"></i> PRINT</button> -->
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>

            <table class="table table-striped table-bordered action-table" id="lab-pickup-patient" hidden>
              <thead>
                <tr>
                  <th> # </th>
                  <th> Patient name </th>
                  <th> Status </th>
                  <th> Mode of test </th>
                  <th> Request type </th>
                </tr>
              </thead>
              <tbody>
                <?php if(empty($count_pickup_lab_transaction)) {?>
                  <tr>
                    <td colspan="6"> NO RELEASE FOUND</td>
                  </tr>
                <?php } else {?>
                  <?php foreach($get_pickup_lab_transaction as $key => $item) {?>
                    <tr>
                      <td> <?php echo ($key+1) ?></td>
                      <td> <?php echo @$item->First_name.' '.@$item->Middle_name.' '.@$item->Last_name ?></td>
                      <td> <?php echo @strtoupper($item->Status) ?></td>
                      <td> 
                        <?php if($item->Mode_of_test_id==2){?>
                        <?php echo @strtoupper($item->Mode).' ('.$item->Package_name.')' ?>
                        <?php } else {?>
                          <?php echo @strtoupper($item->Mode) ?>
                        <?php }?>
                      </td>
                      <td> <?php echo ($item->Abbreviation) ?></td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
            <input type="text" class="span5" id="medtech" value="<?=$_SESSION['user_data']->First_name.' '.$_SESSION['user_data']->Middle_name.' '.$_SESSION['user_data']->Last_name?>" style="display:none">
            <!-- Modal -->
            <div id="patient_releasing_modal" class="modal hide fade lab-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">PATIENT NAME: <span id="releasing_patient_name"></span></h3>
              </div>
              <div class="modal-body" style="max-height:70vh !important; margin-left:5%;">
   
                  <!-- <div class="form-vertical" id="lab-test-template" style="height:550px ; width :100%;"></div> -->
                  <div id="lab-test-template" ></div>

              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary confirming" data-confirm-type="release">Submit</button>
              </div>
            </div>

              <!-- Modal -->
              <div id="patient_releasing_modal_preview" class="modal hide fade modal-extra-width-template lab-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">PATIENT NAME: <span id="releasing_patient_name_preview"></span></h3>
              </div>
              <div class="modal-body modal-body-lab-template">
                <div id="lab-test-template-preview" style="height:50vh ; width :99%;"></div> 
                <!-- <div id="lab-test-template-preview-new" style="height:50vh ; width :99%;"></div>   -->

              </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-small btn-success" id="print_excel" ><i class="fa fa-print"></i> PRINT</button> -->
              </div>
            </div>
            
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
            <!-- <button class="btn btn-primary " id="test-test">test</button>
            <div class="form-vertical" id="ss" style="height:550px ; width :100%; margin:10px;"></div> -->
          
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 

    <!-- Modal -->
    <div id="redo_modal" class="modal hide fade" style="width:500px;left:52%" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">PATIENT NAME: <span id="redo_process_patient_name"></span></h3>
      </div>
      
      <div class="modal-body ">
          <span style="font-size:14px;">To continue this action, only admin has an authorized to proceed it. </span>
      <hr>
          <div class="control-group">											
            <label class="control-label" for="  ">Username:</label> 
            <div class="controls">
              <input type="text" class="span5" id="redo_username_authorize"  >
            </div> <!-- /controls -->				
          </div> <!-- /control-group -->
          <div class="control-group">											
            <label class="control-label" for="  ">Password:</label> 
            <div class="controls">
              <input type="password" class="span5" id="redo_username_password" >
            </div> <!-- /controls -->				
          </div> <!-- /control-group -->
      </div>

      <div class="modal-footer">  
        <button class="btn btn-success proceed_redo" ><i class="fa fa-check"></i> PROCEED</button>
      </div>
    </div>

    <!-- Modal -->
    <div id="confirmation_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">PATIENT NAME: <span id="confirmation_patient_name"></span></h3>
      </div>

      <div class="modal-body ">
        <span id="confirmation_message" style="font-size:15px;"></span>
      </div>

      <div class="modal-footer">  
        <button class="btn btn-success proceed_confirm"><i class="fa fa-check"></i> PROCEED [ENTER]</button>
      </div>
    </div>
    
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<?php 
    main_footer ();
?>  
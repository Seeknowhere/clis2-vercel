<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/header-footer/data.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/reception/service.php');
?>
<?php 
    main_header();

    @$single_test = $query->get_lab_transaction_single_test();
    @$package_test = $query->get_lab_transaction_single_package();

    @$get_request_lab_transaction = $query->get_request_lab_transaction();
    @$get_ongoing_lab_transaction = $query->get_ongoing_lab_transaction();
    @$get_release_lab_transaction = $query->get_release_lab_transaction();
    @$get_pickup_lab_transaction = $query->get_pickup_lab_transaction();

    @$count_request_lab_transaction = count($get_request_lab_transaction);
    @$count_ongoing_lab_transaction = count($get_ongoing_lab_transaction);
    @$count_release_lab_transaction = count($get_release_lab_transaction);
    @$count_pickup_lab_transaction = count($get_pickup_lab_transaction);

?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
<!-- 
         <h1>reception- patient records(new or existing) </h1>
         <h1>reception- view number of request in daily </h1>
         <h1>reception- view number of ongoing in daily </h1>
         <h1>reception- view number of release in daily </h1>
         <h1>reception- request to lab </h1>
         <h1>reception- recieve result from lab </h1>
         <h1>reception- select package promo  </h1>
         <h1>reception- billing </h1> -->

         <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> DAILY OPERATION MONITORING</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                    <div class="stat stat-lab" data-id="1"> LAB REQUEST <i class="fa fa-paper-plane"></i> <span class="value"><?php echo $count_request_lab_transaction?></span> </div>
                    <!-- .stat -->
                    <div class="stat stat-lab" data-id="2"> LAB ONGOING <i class="fas fa-sync"></i> <span class="value"><?php echo $count_ongoing_lab_transaction?></span> </div>
                    <!-- .stat -->
                    <div class="stat stat-lab" data-id="3"> LAB RELEASE <i class="icon-bullhorn"></i> <span class="value"><?php echo $count_release_lab_transaction?></span> </div>
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
          <div class="widget" id="widget-content" hidden>
	      			
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
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>

            <table class="table table-striped table-bordered action-table" id="lab-release-patient" hidden>
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
                  <th class="td-actions"> </th>
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
                      <td class="td-actions">
                        <button class="btn btn-small btn-success patient_pick_up" data-patient-id="<?php echo $item->Patient_id?>" data-lab-transaction-id="<?php echo $item->Lab_transaction_id?>"><i class="fa fa-check"></i> VIEW</button>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>

					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->

          <!-- /widget -->
         <div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>PATIENT RECORD</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li ><a href="#new-patient-record" data-toggle="tab">NEW</a></li>
						  <li class="active"><a href="#existing-patient-record" data-toggle="tab">EXISTING</a></li>
						</ul>
						
						<br>


						
							<div class="tab-content">

								<div class="tab-pane  " id="new-patient-record">

									<fieldset class="form-horizontal">
                    
                      <div class="control-group">											
                        <label class="control-label" for="new_patient_first_name">First name:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_patient_first_name" value="" autofocus>
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_patient_middle_name">Middle name:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_patient_middle_name" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_patient_last_name">Last name:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_patient_last_name" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->
                         
                      <div class="control-group">											
											<label class="control-label">Gender:</label>
                        <div class="controls">
                        <label class="radio inline">
                          <input class="gender" type="radio" name="sex" value="Male"> Male
                        </label>
                        
                        <label class="radio inline">
                          <input class="gender" type="radio" name="sex" value="Female"> Female
                        </label>
                      </div>	<!-- /controls -->			
										</div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_patient_date_of_birth">Date of birth:</label>
                        <div class="controls">
                          <input type="date" class="span10 " id="new_patient_date_of_birth" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_patient_phone_number">Phone number:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_patient_phone_number" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  

                      <div class="control-group">											
                        <label class="control-label" for="new_patient_email_address">Email Address:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_patient_email_address" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  
                      <button class="btn btn-success pull-right" id="new_patient"><i class="fa fa-folder-plus"></i> ADD PATIENT RECORD</button>
									</fieldset>

								</div>
								
								<div class="tab-pane active" id="existing-patient-record">
										<fieldset class="form-horizontal">
                      <div class="control-group">											
                        <label class="control-label" for="search_patient">Search patient:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="search_patient" value="" placeholder="Search by patient name">
                          <!-- <button class="btn btn-success span2  pull-right" id="search_patient_btn"><i class="fas fa-search"></i> SEARCH</button> -->
                        </div> 
                        <!-- /controls -->				
                      </div> <!-- /control-group -->  
                      <table class="table table-striped table-bordered action-table" id="patient-search-result-table" hidden>
                        <thead>
                          <tr>
                            <th> Patient name </th>
                            <th> Gender </th>
                            <th> Age </th>
                            <th> Date of birth </th>
                            <th class="td-actions"> </th>
                          </tr>
                        </thead>
                        <tbody id="patient-search-result-value">
                        </tbody>
                      </table>
										</fieldset>
								</div>
							</div>

                <!-- Modal -->
                <div id="patient_request_modal" class="modal hide fade modal-extra-width" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">PATIENT NAME: <span id="requesting_patient_name"></span></h3>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                        <div class="form-vertical">
                            <div class="span5">
                              <div class="control-group">											
                                <label class="control-label" for="request_type">REQUEST TYPE:</label>
                                <label class="checkbox">
                                  <input type="checkbox" value="1" id="check_package_test"> Check to view package test:
                                </label>
                                <hr>
                                
                                <div id="single_test">
                                  <?php foreach($single_test as $key=>$item){?>
                                    <label class="checkbox">
                                      <input type="checkbox" class="bill_test checkbox_single_lab_test"  data-mode-of-test-id="1" data-lab-test-id="<?php echo $item->ID?>" data-lab-test-cost="<?php echo $item->Price?>" data-lab-test="<?php echo '₱'.$item->Price.' - '.$item->Abbreviation.' ('.$item->Description.')'?>  " value="<?php echo $item->ID?>"><?php echo '₱'.$item->Price.' - '.$item->Abbreviation.' ('.$item->Description.')'?>
                                    </label>
                                  <?php }?> 
                                </div>

                            <div id="package_test" hidden>
                              <table class="table table-striped table-bordered action-table">
                                    <thead>
                                      <tr>
                                        <th> #</th>
                                        <th> Package name </th>
                                        <th> List of test</th>
                                        <th> Cost</th>
                                      </tr>
                                    </thead>
                                    <tbody> 

                                    <?php foreach($package_test as $key=> $item1){?>
                                      <tr>
                                        <td><?php echo ($key+1)?></td>
                                        <td>
                                        <label class="checkbox">
                                          <input type="checkbox" class="bill_test checkbox_package_lab_test" data-mode-of-test-id="2" data-lab-test="<?php echo $item1->Package_name?>" data-lab-test-cost="<?php echo $item1->Price?>" value="<?php echo $item1->ID?>"><?php echo $item1->Package_name?>
                                        </label>
                                        </td>
                                        <td>
                                          <ol id="package-lab-test-<?php echo $item1->ID?>">
                                            <?php foreach($item1->Package_list_test as $key=> $item2){?>
                                              <li>
                                                <?php echo $item2->Abbreviation?>
                                              </li>
                                            <?php }?>
                                          </ol>
                                        </td>
                                        <td><?php echo $item1->Price?></td>
                                      </tr>
                                  <?php }?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                              <div class="span4">
                                <h3>BILL SUMMARY:</h3>
                                    <div id="bill_summary">
                                    
                                    </div>
                              </div>
                            </div> 
                        </div>

                  </div>
                  <div class="modal-footer">
                    <div class="row">
                      <div class="span5">
                        &nbsp;                      
                      </div>
                      <div class="span4">
                        <h3 style="float:left; display: inline-block">TOTAL BILL: ₱<span id="total_bill">0</span> </h3>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button class="btn btn-primary request_patient_btn"><i class="fas fa-money-bill"></i> Bill</button>
                        <!-- <a href="#view_receipt" role="button" class="btn btn-primary request_patient_btn" data-toggle="modal"><i class="fa fa-money"></i> Bill out</a> -->
                      </div>
                    </div>
                  </div>
                </div>


                 <!-- Modal -->
                 <div id="view_receipt" class="modal hide fade modal-extra-width modal-print-receipt receipt-fade-in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">RECEIPT AND PATIENT NAME: <span id="requesting_receipt_patient_name"></span></h3>
                  </div>

                  <div class="modal-body modal-body-print-receipt">
                    <iframe id="load_receipt" height="700" width="100%"></iframe>
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


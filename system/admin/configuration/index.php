<?php 
    include_once(ROOT_PATH.'system/header-footer/data.php');
    include_once(ROOT_PATH.'system/admin/configuration/service.php');
?>
<?php 
    main_header();
    @$user_position = $query->get_position();

    @$get_request_lab_transaction = $query->get_request_lab_transaction();
    @$get_ongoing_lab_transaction = $query->get_ongoing_lab_transaction();
    @$get_release_lab_transaction = $query->get_release_lab_transaction();
    @$get_pickup_lab_transaction = $query->get_pickup_lab_transaction();

    @$count_request_lab_transaction = count($get_request_lab_transaction);
    @$count_ongoing_lab_transaction = count($get_ongoing_lab_transaction);
    @$count_release_lab_transaction = count($get_release_lab_transaction);
    @$count_pickup_lab_transaction = count($get_pickup_lab_transaction);

    @$get_clinic_test = $query->get_clinic_test();


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
                    <div class="stat stat-lab" data-id="1"> REQUEST <i class="fa fa-paper-plane"></i> <span class="value"><?php echo $count_request_lab_transaction?></span> </div>
                    <!-- .stat -->
                    <div class="stat stat-lab" data-id="2"> ONGOING <i class="fas fa-sync"></i> <span class="value"><?php echo $count_ongoing_lab_transaction?></span> </div>
                    <!-- .stat -->
                    <div class="stat stat-lab" data-id="3"> RELEASE <i class="icon-bullhorn"></i> <span class="value"><?php echo $count_release_lab_transaction?></span> </div>
                    <!-- .stat --> 
                    <div class="stat stat-lab" data-id="4"> PICK UP <i class="icon-bullhorn"></i> <span class="value"><?php echo $count_pickup_lab_transaction?></span> </div>
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

					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->


          <!-- /widget -->
         <div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-cogs"></i>
	      				<h3>CONFIGURATION</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
              <li ><a href="#add-clinic-test" data-toggle="tab">ADD LAB TEST</a></li>
              <li ><a href="#add-clinic-package-test" data-toggle="tab">ADD LAB PACKAGE TEST</a></li>
              <li class="active"><a href="#list-of-clinic-test" data-toggle="tab">LIST OF LAB TEST</a></li>
              <li ><a href="#list-of-clinic-package-test" data-toggle="tab">LIST OF LAB PACKAGE TEST</a></li>
						</ul>
						
						<br>
						
            <div class="tab-content">
                <div class="tab-pane" id="add-clinic-test">
                  <fieldset class="form-horizontal">
                  <form id="lab_test_form" action="<?php echo root_url()?>system/admin/configuration/service.php" method="post" enctype="multipart/form-data">
                    <div class="control-group">											
                        <label class="control-label" for="new_clinic_test">Enter test:</label>
                        <div class="controls">
                          <input type="text" class="span10 " name="Abbreviation" id="new_add_test_abbreviation" placeholder="Enter a abbreviation (If possible (E.g. HBsAg or CBC))">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  

                      <div class="control-group">											
                        <label class="control-label" for="new_clinic_test">Enter description:</label>
                        <div class="controls">
                          <input type="text" class="span10 " name="Description" id="new_add_test_description" placeholder="Enter a description (If possible (E.g. Hepatitis B Surface Antigen or Complete Blood Count ))">

                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  

                      <div class="control-group">											
                        <label class="control-label" for="new_clinic_test">Enter test cost:</label>
                        <div class="controls">
                          <input type="number" class="span10 " name="Cost" id="new_add_test_cost" placeholder="Enter a test cost">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  

                      <div class="control-group">											
                        <label class="control-label" for="new_clinic_test">Upload excel file:</label>
                        <div class="controls">
                        <input type="file" class="custom-file-input" name="Template" accept="*">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  

                        <input type="text" name="from" value="admin-configuration" style="display:none" />
                        <input type="text" name="action" value="add-clinic-test" style="display:none" />
                        <input  class="btn btn-success" type="submit" value="Upload" style="display:none">
                      </form>
                          
                        <button class="btn btn-success span2  pull-right" id="new_clinic_test_btn"><i class="fas fa-plus"></i> ADD TEST</button>

                  </fieldset>
								</div>
						
                <div class="tab-pane" id="add-clinic-package-test">
                  <fieldset class="form-horizontal">

                      <div class="control-group">											
                        <label class="control-label" for="new_clinic_test">Enter package test:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_add_clinic_package_test" placeholder="Enter package test">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  
                      
                      <div class="control-group">											
                        <label class="control-label" for="new_clinic_test">Enter price:</label>
                        <div class="controls">
                          <input type="number" class="span10 " id="new_add_clinic_package_price" placeholder="Enter package price">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  
        
                      <div class="control-group">											
											  <label class="control-label">Check test:</label>             
                        <div class="controls">
                            
                            <?php foreach($get_clinic_test as $key=>$item){?>
                 
                                <label class="checkbox">
                                  <input type="checkbox" class="checkbox_clinic_test" value="<?php echo $item->ID?>" data-price="<?php echo $item->Price?>"><?php echo '₱'.number_format($item->Price,2,'.','').' - '.$item->Abbreviation.' ('.$item->Description.')'?>
                                </label>
                  
                            <?php }?> 

    
                        </div>		<!-- /controls -->	
                      	
										</div> <!-- /control-group -->

                    <div class="control-group">											
                      <label class="control-label" for="new_clinic_package_raw_price">Total raw price:</label>
                      <div class="controls">
                      ₱<b id="package_raw_price">0.00</b>
                      </div> <!-- /controls -->				
                    </div> <!-- /control-group -->  

                        <button class="btn btn-success span3  pull-right" id="new_clinic_package_test_btn" style="margin-bottom:1%;"><i class="fas fa-plus"></i> ADD PACKAGE TEST</button>

                  </fieldset>
								</div>

                <div class="tab-pane active" id="list-of-clinic-test">

										<fieldset class="form-horizontal">

                      <div class="control-group">											
                        <label class="control-label" for="search_clinic_test">Search:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="search_clinic_test" value="">
                          <!-- <button class="btn btn-success span2  pull-right" id="search_clinic_test_btn"><i class="fas fa-search"></i> SEARCH</button> -->
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  
                      <hr>

                      <table class="table table-striped table-bordered action-table" id="clinic-test-result-table" hidden>
           
                        <thead>
                          <tr>
                            <th> #</th>
                            <th> List of clinic test (Abbreviation) </th>
                            <th> Description</th>
                            <th> Cost</th>
                            <th> Available</th>
                            <th> Date created</th>
                            <th class="td-actions"> </th>
                          </tr>
                        </thead>

                        <tbody id="clinic-test-result-value">
                         
                        </tbody>
                      </table>
										</fieldset>

								</div>



                <div class="tab-pane  " id="list-of-clinic-package-test">

										<fieldset class="form-horizontal">

                      <div class="control-group">											
                        <label class="control-label" for="search_clinic_package_test">Search:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="search_clinic_package_test" value="">
                          <!-- <button class="btn btn-success span2  pull-right" id="search_clinic_package_test_btn"><i class="fas fa-search"></i> SEARCH</button> -->
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  
                      <hr>
                      <table class="table table-striped table-bordered action-table" id="clinic-package-test-result-table" hidden>
                        <thead>
                          <tr>
                            <th> #</th>
                            <th> Package name </th>
                            <th> List of test</th>
                            <th> Cost</th>
                            <th> Available</th>
                            <th> Date created</th>
                            <!-- <th class="td-actions"> </th> -->
                          </tr>
                        </thead>
                        <tbody id="clinic-package-test-result-value"> 
                         
                        </tbody>
                      </table>
										</fieldset>

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


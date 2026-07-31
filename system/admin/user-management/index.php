<?php 
    include_once(ROOT_PATH.'system/header-footer/data.php');
    include_once(ROOT_PATH.'system/admin/user-management/service.php');
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
	      				<i class="icon-user"></i>
	      				<h3>USER MANAGEMENT</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li ><a href="#new-user" data-toggle="tab">ADD USER</a></li>
              <li ><a href="#user-position" data-toggle="tab">USER POSITION</a></li>
						  <li class="active"><a href="#list-of-user" data-toggle="tab">LIST OF USER</a></li>
						</ul>
						
						<br>
						
							<div class="tab-content">

								<div class="tab-pane  " id="new-user">

									<fieldset class="form-horizontal">
                    <div class="control-group">											
                        <label class="control-label" for="new_user_username">Username:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_user_username" value="" autofocus>
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_user_password">Password:</label>
                        <div class="controls">
                          <input type="password" class="span10 " id="new_user_password" value="" autofocus>
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->
                      <hr>
                      <div class="control-group">											
                        <label class="control-label" for="new_user_first_name">First name:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_user_first_name" value="" autofocus>
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_user_middle_name">Middle name:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_user_middle_name" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_user_last_name">Last name:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_user_last_name" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->
                         
                      <div class="control-group">											
                        <label class="control-label" for="new_user_position">Position:</label>
                        <div class="controls">
                          <select class="select" id="new_user_position" >
                            <option value="0">Select position</option>
                            <?php foreach($user_position as $item){?>
                            <option value="<?php echo $item->ID;?>"><?php echo $item->Position;?></option>
                            <?php }?>
                          </select>
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->

                      <div class="control-group">											
											<label class="control-label">Gender:</label>
                        <div class="controls">
                        <label class="radio inline">
                          <input type="radio"  name="sex" value="Male"> Male
                        </label>
                        
                        <label class="radio inline">
                          <input type="radio" name="sex" value="Female"> Female
                        </label>
                      </div>	<!-- /controls -->
										</div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_user_date_of_birth">Date of birth:</label>
                        <div class="controls">
                          <input type="date" class="span10 " id="new_user_date_of_birth" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->

                      <div class="control-group">											
                        <label class="control-label" for="new_user_phone_number">Phone number:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="new_user_phone_number" value="">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  

                      <button class="btn btn-success pull-right" id="new_user"><i class="fa fa-user-plus"></i> ADD USER ACCOUNT</button>
									</fieldset>

								</div>
								
                <div class="tab-pane" id="user-position">

										<fieldset class="form-horizontal">

                      <div class="control-group">											
                        <label class="control-label" for="search_user_position">Search:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="search_user_position" value="">
                          <!-- <button class="btn btn-success span2  pull-right" id="search_user_position_btn"><i class="fas fa-search"></i> SEARCH</button> -->
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  
                      <hr>
                      <div class="control-group">											
                        <label class="control-label" for="new_add_user_position">Enter new position:</label>
                        <div class="controls">
                          <input type="text" class="span8 " id="new_add_user_position" >
                          <button class="btn btn-success span2  pull-right" id="new_user_position_btn"><i class="fas fa-plus"></i> ADD POSITION</button>
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  

                      <table class="table table-striped table-bordered action-table" id="user-position-search-result-table" hidden>
                        <thead>
                          <tr>
                            <th> List of postion </th>
                            <th class="td-actions"> </th>
                          </tr>
                        </thead>
                        <tbody id="user-position-search-result-value">
                         
                        </tbody>
                      </table>
										</fieldset>

								</div>

								<div class="tab-pane active" id="list-of-user">

										<fieldset class="form-horizontal">
                      <div class="control-group">											
                        <label class="control-label" for="search_user">Search:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="search_user" placeholder="Search by username">
                          <!-- <button class="btn btn-success span2  pull-right" id="search_user_btn"><i class="fas fa-search"></i> SEARCH</button> -->
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->
                      
                      <table class="table table-striped table-bordered action-table" id="user-search-result-table" hidden>
                        <thead>
                          <tr>
                            <th> Username</th>
                            <th> Full name </th>  
                            <th> Position </th>
                            <th> Status </th>
                            <th class="td-actions"> </th> 
                          </tr>
                        </thead>
                        <tbody id="user-search-result-value">
                          
                        </tbody>
                      </table>
										</fieldset>

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


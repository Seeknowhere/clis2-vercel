<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/header-footer/data.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/laboratory/test-supply/service.php');
?>
<?php 
    main_header();

    @$get_lab_test = $query->get_lab_test();

    @$test = $query->get_template();

    // var_dump($test->Json); 

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

         <!-- <h1>laboratory- patient records</h1>
         <h1>laboratory- view number of request in daily </h1>
         <h1>laboratory- view number of ongoing in daily </h1>
         <h1>laboratory- view number of release in daily </h1>
         <h1>laboratory- request reception to lab </h1>
         <h1>laboratory- send patient result to reception </h1> -->

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
        <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-beaker"></i>
              <h3> LABORATORY TEST</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <table class="table table-striped table-bordered action-table">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th> Laboratory test name</th>
                        <th> Cost </th>
                        <th> Available</th>
                        <th> Date created</th>
                        <th class="td-actions td-more-actions"> </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(empty($get_lab_test)) {?>
                        <tr>
                          <td colspan="6"> NO LABORATORY TEST FOUND</td>
                        </tr>
                      <?php } else {?>
                        <?php foreach($get_lab_test as $key => $item) {?>
                          <tr>
                            <td> <?php echo ($key+1) ?></td>
                            <td> <?php echo @$item->Abbreviation.' ('.@$item->Description.')' ?></td>
                            <td> <?php echo @$item->Price ?></td>
                            <td> <?php echo (@$item->Available==1) ? "YES" : "NO" ?></td>
                            <td> <?php echo @strtoupper($item->Datetime_created) ?></td>
                            <td class="td-actions">
                              <?php if(@$item->Available==1){?>
                                <button class="btn btn-small btn-danger supply_status" data-id="<?php echo $item->ID?>" data-available="<?php echo $item->Available?>" ><i class="fa fa-ban"></i> UNAVAILABLE</button>
                              <?php }else{ ?>
                                <button class="btn btn-small btn-success supply_status" data-id="<?php echo $item->ID?>" data-available="<?php echo $item->Available?>" ><i class="fa fa-check"></i> AVAILABLE</button>
                              <?php }?>
                            </td>
                          </tr>
                        <?php }?>
                      <?php }?>
                    </tbody>
                  </table>
                </div>
                <!-- /widget-content --> 
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


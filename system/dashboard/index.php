<?php
    include_once(ROOT_PATH.'system/header-footer/data.php');
    include_once(ROOT_PATH.'system/dashboard/service.php');
?>
<?php
    main_header();

    @$get_total_sales_daily = $query->generate_total_sales_daily();

    @$get_request_lab_transaction = $query->get_request_lab_transaction();
    @$get_ongoing_lab_transaction = $query->get_ongoing_lab_transaction();
    @$get_release_lab_transaction = $query->get_release_lab_transaction();
    @$get_pickup_lab_transaction = $query->get_pickup_lab_transaction();

    @$count_request_lab_transaction = count($get_request_lab_transaction);
    @$count_ongoing_lab_transaction = count($get_ongoing_lab_transaction);
    @$count_release_lab_transaction = count($get_release_lab_transaction);
    @$count_pickup_lab_transaction = count($get_pickup_lab_transaction);

    @$total_income = 0;

    // var_dump($_SESSION['user_data']->User_position_id);
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
         <!-- <h1>Dashboard - overview of operation</h1>
         <h1>Dashboard - daily income</h1>
         <h1>Dashboard - stats(number of request, number of ongoing with remarks, number of pick up</h1> -->

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
                      <td> <?php echo ($item->Abbreviation) ?></td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>

					</div> <!-- /widget-content -->

				</div> <!-- /widget -->

  <?php if ($_SESSION['user_data']->User_position_id==1){?>


        <div class="widget widget-nopad">
            <div class="widget-header"> <i class=" icon-money"></i>
              <h3> INCOME as of <?php echo date('l jS \of F Y')?></h3>
            </div>
                <!-- /widget-header -->
                <div class="widget-content">

                <table class="table table-striped table-bordered action-table" style="margin-bottom:0px;" >
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> LAB TEST </th>
                      <th> COST </th>
                      <th> QUANTITY </th>
                      <th> AMOUNT </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(empty($get_total_sales_daily)) {?>
                      <tr>
                        <td colspan="6"> UNAVAILABLE TEST TODAY</td>
                      </tr>
                    <?php } else {?>
                      <?php foreach($get_total_sales_daily as $key => $item) {?>
                        <tr>
                          <td> <?php echo ($key+1) ?></td>
                          <td> <?php echo @$item->Abbreviation.' '.'('.$item->Description.')  ' ?></td>
                          <td> <?php echo '₱'.@$item->Price ?></td>
                          <td> <?php echo @$item->Quantity ?></td>
                          <td> <?php echo '₱'.@$item->Income ?></td>
                          <?php $total_income+=$item->Income ?>
                        </tr>
                      <?php }?>
                      <tr >
                          <td colspan="4"> <b>TOTAL INCOME</b> </td>
                          <td> <b><?php echo '₱'.$total_income;?></b></td>
                        </tr>
                    <?php }?>
                  </tbody>
                </table>
                </div>
              </div>
              <!-- /widget -->

					</div> <!-- /widget-content -->

				</div> <!-- /widget -->
                <?php }?>

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

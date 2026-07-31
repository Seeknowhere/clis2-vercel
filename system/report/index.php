<?php 
    include_once(ROOT_PATH.'system/header-footer/data.php');
    include_once(ROOT_PATH.'system/report/service.php');
?>
<?php 
    main_header();
    @$lab_test_list = $query->get_lab_test_list();
    // var_dump($lab_test_list);

?>
<div class="main">
  <div class="main-inner">
    <div class="container">
          <!-- /widget -->
          <div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-graph"></i>
	      				<h3>GENERATE REPORT</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li class="active"><a href="#lab-test" data-toggle="tab">LAB TEST</a></li>
              <!-- <li ><a href="#sent-out" data-toggle="tab">SENT OUT</a></li> -->
						</ul>
						
						<br>
						
							<div class="tab-content">

								<div class="tab-pane active" id="lab-test">

                  <div class="row">
                      <div class="span12">
                      <h4>FILTER BY:</h4>
                      <div class="container">
                            <div class="row">
                
                              <div class="control-group span3 ">
                                
                                <label class="control-label" for="single_lab_test">Select lab test:</label>
                                  <select class="select" id="single_lab_test" >
                                        <option value="0">ALL TEST</option>
                                      <?php foreach($lab_test_list as $item){?>
                                        <option value="<?php echo $item->ID;?>"><?php echo $item->Abbreviation;?></option>
                                      <?php }?>
                                  </select>
                                </div> <!-- /control-group --> 

                                  <div class="control-group span3">											
                                    <label class="control-label" for="generate_total_sales_date_from">From:</label>
                                    <div class="controls">
                                      <input type="date" class=" " id="generate_total_sales_date_from" value="<?php echo date('Y-m-d'); ?>" placeholder="Enter a date from">
                                  </div> <!-- /controls -->				
                                </div> <!-- /control-group -->  

                                <div class="control-group span3">											
                                  <label class="control-label" for="generate_total_sales_date_to">To:</label>
                                  <div class="controls ">
                                    <input type="date" class=" " id="generate_total_sales_date_to" value="<?php echo date('Y-m-d', strtotime("+1 month")); ?>" placeholder="Enter a date to">
                                  </div> <!-- /controls -->				
                                </div> <!-- /control-group -->  

                                <div class="control-group span2">											
                                  <label class="control-label" for="generate_total_sales">&nbsp; </label>
                                  <div class="controls">
                                    <button class="btn btn-success " id="generate_total_sales"><i class="icon-bar-chart"></i> GENERATE</button> 
                                  </div> <!-- /controls -->				
                                </div> <!-- /control-group -->  

                                </div> <!-- /row -->  
                              </div><!-- /container -->
                          <hr>

                    
                          <div class="widget" id="lab_test_total_sales" hidden style="width:97%">
                            <div class="widget-header">
                              <i class="icon-list-alt"></i>
                              
                              <h3>INCOME LAB TEST </h3>
                                
                            </div> 
                            
                            <div class="widget-content">

                              <canvas id="bar-chart" class="chart-holder" width="1125" height="300"></canvas>

                              <table class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th> # </th>
                                  <th> Laboratory test </th>
                                  <th> Qty </th>
                                  <th> Amount </th>

                                </tr>
                              </thead>
                              <tbody id="lab-test-reports">

                              </tbody>
                            </table>
                            </div> <!-- /widget-content -->
                          
                          </div>
                          <!-- /widget -->

                          <div class="widget" id="sent_out" hidden>
                          <div class="widget-header">
                            <i class="icon-list-alt"></i>
                            
                            <h3>GENERATE SENT OUT</h3>
                              
                          </div> 
                          
                          <div class="widget-content">

                            <canvas id="bar-chart" class="chart-holder" width="1125" height="300"></canvas>

                         
                          </div> <!-- /widget-content --> 

                          
                        
                        </div>
                          <!-- /widget -->

                      </div>
                      <!-- /span6 --> 
                    </div>

								</div>
								
                <div class="tab-pane" id="sent-out">

										<fieldset class="form-horizontal">

                    
										</fieldset>

								</div>

				
							</div>

						</div>
					
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->
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
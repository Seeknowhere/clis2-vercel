<?php 
    include_once(ROOT_PATH.'system/header-footer/data.php');
    include_once(ROOT_PATH.'system/admin/configuration/edit-lab-package-test/service.php');
?>
<?php 
    main_header();

    @$get_clinic_test_package_details = $query->get_clinic_test_package_detail($_GET['id']);
    @$get_clinic_test_package = $query->get_clinic_test_package($_GET['id']);
    // var_dump($get_clinic_test_package);
    
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">

          <!-- /widget -->
         <div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-cogs"></i>
                <h3><?php echo @$get_clinic_test_package_details->Package_name?> <?php echo ' (₱'.@$get_clinic_test_package_details->Price.')'?></h3>
                <a class="btn btn-small pull-right back-btn" href="<?php echo root_url();?>system/admin/configuration/" role="button" ><i class="fa fa-arrow-alt-circle-left"></i> BACK</a>
	  				</div> <!-- /widget-header -->
  
					<div class="widget-content">
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
              <li class="active"><a href="#preview_template" data-toggle="tab">EDIT PACKAGE</a></li>
						</ul>
						
						<br>

						
                <div class="tab-pane active" id="preview_template">
                  <fieldset class="form-horizontal">
                  <table class="table table-striped table-bordered action-table" id="">
                      <thead>
                        <tr>
                          <th> #</th>
                          <th> List of clinic test (Abbreviation) </th>
                          <th> Description</th>
                          <th> Cost</th>
                          <th> Available</th>
                          <th> Date created</th>
                        </tr>
                      </thead>

                      <tbody id="clinic-test-result-value">
                        
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

                          
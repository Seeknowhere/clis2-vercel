<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/header-footer/data.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/reception/patient-details/service.php');
?>
<?php 
    main_header();
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">

      
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
	      				<h3>PATIENT RECORD > SEARCH RECENT LABORATORY TEST RESULT</h3>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
          <div class="container" style="">
              <div class="span11" >
                <fieldset class="form-horizontal">
                    <div class="control-group">											
                      <label class="control-label" for="search_patient">Search patient:</label>
                      <div class="controls">
                        <input type="text" class="span9 " id="search_patient_record" value="" placeholder="Search by patient name">
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
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
        </div>
        <!-- /span12 --> 
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


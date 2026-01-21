<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/header-footer/data.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/admin/configuration/edit-lab-test/service.php');
?>
<?php 
    main_header();

    @$get_clinic_test_single = $query->get_clinic_test_single($_GET['id']);

    
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
                <h3><?php echo @$get_clinic_test_single->Abbreviation.' ('.@$get_clinic_test_single->Description.')'?> TEMPLATE - <?php echo (@$get_clinic_test_single->Available) ? "AVAILABLE" : "NOT AVAILABLE" ;  ?></h3>
                <a class="btn btn-small pull-right back-btn" href="<?php echo root_url();?>system/admin/configuration/" role="button" ><i class="fa fa-arrow-alt-circle-left"></i> BACK</a>
	  				</div> <!-- /widget-header -->
  
					<div class="widget-content">
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
              <li ><a href="#add-label" data-toggle="tab">ADD LABEL</a></li>
              <li ><a href="#label-detail" data-toggle="tab">LABEL DETAIL</a></li>
              <li class="active"><a href="#preview_template" data-toggle="tab">PREVIEW TEMPLATE</a></li>
						</ul>
						
						<br>
						
            <div class="tab-content">

                <div class="tab-pane" id="add-label">
                  <fieldset class="form-horizontal">
                      <div class="alert">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Warning!</strong> 
                        There are require labels and coordinates must have set before use this template as following:
                        <ol>
                          <li>Name</li>
                          <li>Date</li>
                          <li>Age</li>
                          <li>Gender</li>
                          <li>Medtech</li>
                        </ol>
                        There are case-sensitive and mistyped label the system will not recognize as requiring of the template. 
                      </div>
                      <div class="control-group">											
                        <label class="control-label" for="template_add_label">Enter label name:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="template_add_label" placeholder="Enter a description & label (e.g. Name)">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group --> 

                      <div id="field_type">
                      </div>
                      <div class="control-group">
                        <label class="control-label" for="template_add_label_coordinate">Enter coordinates:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="template_add_label_coordinate" placeholder="Enter a column-row coordinates (e.g. A,2)">
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->  

                        <button class="btn btn-success span2  pull-right" id="template_add_label_btn" data-id="<?php echo $_GET['id'];?>"style="margin-bottom:1%;"><i class="fas fa-plus"></i> ADD LABEL</button>
            
                  </fieldset>
								</div>

              
                <div class="tab-pane " id="label-detail">
                 	<fieldset class="form-horizontal">

                      <div class="control-group">											
                        <label class="control-label" for="search_label">Search label:</label>
                        <div class="controls">
                          <input type="text" class="span10 " id="search_label" data-id="<?php echo @$_GET['id']?>" value="">
                          <!-- <button class="btn btn-success span2  pull-right" id="search_label_btn" data-id="<?php echo @$_GET['id']?>"><i class="fas fa-search"></i> SEARCH</button> -->
                        </div> <!-- /controls -->				
                      </div> <!-- /control-group -->
                      <hr>

                      <table class="table table-striped table-bordered action-table" id="label-result-table" hidden>
           
                        <thead>
                          <tr>
                            <th> #</th>
                            <th> Label </th>
                            <th> Coordinate</th>
                            <th> Date created</th>
                            <th> Diplay label</th>
                            <th class="td-actions td-more-actions"> </th>
                          </tr>
                        </thead>

                        <tbody id="label-result-value">
                         
                        </tbody>

                      </table>
										</fieldset>
								</div>
						
                <div class="tab-pane active" id="preview_template">
                  <fieldset class="form-horizontal">
                    <div id="excel_template" style="height:700px ; width :99%;" data-filename="<?=$get_clinic_test_single->File_name?>"></div>
                  </fieldset>
								</div>

                <!-- <button class="btn btn-success span2  pull-right" id="clickme" style="margin-bottom:1%;"><i class="fas fa-plus"></i> click</button> -->



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

                          
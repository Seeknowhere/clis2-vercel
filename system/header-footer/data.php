<?php
    include_once(ROOT_PATH.'config.php');

    if(!isset($_SESSION)) { 
      session_start();
     } 

    if(empty($_SESSION["user_data"]) || empty($_SESSION["user_data"]->Active)){
        header("Location:".root_url()."system/login");
        die();
    }



    function main_header(){

      $url = explode('/',$_SERVER['REQUEST_URI']);   
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Clinical Laboratory Information System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo root_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo root_url()?>assets/css/bootstrap-responsive.min.css" rel="stylesheet">
<link rel="icon" href="data:;base64,iVBORw0KGgo=">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="<?php echo root_url()?>assets/css/fontawesome-v5.6.3.css" rel="stylesheet" >
<link href="<?php echo root_url()?>assets/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo root_url()?>assets/css/style.css" rel="stylesheet">
<link href="<?php echo root_url()?>assets/css/pages/dashboard.css" rel="stylesheet">
<link href="<?php echo root_url()?>root/library/grapecity/gc.spread.sheets.excel2013white.12.0.10.css" rel="stylesheet">
<!-- <script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript"></script> -->



<link rel="icon" href="<?php echo root_url().'assets/img/company_logo.png'?>">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo root_url()?>system/dashboard">Clinical Laboratory Information System </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> <?php echo strtoupper($_SESSION["user_data"]->Position)?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo root_url()?>system/settings/index.php?id=<?php echo $_SESSION["user_data"]->ID;?>"> <i class="fa fa-user-cog"></i> Settings</a></li>
              <li><a href="<?php echo root_url()?>system/login"> <i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
        <!-- <form class="navbar-search pull-right">
          <input type="text" class="search-query" placeholder="Search">
        </form> -->
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class="<?php echo (strtolower($url[2])=="dashboard") ? "active" : "" ?>"><a href="<?php echo root_url()?>system/dashboard"><i class="icon-dashboard"></i><span>DASHBOARD</span> </a> </li>
        <?php if ($_SESSION["user_data"]->User_position_id==1){?>
        <li class="<?php echo (strtolower($url[2])=="report") ? "active" : "" ?>"><a href="<?php echo root_url()?>system/report"><i class="icon-list-alt"></i><span>REPORT</span> </a> </li>
        <?php }?>
        <?php if ($_SESSION["user_data"]->User_position_id==2){?>
          <li class="<?php echo (strtolower($url[2])=="reception") ? "active" : "" ?>"><a href="<?php echo root_url()?>system/reception"><i class="icon-sitemap"></i><span>RECEPTION</span> </a> </li>
        <?php }?>
        <?php if ($_SESSION["user_data"]->User_position_id==3){?>
        <li class="dropdown <?php echo (strtolower($url[2])=="laboratory") ? "active" : "" ?>"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-microscope  "></i><span>LABORATORY</span> <b class="caret"></b> </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo root_url()?>system/laboratory/test-supply"><i class="fas fa-boxes"> </i> Test supply</a></li>
            <li><a href="<?php echo root_url()?>system/laboratory/transaction"><i class="fas fa-exchange-alt"></i> Transaction</a></li>
            <li><a href="<?php echo root_url()?>system/laboratory/patient-records"><i class="fas fa-user"></i> Patient Record</a></li>
          </ul>
        </li>
        <?php }?>
        <?php if ($_SESSION["user_data"]->User_position_id==1){?>
        <li class="dropdown <?php echo (strtolower($url[2])=="admin") ? "active" : "" ?>"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i ><span>ADMIN</span> <b class="caret"></b></a>
        <?php }?>
          <ul class="dropdown-menu">
            <li><a href="<?php echo root_url()?>system/admin/user-management"><i class="icon-group"> </i>User management</a></li>
            <li><a href="<?php echo root_url()?>system/admin/configuration"><i class="icon-cogs"> </i>Configuration</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->

<div id="loading">
  <div id="loading_content">
    <div class="fa-3x">
    <div id="loading_text">
      <i class="fas fa-spinner fa-pulse"></i> Loading. . .
    </div>
    </div>
    <br>  
    <div class="fa-2x" style="margin-bottom:10px;">
      <div id="sms_sending">
        <i class="fas fa-spinner fa-pulse"></i> Sms sending. . .
      </div>
      <div id="sms_sent">
        <i class="fas fa-check"></i> Sms sent
      </div>
      <div id="sms_failed">
        <i class="fas fa-exclamation-triangle"></i> Sending sms failed
      </div>
    </div>
    <div class="fa-2x">
      <div id="email_sending">
        <i class="fas fa-spinner fa-pulse"></i> Email sending. . .
      </div>
      <div id="email_sent">
        <i class="fas fa-check"></i> Email sent
      </div>
      <div id="email_failed">
        <i class="fas fa-exclamation-triangle"></i> Sending email failed
      </div>
    </div>

  </div>
</div>


<?php
    }
?>

<?php
  function main_footer(){
?>
        

<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="<?php echo root_url()?>assets/js/jquery-1.7.2.min.js"></script> 
<script src="<?php echo root_url()?>assets/js/excanvas.min.js"></script> 
<script src="<?php echo root_url()?>assets/js/chart.min.js" type="text/javascript"></script> 
<script src="<?php echo root_url()?>assets/js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo root_url()?>assets/js/full-calendar/fullcalendar.min.js"></script>
<script src="<?php echo root_url()?>root/library/grapecity/FileSaver.min.js"></script> 
<script src="<?php echo root_url()?>root/library/grapecity/gc.spread.sheets.all.12.0.10.min.js"></script> 
<script src="<?php echo root_url()?>root/library/grapecity/gc.spread.excelio.12.0.10.min.js"></script> 
<script src="<?php echo root_url()?>root/library/grapecity/gc.spread.sheets.print.12.0.10.min.js"></script> 
<script src="<?php echo root_url()?>root/library/grapecity/gc.spread.sheets.pdf.12.0.10.min.js"></script> 
<script src="<?php echo root_url()?>root/library/smtpjs/smtp.js"></script> 
<script src="<?php echo root_url()?>assets/js/service.js"></script> 
</body>
</html>

<?php
    }
?>
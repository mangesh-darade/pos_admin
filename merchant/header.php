<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title>Point Of Sale | POS | Bhopal | indore | Jaipur | pune | Mumbai | Delhi | India</title>
    <meta name="Description" content="POS, Point of Sale, Simply POS, Simply Safe Bhopal Call us: 0755-2555950, My office is here to help you-Bhopal, indore, Jaipur, pune, Mumbai, Delhi, India"/>
    <meta name="keywords" content="POS | Point of Sale | Smart Class | Online | Offline | CBSE |Education |Software | Digital Class | Vehicle Tracking | Car | Bus | GPS | GPRS | Fleet | Device | ERP | Asset tracking | RFID | truck | Location | E Attendance | Management | Biometric | RFID card | Employee | Student | payroll | Software | Leave  | HR Solutions | Event Management | Company | Website | Conference | Meeting | Bhopal | indore | Jaipur | pune | Mumbai | Delhi | India" />
    <meta name="author" content="Sunil Sadani">
    <meta class="viewport" name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $objapp->baseURL('img/favicon.png');?>">
    <!-- Font -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/bootstrap.min.css');?>" media="all" />
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/font-awesome.min.css');?>" media="all" />
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/jslider.css');?>" media="all" />
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/revslider/settings.css');?>" media="all" />
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/jquery.fancybox.css');?>" media="all" />
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/animate.css');?>" media="all" />
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/jquery.scrollbar.css');?>" media="all" />
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/style.css');?>" media="all" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/customizer/pages.css');?>" media="all" />
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/customizer/home-pages-customizer.css');?>" media="all" />
    <!-- IE Styles-->
    <link rel="stylesheet" href="<?php echo $objapp->linkCSS('css/ie/ie.css');?>" media="all" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <link rel='stylesheet' href="css/ie/ie8.css">  <![endif]-->
    
    <style>.title1 {color: cadetblue;}</style>
    <link href="<?php echo $objapp->linkCSS('css/pos-style.css');?>" rel="stylesheet" media="screen" />
<?php if($posPageName == "package") { ?>
    <link href="<?php echo $objapp->linkCSS('css/package_style.css');?>" rel="stylesheet" media="screen" />
<?php } ?>
<?php if($posPageName == "login") { ?>
    <link href="<?php echo $objapp->linkCSS('css/login_style.css');?>" rel="stylesheet" media="screen" />
<?php } ?>
<?php if($posPageName == "merchant") { ?>
    <link href="<?php echo $objapp->linkCSS('merchant/merchant.css');?>" rel="stylesheet" media="screen" />
    <link href="<?php echo $objapp->linkCSS('merchant/sidebar-menu.css');?>" rel="stylesheet" media="screen" />
     
<?php } ?>
</head>
<body class="fixed-header home" id="pos_top">
    <div class="page-box">
        <div class="page-box-content">
            <header class="header header-two">
                <div class="header-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 logo-box">
                                <div class="logo">
                                    <a href="<?php echo $objapp->baseURL('index.html');?>">
                                        <img src="<?php echo $objapp->baseURL('img/logo.png');?>" class="logo-img" alt="Simply Safe">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                 
                                <div style="margin-top:20px;display: inline-block;margin-right: 25px;"  >    
                                    <a href="<?php echo $objapp->baseURL('pos-free-trial.php');?>" class="btn btn-warning center-block">
                                        <h4 style="margin:0px;"> Get a free website</h4>
                                    </a>
                                </div>
		                <img src="https://simplystatic.simplypos.in/img/approved-stamp-1.png" alt="approved-stamp-1" style="padding: 7px 0 0 0;width: 82px;">
                            </div>
                            <!-- .logo-box -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-box">
                                <div class="right-box-wrapper">
                                    <!-- .header-icons -->
                                    <div class="primary">
                                        <div class="col-lg-12" style="text-align: right">
                                            <span><?php if(isset($_SESSION['sess_merchant_name'])) { echo "Welcome ". $_SESSION['sess_merchant_name']; } ?></span>
                                            <span style="margin-left: 20px">
                                                <img src="<?php echo $objapp->baseURL('img/png-icons/phone-icon.png');?>" alt="Call us" width="16" height="16" style="vertical-align: top;" />&nbsp  <a href="tel://0755-4905-950">0755-4905-950</a>, <a href="tel://0755-4935-950">0755-4935-950</a>, <a href="tel://0755-4935-949">0755-4935-949</a></span>
                                            <span style="margin-left: 20px">
                                                <img src="<?php echo $objapp->baseURL('img/png-icons/Email.png');?>" alt="Mail us" width="16" height="16" style="vertical-align: top;" />&nbsp; <a href="mailto:pos@simplysafe.in">pos@simplysafe.in</a></span>
                                        </div>
                                        <div class="navbar navbar-default" role="navigation">
                                            <button
                                                type="button" class="navbar-toggle btn-navbar collapsed" data-toggle="collapse" data-target=".primary .navbar-collapse">
                                                <span class="text">Menu</span> <span class="icon-bar"></span>
                                                <span class="icon-bar"></span><span class="icon-bar"></span>
                                            </button>
                                            <nav class="collapse collapsing navbar-collapse">
                                                <ul class="nav navbar-nav navbar-center">
                                                    <li class="active"><a href="<?php echo $objapp->pageLink('index.php');?>"><strong>HOME</strong></a> </li>
                                                    <li class=""><a href="<?php echo $objapp->pageLink('package.php');?>"><strong>PACKAGES</strong></a></li>
                                                    <li class=""><a href="<?php echo $objapp->pageLink('contact-us.php');?>"><strong>CONTACT US</strong></a> </li>
                                                    <?php 
                                                       $objapp->authenticationLinks();
                                                    ?>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                    <!-- .primary -->
                                </div>
                            </div>
                          
                        </div>
                        <!--.row -->
                    </div>
                </div>
                <!-- .header-wrapper -->
            </header>
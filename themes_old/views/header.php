<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Home - Best POS Software For Retail, Point Of Sale Software, GST Compatible</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta name="description" content="Point Of Sale, POS Software, Hardware And Complete Retail Management Solution With E-Shop/Website By Simply POS, Free to Call Us:0755-4905-950."/>
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Home - Best POS Software For Retail, Point Of Sale Software, GST Compatible" />
        <meta property="og:description" content="Point Of Sale, POS Software, Hardware And Complete Retail Management Solution With E-Shop/Website By Simply POS, Free to Call Us:0755-4905-950" />
        <meta property="og:url" content="https://simplypos.in/" />
        <meta property="og:site_name" content="Best POS Software For Retail, Point Of Sale Software, GST Compatible" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:description" content="Point Of Sale, POS Software, Hardware And Complete Retail Management Solution With E-Shop/Website By Simply POS, Free to Call Us:0755-4905-950" />
        <meta name="twitter:title" content="Home - Best POS Software For Retail, Point Of Sale Software, GST Compatible" />
        <meta name="twitter:site" content="@simplypos_" />
        <meta name="twitter:creator" content="@simplypos_" />

        <!-- Favicons -->
        <link href="<?= $assets ?>img/favicon.png" rel="icon">
        <link href="<?= $assets ?>img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

        <!-- Bootstrap CSS File -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

        <!-- Libraries CSS Files -->
        <link href="<?= $assets ?>lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= $assets ?>lib/animate/animate.min.css" rel="stylesheet">
        <link href="<?= $assets ?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">
        <link href="<?= $assets ?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="<?= $assets ?>lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link rel="stylesheet"  href="<?= $assets ?>css/lightslider.min.css"/>
        <!-- Main Stylesheet File -->
        <link href="<?= $assets ?>css/style.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <style type="text/css">
            .carousel-control-prev{
                display: none;
            }
            .carousel-control-next{
                display: none;
            }
            .carousel-indicators{
                float: left;
                padding: 0px;
                position: relative;
                top: 450px;
                left: -12%;
            }
            .carousel-indicators li{
                background-color: #f2a8cd;

            }
            .carousel-indicators li.active{
                background-color: #d6076f;
            }
            .owl-dot{

                background-color:pink;
            }
            .nav-menu li a{
		font-family: "Poppins";
		color:#231f20;
		}
        </style> 
        <?php
        /*
         * Google Recaptcha:
          Site key : 6Lequn4UAAAAAP2NytY0mUGA3zdKnuzsO11OR5pk

          Secret key: 6Lequn4UAAAAAGQGLIS09EPEx25ZNyLBRTeffEBy

         */
        ?>
        <script type="text/javascript">
            var verifyCallback = function () {

                var reChResponse = grecaptcha.getResponse(widgetId1);


                if (reChResponse) {
                    return true;
                } else {
                    alert('Please solve the reCAPTCHA');
                    return false;
                }
            };
            var widgetId1;

            var onloadCallback = function () {
                // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
                // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
                widgetId1 = grecaptcha.render('example1', {
                    'sitekey': '6Lequn4UAAAAAP2NytY0mUGA3zdKnuzsO11OR5pk',
                    'theme': 'light'
                });

            };
        </script>


        <!-- Global site tag (gtag.js) - Google Ads: 850050350 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-850050350"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'AW-850050350');
        </script>

        <?php if ($this->uri->segment(1) == "free_trial") { ?>

            <!-- Event snippet for Free Trial Page conversion page -->
            <script>
                gtag('event', 'conversion', {'send_to': 'AW-850050350/4yfiCMCN9pABEK76qpUD'});
            </script>
        
        <?php } else if ($this->uri->segment(1) == "thankyou") { ?>
            <!-- Event snippet for Final Enquiry(Form/Request Submission) conversion page -->
            <script>
                gtag('event', 'conversion', {'send_to': 'AW-850050350/Ohu6CKGo5JoBEK76qpUD'});
            </script>
        <?php } ?>
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-76783373-4"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-76783373-4');
        </script>


    </head>
    <body>
<?php 
$getpage_name = ($this->uri->segment(1)=='') ? 'home' : $this->uri->segment(1);

?>
        <!--==========================
          Header
        ============================-->


        <header id="header" class="sl_header" style="<?= ($getpage_name=='home'||$getpage_name=='')?'border-bottom:none;':'border-bottom: 1px solid #d1d1d1;' ?> >
<input type="hidden" value="<?=base_url()?>" id="base_url" />
            <div class="container-fluid">
                <div id="logo" class="pull-left">
                    <a href="#intro" class="scrollto"><img src="<?= $assets ?>img/logo.png" alt=""></a>
                </div>
                <nav id="nav-menu-container">
                    <ul class="nav-menu">
                        <li  <?= ($getpage_name=='home')?'class="menu-active"':(($getpage_name=='')?'class="menu-active"':'')?>><a href="<?= base_url('home') ?>">Home</a></li>
                        <li <?= ($getpage_name=='package')?'class="menu-active"':'' ?>><a href="<?= base_url('package') ?>">Package</a></li>
                        <li <?= ($getpage_name=='about')?'class="menu-active"':'' ?>><a href="<?= base_url('about') ?>">About Us</a></li>          
                        <li <?= ($getpage_name=='contact')?'class="menu-active"':'' ?>><a href="<?= base_url('contact') ?>">Contact us</a></li>
                        <li><a class="login_bt" href="login.php">Login</a></li>    
                    </ul>
                </nav><!-- #nav-menu-container <?= base_url('login') ?>-->
            </div>
        </header><!-- #header -->

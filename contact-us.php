<?php
    include_once 'application_main.php';
     
?>


<?php include_once 'header.php'; ?>

<div class="breadcrumb-box" style="display:none">
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="index.html">Home</a> </li>
      <li class="active">Contact Us</li>
    </ul>	
  </div>
</div><!-- .breadcrumb-box -->

<section id="main">
  <header class="page-header">
    <div class="container">
      <h1 class="title">Contact Us</h1>
    </div>	
  </header>
  <div class="container">
    <div class="row">
      <div class="content col-sm-12 col-md-12">
		<div class="row">
		  <div class="col-sm-6 col-md-6 contact-info bottom-padding">
			<address>
			  <div class="title"><strong>India - Office</strong></div>
			  <br><strong>Bhopal - </strong>Plot no 5, Second floor, Above Godrej showroom, MP Nagar Zone - 2, Bhopal 462011.
			  <br><br><strong>Indore - </strong>112, 1st floor Shalimar Corporate Center, South Tukoganj, Near Best Western Plus O2 Hotel, Indore 452001
			  <!--br><br><strong>Jaipur - </strong>206 - Geeta Enclave , Vinobha Marg, C-Scheme, Jaipur, Rajasthan 302001-->
			</address>
			
			
			
			<address>
			  <div class="title"><strong>USA - Office</strong></div>
			 1310 SE Maynard Road #101 Cary NC 27511 USA <br /> Phone: +1-(919)-377-8484
			 </address>
			
		
			<div class="row">
			  <address class="col-sm-6 col-md-6">
				<div class="title"><strong>Call</strong></div>
				<div> <strong>Bhopal  : </strong> <a href="tel://0755-4905-950">0755-4905-950</a>, <a href="tel://0755-4935-950">0755-4935-950</a>, <a href="tel://0755-4935-949">0755-4935-949</a></strong></div>                             			
				<div> <strong>Fax &nbsp &nbsp &nbsp  : </strong> +91 755-2555-950</div>
				
			  </address>
			  <address class="col-sm-6 col-md-6">
				<div class="title"><strong>Email Address</strong></div>
				<div><a href="mailto:pos@simplysafe.in">pos@simplysafe.in</a></div>
				<div><a href="mailto:possales@simplysafe.in">possales@simplysafe.in</a></div>
			  </address>
			</div>
		  </div>
 
		  <div class="col-sm-6 col-md-6 bottom-padding">
                    <?php if($mailResult === false) : ?>
                        <div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry message could not be completed. </div>
                    <?php endif; ?> 
                    <?php if($mailResult === true) : ?> 
                        <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> Message sent successfully.</div>
                    <?php endif; ?>
                        <h3 class="title">Contact Us</h3>
                      <form id="contactform" method="post" action="thank-you_contact.php" >
			  <input type="hidden" name="submitContactForm" value="1" />
			 
			<!--  <label>Name: </label>--><span class="required"></span>
                          <input type="text" class="form-control" maxlength="50" required="required" name="name" placeholder="name" id ="contactName" />
                
			 <!-- <label>Email Address: </label>--><span class="required"></span>
                          <input type="email" required="required" maxlength="60" class="form-control" placeholder="email" name="email" id="contactEmail" />
                
			  <!--<label>Telephone:</label>--> <span class="required"></span></label>
                          <input type="text" required="required" maxlength="14" class="form-control" placeholder="phone" name="phone" id="contactelephone"  pattern="[0-9]{6,}" title="Only number and minimum 6 digits." />
			  
                          <!--<label>Comment:</label>--><span class="required"></span></label>
                          <textarea required="required" maxlength="255"  class="form-control" name="comment" placeholder="comment" id="contactMessage" TextMode="MultiLine" ></textarea>

			  <div class="clearfix"></div>
			  <div class="buttons-box clearfix">
				
                             <!-- <input type="submit" ID="btn_submit" value="Submit"   class="btn btn-default"  />-->
							 <input type="submit" id="btn_submit" value="Submit" class="btn btn-default" style="
    width: 25%;
">
                              
                             <!-- <span class="text-info"><b>*</b> Required field</span>-->
                    
			  </div><!-- .buttons-box -->
                
            
			</form>
		  </div>
		  <div class="map-box col-sm-12 col-md-12">
			<div style="height: 276px;">
			 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7697.896421395321!2d-78.7662760333213!3d35.78601737956395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89acf39bc6264383%3A0x8502511cc29a8838!2s1310+SE+Maynard+Rd+%23101%2C+Cary%2C+NC+27511%2C+USA!5e0!3m2!1sen!2sin!4v1484373876193" width="100%" height="276" frameborder="0" style="border:0" allowfullscreen></iframe>
</div><br><br>
			  <div  style="height: 276px;">
                         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d35900.55567634857!2d77.38454325520188!3d23.2374617375809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397c425d71e864e7%3A0x6b3d7aae99fef455!2sPhoenix+Simply+Safe+Pvt+Ltd!5e0!3m2!1sen!2sin!4v1496125203341"  width="100%" height="276" frameborder="0" style="border:0" allowfullscreen></iframe>
                         </div>
                         <br>
			  </div><br><br>
		  </div>
		</div>
      </div>
    </div>
  </div><!-- .container -->
</section><!-- #main -->

</div><!-- .page-box-content -->
</div><!-- .page-box -->

 <!--footer id="footer" style="display:none" >
        <div class="footer-top">
            <div class="container">
                <div class="row sidebar">
                    <aside class="col-xs-12 col-sm-6 col-md-3 widget social">
                        <div class="title-block">
                            <h3 class="title">Follow Us</h3>
                        </div>
                        <p>Follow us in social media</p>
                        <div class="social-list">
                            <a class="icon rounded icon-facebook" href="https://www.facebook.com/phoenix.simplysafe/?fref=ts"><i class="fa fa-facebook"></i></a>
                            <a class="icon rounded icon-twitter" href="https://www.youtube.com/channel/UCbSWmZx5a2_v8uld31JFvBA"><i class="fa fa-youtube"></i></a>
                            <a class="icon rounded icon-twitter" href="https://www.youtube.com/channel/UCbSWmZx5a2_v8uld31JFvBA"><i class="fa fa-twitter"></i></a>
                            <a class="icon rounded icon-twitter" href="https://www.youtube.com/channel/UCbSWmZx5a2_v8uld31JFvBA"><i class="fa fa-google-plus"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </aside>
                    <aside class="col-xs-12 col-sm-6 col-md-2 widget links">
                        <div class="title-block">
                            <h3 class="title">Information</h3>
                        </div>
                        <nav>
                            <ul>
                                <li><a href="about-us.html">About us</a></li>
                                <li><a href="Terms.html">Privacy Policy</a></li>
                                <li><a href="Terms.html">Terms &amp; Conditions</a></li>
                            </ul>
                        </nav>
                    </aside>                   

                    <aside class="col-xs-12 col-sm-6 col-md-2 widget links">
                        <div class="title-block">
                            <h3 class="title">Download</h3>
                        </div>
                        <nav>
                            <ul>
                                <a download="School Attendance System.pdf" href="http://www.simplysafe.in/file/School Attendance System.pdf" title="e broucher smart class v2.pdf">
                                    <img alt="Download" src="http://www.simplysafe.in/content/img/download.png" style="height: 30px; width: 30px; margin-right: 10px">Brochure</a>

                                <!--<li><a href="#">Newsletter</a></li>-->
                            <!--/ul>
                        </nav>
                    </aside>
 <aside class="col-xs-12 col-sm-6 col-md-2 widget links">
                        <div class="title-block">
                            <h3 class="title">Industries</h3>
                        </div>
                        <nav>
                            <ul>
                                <li><a href="#">Pharmaceutical</a></li>
                                <li><a href="#">Grocery</a></li>
                                <li><a href="#">Retail</a></li>
                                <li><a href="#">Electrical</a></li>
                                <li><a href="#">Electronics</a></li>
                                <li><a href="#">Hardware</a></li>
                               <li><a href="#">Hotel</a></li>
                            </ul>
                        </nav>
                    </aside>
                    <aside class="col-xs-12 col-sm-6 col-md-3 widget links">
                        <div class="title-block">
                            <h3 class="title">Partners</h3>
                        </div>
                        <nav>
                            <ul class="sub">
                               
                            </ul>

                        </nav>
                    </aside>
                </div>
            </div>
        </div>
        <!-- .footer-top -->
        <!--div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="copyright col-xs-12 col-sm-3 col-md-3">
                        Copyright ©
              Simply safe 2015
                    </div>
                    <div class="phone col-xs-6 col-sm-3 col-md-3">
                        <img src="img/png-icons/phone-icon.png" alt="Call us" width="16" height="16" />
                        <strong class="title">Call Us:</strong> 07552555950 , +91-8717996161
                         
                        <br />
                        <img src="img/png-icons/Email.png" alt="Call us" width="16" height="16" />
                        <strong class="title">Email-Id:</strong>Info@simplysafe.in
                    </div>
                    <div class="address col-xs-6 col-sm-3 col-md-3">
                        <div class="footer-icon">
                            <svg x="0" y="0" width="16px" height="16px" viewBox="0 0 16 16"
                                enable-background="new 0 0 16 16" xml:space="preserve">
                                <g>
                                    <g>
                                        <path fill="#c6c6c6" d="M8,16c-0.256,0-0.512-0.098-0.707-0.293C7.077,15.491,2,10.364,2,6c0-3.309,2.691-6,6-6
					c3.309,0,6,2.691,6,6c0,4.364-5.077,9.491-5.293,9.707C8.512,15.902,8.256,16,8,16z M8,2C5.795,2,4,3.794,4,6					c0,2.496,2.459,5.799,4,7.536c1.541-1.737,4-5.04,4-7.536C12.001,3.794,10.206,2,8,2z">
                                        </path>
                                    </g>
                                    <g>
                                        <circle fill="#c6c6c6" cx="8.001" cy="6" r="2"></circle>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        H3B Nishat Enclave, 74 Bungalow<br />
                        Bhopal MP 462003
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <a href="#" class="up">
                            <span class="glyphicon glyphicon-arrow-up"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- .footer-bottom -->
    <!--/footer-->
    <?php include_once 'footer.php'; ?>
    <div class="clearfix"></div>
    <!--[if (!IE)|(gt IE 8)]><!-->
    <script src="https://simplypos.in/js/jquery-2.1.3.min.js"></script>
    <!--<![endif]-->
    <!--[if lte IE 8]>
  <script src="https://simplypos.in/js/jquery-1.9.1.min.js"></script>
    <![endif]-->

    <!-- Pricing page script-->
    <script type="text/javascript" src="https://simplypos.in/js/combined-head-resp.js"></script>
   
    
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://simplypos.in/js/jquery.carouFredSel-6.2.1-packed.js"></script>
    <script src="https://simplypos.in/js/jquery.touchwipe.min.js"></script>

  <!--  <script src="js/jquery.imagesloaded.min.js"></script> -->
    <script src="https://simplypos.in/js/jquery.appear.min.js"></script>

    <script src="https://simplypos.in/js/jquery.easing.1.3.js"></script> 

    <script src="https://simplypos.in/js/isotope.pkgd.min.js"></script>

    <script src="https://simplypos.in/js/revolution/jquery.themepunch.tools.min.js"></script>
    <script src="https://simplypos.in/js/revolution/jquery.themepunch.revolution.min.js"></script>
   <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
	(Load Extensions only on Local File Systems !	The following part can be removed on Server for On Demand Loading) -->
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.actions.min.js"></script>
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.carousel.min.js"></script>
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.migration.min.js"></script>
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.navigation.min.js"></script>
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.parallax.min.js"></script>
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="https://simplypos.in/js/revolution/extensions/revolution.extension.video.min.js"></script>
	
    <script src="https://simplypos.in/js/main.min.js"></script>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date(); a = s.createElement(o),
            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-76783373-1', 'auto');
        ga('send', 'pageview');

    </script>
    <script>
        function smoothScroll(classname) {
        document.querySelector('.'+classname).scrollIntoView({ 
            behavior: 'smooth' 
          });
      }
    </script>
    <script type="text/javascript" src="https://simplypos.in/js/pos/slider.js"></script> 
    <script type="text/javascript">
      $(document).omSlider({
        slider: $('.pos_slider'),
        dots: $('.dots'),
        next:$('.btn-right'),
        pre:$('.btn-left'),
        timer: 5000,
        showtime: 1000
      });
      </script>
      
     <!-- BEGIN JIVOSITE CODE {literal} -->
 
     <!--<script type='text/javascript'>
(function(){ var widget_id = 'DE3K80MMsi';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>-->
 
<!-- {/literal} END JIVOSITE CODE -->


    
<script>
    $(function(){
          <!-- Required for professional services marketo form -->
        Templates.forms.professionalServices();
        <!-- Required for enterprise services marketo form lightbox -->
        Templates.forms.enterpriseServices();
        <!-- Required for general page functionality -->
        Templates.pricing.pricingV2();
        Templates.global.topBarSuccess();
        Templates.global.headerSuccess();
    });

</script>
<?php include_once 'footer.php'; ?>
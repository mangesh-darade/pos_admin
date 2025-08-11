<!--==========================
    Footer
  ============================-->
  <footer id="<?= ($footer2) ? 'footer2' : 'footer' ?>">
    <div class="footer-top">
        <div class="row">
          <div class="col-lg-3 col-md-6 footer-contact">
              <h4><span><i class="fa fa-map-marker"></i></span>Address</h4>
              <p>
              Plot no 5, Second floor, Above
              Godrej showroom, MP Nagar Zone - 2,
              Bhopal 462011
              </p>      
              <h4><span><i class="fa fa-phone"></i></span>call</h4><p><a href="tel:+917554905950"> +91 7554905950 </a> <a href="tel:+917554935950">+91 7554935950 </a></p>
              <h4><span><i class="fa fa-envelope"></i></span>Email</h4><p><a href="mailto:pos@simplysafe.in"> pos@simplysafe.in </a></p>
          </div>
          <div class="col-lg-9 col-md-6 footer-newsletter" style="float: right;">
            <div class="footer-newsletter_box">
            <a href="brochure/simplyposbrochure-3.pdf" target="_blank"><h4>Download Our Brochure Now</h4></a>
            <h5>Download Our App</h5>
          
            <button type="button" class="btn app_store_bt"></button>
            
            <button type="button" class="btn play_store"></button> 
            <div class="social-links">
              <a href="https://www.facebook.com/SimplySafePOS/" target="_blank" title="Facebook" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="https://twitter.com/simplypos_" target="_blank" title="Twitter" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="https://www.linkedin.com/company/phoenix-simply-safe-pvt.-ltd./" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a>
              <a href="https://www.youtube.com/channel/UCbSWmZx5a2_v8uld31JFvBA" target="_blank" title="YouTube" class="instagram"><i class="fa fa-youtube"></i></a>    
              <a href="https://www.instagram.com/simplypos_/" target="_blank" title="instagram" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="https://plus.google.com/106337412045262850584" target="_blank" title="Google Plus" class="google-plus"><i class="fa fa-google-plus"></i></a>  
            </div>    
            </div>
          </div>

        </div>
    </div>
      <div class="copyright">
         Copyright &copy;<strong>2019</strong>. Simply POS
      </div>
      
      <div class="credits">
        <a href="<?=base_url('privacy_policy')?>">Privacy Policy </a>| <a href="<?=base_url('terms_conditions')?>"> Terms & Conditions </a>
      </div>
      <div style="clear:both"></div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  
   <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/592d4dc74374a471e7c50791/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
  
  <!-- JavaScript Libraries -->
  <script src="<?=$assets?>lib/jquery/jquery.min.js"></script>
  <script src="<?=$assets?>lib/jquery/jquery-migrate.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="<?=$assets?>lib/easing/easing.min.js"></script>
  <script src="<?=$assets?>lib/superfish/hoverIntent.js"></script>
  <script src="<?=$assets?>lib/superfish/superfish.min.js"></script>
  <script src="<?=$assets?>lib/wow/wow.min.js"></script>
  <script src="<?=$assets?>lib/waypoints/waypoints.min.js"></script>
  <script src="<?=$assets?>lib/counterup/counterup.min.js"></script>
  <script src="<?=$assets?>lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="<?=$assets?>lib/isotope/isotope.pkgd.min.js"></script>
  <script src="<?=$assets?>lib/lightbox/js/lightbox.min.js"></script>
  <script src="<?=$assets?>lib/touchSwipe/jquery.touchSwipe.min.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="<?=$assets?>lib/contactform/contactform.js"></script>
  <script src="<?=$assets?>js/lightslider.min.js"></script> 
  <!-- Template Main Javascript File -->
  <script src="<?=$assets?>js/main.js"></script>

<script type="text/javascript">
$(document).ready(function(){
   
   
          if ($(window).width() <= 620) { 
                $("#content-slider").lightSlider({
                item:1,
                auto: true,    
                loop:true,
                keyPress:true
               });
                $("#content-slider1").lightSlider({
                item:1,
                auto: true,    
                loop:true,
                keyPress:true
               });

          }else{
              
              $("#content-slider").lightSlider({
                  item:3,
                loop:true,
                auto:true,  
                keyPress:true,
               
            });
              $("#content-slider1").lightSlider({
                  item:1,
                loop:true,
                auto:true,  
                keyPress:true,
                  prevHtml: '<img src="<?=$assets?>img/left-arrow-pink.png">',
                  nextHtml: '<img src="<?=$assets?>img/right-arrow-pink.png">',
            });
           
          }  

});

</script>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new
	Date();a=s.createElement(o),
	   
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	   
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	 
	   ga('create', 'UA-76783373-4', 'auto');
	   ga('send', 'pageview');
	 
	
        function smoothScroll(classname) {
        document.querySelector('.'+classname).scrollIntoView({ 
            behavior: 'smooth' 
          });
      }
    </script>

</body>
</html>

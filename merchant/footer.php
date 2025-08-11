 
     </div>
    <!-- .page-box -->
</div>
<footer id="footer">
        
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="copyright col-xs-12 col-sm-3 col-md-3">
                        Copyright &copy; Simply POS 2017
                    </div>
                    <div class="phone col-xs-6 col-sm-3 col-md-3">
                        <img src="<?php echo $objapp->baseURL('img/png-icons/phone-icon.png');?>" alt="Call us" width="16" height="16" />
                        <strong class="title">Call Us:</strong>  <a href="tel://0755-4905-950">0755-4905-950</a>, <a href="tel://0755-4935-950">0755-4935-950</a>, <a href="tel://0755-4935-949">0755-4935-949</a>                         
                        <br />
                        <img src="<?php echo $objapp->baseURL('img/png-icons/Email.png');?>" alt="Call us" width="16" height="16" />
                        <strong class="title">Email-Id:</strong>pos@simplysafe.in
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
    </footer>
    <div class="clearfix"></div>
    <!--[if (!IE)|(gt IE 8)]><!-->
    <script src="<?php echo $objapp->linkJS('js/jquery-2.1.3.min.js');?>"></script>
    <!--<![endif]-->
    <!--[if lte IE 8]>
    <script src="<?php echo $objapp->linkJS('js/jquery-1.9.1.min.js');?>"></script>
    <![endif]-->

<?php if($posPageName == "package") { ?>
    <!-- Pricing page script-->
    <script type="text/javascript" src="<?php echo $objapp->linkJS('js/combined-head-resp.js');?>"></script>
<?php } ?>
   
    
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 

    
<?php if($posPageName == "merchant") { ?>
<script src="<?php echo $objapp->linkJS('merchant/sidebar-menu.js');?>"></script>
<script>
    $.sidebarMenu($('.sidebar-menu'))
  </script>
    <script>
    $('.col-sm-3.col-xs-12').click(function() {
      $(".col-sm-3.col-xs-12.active").removeClass("active");
      $(this).addClass('active');
});
$('.plans-outer').click(function() {
      $(".plans-outer.select").removeClass("select");
      $(this).addClass('select');
});
  </script>
<script type="text/javascript">
$(document).ready(function(){ 
    
   $(document).on('click','.plan1-act',function(){
		$(".plan2").removeClass("visible");
		$(".plan3").removeClass("visible");
		$(".plan4").removeClass("visible");
      $(document).find('.plan1').addClass('visible');
   });
   $(document).on('click','.plan2-act',function(){
	   $(".plan1").removeClass("visible");
	   $(".plan3").removeClass("visible");
	   $(".plan4").removeClass("visible");
	   $(document).find('.plan2').addClass('visible');
   });
   $(document).on('click','.plan3-act',function(){
	   $(".plan1").removeClass("visible");
	   $(".plan2").removeClass("visible");
	   $(".plan4").removeClass("visible");
	   $(document).find('.plan3').addClass('visible');
   });
   $(document).on('click','.plan4-act',function(){
	   $(".plan1").removeClass("visible");
	   $(".plan2").removeClass("visible");
	   $(".plan3").removeClass("visible");
	   $(document).find('.plan4').addClass('visible');
   });
   $(document).on('click','.col-sm-3.col-xs-12',function(){
	   $(document).find('.coll.visible-div').addClass('visible-none');
	   $(".coll.visible-none").removeClass("visible-div");
   });
});
</script>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "173px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


 
$(document).ready(function(){
   
    var package = $("input:radio[name='package_selected']:checked").val();
    
    calculatePackage(package);
   
    $('.package_selected').click(function(){
       
          package = $("input:radio[name='package_selected']:checked").val();
          
          calculatePackage(package);
        
    });
    
});

function calculatePackage(package){ 
      
    /* for(var i=1; i<=4; i++){
        
        if(i == package) { continue; }
        else {
            
            $("input[name='package_monthaly_"+i+"']").attr("disabled", "disabled");
            $("input[name='package_annually_"+i+"']").attr("disabled", "disabled");
            $("input[name='package_name_"+i+"']").attr("disabled", "disabled");
        }
     }
     */
     
        if(package == 1) {
            $('#billingSection').hide();
        }
        else
        {
            $('#billingSection').show();
            var package_monthaly_price = $("input[name='package_monthaly_"+package+"']").val();
            var package_annually_price = $("input[name='package_annually_"+package+"']").val();
            var package_name = $("input[name='package_name_"+package+"']").val();
            
          
            
            var annual_billing_monthly_cost = parseInt(parseInt(package_annually_price) / 12);

            $('.display_annual_billing_monthly_cost').html(annual_billing_monthly_cost);
            $('.display_annual_billing_annual_cost').html(package_annually_price);
            $('#annualy_billing_package_price').val(package_annually_price);
            $('#selected_plan_name').val(package_name);


            var display_monthly_billing_annual_cost = parseInt(parseInt(package_monthaly_price) * 12);
   
            $('.display_monthly_billing_cost').html(package_monthaly_price);
            $('.display_monthly_billing_annual_cost').html( display_monthly_billing_annual_cost );
            $('#monthly_billing_package_price').val(package_monthaly_price);

            var annual_billing_discount_amount = parseInt(display_monthly_billing_annual_cost) - parseInt(package_annually_price);
            $('#display_annual_billing_discount_amount').html(annual_billing_discount_amount);
            $('#annual_billing_discount_amount').val(annual_billing_discount_amount);
        }
        
        $('#selected_package_id').val(package);
        $('#selected_package_name').val(package_name);
}
 
</script> 
<?php }  ?>
 

 <script>
   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new
Date();a=s.createElement(o),
   
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
   
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
 
   ga('create', 'UA-76783373-4', 'auto');
   ga('send', 'pageview');
 
</script>

<script>
	
  
$(document).ready(function(){
    
    var d = new Date();
    var n = d.getTime();
     
    document.getElementById("tid").value = n;
		 
});
</script>
</body>
</html>

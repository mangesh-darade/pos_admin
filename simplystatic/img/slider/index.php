<?php
    include_once 'application_main.php';
     
?>
<?php include_once 'header.php'; ?>
 <style>
 .banner-button.list-group-item-warning.animated.rotateIn {
     border-radius: 7px;
    font-size: 1.5em;
    padding: 0.4em 0.5em;
}
.page-header
{
text-align:center;
border-bottom:none;
}
.courseTypeWord {
    font-size: 2em;
    color: #1d1b1b;
    font-weight: bold;
}
.courseTypeFirstLetter {
    font-family: 'Sitka Banner';
    font-size: 3em;
    font-weight: bold;
}
p{
  
    color: #000;
}
.title
{
font-size:24px;

}
.pos_block ul li, #Security ul li, #Functionality ul li {
   
    color: #000;
}
.box {
    border: 1px groove #e1e1e1;
    height:300px;
    width: 100%;
    padding: 10px;
    border-style: outset;
    z-index: 10;
background-color: whitesmoke;
}

    .box:hover {
        border: 2px groove #e1e1e1;
    }
	.slider.rs-slider{
		width:100%;
	}
	body{
		overflow-x:hidden !importent;
	}
	

 </style>
<script>
function closePopup() {
 debugger
           $("#advertise1").css("display","none");
        };
</script>
 <div class="slider rs-slider load">
    <div class="tp-banner-container">
        <div class="rev_slider tp-banner" data-version="5.0.7">
            <ul>
				<li data-delay="4000" data-transition="fade" data-slotamount="0" data-masterspeed="2000" style="background:#7ab4cc;">
                    <div class="elements"> 
						<div class="tp-caption" data-x="-61" data-y="110" data-start="1000"
                            data-transform_in="x:left;s:1000;e:Power.easeOut;" data-transform_out="x:left;s:1000;e:Power1.easeOut">
                            <img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/banner-1-left.png" alt="banner-1-left">
                        </div>
						<div class="tp-caption" data-x="950" data-y="59" data-start="1000"
                            data-transform_in="x:right;s:1000;e:Power1.easeOut;" data-transform_out="x:right;s:1000;e:Power1.easeOut">
                            <img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/pos.png" alt="pos">
                        </div>
						<div class="tp-caption" data-x="387" data-y="82" data-start="1000"
                            data-transform_in="x:right;s:1000;e:Power1.easeOut;" data-transform_out="x:right;s:1000;e:Power1.easeOut">
                            <img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/pos-banner-2.png" alt="pos">
                        </div>
						<!--img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/banner-bg.jpg"
                        alt="bg" data-bgfit="cover" data-bgposition="center top" style="width:100%;" data-bgrepeat="no-repeat"-->
						<img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/banner.jpg"
                        alt="bg" data-bgfit="cover" data-bgposition="center top" style="width:100%;" data-bgrepeat="no-repeat">
						
						<div class="tp-caption fade" data-transition="fadeIn" data-x="600" data-y="400" data-start="2000">
                            <a class="banner-button list-group-item-warning animated rotateIn" href="<?php echo $objapp->baseURL('pos-free-trial.php');?>">Try Now</a>
                        </div>
					</div>
				</li>
                <li data-delay="8000" data-transition="fade" data-slotamount="7" data-masterspeed="2000" style="background:#c7edfc;">
                    <div class="elements">                         
                        <div class="tp-caption" data-x="-49" data-y="30" data-start="1000"
                            data-transform_in="s:1000;" data-transform_out="x:right;s:1000;e:Power1.easeOut">
							<img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/pos-banner.png"
                                alt="image-small-line" style="width:1200px;">
                        </div>
						<!--top-->
                        <div class="tp-caption" data-x="634" data-y="66" data-start="1200"
                            data-transform_in="x:right;s:1500;e:Power4.easeOut;" data-transform_out="x:right;s:1500;e:Power1.easeOut">
                            <img class="replace-2x" style="width:383px" src="https://simplystatic.simplypos.in/img/slider/slider-new/image-large-line.png"
                                alt="image-large-line">
                        </div>
						<div class="tp-caption" data-x="1025" data-y="54" data-start="1500"
                            data-transform_in="x:right;s:1500;e:Power4.easeOut;" data-transform_out="x:right;s:1500;e:Power1.easeOut">
							<img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/slider-new/merchants.png"
                                alt="image-small-line">
                        </div>
						
						<!--bottom-->
                        <div class="tp-caption" data-x="173" data-y="388" data-start="1800"
                            data-transform_in="x:left;s:1500;e:Power1.easeOut;" data-transform_out="x:left;s:1500;e:Power1.easeOut">
                            <img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/slider-new/image-large-line.png"
                                alt="image-large-line">
                        </div>
						<div class="tp-caption" data-x="42" data-y="379" data-start="2500"
                            data-transform_in="x:left;s:1500;e:Power4.easeOut;" data-transform_out="x:left;s:1500;e:Power1.easeOut">
							<img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/slider-new/customers.png"
                                alt="image-small-line">
                        </div>
						
						<!--right-->
                       	<div class="tp-caption" data-x="883" data-y="188" data-start="1600"
                            data-transform_in="x:right;s:1500;e:Power4.easeOut;" data-transform_out="x:right;s:1500;e:Power1.easeOut">
                            <img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/slider-new/image-small-line.png"
                                alt="image-small-line">
                        </div>
						<div class="tp-caption" data-x="1025" data-y="177" data-start="1900"
                            data-transform_in="x:right;s:1500;e:Power4.easeOut;" data-transform_out="x:right;s:1500;e:Power1.easeOut">
						   <img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/slider-new/ecomerce.png"
                                alt="image-small-line">
                        </div>
						
						<!--left-->
                        <div class="tp-caption" data-x="173" data-y="268" data-start="2500"
                            data-transform_in="x:left;s:1500;e:Power4.easeOut;" data-transform_out="x:left;s:1500;e:Power1.easeOut">
                            <img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/slider-new/image-small-line.png"
                                alt="image-small-line">
                        </div>
						<div class="tp-caption" data-x="27" data-y="257" data-start="2800"
                            data-transform_in="x:left;s:1500;e:Power4.easeOut;" data-transform_out="x:left;s:1500;e:Power1.easeOut">
							<img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/slider-new/go-cashless.png"
                                alt="image-small-line">
                        </div>
						<!--end-->
						
						<div class="tp-caption fade" data-transition="fadeIn" data-x="500" data-y="450" data-start="2600">
                            <a class="banner-button list-group-item-warning animated rotateIn" href="https://simplypos.in/pos-free-trial.php"><?php echo FREE_DEMO_DAYS;?> Day Free Trial</a>
                        </div>
						

                    </div>
                    <img class="replace-2x" src="https://simplystatic.simplypos.in/img/slider/banner2-bg.jpg"
                        alt="bg" data-bgfit="cover" data-bgposition="center top" width="100%" style="width:100%," data-bgrepeat="no-repeat">
                </li>
				
            </ul>
            <div class="tp-bannertimer"></div>
        </div>
    </div>
</div>


<div class="compatible_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-6"><br/>
                <h6 class="compatible_h6">Simply POS Merchant Management Solution</h6>
                <!--<p class="compatible_p">POS merchant management touch screens, macs, PC's, tablets and phones. 
use Simply Safe POS in internet explorer, firefox, safari and android.</p>-->
            </div>
            <div class="col-sm-3">
                <img src="https://simplystatic.simplypos.in/img/pos/browser-icon.png" alt="browser-icon" class="compatible_img"  />
            </div>
            <div class="col-sm-3">
                <img src="https://simplystatic.simplypos.in/img/pos/os_icons.png" alt="os_icons" class="compatible_img"  />
            </div>
        </div>
        
    </div>
</div>


<div class="container-flud clearHeader">
   <ul class="nav nav-pills">
  <li class="list-group-item list-group-item-warning animated active" style="width: 165px; text-align: center;" onclick="smoothScroll('home')"><i class="fa fa-home" aria-hidden="true"></i>&nbsp; Home</li>
    <li class="list-group-item list-group-item-warning animated " style="width: 165px; text-align: center;" onclick="smoothScroll('POS')"><i class="fa fa-tachometer" aria-hidden="true"></i> POS</li>
     <li class="list-group-item  list-group-item-success animated " style="width: 165px; color:white; text-align: center;" onclick="smoothScroll('FEATURES')"><i class="fa fa-list" aria-hidden="true"></i> Features</li>
  <li class="list-group-item list-group-item-info animated" style="width: 165px; text-align: center;" onclick="smoothScroll('HARDWARE')"><i class="fa fa-cogs" aria-hidden="true"></i> Hardware</li>
  
    <li class="list-group-item list-group-item-warning animated" style="width: 165px; text-align: center;" onclick="smoothScroll('FUNCTIONALITY')"><i class="fa fa-sitemap" aria-hidden="true"></i> Functionality</li>
    <li class="list-group-item list-group-item-success animated" style="width: 165px; text-align: center;" onclick="smoothScroll('SECURITY')"><i class="fa fa-shield" aria-hidden="true"></i> Security</li>
    <li class="list-group-item list-group-item-warning animated" style="width: 165px; text-align: center;" onclick="smoothScroll('PARTNERS')"><i class="fa fa-users" aria-hidden="true"></i> Business Types</li>
    <li class="list-group-item list-group-item-info animated" style="width: 165px; text-align: center;" onclick="smoothScroll('SUPPORT')"><i class="fa fa-support" aria-hidden="true"></i> Support</li>
  </ul>
</div>



<!-- /.fixed_links_relative .col-sm-3 -->
    <div class="col-sm-12 col-xs-12">
        
       <section id="POS" class="pos_block POS">            
            <div class="row">            
                <header class="page-header item" data-aos="zoom-in">
                    <div class="title text-success"><span class="courseTypeFirstLetter" style="color:#f89406;">S</span><span class="courseTypeWord">imply POS</span>
					</div >
                </header>
            </div>
           <div class="row">
                <div class="col-sm-3 item" data-aos="fade-right">
            <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/pos1.jpg" alt="POS" class="center-block featuere_icon"/>
                   <!--i class="pos1 center-block"></i-->
                    <h4 class="feature_item_title" style="color:#f89406;">POINT OF SALE</h4>
                    <p >A point of sale system is a combination of software and hardware that allows merchants to take transactions and simplify key day-to-day business operations</p>			<br/>
                </div></div>
                 <div class="col-sm-3 item" data-aos="fade-right"> <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/cloud.jpg" alt="cloud"  class="center-block featuere_icon"/>
<!--i class="cloud center-block"></i-->
                    <h4 class="feature_item_title" style="color:#f89406;">CENTRALIZED DATA</h4>
                    <p >Simply POS allows instant centralization of data , ability to access data from anywhere there is internet connection, and lower start-up costs</p><br/>
                </div></div>
                <div class="col-sm-3 item" data-aos="fade-left"> <div class="box">
                    <img src="https://simplystatic.simplypos.in/img/touch.jpg" alt="touch"  class="center-block featuere_icon"/>
<!--i class="touch center-block"></i-->
                    <h4 class="feature_item_title" style="color:#f89406;">EASY INTERFACE</h4>
                    <p >Simply POS a complete touch based point of sale solution which offers powerful & rich feature set of tools required to run your store efficiently.</p>
                </div></div>
<div class="col-sm-3 item" data-aos="fade-left">
 <div class="box">
                    <img src="https://simplystatic.simplypos.in/img/mobile.jpg" alt="mobile" class="center-block featuere_icon"/>
		<!--i class="mobile center-block"></i-->
                    <h4 class="feature_item_title" style="color:#f89406;">GO MOBILE </h4>
                    <p >Quickly see items that need your attention, and track your business. Add products, assign product image, change a price, or add inventory – all from your mobile. </p>
                </div></div>
                </div>
        </section>
        <!-- /#pos -->
        
      
  
     <?php //include_once('quick_links.php'); ?>

        
        <div id="FEATURES" class="pos_block FEATURES">
            <div class="row">
                 <header class="page-header item" data-aos="zoom-in">
                    <div class="title text-success"><span class="courseTypeFirstLetter" style="color:#738d00">F</span><span class="courseTypeWord">eatures</span>
					</div >
                </header>
                 
                <h3 class="pos_block_heading item" data-aos="fade-left">Simply POS is easy to use, faster and fully integrated, get started within 10 minutes.</h3>
                <p class="text-center item" data-aos="fade-left">There are many cloud POS options out there. So why do merchant the world over choose Simply POS?</p>
            </div>
            <div class="row">
                <div class="col-sm-3 item" data-aos="fade-right">
            <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/cloud_.jpg" alt="cloud" width="85" class="center-block featuere_icon" />
                   <!--i class="cloud_ center-block"></i-->
                    <h4 class="feature_item_title" style="color:#738d00">CLOUD-BASED</h4>
                    <p >Sign in and work from anywhere. Your sales, products and reports are always available, safe, and up to date.</p><br/>
                </div></div>
                <div class="col-sm-3 item" data-aos="fade-right"> <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/cardpay.jpg" alt="cardpay" width="85"  class="center-block featuere_icon"/>
<!--i class="cardpay center-block"></i-->
                    <h4 class="feature_item_title" style="color:#738d00">ACCEPT ANY PAYMENTS</h4>
                    <p >POS works with leading merchant providers globally, so you can choose the best way to accept payments in your store.</p><br/>
                </div></div>
                <div class="col-sm-3 item" data-aos="fade-left"> <div class="box">
                    <img src="https://simplystatic.simplypos.in/img/responsive.jpg" alt="responsive" width="85" class="center-block featuere_icon" />
<!--i class="responsive center-block"></i-->
                    <h4 class="feature_item_title" style="color:#738d00">WORKS ON ANY DEVICE</h4>
                    <p >POS works on iPad, Mac or PC. All you need is a browser. It may even work with POS hardware you already own.</p>
                </div></div>
<div class="col-sm-3 item" data-aos="fade-left">
 <div class="box">
                     <img src="https://simplystatic.simplypos.in/img/connect.jpg" alt="connect" width="85"  class="center-block featuere_icon"/>
                     <!--i class="connect center-block"></i-->
                    <h4 class="feature_item_title" style="color:#738d00">CONNECT ADD-ONS</h4>
                    <p >Simply POS connects to the best business apps in accounting, ecommerce, staff rostering and more to run your entire business online.</p>
                </div></div>
            </div>
                <div class="row">
<br />
                <div class="col-sm-3 item" data-aos="fade-right">
            <div class="box">
                    <img src="https://simplystatic.simplypos.in/img/ecommerce.png" alt="ecommerce" width="85" class="center-block featuere_icon" />
                    <!--i class="ecommerce center-block"></i-->
                    <h4 class="feature_item_title" style="color:#738d00">SIMPLY ECOMMERCE</h4>
                    <p >Easily fulfill orders and bring all your business operations into one account, with a global view. With a central product catalog, you can choose what to sell in-store, online, or both.</p><br/>
                </div></div>
                <div class="col-sm-3 item" data-aos="fade-right"> <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/offline.jpg" alt="offline" width="85"  class="center-block featuere_icon"/>
                   <!--i class="offline center-block"></i-->
                    <h4 class="feature_item_title" style="color:#738d00">WORKS OFFLINE</h4>
                    <p >Slow internet shouldn’t slow down your business. That is why Simply POS lets you work offline even without the internet and once you’re reconnected, it syncs all your sales data automatically.</p><br/>
                </div></div>
                <div class="col-sm-3 item" data-aos="fade-left"> <div class="box">
                    <img src="https://simplystatic.simplypos.in/img/order.jpg" alt="order" width="85" class="center-block featuere_icon" />
                    <!--i class="order center-block"></i-->
                    <h4 class="feature_item_title" style="color:#738d00"> STOCK ORDERS</h4>
                    <p >Use automated reordering, and adjust reorder points and restock levels to make sure you never have too much or too little stock on your shelves.</p>
                </div></div>
<div class="col-sm-3 item" data-aos="fade-left">
 <div class="box">
                     <img src="https://simplystatic.simplypos.in/img/customerf.jpg" alt="customerf" width="85"  class="center-block featuere_icon"/>
                     <!--i class="customerf center-block"></i-->
                    <h4 class="feature_item_title" style="color:#738d00">CUSTOMER FOCUS</h4>
                    <p >POS automate the process of retargeting and rewarding your customers with its special module. It will automatically send unique offers and reminders to customers based on their purchase behaviour.</p>
                </div></div>
            </div>
           
           
            </div>
       
        <!-- /#FEATURES -->
        
        <div id="hardware" class="pos_block HARDWARE">
            <div class="row">            
                <header class="page-header item" data-aos="zoom-in">
                    <div class="title text-success"><span class="courseTypeFirstLetter" style="color:#0098ca;">H</span><span class="courseTypeWord">ardware</span>
					</div >
                </header>
                
               
                
            </div>
            <div class="row">
                <div class="feature_images center col-sm-4 item" data-aos="fade-right">
                   <!--
                    <img  src="https://simplystatic.simplypos.in/img/hardware.jpg" alt="pos-hardware" class="img-responsive" width="300" data-appear-animation="tada"/>
                     -->
 <img  src="https://simplystatic.simplypos.in/img/pos/banner.png" alt="pos-hardware" class="img-responsive"  width="300"/>

                     <br /> <br /><br /> <br />
 <h5>USE YOUR OWN HARDWARE</h5>
                    <p>Simply POS might work with your current POS system, smartphone or tablet. Simply POS works on any device with a web-browser.</p>
                </div>
                <div class="col-sm-4">
                  <img  src="https://simplystatic.simplypos.in/img/pos/hardware.png" alt="pos-hardware" class="img-responsive" width="300" />
     <br /> <br />
                   <h5>BUY NEW HARDWARE</h5>
                    <p> Our recommended hardware will definitely work with Simply POS. We provide flexible and reliable hardware choices. Our integrated POS solution makes processing sales easy and efficient.</p>
                   </div>
                 <div class="feature_images center col-sm-4 item" data-aos="fade-left" style="margin-top: -15PX;">
             <!-- 
<img  src="https://simplystatic.simplypos.in/img/barcode.jpg" alt="pos-hardware" class="img-responsive" width="300" data-appear-animation="tada"/> 
-->
              <img  src="https://simplystatic.simplypos.in/img/hardware.jpg" alt="pos-hardware" width="300" class="img-responsive" width="300" />
                  <h5>PERIPHERAL DEVICES</h5>
                    <p>Peripheral items are added to enhance the functionality of your computer. Simply POS easily supports devices like printers, barcode scanners and cash drawers. We offer complete packages & individual items to get your store running in no time.</p>
                    
                </div>
            </div>
            
        </div>
        <!-- /#HARDWARE -->    
    
        <div id="Functionality" class="pos_block FUNCTIONALITY">
            
            <div class="row">            
                <header class="page-header item" data-aos="zoom-in">
<div class="title text-success"><span class="courseTypeFirstLetter" style="color:#c10841;">F</span><span class="courseTypeWord">unctionality & Modules</span></div >
                    
                </header>
                
                              
            </div>
            <div class="row">
				<div class="col-sm-4 col-xs-12 item" data-aos="fade-right">
                     <i class="pos_2 img-responsive" ></i>
					<img src="https://simplystatic.simplypos.in/img/pos_2.jpg" alt="pos_2" style="max-height:300px;"  class="center-block "/>					 
                </div> 

				<div class="col-sm-4 item" data-aos="fade-left"> <div class="box">
                  <img src="https://simplystatic.simplypos.in/img/inventory.png" alt="inventory"  class="center-block featuere_icon"/>
                  <!--i  class="inventory center-block"></i-->
                    <h4 class="feature_item_title" style="color:#c10841">INVENTORY MANAGEMENT</h4>
                    <p >Manage your entire inventory with Simply POS. An easy way to know exactly what you have in stock at all times, transfer inventory and place orders with your vendors. Create product variants of different sizes, colors or any variations with barcodes and labels</p><br/>
                </div></div>
                
                 <div class="col-sm-4 item" data-aos="fade-left"> <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/dashboard-desktop-windows.jpg" alt="dashboard-desktop-windows" width="85"  class="center-block featuere_icon"/>
                    <!--i class="dashboard-desktop-windows center-block"></i-->
                    <h4 class="feature_item_title" style="color:#c10841">DASHBOARD</h4>
                    <p >Access your dashboard and reports to see your store’s performance - anytime, anywhere. The Dashboard provides a high-level view of everything that’s happening in your store.See daily sales, best-selling products, sales and quotations, quantity alerts, user profiles and more.</p><br/>
                </div></div>             
                
            </div>
            <br/>
            
            <div class="row">
 <div class="col-sm-4 item" data-aos="fade-left"> <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/customerm.jpg" alt="customerm" width="85"  class="center-block featuere_icon"/>
                     <!--i class="customerm center-block"></i-->
                     <h4 class="feature_item_title" style="color:#c10841">CUSTOMER MANAGEMENT</h4>
                    <p>Track real time information between merchant and customers. View your customer profiles and notify them of upcoming sales and offers through emails. Customer transactions are saved to their profile where you can view their purchase history, loyalty and accounts.</p><br/>
                </div></div> 

  <div class="col-sm-4 item" data-aos="fade-left"> <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/reporting.jpg" alt="reporting" width="85"  class="center-block featuere_icon"/>
                    <!--i  class="reporting center-block"></i-->
                    <h4 class="feature_item_title" style="color:#c10841">REPORTING</h4>
                    <p >You can access your sales data in real time to help track the performance of stores, products and staff and take necessary corrective actions. Review daily reports for payments, purchases, expenses, suppliers and many more.</p><br/>
                </div></div>
                
                 <div class="col-sm-4 item" data-aos="fade-left"> <div class="box">
                   <img src="https://simplystatic.simplypos.in/img/account.jpg" alt="account" width="85"  class="center-block featuere_icon"/>
                    <!--i class="account center-block"></i-->
                    <h4 class="feature_item_title" style="color:#c10841">FINANCIAL ACCOUNTING</h4>
                    <p >Eliminate the risk of data entry errors; simplify your accounting through reports like payment reports and profit and loss statements. Quickly access customer payment history and current balances with accuracy.</p><br/>
                </div></div>             
                
            </div>
            
        </div>
        <!-- /#Functionality -->
    
        <div id="Security" class="pos_block SECURITY">
            
            <div class="row">            
                 <header class="page-header item" data-aos="zoom-in">
                    
<div class="title text-success"><span class="courseTypeFirstLetter" style="color:#738d00;">S</span><span class="courseTypeWord">ecurity</span></div >
                </header>
            </div>
            <div class="row">                
                <div class="col-sm-offset-1 col-sm-4 item" data-aos="fade-right"> <br/>
                    <!--i class="security_image3 img-responsive center-block"  data-appear-animation="tada"></i-->
					<img src="https://simplystatic.simplypos.in/img/security_image3.jpg" alt="security_image3" class="center-block"/>
                </div>
                <div class="col-sm-7 item" data-aos="fade-left">
                    <div class="title-box">
                        <h2 class="title" style="vertical-align: middle;"><img class="SSL" /> Simply POS software is 100% secure.</h2>
<!-- <img src="https://simplystatic.simplypos.in/img/pci.jpg" width="80px"  height="30px"/> -->
                    </div>
 <p>&nbsp;&nbsp; POS (Point of Sale) Security is the prevention of unauthorized access by third parties who look for security gaps to sneak into customer information (like credit card information) and cause data theft. The main objective is to generate secure customer transactions by tackling security risks and providing data security.</p> 

<p>&nbsp;&nbsp; Simply POS Systems is 100% secure solution. Depending on the roles the POS software allows to authorize or restrict users. The access has many levels of security which can be controlled easily.</p>
                  
                    <ul class="font_big">
                       
                        <li>&rightarrow; &nbsp; PCI compliant encryption</li>
                        <li>&rightarrow; &nbsp; Secured messaging (no profiling by provider)</li>
                        
                        
                    </ul>
                </div>
            </div>
            
            
        </div>
        <!-- /#Security -->
        
        <div id="partners" class="pos_block PARTNERS">            
            <div class="row">
                <header class="page-header item" data-aos="zoom-in">
                    
<div class="title text-success"><span class="courseTypeFirstLetter" style="color:#f89406;">B</span><span class="courseTypeWord">usiness Types</span></div >
                </header>
                 
               <h3 class="pos_block_heading item" data-aos="fade-left">Whatever business you’re in, we’ll make a POS system that fits like a glove.</h3>
                <p class="text-center item" data-aos="fade-left">Choose from the list below, and let’s get started on making sales simple.</p>
                
            </div>
            <div class="container">
              <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype"> 
					<img src="https://simplystatic.simplypos.in/img/retail.jpg" alt="retail"  style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
               Retail
              </a>
              </div>
              <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
               <img src="https://simplystatic.simplypos.in/img/Apparel.jpg" alt="Apparel"  style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
               Apparel
              </a>
              </div>
              <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                  <img src="https://simplystatic.simplypos.in/img/restorent.jpg" alt="Restaurants"  style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
               Restaurants
              </a>
              </div>
                            <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                 <img src="https://simplystatic.simplypos.in/img/homeDecore.jpg" alt="HomeDecore"  style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
               Home Decor
              </a>
              </div>


<div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                  <img src="https://simplystatic.simplypos.in/img/Pharmaceutical.jpg" alt="Pharmaceutical"  style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
               Pharmaceutical
              </a>
              </div>
              <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                 <img src="https://simplystatic.simplypos.in/img/ELECTRONICS.jpg" alt="ELECTRONICS" style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
             Electronics
              </a>
              </div>
              <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                 <img src="https://simplystatic.simplypos.in/img/electrical.jpg" alt="electrical" style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
               Electrical & Hardware
              </a>
              </div>
             <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                  <img src="https://simplystatic.simplypos.in/img/Stationary.png" alt="Stationary" style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
             Stationary
              </a>
              </div>
            
            
       <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                 <img src="https://simplystatic.simplypos.in/img/Babcare.jpg" alt="Babcare" style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
               Baby care & toys
              </a>
              </div>
              <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
               <img src="https://simplystatic.simplypos.in/img/Bakery.jpg" alt="Bakery" style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
              Bakery
              </a>
              </div>
              <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                 <img src="https://simplystatic.simplypos.in/img/Salon.jpg" alt="Salon" style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
               Salon & SPA
              </a>
              </div>
                            <div class="col-sm-3" style="text-align: center;    font-size: 19px;">
              <a href="#"> 
                <div class="imgtype">
                 <img src="https://simplystatic.simplypos.in/img/service.png" alt="service" style="height: 170px;width: 200px;border-radius: 50%; border:1px solid #eef;"/>
                </div>
               <br/>
              Services
              </a>
              </div>
            </div>
      

           
        </div>
<style>
.imgtype{
width:100%;
text-align:center;
 margin-top: 60px;
}
.imgtype img
{
height:170px;
width:200px;
border-radius: 50%;
}


</style>
        <!-- /#partners -->
     

        <div id="support" class="pos_block SUPPORT">            
            <div class="row"> 
                <header class="page-header item" data-aos="zoom-in">
                 
<div class="title text-success"><span class="courseTypeFirstLetter" style="color:#0098ca;">S</span><span class="courseTypeWord">upport & Services</span></div >
                </header>
                 
                <h3 class="pos_block_heading">We measure ourselves by your happiness</h3>
                <p style="text-align:center">We ask customers to rate us every time we help them, and publish those ratings because we hold ourselves to the same high standards you do.</p>
            </div>
            <div class="row">
                <div class="col-sm-offset-1 col-sm-4">
                    <img src="https://simplystatic.simplypos.in/img/pos/call-center.png" alt="call-center" class="img-responsive"  />
                </div>
                <div class="col-sm-7 item" data-aos="fade-left">
                    <div class="title-box">
                        <h2 class="title">We are here for you - 24 hours a day, 7 days a week.</h2>
                    </div>
                     
                    <h6><i class="fa fa-check-square-o text-success" aria-hidden="true"></i> Global support</h6> 
                    <p>With offices in USA and India, our friendly support team is quick to respond, on every channel.</p>
                    <h6><i class="fa fa-check-square-o text-success" aria-hidden="true"></i> Email and live chat</h6>
                    <p>Email our helpful team to get assistance with everything from hardware to inventory, to adding a new register and expanding to new locations, or try our live chat and get help on the spot. Both free with all Simply POS paid subscriptions.</p>
                    <h6><i class="fa fa-check-square-o text-success" aria-hidden="true"></i> Priority phone support</h6>
                    <p>Skip to the front of the line with priority phone support. Our dedicated team is here anytime you need.</p>
                    <h6><i class="fa fa-check-square-o text-success" aria-hidden="true"></i> Social media</h6>
                    <p>Find us on twitter, facebook & linkedin, we’ll keep you up to date with the latest news and features, answer any questions, and always reply to your messages.</p>
                    </div>
            </div>
            
        </div>
        <!-- /#support -->
        
        
        
        <div id="free_trial" class="pos_block FREE_TRIAL">            
            <div class="row">            
                <header class="page-header item" data-aos="zoom-in">
                    <h2 class="title text-success">Try out our POS software for <?php echo FREE_DEMO_DAYS;?> days free.</h2>
                </header>
                
                <h4 class="pos_block_heading">Ready to take the next step? Here are some options to proceed.</h4>                
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <h1 class="text-center" ><i class="fa fa-phone" aria-hidden="true"></i></h1>
                    <h4 class="text-center text-danger">Give us a call</h4>
                    <h5 class="text-center">0755-2555-950<br/>0755-2985-733<br/>0755-4905-950</h5>
                </div>
                <div class="col-sm-4 border-left">
                    <h1 class="text-center"><i class="fa fa-envelope-o" aria-hidden="true"></i></h1>
                    <h4 class="text-center text-danger">Send us email</h4>
                    <h5 class="text-center">pos@simplysafe.in<br/>possales@simplysafe.in</h5>
                </div>
                <div class="col-sm-4 border-left">
                    <h1 class="text-center"><i class="fa fa-keyboard-o" aria-hidden="true"></i></h1>
                    <h4 class="text-center text-danger">Fill the free form</h4>
                    <h5><a href="pos-free-trial.php" class="btn btn-success center-block"><i class="fa fa-check" aria-hidden="true"></i> <?php echo FREE_DEMO_DAYS;?>  Days free trial </a></h5>
                </div>
                
            </div>
        </div>
        <!-- /#Free_Trial -->
        
     <!--   <div id="faqs" class="pos_block FAQ">            
            <div class="row">            
                <header class="page-header">
                    <div class="container">
                        <h2 class="title text-danger">Frequently Asked Questions</h2>
                    </div>
                </header>
                 
                <h4 class="pos_block_heading">Honest (non-salesy) answers to your top questions about switching to Simply Safe</h4>
            </div>
            <div class="row">
                <div  class="bottom-padding col-sm-12">
                    <div  class="title-box">
                      <h2  class="title">FAQ's</h2>
                    </div>
                   < ?php //include_once 'pos-faqs.php'; ?>
                  </div>
            </div>
        </div> -->
        <!-- /#faqs -->
    </div>




<div class ="advertise" style="display:none" id="advertise1"><span class="close1" onclick="return closePopup();">X</span><img src="https://simplystatic.simplypos.in/img/Special-Limited-Time-Offer.png" alt ="@999/- yearly"></img></div>
        
<!--popup for home page-->         
<!--div id="myModal" class="modal fade" role="dialog" style="background: rgba(0, 0,0,0.5);">
  <div class="modal-dialog">
    <!-- Modal content->
      <center><img alt="Download" src="https://simplystatic.simplypos.in/img/approved-stamp-1.png" ></center>
	  
      

  </div>
  <button type="button" class="close" data-dismiss="modal">&times;</button>
</div-->
<!--popup for home page end-->
<div class="clearfix"></div>

<?php include_once 'footer.php'; ?>

<!--link href="https://simplypos.in/css/aos.css" rel="stylesheet">
<script src="https://simplypos.in/css/aos.js"></script>
<script>
    AOS.init({
        duration: 1200,
    })
</script>
<script>
.item {
  width: 200px;
  height: 200px;
  margin: 50px auto;
  padding-top: 75px;
  background: #ccc;
  text-align: center;
  color: #FFF;
  font-size: 3em;
}
</style-->

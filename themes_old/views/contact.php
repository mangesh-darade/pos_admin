<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <main id="main">
     <section id="contact_with" style="">
          <header class="section-header" style="padding-top:140px;">
          <h3 >Contact With Us</h3>
         </header>
        <div class="row">
          <div class="col-md-6 left_box wow fadeInUp">
            <div class="form" style="padding-top:30px;">
            <div id="errormessage"></div>
            <form action="testing" method="post" role="form" class="contactForm">
            <div class="form-row">
              <div class="form-group col-md-6">
			    <img src="<?=$assets?>img/user.png" alt=""/>  
                <input type="text" name="first_name" class="simply_form" id="first_name" placeholder="First Name"/>
                <div class="validation"></div>
              </div>
              <div class="form-group col-md-6">
			    <img src="<?=$assets?>img/user.png" alt=""/>  
                <input type="text" class="simply_form" name="last_name" id="last_name" placeholder="Last Name"/>
                <div class="validation"></div>
              </div>
              <div class="form-group col-md-6">
			    <img src="<?=$assets?>img/call.png" alt=""/>  
                <input type="text" class="simply_form" name="phone_number" id="phone_number" placeholder="Phone Number" />
                <div class="validation"></div>
              </div>
              <div class="form-group col-md-6">
			    <img src="<?=$assets?>img/mail.png" alt=""/>  
                <input type="email" class="simply_form" name="email" id="email" placeholder="Email ID" data-rule="email" data-msg="Please enter a valid email"/>
                <div class="validation"></div>
              </div>
            </div>
            <div class="form-row" style="padding-top:40px;">
              <div class="form-group col-md-12">
			  <img src="<?=$assets?>img/message.png" alt=""/>  
              <input type="text" class="simply_form" name="subject" id="subject" placeholder="Type Message" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
              <div class="validation"></div>
              </div>
              <div class="form-group col-md-6">
              </div>
              <div class="form-group col-md-6">
              <div class="text-center">
              	 <button type="submit" class="btn simply_bt">SUBMIT</button>
              </div>
              </div>    
            </div>
           </form>
		  </div>
          </div>
		  <div class="col-md-6 right_box">
		    <h2>Head Office</h2>
			<div class="cont_box">
		    <div style="margin-left:50px;">
              <h4><span><i class="fa fa-map-marker"></i></span>Address</h4>
              <p>
              Plot no 5, Second floor, Above
              Godrej showroom,<br> MP Nagar Zone - 2,
              Bhopal 462011
              </p>      
              <h4><span><i class="fa fa-phone"></i></span>call</h4><p> +91 7554905950 +91 7554935950</p>
              <h4><span><i class="fa fa-envelope"></i></span>Email</h4><p> pos@simplysafe.in </p>
            </div>
			</div>
			<h2>USA Office</h2>
			<div class="cont_box" style="height:180px; ">
		    <div style="margin-left:50px;">
              <h4><span><i class="fa fa-map-marker"></i></span>Address</h4>
              <p>
              1310 SE Maynard Rd. Cary, NC 27153(USA)
              </p>      
              <h4><span><i class="fa fa-phone"></i></span>call</h4><p> +1(919)377-8484</p>
            </div>
			</div>
          </div>
        </div>
		<div class="row" style="padding-bottom: 10px;">
		  <div class="col-md-12">
		  <div class="mytbody">
                    <table class="table teable-responsive">
                        <tbody>
                            <tr class="title">
                                <td>India Offices</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Bhopal</td>
                                <td>Plot no 5, Second floor, Above Godrej showroom, 462011, MP Nagar Zone - 2, Bhopal, Madhya Pradesh.</td>
                            </tr>
                            <tr>
                                <td>Delhi</td>
                                <td> E - 148, 2nd Floor E-Block, Sector 63 Noida, UP - 201301</td>
                            </tr>
					<!--		<tr>
                                <td>Indore</td>
                                <td>327, Saket Nagar, 452018, Indore, Madhya Pradesh.</td>
                            </tr>-->
							<tr>
                                <td>Nagpur</td>
                                <td>Gyanjyoti-6 Apartment, Flat No. 301, 3rd floor, Plot No. 103, Shree Nagar, Empress Mill Society, Near Narendra Nagar Square, Manewada Ring Road, Nagpur-440015, Maharashtra.</td>
                            </tr>
							<tr>
                                <td>Pune</td>
                                <td> Plot no 204 ,Bhusari Colony , Neel Prabha Apartment ,Paud Road ,Bhusari Colony ,kothrud Depot ,pune ,Maharashtra -411038.</td>
                            </tr>
							<tr>
                                <td>Bangalore</td>
                                <td>Suraj Plaza, 8th F Main Rd, Near-Canara Bank, Jayanagar, Bengaluru, Karnataka 560011.</td>
                            </tr>
							<tr class="title">
                                <td>USA Offices</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>North Carolina</td>
                                <td>1310 SE Maynard Rd.
                                     Cary, NC 27513 (USA)</td>
                            </tr>
                        </tbody>    
                    </table>    
                </div>
		    </div>
          </div>
    </section> 
  </main>
  
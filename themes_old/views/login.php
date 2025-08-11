<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main id="main">

    <section id="login_sec" style="">
          <header class="section-header" style="padding-top:110px; font-size: 14px; font-family: Poppins; padding-left: 2%; padding-right: 2%;">
            <p>Great Step towards transformation, Great Step towards transparency. We are GST ready !!</p>
         </header>
      <div class="container" >
        <div class="row">
           <div class="col-md-7">
		   </div>
          <div class="col-md-5 login_col wow fadeInUp" style="float:right;">
            <div class="login_head">
			  <h2>Sign In <br><span>Registered Merchant</span></h2>
			  <a href="<?=base_url('free_trial')?>"><button type="submit" class="btn simply_bt">GET A FREE TRAIL</button></a>
			</div>
            <div class="form" style="padding-top:30px;">
            <div id="errormessage"></div>
            <form action="" method="post" role="form" class="contactForm">
            <div class="form-row">
              <div class="form-group col-md-12">
                <input type="text" name="first_name" class="form-control simply_form" id="first_name" placeholder="Email or Mobile" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
                <div class="validation"></div>
              </div>
              <div class="form-group col-md-12">
                <input type="text" class="form-control simply_form" name="last_name" id="last_name" placeholder="Password"/>
                <div class="validation"></div>
              </div>
            </div>
            <div class="form-row" style="padding-top:40px;">
              <div class="form-group col-md-5">
              <div class="text-center"><button type="submit" class="btn simply_bt">SUBMIT</button></div>
              </div> 
        	  <div class="form-group col-md-7" >
                  <a class="forgot_pass" href="<?=base_url('forgot_password')?>">Forgot Password?</a>
			  </div>
            </div>
            <div class="form-row" style="padding-top:0px;">
        	  <div class="col-md-12">
                  <p class="alredy_signin">If you are not registered? <a href="<?=base_url('free_trial')?>">Try Free Trail</a></p>
			  </div>
            </div>
           </form>
		   </div>
          </div>
        </div>
	  </div>
    </section> 
  </main>

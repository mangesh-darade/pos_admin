<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<main id="main">
    <section id="trial" style="">
        <header class="section-header" style="padding-top:140px;">
            <h3>Thank you for requesting POS trial.</h3>
            <p class="text-success" style="text-align: center;">
                You have been sent the verification code on your registered mobile.
            </p>
        </header>
        <div class="row">
            <div class="col-md-12 left_box wow fadeInUp">
                <div class="form" style="padding-top:30px;">
                    <div id="errormessage" class="text-danger"><?php echo validation_errors(); ?></div>
                    <?php echo form_open('mobile_verification', ' class="" '); ?>
                       <?php  if($this->session->flashdata('Error_message')) { ?>
                           <div id='msg' class='text-center text-danger'><?= $this->session->flashdata('Error_message')?></div>
                       <?php } ?>
                        <div class="row  col-sm-offset-12">
                           
                                <input  type="hidden" name="action" value="otp_verification" />
                                <input  type="hidden" name="phone" value="<?=$_GET['u']?>" />
                                <div class="col-sm-3 form-group">
                                </div>    
                                <div class="col-sm-offset-4 col-sm-4 form-group">
                                    <input type="text" class="form-control" name="otp" id="otp" maxlength="4" style="font-size: 20px; text-align: center;" value="" />
                                </div>
                                <div class="col-sm-4 form-group">
                                    <button type="submit" class="btn btn-primary btn-lg center-block request-form ">Verify Code</button>
                                </div>
                           
                        </div>
                    <?php  echo form_close(); ?>
                </div>
            </div>
         </div>     
    </section>     
     
</main>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main id="main">
    <section id="trial" style="">
        <header class="section-header" style="padding-top:140px;">
            <h3>Start POS 14 day free trial now.</h3>
        </header>
        <div class="row">
            <div class="col-md-12 left_box wow fadeInUp">
                <div class="form" style="padding-top:30px;">
                    <div id="errormessage" class="text-danger"></div>
                    <?php echo form_open('free_trial', ' class="" '); ?>
                    <?php
                        $data = array( 'trial_request'  => '1' );

                        echo form_hidden($data);
                    ?>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="text" class="simply_form" name="name" value="<?= set_value('name') ?>" id="name" maxlength="60" placeholder="* Full Name" required="required" />
                                <div class="validation"><?php echo form_error('name'); ?></div>
                            </div>                            
                            <div class="form-group col-md-6">
                                <input type="email" maxlength="55" class="simply_form" name="email" id="email" value="<?= set_value('email') ?>" placeholder="* Email" required="required"/>
                                <div class="validation"><?php echo form_error('email'); ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="row" style="padding:0px;">
                                    <div class="col-md-4" style="padding:0px;">
                                        <select name="country" id="country" class="simply_form" required="required">
                                           <option value="India~91" >India (+91)</option>
       <!--                                    <option value="United Kingdom~44" >United Kingdom (+44)</option>
                                           <option value="United States~1" >United States (+1)</option>-->
                                       </select> 
                                        <div class="validation"><?php echo form_error('country'); ?></div>
                                    </div>
                                    <div class="col-md-8" >
                                        <input type="text" name="phone" class="simply_form" id="phone" value="<?= set_value('phone') ?>" maxlength="10" placeholder="* Phone No." required="required" />

                                    </div>
                                    <div class="validation"><?php echo form_error('phone'); ?></div>
                                </div>
                            </div>
                            <!--<div class="form-group col-md-6">
                                <select name="country" id="country" class="simply_form" required="required">
                                    <option value="India~91" >India (+91)</option>
                                    <option value="United Kingdom~44" >United Kingdom (+44)</option>
                                    <option value="United States~1" >United States (+1)</option>
                                </select> 
                                <div class="validation"></div>
                            </div>-->
                           
                            <div class="form-group col-md-12">
                                <select class="simply_form" id="type" name="type" required="required" >
                                    <option value="">* Select Merchant Type</option>
                                    <?php                      
                                        if(is_array($merchant_types)){

                                           $selected = '';

                                            foreach($merchant_types as $id => $type) {
                                               if($merchant_type_id == $id) {
                                                  $selected = ' selected="selected"'; 
                                               }
                                                echo '<option value="'.$id.'" '. $selected.'>'.$type.'</option>';
                                            }
                                        }
                                    ?>                                                   
                                </select>
                                <div class="validation"><?php echo form_error('type'); ?></div>
                            </div>

                            <div class="form-group col-md-6">
                                <input type="text" name="business_name" maxlength="60" value="<?= set_value('business_name') ?>" class="simply_form" id="business_name" placeholder="* Business Name" required="required"/>
                                <div class="validation"><?php echo form_error('business_name'); ?></div>
                            </div>
                             <div class="form-group col-md-6">
                                <input type="text" name="state" class="simply_form" id="state" value="<?= set_value('state') ?>" maxlength="50" placeholder="State Name" />
                                <div class="validation"><?php echo form_error('state'); ?></div>
                            </div>

                            <div class="form-group col-md-6">
                                <input type="text" class="simply_form" name="city" value="<?= set_value('city') ?>" id="city" maxlength="32" placeholder="* City Name" required="required" />
                                <div class="validation"><?php echo form_error('city'); ?></div>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="simply_form" name="pincode" id="pincode" value="<?= set_value('pincode') ?>" maxlength="6" placeholder="* Pincode" required="required" />
                                <div class="validation"><?php echo form_error('pincode'); ?></div>
                            </div>
                            <div class="form-group col-md-8 col-sm-8">
                                <input type="text" name="pos_name" maxlength="32" value="<?= set_value('pos_name') ?>"  class="simply_form" id="pos_username" placeholder="Web Url" />
                                <div class="validation"><?php echo form_error('pos_name'); ?></div>
                            </div>

                            <div class="form-group col-md-4 col-sm-4">
                                <p style="font-family:Poppins; position:absolute; bottom:-22px;">.simplypos.in</p>
                            </div>

                            <div class="form-group col-md-6">
                                <input type="text" name="username" value="<?= set_value('username') ?>" maxlength="20" class="simply_form" id="username" placeholder="* Choose Username" required="required"/>
                                <div class="validation"><?php echo form_error('username'); ?></div>
                            </div>

                            <div class="form-group col-md-6">
                                <input type="password" name="password" maxlength="32" class="simply_form" id="pos_username" placeholder="* Choose Password" value="" required="required" autocomplete="new-password" />
                                <div class="validation"><?php echo form_error('password'); ?></div>
                            </div>
                            <div class="form-group col-md-12">
                                <textarea class="simply_form" rows="3" maxlength="200" id="message" name="message" maxlength="255" placeholder="Type your message here.." ><?= set_value('message') ?></textarea>
                                <div class="validation"><?php echo form_error('message'); ?></div>
                            </div>          
                            <div class="row form-group col-sm-4 col-sm-offset-4 col-xs-12">
                                <div id="example1"></div>                                    
                            </div>
                            <div class="form-group col-md-12">
                                <label><input type="checkbox" required="required"> &nbsp I agree to all <a class="forgot-link" href="<?= base_url('terms_conditions') ?>">terms and conditions.</a></label>
                                <div class="validation"></div>
                            </div>
                            <div class="form-group col-md-4">                                
                                <!--<button type="submit"  onclick="return verifyCallback();" class="btn simply_bt" style="">Start POS Free Trial</button>-->
                                <button type="submit" class="btn simply_bt" style="">Start POS Free Trial</button>
                                <div class="validation"></div>
                            </div>
                        </div>
                    <?php   
                        echo form_close();
                    ?>
                    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
                </div>

            </div>
        </div>

    </section> 
</main>

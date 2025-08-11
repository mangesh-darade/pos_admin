<?php
include_once('../../application_main.php');

$objPackages = new packages; 

$smsPackageList = $objPackages->getSmsPackageList(); 
 
?>
<div style="padding: 50px;">
    <h3>Upgrade SMS Package.</h3> <hr/>
    <div class="row form-group hide-element">
        <ul class="list-unstyled">
        <?php
            if(is_array($smsPackageList)){
                foreach ($smsPackageList as $key => $smspack) {
                    extract($smspack);
                    ?>
                    <li class="col-sm-4 col-xs-12">
                        <label><input type='radio' name="sms_pack" value='<?php echo "$id~$price~$quantity";?>'> <?php echo $title;?></label>
                    </li> 
                    <?php
                }//end for.
            }//end if.
        ?> 
        </ul>
    </div>
    <div class="row form-group hide-element">
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="transaction_mode">Payment Mode</label>
            <select name="transaction_mode" id="transaction_mode" class="form-control" >
                <option value="">--Select One--</option>                
                <option value="due" selected="selected">Due Payment</option>
                <option value="cash">Cash</option>
                <option value="cheque">Cheque</option>
                <option value="bank_deposit">Bank Deposit</option>
                <option value="net_banking">Net Banking</option>
                <option value="card">Debit/Credit Card</option>
                <option value="wallet">Wallet Payment</option>
                <option value="upi">UPI</option>
            </select>
        </div>
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="transaction_id">Transaction Id</label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control" />
        </div>
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="transaction_id">Transaction Amount</label>
            <input type="text" name="transaction_amount" id="transaction_amount" class="form-control" />
        </div>                
    </div>
    
    <hr class="hide-element"/>
    <div class="row form-group text-center">
        <div class="col-sm-12 text-left" id="alert_sms_msg"></div>
        <input type="hidden" name="sms_merchant_id" id="sms_merchant_id" value="<?php echo $_POST['id'];?>" />
        <button type="button" class="btn btn-info hide-element" id="btn_active_sms_pack">Active SMS Package</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>


<script>

$(document).ready(function(){
    
    
     $('#btn_active_sms_pack').click(function(){
        
        var merchantId = $('#sms_merchant_id').val();
        
        
        if($('[name="sms_pack"]').is(':checked')){
            
            var package = $('[name="sms_pack"]:checked').val();
            var transaction_mode = $('#transaction_mode').val();
            var transaction_id = $('#transaction_id').val();
            var transaction_amount = $('#transaction_amount').val();
            
            var postData = 'action=smsPackUpgrade';
                postData = postData + '&id='+merchantId;
                postData = postData + '&package='+package;
                postData = postData + '&transaction_mode='+transaction_mode;
                postData = postData + '&transaction_id='+transaction_id;
                postData = postData + '&transaction_amount='+transaction_amount;
            
            $.ajax({
                type: "POST",
                url: "ajax_request/merchant_actions.php",
                data: postData,
                beforeSend: function(){
                    $('#alert_sms_msg').removeClass('text-danger'); 
                    $('#alert_sms_msg').addClass('text-info'); 
                    $('#alert_sms_msg').html("<i class='fa fa-refresh fa-spin'></i> Please wait! Package Upgrading...");   
                     
                },
                success: function(response){
                     $('.hide-element').hide();
                     $("#alert_sms_msg").html(response);
                     requestMerchantsList(1);
                }
            });

        } else {
            $('#alert_sms_msg').addClass('text-danger'); 
            $('#alert_sms_msg').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select the sms package.');
        }
        

        
    });
    
});


</script>
<?php
include_once('../../application_main.php');

$objPackages = new packages;

?>
<div style="padding: 50px;">
    <h3>Activate Package</h3> <hr/>
    <div class="row form-group hide-element">
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="package_id">Select Package <span class="text-danger">*</span></label>
            <select name="package_id" required="required" id="package_id" class="form-control" >
            <?php
                if (is_array($objPackages->packages)) {
                    foreach ($objPackages->packages as $key => $package) {
                        if ($key <= 1)
                            continue;
                        ?>
                        <option value="<?php echo $package['id']; ?>"><?php echo $package['package_name']; ?></option>
                        <?php
                    }//end for.
                }//end if.
            ?>
            </select>
        </div>
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="duration">Subscription For <span class="text-danger">*</span></label>
            <select name="duration" required="required" id="duration" class="form-control" >
                <option value="12" selected="selected">Year</option>
                <option value="1">Month</option>
            </select>
        </div>
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="transaction_mode">Payment Mode <span class="text-danger">*</span></label>
            <select name="transaction_mode" required="required" id="transaction_mode" class="form-control" >
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
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="payment_status">Payment Status <span class="text-danger">*</span></label>
            <select name="payment_status" required="required" id="payment_status" class="form-control" >
                <option value="">--Select One--</option>
                <option value="unpaid" selected="selected">Unpaid</option>
                <option value="partial">Partial Paid</option>  
                <option value="paid">Paid</option>
            </select>
        </div>
    </div>
    <div class="row form-group hide-element">
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="transaction_date">Payment Date</label>
            <div class="input-group date">
                <div class="input-group-addon bg-gray">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" value="" placeholder="Patment Date" onkeyDown="return false;" name="transaction_date" id="transaction_date" type="text" />
            </div>         
        </div>
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="transaction_id">Transaction Details</label>
            <input type="text" name="transaction_id" placeholder="Transaction Id / Cheque No." id="transaction_id" class="form-control" />
        </div>
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="inclusive_tax">Tax Mode</label>
            <select name="inclusive_tax" required="required" id="inclusive_tax" class="form-control" >                 
                <option value="1" selected="selected">Tax Included</option>
                <option value="0">Without Tax</option>                
            </select>
        </div>
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="transaction_amount">Payment Amount</label>
            <div class="input-group">
                <div class="input-group-addon bg-gray">
                    <i class="fa fa-inr"></i>
                </div>
                <input type="text" name="transaction_amount" placeholder="Paid Amount" onblur="validateCurrency(this);" id="transaction_amount" class="form-control pull-right" />                
            </div>

        </div> 
    </div>
    <div class="row form-group hide-element">
        <div class="col-sm-3 col-xs-12">
            <label class="control-label" for="subscription_date">Subscription Date</label>
            <div class="input-group date">
                <div class="input-group-addon bg-gray">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" value="<?php echo date('m/d/Y') ?>" placeholder="<?php echo date('m/d/Y') ?>" name="subscription_date" id="subscription_date" type="text" />
            </div>         
        </div>
        <div class="col-sm-9 col-xs-12">
            <label class="control-label" for="payment_note">Transaction Notes</label>
            <div class="input-group">
                <div class="input-group-addon bg-gray">
                    <i class="fa fa-pencil"></i>
                </div>
                <input type="text" name="note" id="note" placeholder="Payment Note" class="form-control" />                
            </div>
        </div>
    </div>    
    

    <div class="row form-group hide-element">

        <h4 class="text-warning">User Authentication:</h4><hr/>
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="auth_username">Enter Login username <span class="text-danger">*</span></label>
            <input type="text" name="auth_username" value="" placeholder="Username" id="auth_username" class="form-control" />
        </div>
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="auth_passwd">Enter Login Password <span class="text-danger">*</span></label>
            <input type="password" value="" autocomplete="new-password" name="auth_passwd" placeholder="Password" id="auth_passwd" class="form-control" />
        </div>

    </div>

    <hr class="hide-element"/>
    <div class="row form-group text-center">
        <div class="col-sm-12 text-left" id="alert_msg"></div>
        <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $_POST['id']; ?>" />
        <input type="hidden" name="current_package" id="current_package" value="<?php echo $_POST['currentPackage']; ?>" />
        <input type="hidden" name="current_package_expiry_at" id="current_package_expiry_at" value="<?php echo $_POST['expiry_at']; ?>" />
        <input type="hidden" id="auth_session_id" value="<?php echo $_SESSION['session_user_id']; ?>" />

        <button type="button" class="btn btn-info hide-element" id="btn_activate_package">Activate</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>

<script>

    $("#transaction_date").datepicker({autoclose: true});
    $("#subscription_date").datepicker({autoclose: true, dateFormat: 'yy-mm-dd'});

    $(document).ready(function () {

        $('#btn_activate_package').click(function () {

            var transaction_mode = $('#transaction_mode').val();
            var auth_username = $('#auth_username').val();
            var auth_passwd = $('#auth_passwd').val();
            var auth_session_id = $('#auth_session_id').val();
            var payment_status = $('#payment_status').val();
            var subscription_date = $('#subscription_date').val();             
             
            if (payment_status === '') {
                $('#alert_msg').addClass('text-danger');
                $('#alert_msg').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select payment status.');

                return false;
            }
            if (subscription_date === '') {
                $('#alert_msg').addClass('text-danger');
                $('#alert_msg').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select subscription date.');

                return false;
            }

            if (transaction_mode === '') {
                $('#alert_msg').addClass('text-danger');
                $('#alert_msg').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select payment mode.');

                return false;
            }

            if (auth_username === '' || auth_passwd === '') {
                $('#alert_msg').addClass('text-danger');
                $('#alert_msg').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please enter authentication details.');
                return false;
            }


            var postData = 'action=checkAuthentication';
            postData = postData + '&username=' + auth_username;
            postData = postData + '&password=' + auth_passwd;
            postData = postData + '&auth_session_id=' + auth_session_id;

            $.ajax({
                type: "POST",
                url: "ajax_request/merchant_actions.php",
                data: postData,
                beforeSend: function () {
                    $('#alert_msg').removeClass('text-danger');
                    $('#alert_msg').addClass('text-info');
                    $('#alert_msg').html("<i class='fa fa-refresh fa-spin'></i> Please wait! Authentication Checking...");
                },
                success: function (response) {
                    var ObjAuth = jQuery.parseJSON(response);

                    if (ObjAuth.status == 'SUCCESS') {

                        setTimeout(function () {

                            $('#alert_msg').html('<div class="list alert alert-success">' + ObjAuth.msg + '</div>');

                            setTimeout(function () {

                                if (confirm('Are you realy want to activate selected package?')) {

                                    var merchant_id = $('#merchant_id').val();
                                    var current_package = $('#current_package').val();
                                    var current_package_expiry_at = $('#current_package_expiry_at').val();                                     
                                    var package_id = $('#package_id').val();
                                    var transaction_amount = $('#transaction_amount').val();
                                    var transaction_id = $('#transaction_id').val();
                                    var duration = $('#duration').val();
                                    var inclusive_tax = $('#inclusive_tax').val();
                                    var transaction_date = $('#transaction_date').val();
                                    var note = $('#note').val();
                                    
                                    transaction_amount = transaction_amount ? transaction_amount : 0.0;
                                    
                                    var postPackageData = 'action=activatePackage';
                                    postPackageData = postPackageData + '&customer_id=' + merchant_id;
                                    postPackageData = postPackageData + '&current_package=' + current_package;
                                    postPackageData = postPackageData + '&current_package_expiry_at=' + current_package_expiry_at;
                                    postPackageData = postPackageData + '&activate_at=' + subscription_date;                                   
                                    postPackageData = postPackageData + '&package_id=' + package_id;
                                    postPackageData = postPackageData + '&amount=' + transaction_amount;
                                    postPackageData = postPackageData + '&tid=' + transaction_id;
                                    postPackageData = postPackageData + '&duration=' + duration;
                                    postPackageData = postPackageData + '&payment_mode=' + transaction_mode;
                                    postPackageData = postPackageData + '&payment_status=' + payment_status;
                                    postPackageData = postPackageData + '&inclusive_tax=' + inclusive_tax;
                                    postPackageData = postPackageData + '&transaction_date=' + transaction_date;
                                    postPackageData = postPackageData + '&note=' + note;
                                    
                                    $.ajax({
                                        type: "POST",
                                        url: "ajax_request/merchant_actions.php",
                                        data: postPackageData,
                                        beforeSend: function () {
                                            $('#alert_msg').removeClass('text-danger');
                                            $('#alert_msg').addClass('text-info');
                                            $('#alert_msg').html("<i class='fa fa-refresh fa-spin'></i> Please wait! Package activation is in progress...");
                                        },
                                        success: function (OrderResponse) {

                                            setTimeout(function () {

                                                var data = jQuery.parseJSON(OrderResponse);

                                                if (data.status == 'SUCCESS') {
                                                    $('.hide-element').hide();
                                                    $("#alert_msg").html('<div class="alert alert-success">' + data.msg + '</div>');


                                                    $('.tab-filter.btn-success').addClass('btn-default');
                                                    $('.tab-filter.btn-success').removeClass('btn-success');
                                                    $('#pos_status-upgrade').addClass('btn-success');

                                                    var upgradeCount = $('#pos_status-upgrade small').html();
                                                    var expiredCount = $('#pos_status-expired small').html();

                                                    upgradeCount = parseInt(upgradeCount) + 1;
                                                    expiredCount = parseInt(expiredCount) - 1;

                                                    $('#pos_status-upgrade small').html(upgradeCount);
                                                    $('#pos_status-expired small').html(expiredCount);

                                                    $('#record_filter_by').val('pos_status-upgrade');
                                                    requestMerchantsList(1);
                                                } else {
                                                    $('#alert_msg').html('<div class="alert alert-danger">' + data.msg + '</div>');
                                                }

                                            }, 1000);
                                        }
                                    });

                                }//End If Confirm
                                else
                                {
                                    $('#posUsers').modal('toggle');
                                }

                            }, 1000);

                        }, 1000);
                    }

                    if (ObjAuth.status == 'ERROR') {
                        setTimeout(function () {
                            $('#alert_msg').html('<ul class="list alert alert-danger"><li>' + ObjAuth.msg + '</li></ul>');
                        }, 1000);
                    }
                }
            });

        });

    });
//End DOM Ready.




    function validateCurrency(obj) {
        var regex = /^[1-9]\d*(?:\.\d{0,2})?$/;
        if (obj.value != '' && regex.test(obj.value) == false) {
            alert('Amount should be valid.');
            obj.value = '';
            return false;
        }
    }
</script>
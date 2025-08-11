<?php
include_once('../../application_main.php');
include_once('session.php');
include_once('xmlapi.php');
require_once('../../functions/phpFormFunctions.php');

$objMerchant = new merchant($conn);
$marchant_data = $objMerchant->getmarchants_list('1');

$sr = 1;
?>
<style >
    .btn-sm{padding:2px 5px;}
    table thead tr th{vertical-align: middle !important; 
                      text-align: center;}
    </style>

    <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr> 
            <th> Sr. No</th>
            <th> Business Name</th> 
            <th> Merchant Name</th>
            <th> Merchant Id</th>
            <th> POS Name</th> 
            <th> Pos Version</th>
            <!-- <th> City </th>-->
            <th> Balance Order</th>
            <th> POS Status</th>
            <th> Urbenpiper  API Key  </th>
            <th> Webhook</th>
            <th> Orders</th>
        </tr>  
    </thead>
    <tbody>
        <?php
        foreach ($marchant_data as $marchant_value) {


            switch ($marchant_value['pos_status']) {
                case ('suspended') :
                    $bg = 'btn-danger';
                    break;
                case ('deleted') :
                    $bg = 'btn-danger';
                    break;
                case ('upgrade'):
                    $bg = 'btn-success';
                    break;
                case ('expired'):
                    $bg = 'btn-warning';
                    break;
                case ('extended'):
                    $bg = 'btn-primary';
                    break;
                case ('created'):
                    $bg = 'btn-info';
                    break;
                default :
                    $bg = '';
                    break;
            }
            ?>
            <tr >
                <td onclick="detailsshow('<?= $marchant_value['id'] ?>')"><?= $sr; ?> </td>
                <td onclick="detailsshow('<?= $marchant_value['id'] ?>')"> <?= $marchant_value['business_name'] ?> </td>
                <td onclick="detailsshow('<?= $marchant_value['id'] ?>')"><?= $marchant_value['name'] ?> </td>
                <td onclick="detailsshow('<?= $marchant_value['id'] ?>')"><?= $marchant_value['phone'] ?> </td>
                <td onclick="detailsshow('<?= $marchant_value['id'] ?>')"><?= $marchant_value['pos_name'] ?> </td>
                <td onclick="detailsshow('<?= $marchant_value['id'] ?>')"><?= $marchant_value['pos_current_version'] ?> </td>

                <!-- <td onclick="detailsshow('<?= $marchant_value['id'] ?>')"><?= ($marchant_value['city']) ? $marchant_value['city'] : '---' ?> </td> -->
                <td onclick="detailsshow('<?= $marchant_value['id'] ?>')"><?= $marchant_value['balance_urbnpiper_order'] ?> </td>
                <td class="text-center" > <span class="btn btn-sm <?= $bg ?>"><?= ucfirst($marchant_value['pos_status']) ?> </span></td>
                <?php if ($marchant_value['pos_current_version'] >= '4.00') { ?> 
                    <td class="text-center">
                        <?php if ($marchant_value['pos_status'] == 'suspended' || $marchant_value['pos_status'] == 'deleted') { ?> 
                            <?php if ($marchant_value['urbanpiper_api_key']) { ?>
                                <span class="btn btn-success btn-sm" onclick="add_store('add_api_key', '<?= $marchant_value['id'] ?>', '<?= $marchant_value['urbanpiper_api_key'] ?>')"> Edit Key  </span>
                            <?php } ?>
                        <?php } else { ?>
                            <?php if ($marchant_value['urbanpiper_api_key']) { ?>
                                <span class="btn btn-success btn-sm" onclick="add_store('add_api_key', '<?= $marchant_value['id'] ?>', '<?= $marchant_value['urbanpiper_api_key'] ?>')"> Edit Key  </span>
                            <?php } else { ?>
                                <button class="btn btn-danger btn-sm" onclick="add_store('add_api_key', '<?= $marchant_value['id'] ?>')"> <i class="fa fa-plus"></i> API Key</button>     
                            <?php } ?>
                        <?php } ?>

                        <div id="myModaldetails_<?= $marchant_value['id'] ?>" class="modal details_modal" role="dialog" style="overflow: auto;">
                            <div class="modal-dialog" style="width:70%;">
                                <!-- Modal content -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title text-left" >Merchant Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table text-left">
                                                <tbody>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>:</td>
                                                        <td> <?= $marchant_value['name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>:</td>
                                                        <td> <?= ($marchant_value['email']) ? $marchant_value['email'] : '---' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone No.</td>
                                                        <td>:</td>
                                                        <td> <?= $marchant_value['phone'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td>:</td>
                                                        <td> <?= ($marchant_value['address']) ? $marchant_value['address'] : '---' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pincode</td>
                                                        <td>:</td>
                                                        <td> <?= ($marchant_value['city']) ? $marchant_value['city'] . ' - ' . $marchant_value['pincode'] : '---' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Business Name</td>
                                                        <td>:</td>
                                                        <td><?= $marchant_value['business_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pos Name</td>
                                                        <td>:</td>
                                                        <td> <?= $marchant_value['pos_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pos URL</td>
                                                        <td>:</td>
                                                        <td> <?= $marchant_value['pos_url'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Urban Piper API Key</td>
                                                        <td>:</td>
                                                        <td> <?= $marchant_value['urbanpiper_api_key'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pos Status</td>
                                                        <td>:</td>
                                                        <td> <?= ucfirst($marchant_value['pos_status']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Webhook Updates</td>
                                                        <td>:</td>
                                                        <td> <?= ($marchant_value['up_webhook_status']) ?></td>
                                                    </tr>                                                    
                                                    <tr>
                                                        <td>Orders Received</td>
                                                        <td>:</td>
                                                        <td> <?= ($marchant_value['total_urbanpiper_order']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Orders Balance</td>
                                                        <td>:</td>
                                                        <td> <?= ($marchant_value['balance_urbnpiper_order']) ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                         
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" id="" class=" btn btn-danger closemodeldetails" >Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Merchant Details model --->
                    </td>
                    <td>
                        <?php if ($marchant_value['urbanpiper_api_key']) { ?>
                            <?php
                            $merchnatData = [
                                'mid' => $marchant_value['id'],
                                'upapi_key' => $marchant_value['urbanpiper_api_key'],
                                'posurl' => $marchant_value['pos_url'],
                            ];
                            if ($marchant_value['up_webhook_status']) {
                                ?>
                                <span class="btn btn-success btn-sm">Added</button>	
                                <?php } else { ?>
                                    <button class="btn btn-primary btn-sm" onclick="updateWebhooks('<?= $marchant_value['id'] ?>', 'Webhooks', '<?= $marchant_value['urbanpiper_api_key'] ?>')">Add Webhooks</button>
                                <?php }
                            }
                            ?>
                    </td>
                    <td> <?php if ($marchant_value['urbanpiper_api_key']) { ?>
                        <button class="btn btn-primary btn-sm" onclick="add_store('update_package', '<?= $marchant_value['id'] ?>')">Package</button>
                        <?php } ?>
                    </td>
                <?php } else { ?> 
                    <td colspan="3" class="text-danger">Pos version should be 4.00 & Above</td>
            <?php } ?> 
            </tr>
    <?php $sr++;
} ?>
    </tbody>
</table>


<!-- Message Modal -->
<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modeltitle"></h4>
            </div>
            <div class="modal-body">
                <h3 class="text-center" id="showmsg"></h3>                
            </div>
            <div class="modal-footer">
                <button type="button" style="display:none" id="btnconfirm" class="btn btn-success"> Ok</button> 
                <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Message model --->
<!-- Message Modal -->
<div id="myModalauth" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="authtitle">User Authentication</h4>
            </div>
            <div class="modal-body">
                <form id="authform" autocomplete="off" > 
                    <div class="login-box-body" id="authentication_form">
                        <p class="login-box-msg">Verify Your Authentication</p>
                        <input type="hidden" name="merchant_id" id="merchant_id" >
                        <input type="hidden" name="action" id="action" >
                        <input type="hidden" name="api_key"  id="apikey">
                        <div class="form-group has-feedback">
                            <input type="text" id="auth_uid" maxlength="30"  name="username" value="" class="form-control" placeholder="Username">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" id="auth_pcode" maxlength="50"  name="password" autocomplete="new-password" value="" class="form-control" placeholder="Password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="authenticate();" id="btn_authenticate" class="btn btn-success">Authenticate</button>
                <button type="button" id="closeauth" class=" btn btn-danger" >Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Message model --->
<script type="text/javascript">
    // Get the modal
    $('#btnconfirm').hide();
    var modal = document.getElementById('myModal');

    var authmodal = document.getElementById('myModalauth');
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal 


    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
        $('.details_modal').hide();
        $('#myModalauth').hide();
    }

    $('#closemodel').click(function () {
        modal.style.display = "none";
    });
    $('#closeauth').click(function () {
        authmodal.style.display = "none";
    });

    $('.closemodeldetails').click(function () {
        $('.details_modal').hide();
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
            $('.details_modal').hide();
            $('#myModalauth').hide();
        }
    }

    $('.close').click(function () {
        modal.style.display = "none";
        $('.details_modal').hide();
        $('#myModalauth').hide();
    });

    $('#example1').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });

    function add_store() {
        var action = arguments[0];
        var id = arguments[1];
        var apikey = (arguments[2]) ? arguments[2] : '';
        var msg = (action == 'add_store') ? 'add store' : 'update store';
        var html = '';

        if (action == 'add_api_key') {
            html = '<form id="confirm"><input type="hidden" name="action" value="' + action + '~' + id + '"/>\n\
                        <div class="form-group text-left"><lable style="font-size:18px;" >Urbanpiper API Key</lable>\n\
                        <div style="margin-top: 1em;"><input type="text" class="form-control" value="' + apikey + '" name="api_key" placeholder="API Key"/></div></div></form>';
            $('#modeltitle').html('Enter API Key');
        } else if (action == 'update_package') {
            html = '<form id="confirm"><input type="hidden" name="action" value="' + action + '~' + id + '"/>\n\
                        <div class="form-group text-left"><lable style="font-size:18px;" >Update package value</lable>\n\
                        <div style="margin-top: 1em;"><input type="number" min="0" class="form-control"  name="package_value" placeholder="Package values"/></div></div></form>';
                    $('#modeltitle').html('Update package');
        } else {
            html = 'Are you sure to ' + msg + ' on urbanpiper portal? <form id="confirm"><input type="hidden" name="action" value="' + action + '~' + id + '"/></form>';
            $('#modeltitle').html('confirmation');
        }
        $('#showmsg').html(html);

        modal.style.display = "block";
        $('#btnconfirm').show();

    }

    $('#btnconfirm').click(function () {
        modal.style.display = "none";
        var queryString = $('#confirm').serializeArray();
        authmodal.style.display = "block";
        var formdata = queryString[0]['value'].split("~");
        $('#merchant_id').val(formdata[1]);
        $('#action').val(formdata[0]);
        
        if(queryString[1]) {
            $('#apikey').val(queryString[1]['value']);
        }
    });

    function authenticate() {
        //  document.getElementById('popupbox').style.visibility="hidden"; 
        var queryString = $('#authform').serialize();
        
        authmodal.style.display = "none";
        document.getElementById("authform").reset();
        $('#loader').show();
        setTimeout(function () {
            call_action(queryString);
        }, 20);

    }



    function call_action(passdata) {
        
       
        $.ajax({
            type: 'ajax',
            dataType: 'json',
            url: 'ajax_request/urbanpiper_action.php',
            async: false,
            data: passdata,
            method: 'post',
            success: function (result) {
                $('#loader').hide();
                if (result.status == 'success') {
                    $('#showmsg').html(result.messages);
                    $('#loader').show();
                    setTimeout(function () {
                        $('#loader').hide();
                        get_restaurant_list();
                    }, 2000);
                } else {
                    $('#showmsg').html(result.messages);
                }
                $('#modeltitle').html('Message');
                $('#btnconfirm').hide();
                modal.style.display = "block";

            }, error: function () {
                $('#loader').hide();
            }
        });
    }

    // Merchant Details Show
    function detailsshow() {
        $('#loader').show();
        $('#myModaldetails_' + arguments[0]).show();
        $('#loader').hide();
    }

    function updateWebhooks() {
        var merchant_id = arguments[0], action = arguments[1];
        $('#merchant_id').val(merchant_id);
        $('#action').val(action);
        authmodal.style.display = "block";
    }
</script>
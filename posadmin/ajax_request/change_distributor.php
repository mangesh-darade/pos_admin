<div style="padding: 50px;" class="form-group">
    <?php
        $distname= ( $merchantInfo['distributor_id'] > 0 ) ? $distList[$merchantInfo['distributor_id']]['name'] : 'Simplysafe';
    ?>
    <h3>Merchant Informations</h3>  
    <div class="row table-responsive">
        <table class="table">
            <tr>
                <th>#Ref. Id</th>
                <th>Merchant Name</th>
                <th>Business Name</th>
                <th>Mobile</th>
            </tr>            
            <tr>
                <td>#<?= $merchantInfo['id']?></td>
                <td><?= $merchantInfo['name']?></td>
                <td><?= $merchantInfo['business_name']?></td>
                <td><?= $merchantInfo['phone']?></td>
            </tr>
            <tr>
                <th>POS Name</th>
                <th>Current Distributor</th>
                <th>POS URL</th>
                <th>POS Status</th>                
            </tr>
            <tr>
                <td><?= $merchantInfo['pos_name']?></td>
                <td><?= $distname?></td>
                <td><?= $merchantInfo['pos_url']?></td>
                <td><?= $merchantInfo['pos_status']?></td>
            </tr>
        </table>
    </div>
    <h3>Change Distributor</h3> 
     <div class="col-sm-12 text-left" id="alert_msg"></div>
     <hr/>
    <div class="row">
        <div class="col-sm-4 col-xs-12"><b class="text-red">*</b> <label class="control-label" >Select Another Distributor</label></div>
        <div class="col-sm-8 col-xs-12"> 
        <?php
            $comboList = '<select name="new_distributor" id="new_distributor" required="required" class="form-control">'
                    . '<option value="0">Simplysafe</option>';
                
            foreach ($distList as $key => $destdata) {
                $selected = ($merchantInfo['distributor_id']==$destdata['id']) ? ' selected="selected" ' : '';
                $comboList .= '<option '.$selected.' value="'.$destdata['id'].'">'.$destdata['name'].'</option>';
            }

          echo  $comboList .= '<select>';         
        ?>
        </div>                       
    </div>
    
    <hr/>
    <div class="row form-group text-center">
       
        <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $merchantInfo['id'];?>" />
        <input type="hidden" name="distributor_id" id="distributor_id" value="<?php echo $merchantInfo['distributor_id'];?>" />
        <input type="hidden" name="distributor_name" id="distributor_name" value="<?php echo $distname;?>" />
        <button type="button" class="btn btn-info hide-element" id="btn_change_distributor">Save Changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>


<script>

$(document).ready(function(){
        
    $('#btn_change_distributor').click(function(){
        
        var new_distributor = $('#new_distributor').val();
        var distributor_id  = $('#distributor_id').val();
        var distributor_name  = $('#distributor_name').val();
        var merchantId      = $('#merchant_id').val();
        
        if(new_distributor == '' || new_distributor == distributor_id){
            $('#alert_msg').html('<p class="text-red">Please select another distributor.</p>');
            return false;
        }        
        else
        {   
            var postData = 'action=update_distributor';
                postData = postData + '&id='+merchantId;
                postData = postData + '&distributor_id='+new_distributor;
                postData = postData + '&old_distributor='+distributor_name;
               
            $.ajax({
                type: "POST",
                url: "ajax_request/merchant_actions.php",
                data: postData,
                beforeSend: function(){
                    $('#alert_msg').removeClass('text-danger'); 
                    $('#alert_msg').addClass('text-info'); 
                    $('#alert_msg').html("<i class='fa fa-refresh fa-spin'></i> Please wait! Updating...");                     
                },
                success: function(response){
                     $('.hide-element').hide();
                     setTimeout(function(){
                        $("#alert_msg").html(response);
                     }, 2000); 
                     requestMerchantsList(1);
                }
            });

        }
        
    });
    
});


</script>
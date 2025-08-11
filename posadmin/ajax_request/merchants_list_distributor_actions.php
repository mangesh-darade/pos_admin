<?php

if($merchant['is_delete']==0) {
        ?>
          <!--Change Status Toggle Button Dropdown-->
        <?php if($merchant['is_active']) {
                $lable =  "<i class='fa fa-check-circle-o'></i> Active "; 
                $class = 'btn-success';
          } else {
                $lable =  "<i class='fa fa-ban'></i> Deactive ";
                $class = 'btn-default';
          }
        ?>
            <p>
                <buton type="button" class="btn <?php echo $class;?>" id="<?php echo $merchant['id']; ?>"  style="min-width:110px; text-align: left;" ><?php echo $lable;?></buton>
            </p>
          <!--Action Dropdown-->
        <?php
        if($objMerchant->merchantTypeList[$merchant['type']]['generate_pos'] == 'Yes' || $merchant['pos_status'] !== 'pending') {
        ?>
          <div class="dropdown">
              <a class="dropdown-toggle btn btn-info btn-md bg-aqua-active" type="text" data-toggle="dropdown" style="min-width:110px; text-align: left; ">
                  <span><i class="fa fa-bar-chart"></i> POS </span><span class="caret" style="margin-left:20px;"></span></a>
                <ul class="dropdown-menu">
                <?php            
                    if($merchant['pos_generate']) {
                ?>
                         <li><a href="<?php echo $merchant['pos_url']; ?>" target="_blank"><span class="glyphicon glyphicon-equalizer"></span> Visit POS</a></li>
                         <li><a class="send_request" req="ADD_SMS" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"><i class="fa fa-commenting"></i> Active SMS Pack</a></li>
                        <?php if($merchant['pos_generate'] && !in_array($merchant['pos_status'] , [ 'pending', 'suspended', 'deleted', 'trashed'])) { ?> 
                            <li><a class="send_request" req="UPGRADE_PACKAGE" mid="<?php echo $merchant['id'] ?>" cur_pack="<?php echo $merchant['package_id'];?>" data-toggle="modal" data-target="#posUsers"><i class="fa fa-inr"></i> Upgrade Package</a></li>
                        <?php } ?>    
                        <?php if($merchant['pos_status']=='suspended') { ?>
                            <li><a   class="send_request" req="UNDO_SUSPEND" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"><i class="fa fa-plug"></i> Unsuspend POS</a></li>
                        <?php } else { ?>
                            <li><a class="send_request" req="SUSPEND_POS" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"><i class="fa fa-times"></i> Suspend POS</a></li>
                        <?php }//end else ?>
                            
               <?php  } else { ?>
                            <li><a class="send_request" req="GENERATE_POS" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"><i class="fa fa-cubes" aria-hidden="true"></i> Generate POS</a></li>
                <?php      
                  }//end else.
                ?>
                </ul>
          </div>
          
        <?php } else { echo '<span class="text-danger">No Pos Access</span>'; } ?>  
          <div class="dropdown" style="margin-top:10px;">
                <a class="dropdown-toggle btn btn-warning btn-md" type="text" data-toggle="dropdown" style="min-width:110px"> <i class="fa fa-user"></i> Merchant  <span class="caret"></span></a>
                <ul class="dropdown-menu bg-warning">
                    <li><a  class="merchant_details" mdbid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"><i class="fa fa-eye"></i> View Details</a></li>
                    <li><a  class="merchant_edit action-edit"  keyid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i> Change Info</a></li>          
                    <li><a   class="send_request" req="SOFT_DELETE" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"><i class="fa fa-user-times"></i> Soft Delete</a></li>          
                </ul>
          </div> 
        <?php }
            else 
            {
        ?>
           <p><a class="merchant_details btn btn-primary" mdbid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" style="width: 130px;" ><i class="fa fa-eye"></i> View Details</a></p>
           <p><a class="btn btn-warning send_request" req="UNDO_DELETE" mid="<?php echo $merchant['id'] ?>" style="width: 130px;" data-toggle="modal" data-target="#posUsers" ><i class="fa fa-recycle"></i> Undelete</a></p>
           <p><a class="btn btn-danger send_request" req="DELETE_PERMANANTALY" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"  style="width: 130px;" ><i class="fa fa-trash"></i> Delete Forever</a> </p>
        <?php } ?>
        <?php  if($merchant['pos_generate']==1 && !in_array($merchant['pos_status'] , ['pending', 'suspended', 'deleted', 'trashed'])) { ?> 
            <p style="margin-top:10px;">
                <buton type="button" class="btn btn-success send_request" req="EXTEND_EXPIRY" mid="<?php echo $merchant['id']; ?>"  data-toggle="modal" data-target="#posUsers" style="min-width:110px; text-align: center;" ><i class="fa fa-plug"></i> Extend Validity</buton>
            </p>
        <?php }//end if extend Demo ?>  
        <?php  if($merchant['pos_generate']==1 && !in_array($merchant['pos_status'] , ['expired', 'pending', 'suspended', 'deleted', 'trashed'])) {
            
                if( $merchant['pos_current_version'] == '0.00'){
                    $version_btn_lable = '<i class="fa fa-binoculars"></i> Check Updates';
                    $className = "check_pos_version btn btn-default";
                    $setPopupModel = ' data-toggle="modal" data-target="#posUsers" ';
                } else {
                    $setPopupModel = '';
                    $versionData = $posLatestVersions['versions'];
                    $uotodate = true;
                    
                    foreach ($versionData as $key => $version) {                      
                        if($merchant['pos_current_version'] < $version) {
                            $uotodate = false;
                            break;
                        }
                    }//end foreach.
                  
                    if($uotodate == false) {
                        $version_btn_lable = '<i class="fa fa-cubes"></i> Update Available';
                        $className = "send_request btn btn-primary"; 
                        $setPopupModel = ' req="UPDATE_VERSION" data-toggle="modal" data-target="#posUsers"  ';
                    } else {
                        $version_btn_lable = '<i class="fa fa-calendar-check-o"></i> POS Is Updated';
                        $className = "btn btn-success"; 
                        $setPopupModel = '';
                    }
                }//end else.
            ?>
            <p style="margin-top:10px;">
                <buton type="button" class="<?php echo $className;?>" mid="<?php echo $merchant['id']; ?>" <?php echo $setPopupModel;?>  style="min-width:110px; text-align: center;" ><?php echo $version_btn_lable;?></buton>
                <input type="hidden" id="merchant_pos_version_<?php echo $merchant['id']; ?>" value="<?php echo $merchant['pos_current_version'];?>" />
            </p>
<?php } ?>
     
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
                <buton type="button" class="merchant_status btn <?php echo $class;?> merchant_status_<?php echo $merchant['id']; ?>" id="<?php echo $merchant['id']; ?>"  style="min-width:150px; text-align: center;" ><?php echo $lable;?></buton>
                <input type="hidden" id="active_status_<?php echo $merchant['id']; ?>" value="<?php echo $merchant['is_active'];?>" />
            </p>
        <!--Action Dropdown-->
        <?php
        if($objMerchant->merchantTypeList[$merchant['type']]['generate_pos'] == 'Yes' || $merchant['pos_status'] !== 'pending' || true) {
        ?>
          
                <?php            
                    if($merchant['pos_generate']) {
                ?>
                    <?php if( !in_array($merchant['pos_status'] , [ 'pending', 'suspended', 'deleted', 'trashed'])) { ?> 
        <p><a class="upgrade_package btn btn-success" custid="<?php echo $merchant['id'] ?>" cur_pack="<?php echo $merchant['package_id'];?>" expiry_at="<?php echo $pos_expiry_date?>" style="width:150px;" data-toggle="modal" data-target="#posUsers"><i class="fa fa-inr"></i> Add Subscription</a></p> 
                    <?php } ?>
                    
                    <?php if($merchant['pos_status']=='suspended') { ?>
                         <p><a  class="unsuspend_pos btn btn-success" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" style="width:150px;"><i class="fa fa-plug"></i> Unsuspend POS</a></p> 
                         <p><a title="Send to trash" class="merchant_delete btn btn-warning" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" style="width:150px;"><i class="fa fa-trash" aria-hidden="true"></i> Send to Trash</a></p>
                    <?php } else { ?>
                         <p><a  class="suspend_pos btn btn-danger" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" style="width:150px;"><i class="fa fa-times"></i> Suspend POS</a></p> 
                    <?php } //end else ?>
                    
                <?php } else { ?>
                    <p>                       
                        <?php if( $merchant['pos_status'] == 'deleted' ) { ?>
                        <a href="pos_generator.php?action=regenerate&id=<?php echo $merchant['id'] ?>" class="btn btn-info" style="width:150px;"><i class="fa fa-object-group" aria-hidden="true"></i> Regenerate POS</a> 
                        <?php } else { ?> 
                             <a href="pos_generator.php?action=generate&id=<?php echo $merchant['id'] ?>" class="btn btn-primary" style="width:150px;"><i class="fa fa-cubes" aria-hidden="true"></i> Generate POS</a> 
                        <?php } ?>
                    </p>
                <?php      
                  }//end else.
                ?>
        <?php } else { echo '<span class="text-danger">No Pos Access</span>'; } ?>  
           
        <?php }
        else 
        {
        ?>
            <p>
                <buton type="button" class="btn <?php echo $class;?>" style="min-width:150px; text-align: center;" ><?php echo $lable;?></buton>
            </p>
           <p><a class="merchant_details btn btn-primary" mdbid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" style="width: 150px;" ><i class="fa fa-eye"></i> View Details</a></p>
           <p><a class="merchant_undelete btn btn-info" umid="<?php echo $merchant['id'] ?>" style="width: 150px;" data-toggle="modal" data-target="#posUsers" ><i class="fa fa-recycle"></i> Set Untrashed</a></p>
           <p><a class="merchant_reset btn btn-success" resetmid="<?php echo $merchant['id'] ?>" style="width: 150px;" data-toggle="modal" data-target="#posUsers" ><i class="fa fa-refresh"></i> Reset Merchant</a></p>
        <?php if($merchant['pos_generate']==1 && $merchant['pos_status']=='trashed') { ?>
           <p><a class="merchant_remove btn btn-danger" pmid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"  style="width: 150px;" ><i class="fa fa-trash"></i> Delete POS URL</a></p>
        <?php } if($merchant['pos_generate']==0) { ?>
            <p><a class="merchant_delete_record btn btn-warning" mdelid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"  style="width: 150px;" ><i class="fa fa-user"></i> Delete Merchant </a></p>
        <?php } 
        
        }//end else 
        ?>            
        <?php  if($merchant['pos_generate']==1 && !in_array($merchant['pos_status'] , ['pending', 'suspended', 'deleted', 'trashed'])) { ?> 
            <p style="margin-top:10px;">
                <buton type="button" class="extend_demo btn btn-success" extid="<?php echo $merchant['id']; ?>"  data-toggle="modal" data-target="#posUsers" style="width:150px; text-align: center;" ><i class="fa fa-plug"></i> Extend Validity</buton>
            </p>
        <?php }//end if extend Demo ?>  
        <?php  if($merchant['pos_generate']==1 && !in_array($merchant['pos_status'] , ['expired', 'pending', 'suspended', 'deleted', 'trashed'])) {
           
                if( $merchant['pos_current_version'] == '0.00'){
                    $version_btn_lable = '<i class="fa fa-binoculars"></i> Check Updates';
                    $className = "check_pos_version btn btn-default";
                    $setPopupModel = ' data-toggle="modal" data-target="#posUsers" ';
                } else {
                    
                    if($merchant['restricted_pos_updates']) {                        
                         $version_btn_lable = '<i class="fa fa-cubes"></i> Update Restricted';
                         $className = "pos_updates_restricted btn btn-default";                         
                    } else {
                        
                        $project_id = $merchant['project_id'] ? $merchant['project_id'] : 1 ;
                        $setPopupModel = '';
                        $versionData = $posLatestVersions[$project_id]['versions'];
                        $uotodate = true;
                        $latest_version = max($versionData);
                        foreach ($versionData as $key => $version) {                      
                            if($merchant['pos_current_version'] < $version) {
                                $uotodate = false;
                                break;
                            }
                        }//end foreach.

                        if($uotodate == false && !$merchant['restricted_pos_updates']) {
                            $version_btn_lable = '<i class="fa fa-cubes"></i> Update Ver: '.$latest_version;
                            $className = "pos_updates_available btn btn-primary"; 
                            $setPopupModel = ' data-toggle="modal" data-target="#posUsers"  ';
                        } else {
                            $version_btn_lable = '<i class="fa fa-calendar-check-o"></i> Project Updated';
                            $className = "uptodate_version btn btn-success"; 
                            $setPopupModel = ' data-toggle="modal" data-target="#posUsers"  ';
                        }
                    }//end else.
                }//end else.
            ?>
           <p style="margin-top:10px;">
                <buton type="button" class="<?php echo $className;?>" mid="<?php echo $merchant['id']; ?>" <?php echo $setPopupModel;?>  style="min-width:150px; text-align: center;" ><?php echo $version_btn_lable;?></buton>
                <input type="hidden" id="merchant_pos_version_<?php echo $merchant['id']; ?>" value="<?php echo $merchant['pos_current_version'];?>" />
                <input type="hidden" id="merchant_group_<?php echo $merchant['id']; ?>" value="<?php echo $merchant_group;?>" />
                <input type="hidden" id="project_group_<?php echo $merchant['id']; ?>" value="<?php echo $project_id;?>" />
            </p>
<?php } ?>
     
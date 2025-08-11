<div class="row">
    <div class="col-sm-4 col-xs-12">
        Show <select class="form-control input-sm" name="per_page_records" id="per_page_records" style="display:inline; width:auto;">
            <?php
            $perpageArr = [10, 20, 30, 50, 70, 100];

            foreach ($perpageArr as $pp) {
                $selectpp = ($pp == $merchantsData['itemsPerPage']) ? ' selected="selected" ' : '';
                echo '<option ' . $selectpp . '>' . $pp . '</option>';
            }
            ?> 
        </select>
        <span class="pull-right text-info">Result: <?php echo ($merchantsData['count']) ? $merchantsData['count'] : '0'; ?> Records Found.</span>
    </div>
    <div class="col-sm-6 col-xs-12 text-center"><?php echo $objMerchant->merchantPagignations($merchantsData); ?> </div>
    <div class="col-sm-2 col-xs-12">
        <div class="box-tools pull-right">
            <div class="input-group input-group-sm" style="width: 200px;">
                <input type="text" name="search_key" id="search_key" value="<?php echo $merchantsData['search_key']; ?>" class="form-control pull-right" placeholder="Search" />
                <div class="input-group-btn" id="btn_search">
                    <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div> 
    </div>
</div>

<div class="row">
    <div class="col-sm-12 table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>                 
                    <th>Merchant(s) Details</th>
                    <th>Project Details</th>
                    <th>Status & Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($merchantsData)):
                
                    if (in_array($_SESSION['session_user_group'], ['employee-sales', 'distributors'])) {
                        //Actions For only Distributors User 
                        $action_page = 'merchants_list_distributor_actions.php';
                    } else {
                        //Actions For Admin User 
                        $action_page = 'merchants_list_admin_actions.php';
                    }//end else 

                    foreach ($merchantsData['rows'] as $merchant) {
                        ?>
                        <tr>
                            <td style="border-bottom: thin solid #000;">
                                <?php //echo $merchant['index']; ?><br/> 
                                <?php
                                if (in_array($_SESSION['session_user_group'], ['employee-sales', 'distributors'])) {
                                    $modalAttr = '';
                                    $showChangeDistributorIcon = false;
                                } else {
                                    $modalAttr = ' class="merchantVerification" custid="' . $merchant['id'] . '" data-toggle="modal" data-target="#posUsers" ';
                                    $showChangeDistributorIcon = true;
                                }
                                ?>
                                <a  href="#" title="Merchant Data" class="merchant_details btn btn-primary btn-xs" mdbid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" ><i class="fa fa-eye text-align-lg-center" aria-hidden="true"></i></a>
                                <?php if ($merchant['is_delete'] == 0 && $merchant['pos_generate'] == 0) { ?>
                                    <br/><br/>  
                                    <a title="Send to trash" class="merchant_delete btn btn-danger btn-xs" mid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i></a>  
                                <?php } ?>
                                <?php if ($merchant['is_delete'] == 0) { ?>
                                    <br/><br/>    
                                    <a  title="Edit Information" class="merchant_edit action-edit btn btn-info btn-xs" keyid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#myModal" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                <?php } ?>
                                <br/><br/>
                                
                                <a href="#" title="Project Action Log" class="merchantLog btn btn-warning btn-xs" custid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" ><i class="fa fa-history text-align-lg-center" aria-hidden="true"></i></a>
                                <br/><br/>
                                <a href="#" title="Merchants Feedback Log" class="feedback_details btn btn-success btn-xs" id="feedback_<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" ><i class="fa fa-comments text-align-lg-center" aria-hidden="true"></i></a>
                                                    
                            </td>
                            <td style="border-bottom: thin solid #000;">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Merchant Name</td>
                                        <td colspan="2"><?php echo $merchant['name'] ?> <span class="pull-right"><b>Code:</b> #<?php echo $merchant['id'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Created At</td>
                                        <td colspan="2">
                                            <?php echo $objMerchant->appCommon->DateTimeFormat($merchant['created_at']); ?>
                                            <span class="pull-right"><b>By:</b> <?php echo $Distributors[$merchant['distributor_id']]['name'] ?></span>
                                        </td>              
                                    </tr>
                                    <tr>
                                        <td>Business Type</td>
                                        <td colspan="2"><?php echo $objMerchant->merchantTypes[$merchant['type']]; ?>
                                            <?php if ($merchant['is_testing_merchant']) { ?>
                                                <span class="pull-right badge bg-red">For Testing</span>
                                            <?php } ?>                     
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Business Name</td>
                                        <td colspan="2"><?php echo $merchant['business_name']; ?>
                                            <span class="pull-right"><?php echo!empty($merchant['city']) ? "<b>City : </b>" . $merchant['city'] : ''; ?></span>
                                        </td>
                                    </tr>                
                                    <tr>
                                        <td>Business Group</td>
                                        <td colspan="2"><?php echo $merchant['merchant_group'] ? $objMerchant->merchantGroups[$merchant['merchant_group']] : 'NA'; ?></td>
                                    </tr>                
                                    <tr>
                                        <td>Contacts Details</td>
                                        <td title="<?php echo ($merchant['is_email_verified']) ? 'Verified' : 'Not Verified' ?>"><i class="fa fa-envelope <?php echo ($merchant['is_email_verified']) ? 'text-green' : '' ?>" aria-hidden="true"></i> <?php echo $email = (empty($merchant['email'])) ? '<i>NULL</i>' : $merchant['email']; ?> </td>
                                        <td title="<?php echo ($merchant['is_mobile_verified']) ? 'Verified' : 'Not Verified' ?>"><i class="fa fa-phone <?php echo ($merchant['is_mobile_verified']) ? 'text-green' : '' ?>" aria-hidden="true"></i> <?php echo $merchant['phone'] ?> </td>
                                    </tr>
                                </table>                      
                            </td>
                            <td style="border-bottom: thin solid #000;">
                                <?php
                                $pos_status = $merchant['pos_status'];
                                $statusClass = array('created' => 'bg-green', 'extended' => 'bg-green', 'upgrade' => 'bg-green', 'expired' => 'bg-red', 'suspended' => 'bg-red', 'pending' => 'bg-primary', 'deleted' => 'bg-red', 'trashed' => 'bg-orange');
                                ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><?php echo $merchant['pos_generate'] ? 'Project URL' : 'POS Name' ?></td>
                                        <td colspan="2">
                                            <?php $pos_name = (empty($merchant['pos_name'])) ? '<i>NULL</i>' : $merchant['pos_name']; ?>
                                            <?php if (!empty($merchant['pos_name']) && $merchant['pos_generate']) { ?>                                                
                                              <?php  if($merchant['pos_status'] == 'deleted') { ?>
                                                <span style="color:#ccc; text-decoration: line-through;">https://<?=$pos_name?>@simplypos.in</span>                                                
                                            <?php } else { ?>
                                                    <span style="color:#ccc;">https://</span> 
                                                    <?=$pos_name?>
                                                    <span style="color:#ccc;">@simplypos.in</span>
                                                    <span class="pull-right">                    
                                                        <a href="<?= "https://" . $pos_name . ".simplypos.in/login" ?>" target="new"><i class="fa fa-link" aria-hidden="true"></i></a>
                                                    </span> 
                                            <?php } ?>
                                            <?php
                                            } else {
                                                echo $pos_name;                                                 
                                            }                                            
                                            ?>
                                        </td>                                         
                                    </tr>
                                    <tr>
                                        <td>Project Type</td>
                                        <td colspan="2">
                                            <?php echo $objMerchant->projectGroups[$merchant['project_id']]; ?> 
                                            <?php if ($merchant['pos_generate'] && $merchant['pos_status'] != 'deleted') : ?>
                                                <span class="pull-right badge bg-blue"> Version: <?php echo $merchant['pos_current_version']; ?> </span> 
                                            <?php endif; ?>
                                            <?php if (in_array($merchant['pos_status'], ['pending'])) {  ?>
                                            <span class="pull-right badge <?php echo $statusClass[$pos_status]; ?>"><?php echo strtoupper($pos_status); ?></span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php if($merchant['pos_generate']) :  ?>
                                    <tr>
                                        <td>Generated</td>
                                        <td colspan="2"><?php echo $objMerchant->appCommon->DateTimeFormat($merchant['pos_create_at']); ?>
                                            <?php if (!in_array($merchant['pos_status'], ['deleted'])) {  ?>
                                            <span class="pull-right badge <?php echo $statusClass[$pos_status]; ?>"><?php echo strtoupper($pos_status); ?></span>
                                            <?php } ?>
                                        </td>                             
                                    </tr>
                                    <?php //if ($merchant['pos_status'] != 'deleted') {  ?>
                                    <tr>
                                        <td>Subscription</td>
                                        <?php
                                            if ($merchant['package_id'] > 1) {
                                                $pos_expiry_date = $merchant['subscription_end_at'];
                                                $currectSubscription = $objMerchant->appCommon->DateTimeFormat($merchant['subscription_start_at']) . ' To ' . $objMerchant->appCommon->DateTimeFormat($merchant['subscription_end_at']);
                                            } else {
                                                $pos_expiry_date = $merchant['pos_demo_expiry_at'];
                                                $currectSubscription = $objMerchant->appCommon->DateTimeFormat($merchant['pos_create_at']) . ' To ' . $objMerchant->appCommon->DateTimeFormat($merchant['pos_demo_expiry_at']);
                                            }
                                            
                                            $subscriptionClass = (strtotime($pos_expiry_date) < strtotime(date('Y-m-d'))) ? 'color:#f00; text-decoration: line-through;' : '';
                                            $subscriptionClass = ($merchant['pos_status']=="suspended") ? 'color:#f00; text-decoration: line-through;' : $subscriptionClass;
                                        ?>
                                        <td colspan="2" style="<?php echo $subscriptionClass; ?>" >
                                            <?php echo $currectSubscription ?>                                            
                                            <span class="pull-right badge <?php echo ($merchant['package_id'] > 1) ? 'bg-yellow' : 'bg-gray';?>"><?php echo $merchant['package_name']; ?></span>                                           
                                        </td>
                                    </tr>
                                    <?php
                                    //}                                     
                                    ?>
                                    <?php if (in_array($merchant['pos_status'], ['deleted', 'trashed'])) { ?>    
                                    <tr>
                                        <td>Deleted At</td>
                                        <td colspan="2"><?php echo $merchant['deleted_at'] ? $objMerchant->appCommon->DateTimeFormat($merchant['deleted_at']) : ''; ?>
                                        <?php if (in_array($merchant['pos_status'], ['deleted'])) {  ?>
                                            <span class="pull-right badge <?php echo $statusClass[$pos_status]; ?>"><?php echo strtoupper($pos_status); ?></span>
                                            <?php } ?>
                                        </td>                             
                                    </tr>
                                    <?php } ?>
                                    <?php if ($merchant['is_delete'] == 0 && !in_array($merchant['pos_status'], ['deleted', 'trashed'])) { ?>
                                    <tr>
                                        <td>Balance SMS</td>
                                        <td title="User SMS : <?= $sedSMSCount[$merchant['phone']]?$sedSMSCount[$merchant['phone']]:0?>"><?php echo $merchant['sms_balance']; ?>/<?php echo $sedSMSCount[$merchant['phone']]+$merchant['sms_balance']?>
                                            <span class="pull-right" title="Rcharge SMS Pack" style="cursor: pointer;"><a class="upgrade_sms_pack" smsid="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers"><i class="fa fa-commenting"></i></a></span>
                                        </td>
                                        <td>
                                            <table style="width:100%">
                                                <tr>
                                                    <td>
                                                        <?php if ($merchant['is_merchant_verified'] == 0) { ?>
                                                            <a href="#" title="Not Verified Genuine Merchant" <?php echo $modalAttr; ?> ><i class="fa fa-handshake-o text-gray text-align-lg-center" aria-hidden="true"></i></a>
                                                        <?php } else { ?>
                                                            <a href="#"  title="Verified Genuine Merchant" <?php echo $modalAttr; ?> ><i class="fa fa-handshake-o text-green text-align-lg-center" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                <?php if(!in_array($merchant['pos_status'], ['deleted', 'trashed', 'suspended', 'pending'])) { ?>    
                                                    <td>
                                                        <a class="merchant_pos_settings" title="POS Settings" id="<?php echo $merchant['id'] ?>" pos_version="<?php echo $merchant['pos_current_version']; ?>" data-toggle="modal" data-target="#posUsers" style="cursor: pointer;"><i class="fa fa-gear text-align-lg-center" aria-hidden="true"></i></a>
                                                    </td>                                                
                                                    <td>
                                                        <a class="merchant_pos_users" title="Manage Project User" id="<?php echo $merchant['id'] ?>" data-toggle="modal" data-target="#posUsers" style="cursor: pointer;"><i class="fa fa-user text-align-lg-center" aria-hidden="true"></i></a>
                                                    </td>
                                                <?php } ?>
                                                </tr>
                                            </table>        

                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php  endif; ?>
                                    
                                    <tr>
                                        <td>Following By</td>
                                        <td colspan="2"><?php echo $adminUsers[$merchant['client_by']]['display_name'] ?> 
                                            <span class="pull-right"><?php echo $adminUsers[$merchant['client_by']]['mobile_no'] ? '<i class="fa fa-phone" aria-hidden="true"></i> ' . $adminUsers[$merchant['client_by']]['mobile_no'] : '' ?></span>

                                        </td>
                                    </tr>
                                </table> 
                            </td>
                            <td style="border-bottom: thin solid #000; width: 120px;" class="text-center"><?php include($action_page); ?></td>
                        </tr>
                        <?php
                    }//end foreach
                endif;
                ?>
            </tbody>
        </table>
        <!-- DataTables -->
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-xs-12 text-center"><?php echo $objMerchant->merchantPagignations($merchantsData); ?></div>
</div>

<script src="merchants_script.js" ></script> 


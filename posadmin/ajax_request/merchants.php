<?php
include_once('../../application_main.php');

    $objMerchant = new merchant($conn);

    $merchantsData =  $objMerchant->get($_POST['id']);
    

?>
<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Merchant Details</h4>
  </div>
  <div class="modal-body">
      <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow" style="height: 100px;">
                <div class="widget-user-image col-sm-2">
                    <i class="fa fa-user" style="font-size: 80px;" ></i>
                </div>
                <div class="col-sm-10">
                    <!-- /.widget-user-image -->
                    <h3><strong><?php echo $merchantsData['name'];?></strong></h3>
                     
                    <h5><b>Address:</b> <?php echo $merchantsData['address'];?> , <?php echo $merchantsData['city'];?>, <?php echo $merchantsData['state'];?> , <?php echo $merchantsData['country'];?></h5>
                </div>
            </div>
            <div class="box-footer no-padding">
                
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <table class="table table-bordered">
                             <tr>
                                  <th colspan="2">Merchant Details</th>
                              </tr>
                            <tr>
                                <td>Name</td>
                                <td colspan="2"><?php echo $merchantsData['name'] ?> <span class="pull-right">Key Id: #<?php echo $merchantsData['id'] ?></span></td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td colspan="2"><?php echo $objMerchant->merchantType($merchantsData['type']) ?> </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?php echo $merchantsData['email'] ?></td>
                                <td class="text-right <?php echo ($merchantsData['is_email_verified']) ? 'text-success' : 'text-danger';?>"><?php echo ($merchantsData['is_email_verified']) ? 'Verified' : 'Not Verified'; ?></td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td><?php echo $merchantsData['phone'] ?></td>
                                <td class="text-right <?php echo ($merchantsData['is_mobile_verified']) ? 'text-success' : 'text-danger';?>"><?php echo ($merchantsData['is_mobile_verified']) ? 'Verified' : 'Not Verified'; ?></td>
                            </tr>                          
                            <tr>
                                <td>Business Name</td>
                                <td colspan="2"><?php echo $merchantsData['business_name'] ?></td>
                            </tr>                          
                            <tr>
                                <td>Created at</td>
                                <td colspan="2"><?php echo $objMerchant->appCommon->DateTimeFormat($merchantsData['created_at']) ?></td>
                            </tr>                          
                            <tr>
                                <td>Updated at</td>
                                <td colspan="2"><?php echo $objMerchant->appCommon->DateTimeFormat($merchantsData['updated_at']) ?></td>
                            </tr>                          
                        </table>   
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <?php
                            $pos_status = $merchantsData['pos_status'];
                            $statusClass = array('created'=>'bg-green', 'expired'=>'bg-red', 'suspended'=>'bg-red', 'pending'=>'bg-primary', 'deleted'=>'bg-red');
                          ?>
                          <table class="table table-bordered">
                              <tr>
                                  <th colspan="2">POS Details</th>
                              </tr>
                              <tr>
                                <td>POS Status</td>
                                <td colspan="2"><?php echo ($merchantsData['pos_generate'])? 'Generated' : 'Not Generated';?></td>
                              </tr>
                              <tr>
                                <td>POS Name</td>
                                <td><?php echo $merchantsData['pos_name'];?></td>
                                <td><span class="pull-right badge <?php echo $statusClass[$pos_status];?>"><?php echo $pos_status;?></span></td>                            
                              </tr>
                               <?php if($merchantsData['pos_generate']) :  ?>
                              <tr>
                                <td>POS Url</td>
                                <td colspan="2"><?php echo $merchantsData['pos_url'];?></td>                             
                              </tr>
                              <tr>
                                <td>Created at</td>
                                <td colspan="2"><?php echo $objMerchant->appCommon->DateTimeFormat($merchantsData['pos_create_at']);?></td>                             
                              </tr>
                              <tr>
                                <td>Package</td>
                                <td colspan="2"><?php echo $merchantsData['package_name'];?></td>                             
                              </tr>
                              <tr>
                                <td>Package Status</td>
                                <td colspan="2"><?php echo $pos_status;?></td>                             
                              </tr>
                              <tr>
                                <td>Expiry</td>
                                <td colspan="2"><?php echo $objMerchant->appCommon->DateTimeFormat( ($merchantsData['package_id'] > 1) ? $merchantsData['subscription_end_at'] : $merchantsData['pos_demo_expiry_at']);?></td>                             
                              </tr>
                                <?php if($_SESSION['session_user_group'] == 'admin-dev') : ?> 
                                <tr>
                                    <td>DB Name:</td>
                                    <td colspan="2"><?php echo $merchantsData['db_name'];?></td>                             
                                </tr>
                                <tr>
                                    <td>DB User Name:</td>
                                    <td colspan="2"><?php echo $merchantsData['db_username'];?></td>                             
                                </tr>
                                <tr>
                                    <td>Project Directory:</td>
                                    <td colspan="2"><?php echo $merchantsData['project_directory_path'];?></td>                             
                                </tr>
                                <tr>
                                    <td>Pos Username:</td>
                                    <td colspan="2"><?php echo $merchantsData['username'];?></td>                             
                                </tr>
                                <tr>
                                    <td>Pos Password:</td>
                                    <td colspan="2"><?php echo $merchantsData['password'];?></td>                             
                                </tr>


                                <?php endif; ?>
                              
                            <?php endif; ?>
                          </table> 
                    </div>                   
                </div>
                 
                
              
            </div>
          </div>
          <!-- /.widget-user -->
  </div>
  <div class="modal-footer border-muted">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>

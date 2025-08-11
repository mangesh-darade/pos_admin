<?php //
include_once('../../application_main.php');
    $objMerchant = new merchant($conn);
    $merchantsData =  $objMerchant->get($_POST['id']);
?>
<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Merchant Feedback Details</h4>
	
  </div>
  <div class="modal-body">
      <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2" style="box-shadow: none;">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow" style="height: 100px; padding:0px;">
                <div class="widget-user-image col-sm-2" style="padding:20px;">
                    <i class="fa fa-user" style="font-size: 80px;" ></i>
                </div>
                <div class="col-sm-10">
                    <!-- /.widget-user-image -->
                    <h3><strong><?php echo $merchantsData['name'];?></strong></h3>
                     
                    <h5><b>Address:</b> <?php echo $merchantsData['address'];?> , <?php echo $merchantsData['city'];?>, <?php echo $merchantsData['state'];?> , <?php echo $merchantsData['country'];?></h5>
					<h5><b>Mobile No:</b> <?php echo $merchantsData['phone'] ?> , Email Id: <?php echo $merchantsData['email'] ?></h5>
                </div>
            </div>
            <div class="box-footer no-padding">
				 <div class="row" style="margin-top:10px;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<ul class="nav nav-tabs">
							<li class="FeedbackTab AddFeedback active"><a data-toggle="tab" href="#AddFeedback">Add Feedback</a></li>
							<li class="FeedbackTab "><a data-toggle="tab" href="#FeedbackList" onclick="return getFeedbackList();">Feedback List</a></li>
							<li class="FeedbackTab"><a data-toggle="tab" href="#MerchantDetailsTab" onclick="return getFeedbackList();">Merchant Details</a></li>
						</ul>
					    <div class="tab-content">
							<div id="AddFeedback" class="tab-pane fade in active FeedbackBox AddFeedbackBox">
							<form method="post">
									<div class="col-sm-12 col-xs-12 input-group" style="margin-top:20px;">
										<span class="input-group-addon bg-gray"><i class="fa fa-fw fa-comments"></i> <span class="text-danger " >*</span></span>
										<textarea class="form-control" tabindex="1" id="feedback" name="feedback" placeholder="Feedback" value=""></textarea>
										
									</div>
									<div class="col-sm-12 col-xs-12 input-group" style="margin-top:10px;">
									<span class="text-danger feedback_error"></span>
									</div>
									<div class="col-sm-12 col-xs-12 input-group" style="margin-top:10px;">
									<input type="hidden" name="MerchantId" id="MerchantId" value="<?php echo $_POST['id']; ?>">
									<input type="hidden" name="FeedbackId" id="FeedbackId" value="">
									<span class="text-success feedback_succees"></span><br/>
										 <input type="button"  tabindex="2"  class="btn btn-primary add_feedback" onclick="return addFeedback();" value="Add Feedback"> <img src="./images/action_processing.gif" class="img add_feedback_loader" style="display:none;">
									</div>
								</form>
							</div>
							<div id="FeedbackList" class="tab-pane fade FeedbackBox " style="margin-top:10px;">
								  <table id="FeedbackTableList" class="table table-bordered">
									  <thead>
									  <tr>
										  <th >Feedback</th>
										  <th >Created Date</th>
										  <th >Action</th>
									  </tr>
									  </thead>
									  <tbody>
									  </tbody>
								  </table>
							</div>
							<div id="MerchantDetailsTab" class="tab-pane fade FeedbackBox" style="margin-top:10px;">
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
                </div>
            </div>
          </div>
          <!-- /.widget-user -->
  </div>
  <div class="modal-footer border-muted">
 
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>
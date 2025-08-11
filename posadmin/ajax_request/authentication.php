<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" id="modal_title">User Authentication</h4>
  </div>
  <div class="modal-body col-sm-8 col-sm-offset-2 col-xs-12">
      
        <div id="display_msg"></div>
        <!-- /.login-logo -->
        <div class="login-box-body" id="authentication_form">
          <p class="login-box-msg">Verify Your Authentication</p>
            
            <input type="hidden" id="login_session_id" value="<?php echo $_SESSION['session_user_id'];?>" />
            <input type="hidden" id="merchant_id" value="<?php echo $merchant_id;?>" />
            <input type="hidden" id="project_group" value="<?php echo $project_group;?>" />
            <input type="hidden" id="auth_type" value="<?php echo $auth_type;?>" />
            <div class="form-group has-feedback">
                <input type="text" id="auth_uid" maxlength="30" value="<?php echo $auth_uid;?>" class="form-control" placeholder="Username"  />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" id="auth_pcode" maxlength="50" autocomplete="new-password" value="<?php echo $auth_pcode;?>" class="form-control" placeholder="Password"  />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
             
        </div>
          <!-- /.login-box-body -->
  
  </div>
  <div class="modal-footer border-muted">
      <div class="col-xs-12 text-center" id="module_button">
        <button type="button" onclick="authenticate();" id="btn_authenticate"  class="btn btn-success">Authenticate</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
    </div>
  </div>
</div>

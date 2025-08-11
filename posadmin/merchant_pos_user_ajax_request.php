<?php
include_once('application_main.php');
include_once('session.php');
    
$merchant_id = $_POST['id'];
 
$objMerchant = new merchant($conn);
 
$objMerchant->connect_merchant_pos_db($merchant_id);

$merchantUserData = $objMerchant->pos_user_list();

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">POS Url: <?php echo str_replace('login/', '', $objMerchant->merchants['pos_url']);?></h4>
  </div>
<div class="modal-body" style="min-height: 200px;"> 
<?php

if($_POST['action'] == "resetpasswd") :
   
    $user_id = $_POST['user'];
    
    if( $objMerchant->pos_user_reset_password($user_id) === true ) :
    
      echo '<div class="col-sm-10 col-sm-offset-1">';
     
          if( $objMerchant->pos_user_reset_password_email_send($user_id) ):
    
          echo '<div class="alert alert-success">User Password Reset Success. [CODE: '. $objMerchant->resetcode .' ]</div> ';   
   
       endif;
   
       echo ' </div>';
   
    endif;
 
else :
 
 ?>            
    <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Id</th>                 
          <th>User Name</th>                 
          <th>Email</th> 
          <th>Status</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
       <?php
            
            if(is_array($merchantUserData)):
                 
                foreach ($merchantUserData as $posUser) {
            ?>
                <tr>
                  <td><?php echo $posUser['id'] ?></td>
                  <td><?php echo $posUser['first_name'] ?> <?php echo $posUser['last_name'] ?></td>
                  <td><?php echo $posUser['email'] ?></td>
                  <td><?php echo ($posUser['active']) ?'Active' : 'Deactive'; ?></td>                  
                  <td>
                      <div class="dropdown">
                        <a class="dropdown-toggle btn btn-primary btn-sm" type="text" data-toggle="dropdown">Action 
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a onclick="resetpasscode('<?php echo $merchant_id;?>','<?php echo $posUser['id'] ?>');"> Reset Password </a></li>
                        </ul>
                      </div>
                  </td>
                </tr>
           <?php
            }//end foreach
            endif;

            ?>
        </tfoot>
      </table>
<?php

endif;

//Disconnected Merchant POS database connection.
 $objMerchant->desconnect_merchant_pos_db();
?>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<?php include_once('ccavConfig.php'); ?>
<?php
    
        if(!isset($_POST["encResp"])) {
            header("location:../index.php");
        }

 //$objapp->authenticateMerchant();

 $objMerchant = new merchant;

// $merchantData =  $objMerchant->get($objapp->authMerchantId); 
?>

<?php  include_once('Crypto.php'); ?>

<?php include_once '../header.php'; ?>
<div class="jumbotron">
	
    <div class="container">
         
<?php
        
          
            $encResponse=$_POST["encResp"];                             //This is the response sent by the CCAvenue Server
            $rcvdString=decrypt($encResponse,$working_key);		//Crypto Decryption used as per the specified working key.
            $order_status="";
            $decryptValues=explode('&', $rcvdString);
            $dataSize=sizeof($decryptValues);
           
            for($i = 0; $i < $dataSize; $i++) 
            {
                    $information = explode('=',$decryptValues[$i]);

                    $responceData[$information[0]] = urldecode($information[1]);

                    //echo '<br/>'.$information[0].' : '.urldecode($information[1]);
            }    
                  
             $order_status =  $responceData['order_status']  ;
              
             $statusdata = ['id'=>$responceData['order_id'] , 'status'=>$responceData['order_status']];  
             
             $setOrder = false; 
             
            if($order_status==="Success")
            {
                $transaction = $objMerchant->set_merchant_transactions($responceData);               
            } 
                
            $setOrder = $objMerchant->set_order_status( $statusdata );       
         
            if($setOrder) {

               switch($order_status)
               {
                  case 'Success':
                       echo "<div class='alert alert-success text-center'>Thank you for activation. <br/>Your credit card has been charged and your transaction is successful. We will be activate your subscription soon.<div>";
                
                       break;
                   case 'Aborted':
                       echo "<div class='alert alert-danger text-center'>Transaction Canceled! We have noticed that you didn't complete your transaction.</div>";
                
                       break;
                   case 'Failure':
                       echo "<div class='alert alert-danger text-center'>Thank you for transaction. However,the transaction has been declined.</div>";
                
                       break;
                   default :
                       echo "<div class='alert alert-danger text-center'>Security Error. Illegal access detected</div>";
                       
                       break;
               }
                   
            }
            else
            {
                 echo "<div class='alert alert-danger text-center'>Order Status could not set.</div>";
            }
         
           
            ?>              <div class="text-center"><a href="../index.php" class="btn btn-success btn-lg">Go back to My Account</a></div>
    </div>
    <!--/.container-fluid-->
</div>

<?php include_once('../footer.php'); ?>
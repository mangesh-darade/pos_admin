<?php
include_once('../../application_main.php');

$objMerchant = new merchant($conn);

$reportData = $objMerchant->merchants_report($_POST);
$report_name = 'merchants_'. $_POST['report_type'] . '.xls';
 
$view = '<div><a href="reports/'.$report_name.'" target="_new" class="btn btn-success"  style="position: absolute; z-index: 9999; top: 140px; right: 20px;">Download</a></div>
        <div class="box box-success">
            <div class="box-body">';
       
$vth1 = ' <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>';

$vth2 = '<th>Merchant Name</th><th>Email</th><th>Pos Url</th>';

$vth3 = '<th>Business Name</th>
                  <th>Phone</th>
                  <th>POS Name</th>
                  <th>POS Type</th>                  
                  <th>Version</th>
                  <th>Package</th>
                  <th>Status</th>
                  <th>Due Date</th>
                  <th>Balance Validity</th>';
$thlog = '        <th>Log</th>';
$vth4 = '     </tr>
            </thead>
            <tbody>';

$write = $vth1 . $vth2 . $vth3 . $vth4;
$view .= $vth1 . $vth3 . $thlog . $vth4;
                  
        if(!empty($reportData)) {
            foreach ($reportData as $row) {

                extract($row);
            
        $vtd1 = '<tr>
                        <td>'.++$i.'</td>';

        $vtd2 = '<td>'.$name.'</td><td>'.$email.'</td><td>'.$pos_url.'</td>';
    
        $vtd3 =' <td>'.$business_name.'</td>
                        <td>'.$phone.'</td>
                        <td>'.$pos_name.'</td>
                        <td>'.$merchant_type.'</td>
                        <td style="text-align:center;">'.$pos_current_version.'</td>
                        <td>'.$package_name.'</td>
                        <td>'.$pos_status.'</td>
                        <td>'.$subscription_end_at.'</td>
                        <td style="text-align:right;">'.$validity_balance.' days</td>';
         $tdlog ='    <td><a href="#" title="Merchant Log" class="merchantLog" custid="'.$id.'" data-toggle="modal" data-target="#posUsers" ><i class="fa fa-history text-green text-align-lg-center" aria-hidden="true"></i></a></td>';
         $vtd4 =' </tr>';

$write .= $vtd1 . $vtd2 . $vtd3 .$vtd4;
$view  .= $vtd1 . $vtd3 . $tdlog .$vtd4 ;

                }//end foreach 
            } //end if
                   
$write .=  '   </tbody>';
$view  .= '   </tbody>';

$view  .=  '<tfoot>
                <tr>
                  <th>#</th>                  
                  <th>Business Name</th>
                  <th>Phone</th>
                  <th>POS Name</th>
                  <th>POS Type</th>                  
                  <th>Version</th>
                  <th>Package</th>
                  <th>Status</th>
                  <th>Due Date</th>
                  <th>Balance Validity</th>
                  <th>Log</th>
                </tr>
           </tfoot>';

$write .= '</table>';
 
$view  .= '</table>';
   
$view  .= '</div>
    </div>';    
 
file_put_contents("../reports/$report_name", $write);
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename='../reports/$report_name'"); 
 // Clean the output buffer so it won't mess up your excel export 
 ob_clean();
 
 echo $view;
?>
<!-- page script -->
<script src="merchants_script.js"></script> 
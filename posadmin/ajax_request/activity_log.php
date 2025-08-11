<div class="box box-info">
    <div class="box-header">        
        <h1 class="box-title">Activity Log For <q><b><?php echo $merchantData['business_name']?></b></q></h1>
        <a href="#" data-dismiss="modal" class="text-red pull-right">X</a>
    </div>
    <div class="box-body">
        <div class="row text-info">
            <div class="col-sm-6"><b>Merchant Name:</b> <?php echo $merchantData['business_name']?> </div>
            <div class="col-sm-6"><b>POS URL:</b> <?php echo $merchantData['pos_url']?> </div>
            <hr/>
        </div>
        <div class="box-content table-responsive" style="height: 400px; overflow-y: auto;">
         
            <table class="table table-bordered">
                <tr>
                    <th>Activity at</th>
                    <th>Activity Details</th>
                    <th>Activity By</th>                    
                    <th>Activity From</th>
                </tr>
            <?php foreach ($logData as $key => $log) { ?>
                <tr>
                    <td><?php echo $objapp->DateTimeFormat($log['activity_at'], 'jS F Y g:ia');?></td>
                    <td><?php echo $log['user_activity'];?></td>
                    <td><?php echo $log['user_name'];?></td>                   
                    <td><?php echo $log['activity_ip'];?></td>                     
                </tr>
            <?php } ?>
            </table>
        </div>
    </div>
    <div class="box-footer">
        <button class="btn btn-primary"  data-dismiss="modal">close</button>
    </div>
</div>
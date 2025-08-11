<?php
$objMerchant = new merchant($conn);
?>
<div class="row" style="margin: 10px 0;">
    <div class="col-sm-4">
        Show <select class="form-control input-sm"  name="per_page_records" id="per_page_records" style="display:inline; width:auto;">
        <?php
            $perpageArr = [5,10,20,30,40,50];
            
            foreach($perpageArr as $pp){
                
                $selectpp = ($pp == $tableData['itemsPerPage']) ? ' selected="selected" ' : '';
                echo '<option '.$selectpp.'>'.$pp.'</option>';
            }
        ?> 
        </select>
    
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary" style="width:120px; text-align: left;">Filter: <span id="show_sort_by"> All </span></button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu sort_by" role="menu">
                <li id="all"><a>All</a></li>                 
                <li class="divider"></li>
                <li id="is_active-1"><a>ACTIVE</a></li>
                <li id="is_active-0"><a>DEACTIVE</a></li>  
                <li id="is_delete-1"><a>DELETED</a></li>                                     
            </ul>
        </div>       
    </div>
    <div class="col-sm-8">
        <?php echo $objLib->dataPagignations($tableData); ?> 
         <div class="box-tools pull-right">
            <div class="input-group input-group-sm" style="width: 200px;">
                <input type="text" name="search_key" id="search_key" value="<?php echo $tableData['search_key'];?>" class="form-control pull-right" placeholder="Search" />
              <div class="input-group-btn" id="btn_search">
                  <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </div>
            </div>
        </div> 
    </div>
</div>

<div id="error_msg"></div> 
<div id="alert-action-msg" class="alert alert-success alert-action" ></div>  
<div class="row" >
    <div class="col-sm-12 " >        
        <table  class="table table-bordered table-striped">
            <thead>
                <tr >
                  <th>Id</th>                 
                  <th>Project Group</th>                           
                  <th>Project Title</th>                           
                  <th>Version</th>
                  <th>Zip File Name</th>
                  <th>Action <a id="btnAddNew" class="btn btn-success btn-xs pull-right"  data-toggle="modal" data-target="#myModal" >Add New</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                if(is_array($tableData['rows'])):
                    
                    foreach ($tableData['rows'] as $mType) {                     
                    
                    $id = $mType['id'];

                    if($is_active = $mType['is_active']) 
                    {
                        $status = 'Status Active';
                        $statusIcon = '<i class="fa fa-check-square-o text-success" ></i>';
                        $rowClass = '';
                    } 
                    else 
                    { 
                        $status = 'Status Deactive';
                        $statusIcon = '<i class="fa fa-ban text-default" ></i>' ;
                        $rowClass = 'row-deactive';
                    }


                    $row_action_class = 'btn btn-default btn-icon action-'.$id;
                    $row_recycle_class = 'btn btn-default btn-icon recycle-'.$id;

                    if($is_delete = $mType['is_delete']) 
                    {
                        $recycle = '';
                        $action = ' style="display:none" ';
                        $rowClass .= ' text-red';
                    }
                    else
                    {
                        $recycle = ' style="display:none" ';
                        $action = '';
                    }
                ?>
                    <tr id="datarow-<?php echo $id;?>" class="<?php echo $rowClass;?>">
                        <td><?php echo $mType['index'];?></td>
                        <td><?php echo $objMerchant->projectGroups[$mType['project_group']];?></td>                          
                        <td><?php echo $mType['title'];?></td>                          
                        <td><?php echo $mType['version'];?></td>
                        <td><?php echo $mType['project_file'];?></td>
                        <td id="data-action-<?php echo $id;?>" class="text-center"><span class="loading"></span>                            
                            <a class="<?php echo $row_action_class;?> action-change-status" <?php echo $action;?> id="acs_id_<?php echo $id;?>" keyid="<?php echo $id;?>" keystatus="<?php echo $is_active;?>"  title="<?php echo $status;?>"><?php echo $statusIcon; ?> </a>
                            <a class="<?php echo $row_action_class;?> action-edit" <?php echo $action;?> title="Edit" id="ae_id_<?php echo $id;?>" keyid="<?php echo $id;?>" data-toggle="modal" data-target="#myModal"  ><i class="fa fa-pencil-square-o text-primary" ></i></a>
                            <a class="<?php echo $row_action_class;?> action-delete" <?php echo $action;?> title="Delete" id="ad_id_<?php echo $id;?>" keyid="<?php echo $id;?>" ><i class="fa fa-trash-o text-danger" ></i></a>
                            <a class="<?php echo $row_recycle_class;?> action-undelete" <?php echo $recycle;?> title="Undelete" id="aud_id_<?php echo $id;?>" keyid="<?php echo $id;?>"><i class="fa fa-recycle text-success"></i></a>
                        </td>
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


<script src="merchants_script.js"></script> 
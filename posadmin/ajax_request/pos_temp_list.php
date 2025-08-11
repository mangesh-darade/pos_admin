<div class="row" >
    <div class="col-sm-12 " >  
        <form method="post" onsubmit="return confirm('Are you sure to delete selected projects?');" />
        <table id="datatableScraps" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th> 
                    <th>Id</th>
                    <th>Sub Domain</th>  
                    <th>Is Valid Pos</th> 
                    <th>Directory</th>                   
                    <th>Directory Exists</th> 
                    <th>Invalid Database & Username</th>                 
                </tr>
            </thead>
            <tbody>
                <?php
                $AllDBList = $objMerchant->cp_getDBList();
                $AllDBUserList = $objMerchant->cp_getDBUsersList();
                $ValidDBList = $objMerchant->getmarchants_dblist();               
               
                
                $ValidDBList[] = ['db_username'=>'sitadmin_edurp',   'db_name' => 'sitadmin_edurp'];
                $ValidDBList[] = ['db_username'=>'sitadmin_motowin', 'db_name' => 'sitadmin_motowinz'];
                $ValidDBList[] = ['db_username'=>'sitadmin_mypos',   'db_name' => 'sitadmin_mypos'];
                $ValidDBList[] = ['db_username'=>'sitadmin_offline', 'db_name' => 'sitadmin_offlinepos'];
                $ValidDBList[] = ['db_username'=>'sitadmin_smpsafe', 'db_name' => 'sitadmin_simplysafe'];
                $ValidDBList[] = ['db_username'=>'sitadmin_sup2019', 'db_name' => 'sitadmin_super_admin'];
                $ValidDBList[] = ['db_username'=>'sitadmin_superad', 'db_name' => 'sitadmin_super_admin_2019'];
                $ValidDBList[] = ['db_username'=>'sitadmin_consume'];
                $ValidDBList[] = ['db_username'=>'sitadmin_pos1'];
                $ValidDBList[] = ['db_username'=>'sitadmin_useedur'];

                $invalidDBList     = $AllDBList;
                $invalidDBUserList = $AllDBUserList;
                 
                foreach ($ValidDBList as $DbArr) {
                    if (($key = array_search($DbArr['db_name'], $invalidDBList)) !== false) {
                        unset($invalidDBList[$key]);
                    }
                    if (($ukey = array_search($DbArr['db_username'], $invalidDBUserList)) !== false) {
                        unset($invalidDBUserList[$ukey]);
                    }
                }                              
                
                $tableData = $objMerchant->cp_subdomainList();
                $scrapDirList = $objMerchant->getScrapFolderList($POS_PATH);

                $id = 0;
                if (is_array($tableData['data'])):

                    foreach ($tableData['data'] as $key => $mType) {

                        $folderName = str_replace('public_html/', '', $mType['basedir']);
                        $path = '../';

                        if (($key = array_search($folderName, $scrapDirList)) !== false) {
                            unset($scrapDirList[$key]);
                        }

                        $chaVal = $mType['subdomain'] . '~' . $folderName;

                        $isValid = ($objMerchant->is_valid_pos($mType['subdomain'])) ? 'Valid' : 'Invalid';
                        if ($isValid === 'Valid')
                            continue;
                        $id++;
                        ?>

                        <tr id="datarow-<?php echo $id; ?>"  class="<?php echo $rowClass; ?>">
                            <td><input type="checkbox" id="row_<?php echo $id; ?>" name="chkSelect[]"  value="<?php echo $chaVal; ?>" /></td>
                            <td><?php echo $id; ?></td>                          
                            <td><label for="row_<?php echo $id; ?>"><?php echo $mType['subdomain']; ?></label></td>
                            <td><?php echo $isValid; ?></td> 
                            <td><label for="row_<?php echo $id; ?>"><?php echo $folderName; ?></label></td> 
                            <td><?php echo $f = (is_dir($path . $folderName)) ? 'Exists' : 'Not Exists'; ?></td>  
                            <td></td>                       
                        </tr>

                        <?php
                    }//end foreach
                endif;

                foreach ($scrapDirList as $scrapDir) {
                    $id++;
                    ?>
                    <tr id="datarow-<?php echo $id; ?>"  class="<?php echo $rowClass; ?>">
                        <td><input type="checkbox" id="row_<?php echo $id; ?>" name="chkSelect[]"  value="~<?php echo $scrapDir; ?>" /></td>
                        <td><?php echo $id; ?></td>                          
                        <td></td>
                        <td></td> 
                        <td><label for="row_<?php echo $id; ?>"><?php echo $scrapDir; ?></label></td> 
                        <td>Exists</td> 
                        <td></td>                        
                    </tr>
                    <?php
                }
                foreach ($invalidDBList as $key => $dbname) {
                    $id++;
                    ?>
                    <tr id="datarow-<?php echo $id; ?>"  class="<?php echo $rowClass; ?>">
                        <td><input type="checkbox" id="row_<?php echo $id; ?>" name="chkSelect[]"  value="~~<?php echo $dbname; ?>" /></td>
                        <td><?php echo $id; ?></td>                          
                        <td></td>
                        <td></td> 
                        <td></td> 
                        <td>DB Name</td>                         
                        <td><?= $dbname ?></td>                         
                    </tr>
                    <?php
                }
                foreach ($invalidDBUserList as $key => $dbuser) {
                    $id++;
                    ?>
                    <tr id="datarow-<?php echo $id; ?>"  class="<?php echo $rowClass; ?>">
                        <td><input type="checkbox" id="row_<?php echo $id; ?>" name="chkSelect[]"  value="~~~<?php echo $dbuser; ?>" /></td>
                        <td><?php echo $id; ?></td>                          
                        <td></td>
                        <td></td> 
                        <td></td> 
                        <td>DB Username</td>                         
                        <td><?= $dbuser ?></td>                         
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <!-- DataTables -->
        <div class="text-center"><button type="submit" name="CmdClean" class="btn btn-primary" >Delete<button</div>
                    </form>
                    </div>
                    </div>


                    <script src="merchants_script.js"></script> 
<?php
$subDomainName = $_REQUEST['subdomain'];
$merchant_id = $_REQUEST['id'];
$step = 0;

$ProjectDirectory = POS_PROJECT_DIR . $subDomainName;
$ProjectBaseURL = 'https://' . $subDomainName . '.' . CP_HOST . '/';

$projectPath = "../" . $ProjectDirectory;

if ($subDomainName == '') {
    echo "<h2>Please mention Subdomain name and steps.</h2>";
    echo "<p>Ex.: https://ProjectUrl/index.php?step=1&subdomain=ProjectName</p>";
    exit;
}

$dbData = $objMerchant->getDbConfig($subdomain, $id);

$databasename = $dbData['db_name'];
$databaseuser = $dbData['db_user'];  //be careful this can only have a maximum of 7 characters 
$databasepass = $dbData['db_passwd'];


if ($projectDataPath['pos_project_zip'] != '') {
    //Set Project zip according to merchant type
    $sorceFile = $projectDataPath['pos_project_zip'];
} else {
    //Default Project Zip.
    $sorceFile = DEFAULT_POS_PROJECT_ZIP;
}

$pos_images_zip_file = $projectDataPath['pos_images_zip_file'];

if ($projectDataPath['pos_database_file'] != '') {
    //Set sample data according to merchant type
    $databaseFile = "database/" . $projectDataPath['pos_database_file'];
} else {
    //Default Database File
    $databaseFile = "database/" . DEFAULT_POS_SQL;
}

$sampleDataFile = "database/" . $projectDataPath['pos_sample_data_file'];

$steupdata = [
    'merchant_id' => $merchant_id,
    'pos_name' => $subDomainName,
    'prefix' => $prefix,
    'pos_url' => $ProjectBaseURL,
    'step' => $_REQUEST['step'],
    'sql_version' => $projectDataPath['sql_version'],
    'pos_version' => $projectDataPath['pos_version'],
];

$setupurl = "pos_generator.php?action=setup&id=" . $merchant_id . "&subdomain=" . $subDomainName . "&sampledata=" . $uploadSampleDataDump;

//Create Sub-domain, Database, User and Assign All Previladges.
if ($_REQUEST["step"] == 1) {

    $subdomainResult = $objMerchant->cp_createSubDomain($subDomainName, CP_HOST, $ProjectDirectory);

    if ($subdomainResult['status'] == 'SUCCESS') {

        $steupdata['step_1'] = 1;

        if (setp_success($steupdata)) {
            $steupdata['status'] = '<li>' . $subdomainResult['msg'] . '</li>';

            $ssl_domain = $subDomainName . '.' . CP_HOST;

            //Database create
            $createDB = $objMerchant->cp_createDB($databasename);

            if ($createDB['status'] == 'SUCCESS') {

                $steupdata['status'] .= '<li>Database <i><q>' . $databasename . '</q></i> created successfully.</li>';

                $databasepass = $objapp->mc_decrypt($databasepass, MASTER_ENCRYPTION_KEY);

                $addDbUser = $objMerchant->cp_addDbUser($databaseuser, $databasepass);

                if ($addDbUser['status'] == 'SUCCESS') {
                    $steupdata['status'] .= '<li>Database User <i><q>' . $databaseuser . '</q></i> created successfully.</li>';

                    //gives all privileges to the newly created user on the new db
                    $setPrivileges = $objMerchant->cp_AssignDbUserPrivileges($databaseuser, $databasename, 'ALL PRIVILEGES');

                    if ($setPrivileges['status'] == 'SUCCESS') {
                        $steupdata['status'] .= '<li>' . $setPrivileges['msg'] . '</li>';
                        $steupdata['step'] = 2;
                        $steupdata['step_2'] = 1;
                        if (setp_success($steupdata)) {
                            header('location:' . $setupurl . '&step=3');
                        }
                    } else if ($setPrivileges['status'] == 'ERROR') {
                        echo '<div class="alert alert-danger">' . $setPrivileges['msg'] . '</div>';
                        // header('location:'.$setupurl.'&error=setPrivileges');  
                    }//end else.
                } else if ($addDbUser['status'] == 'ERROR') {
                    echo '<div class="alert alert-danger"><b>Create DB User Responce :</b>  ' . $addDbUser['msg'] . '<p>User:' . $databaseuser . ' <br/>Passwd:' . $databasepass . '</p></div>';

                    // header('location:'.$setupurl.'&error=addDBUser');  
                }//end else.                
            } else if ($createDB['status'] == 'ERROR') {
                echo '<div class="alert alert-danger">' . $createDB['msg'] . '</div>';
                //header('location:'.$setupurl.'&error=createDB');                
            }//end else.       
        }//end if.
        else {
            echo '<div class="alert alert-danger">Pos Setup Log Error.</div>';
        }
    } elseif ($subdomainResult['status'] == 'ERROR') {

        echo '<div class="alert alert-danger">' . $subdomainResult['msg'] . '</div>';

        //header('location:'.$setupurl.'&error=createSubdomain');
    }
}



//Import Sql to database
if ($_REQUEST['step'] == 3) {

    $steupdata['status'] = '';
    // Name of the file
    $filename = $databaseFile;
    // MySQL host
    $mysql_host = 'localhost';
    // MySQL username
    $mysql_username = $dbData['db_user'];
    // MySQL password
    $mysql_password = $objapp->mc_decrypt($dbData['db_passwd'], MASTER_ENCRYPTION_KEY);
    // Database name
    $mysql_database = $dbData['db_name'];

    $steupdata['setup_id'] = $setupdata['id'];

    // Create connection
    $posconn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    // var_dump($posconn);
    // Check connection
    if ($posconn->connect_error) {
        echo $steupdata['status'] .= "<li class='alert alert-danger'>Connection failed:## " . $posconn->connect_error . ".</li>";
    } else {
        $steupdata['status'] .= "<li>Pos database <i><q>$mysql_database</q></i> connected.</li>";
        $import = 0;
        if (!file_exists($filename)) {
            echo '<div class="alert alert-danger">File ' . $filename . ' Not exists.</div>';
        } else {
            $import = $objMerchant->importPosSql($filename, $posconn);
        }

        if ($import) {

            $steupdata['status'] .= "<li>Database imported successfully.</li>";

            //Import POS Sample Product Data
            if ($uploadSampleDataDump == 1) {
                $importSampleData = 0;

                if (!file_exists($sampleDataFile) || !is_file($sampleDataFile) || is_dir($sampleDataFile)) {
                    echo '<div class="alert alert-danger">Sample Data File Not Exists.</div>';
                } else {

                    $importSampleData = $objMerchant->importPosSql($sampleDataFile, $posconn);

                    if ($importSampleData) {
                        $steupdata['status'] .= "<li>Sample products data imported successfully.</li>";
                    } else {
                        $steupdata['status'] .= '<li class="alert alert-danger">Sample products data import failed.</li>';
                    }
                }
            }//end if.
            else {
                $defaultDatabaseFile = "database/sample_data/common.sql";
                //Upload Default Products.   
                $importSampleData = $objMerchant->importPosSql($defaultDatabaseFile, $posconn);

                if ($importSampleData) {
                    $steupdata['status'] .= "<li>Sample default 3 products imported successfully.</li>";
                } else {
                    $steupdata['status'] .= '<li class="alert alert-danger">Default products data import failed.</li>';
                }
            }//end else.
            //Create POS Master user.
            if ($objMerchant->create_pos_user($posconn, $merchantsData)) {
                $steupdata['status'] .= '<li>Merchant add to POS as master user.</li>';
            } else {
                echo $steupdata['status'] .= '<li>Error to create pos user.</li>';
            }

            //Set POS Version Into the POS Database Settings.
            if ($objMerchant->setVersionToPosSettings($posconn, $projectDataPath)) {
                $steupdata['status'] .= '<li>POS version set successfully.</li>';
            } else {
                echo $steupdata['status'] .= '<li>Error in set pos version.</li>';
            }

            $steupdata['step_3'] = 1;
            $steupdata['step'] = 3;

            $posconn->close();

            if (setp_success($steupdata)) {
                ?>
                <div id="btn_next_step_4"><a href="<?php echo $setupurl . '&step=4'; ?>" class="btn btn-primary">Next</a></div>
                <?php
            }
        } else {
            echo $steupdata['status'] .= '<li class="alert alert-danger">Error in imports sample product.</li>';
            ?>    <div id="btn_next_step_3"><a href="<?php echo $setupurl . '&step=3'; ?>" class="btn btn-primary" > Try Again</a></div> <?php
        }
    }//end else.
}

//Copy Project Zip to Subdomain, Extract Zip and Remove zip.
if ($_REQUEST['step'] == 4) {

    $projectDirectory = $projectPath;
    $destinationPath = $projectPath;
    $project = 0;
    $steupdata['status'] = '';

    if (is_dir($projectDirectory)) {
        $steupdata['status'] .= "<li>Project directory is available.</li>";

        $project = 1;
    } else {
        mkdir($projectDirectory, 777);

        if (is_dir($projectDirectory)) {
            $steupdata['status'] .= "<li>Project directory created successfully.</li>";

            $project = 1;
        }
    }

    if ($project == 1) {

        if (checkPathWritable($projectDirectory)) {
            if ($sorceFile == '') {
                $steupdata['status'] .= "<li class='text-danger'>Source Project File Is Blank.</li>";
            } else {
                $copy = copy('pos_projects/' . $sorceFile, $destinationPath . "/" . $sorceFile);

                if ($copy) {
                    $steupdata['status'] .= "<li>Project zip copy successfully.</li>";
                    $steupdata['step_4'] = 1;
                    if (setp_success($steupdata)) {
                        // header('location:'.$setupurl.'&step=5');
                        ?>
                        <div id="btn_next_step_5"> <a href="<?php echo $setupurl . '&step=5'; ?>" class="btn btn-primary" >Next</a></div>
                        <?php
                    }//end if.
                } else {
                    echo $steupdata['status'] .= "<li class='text-danger'>Project zip copy failed.</li>";
                    $steupdata['step_4'] = 0;
                    exit;
                    if (setp_success($steupdata)) {
                        header('location:' . $setupurl . '&step=4');
                    }
                }
            }//end else
        }//end if.
    }
}


if ($_REQUEST['step'] == 5) {

    $projectDirectory = $projectPath;
    $steupdata['status'] = '';
    $zip = new ZipArchive;

    if ($zip->open($projectDirectory . "/" . $sorceFile) === TRUE) {
        $extracted = $zip->extractTo($projectDirectory);
        $zip->close();
        if (!$extracted) {
            $steupdata['status'] .= "<li>Project zip extraction failed.<li>";
            $steupdata['step_5'] = 0;
            if (setp_success($steupdata)) {
                header('location:' . $setupurl . '&step=5');
            }
        } else {
            $steupdata['status'] .= "<li>Project zip extracted successfully.</li>";

            $unlink = unlink($projectDirectory . "/" . $sorceFile);

            if ($unlink) {
                $steupdata['status'] .= "<li>Project zip remove successfully.</li>";
                $steupdata['step_5'] = 1;

                //Copy Sample Product Images to generated project as per merchant type.
                if (!empty('pos_images/' . $pos_images_zip_file)) {
                    $steupdata['status'] .= "<li>Product image file availabled:  <q>" . $pos_images_zip_file . "</q></li>";
                    if ($zip->open('pos_images/' . $pos_images_zip_file) === TRUE) {
                        $extracted = $zip->extractTo($projectDirectory . "/assets");
                        $zip->close();
                        if (!$extracted) {
                            $steupdata['status'] .= "<li class='text-danger'>Product images zip extraction failed.<li>";
                            $steupdata['step_5'] = 0;
                        } else {
                            $steupdata['status'] .= "<li>Product images copy successfully.</li>";
                        }
                    }
                } else {
                    $steupdata['status'] .= "<li class='text-danger'>Product images not availabled:  <q>" . $pos_images_zip_file . "</q></li>";
                }

                //////////////////////////////////////////////////////////////////////////////
                //Copy Eshop Theams Default Images. 

                $eshopTheamsImagesPath = $projectDirectory . "/assets/uploads/eshop_user";

               /* $existEshopImages = ['bakery', 'electronics', 'furniture', 'hardware', 'jewellery', 'pharma', 'restaurant', 'stationery'];
                $posTypeZip = (in_array($merchantsData['pos_type'], $existEshopImages)) ? $merchantsData['pos_type'] : 'default';

                $eshopTheamsImageSorceFile = 'pos_images/eshops/' . $posTypeZip . '.zip';
               */

                $eshopTheamsImageSorceFile = 'pos_images/eshops/' . $merchantsData['pos_type'] . '.zip';

                //Eshop Thems Upgrade Images Zip Exists.
                $imageZipExists = file_exists($eshopTheamsImageSorceFile);

                if ($imageZipExists) {
                    $steupdata['status'] .= '<li>Eshop Image Zip Exists: ' . $eshopTheamsImageSorceFile . '</li>';

                    if ($zip->open($eshopTheamsImageSorceFile) === TRUE) {
                        $extracted = $zip->extractTo($eshopTheamsImagesPath);
                        if ($extracted) {
                            $steupdata['status'] .= '<li>Eshop theme images copy successfully.</li>';
                        } else {
                            $steupdata['status'] .= "<li class='text-danger'>Eshop theme images copy failed.</li>";
                        }
                        $zip->close();
                    }//end if.
                }//end if.
                else {
                    $steupdata['status'] .= "<li  class='text-danger'>Eshop images update not found.</li>";
                }
                ////////////////////////////////////////////////////////////////////////////////

                if (setp_success($steupdata)) {
                    //header('location:'.$setupurl.'&step=6');
                    ?>
                    <div id="btn_next_step_6"><a href="<?php echo $setupurl . '&step=6'; ?>" class="btn btn-primary" >Next</a></div>
                    <?php
                }
            }
        }
    }
}


if ($_REQUEST['step'] == 6) {
    $steupdata['status'] = '';
    //Update Database configuration details.
    $fname = $projectPath . "/app/config/database.php";
    if (checkPathWritable($fname)) :
        $fhandle = fopen($fname, "r");
        $content = fread($fhandle, filesize($fname));
        $org = array("[USERNAME]", "[PASSWORD]", "[DBNAME]");
        $chd = array($dbData['db_user'], $objapp->mc_decrypt($dbData['db_passwd'], MASTER_ENCRYPTION_KEY), $dbData['db_name']);
        $content = str_replace($org, $chd, $content);
        $fhandle = fopen($fname, "w");
        $fw1 = fwrite($fhandle, $content);
        if ($fw1) {
            $steupdata['status'] .= "<li>Database connection details updated.</li>";
            $next = true;
        }
        fclose($fhandle);
    else :
        $steupdata['status'] .= '<li class="text-danger">app/config/database.php file not writable.</li>';
        $next = false;
    endif;


    //Set Project Baseurl.
    $fname1 = $projectPath . "/app/config/config.php";
    if (checkPathWritable($fname1)) :
        $fhandle1 = fopen($fname1, "r");
        $content1 = fread($fhandle1, filesize($fname1));
        $ProjectBaseURL = str_replace('http://', 'https://', $ProjectBaseURL);
        $content1 = str_replace('[MERCHANT_PHONE]', $merchantsData['phone'], $content1);
        $content1 = str_replace('[PROJECT_BASE_URL]', $ProjectBaseURL, $content1);
        $fhandle1 = fopen($fname1, "w");
        $fw2 = fwrite($fhandle1, $content1);
        if ($fw2) {
            $steupdata['status'] .= "<li>Project base url set.</li>";
            $next = true;
        } else {
            $steupdata['status'] .= "<li class='text-danger'>Project base url could not set.</li>";
        }
        fclose($fhandle1);
    else :
        $steupdata['status'] .= '<li class="text-danger">app/config/config.php file not writable.</li>';
        $next = false;
    endif;

    if ($next === true) {
        $steupdata['step_6'] = 1;
        if (setp_success($steupdata)) {
            // header('location:'.$setupurl.'&step=7');
            ?>
            <div id="btn_next_step_7"> <a href="<?php echo $setupurl . '&step=7'; ?>" class="btn btn-primary" >Finish Setup</a></div>
            <?php
        }
    } else {
        $steupdata['step_6'] = 0;
        if (setp_success($steupdata)) {
            header('location:' . $setupurl . '&step=6');
        }
    }
}
?>
 



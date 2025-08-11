<?php

$id = $_REQUEST['id'];
$step = $_REQUEST['step'];

$projectPath = "../../".$ProjectDirectory;
$sorceFile = "pos_project.zip";

//Create Sub-domain, Database, User and Assign All Previladges.
if($_REQUEST['step']==1) :
    
    if($subDomainName == '')
    {
        echo "<div class='alert alert-danger'><h2>Please mention Subdomain name and steps</h2>";
        echo "<p>Ex.: http://ProjectUrl/index.php?step=1&subdomain=ProjectName</p></div>";
       // phpinfo();
        exit;
    }
    
    $xmlapi = new xmlapi('127.0.0.1');

    $xmlapi->set_port( 2083 );

    $xmlapi->password_auth($cpanelusr,$cpanelpass);

    $xmlapi->set_debug(0); //output actions in the error log 1 for true and 0 false 

    $result = $xmlapi->api1_query($cpanelusr, 'SubDomain', 'addsubdomain', 

                        array($subDomainName, $hostName ,0, 0, $ProjectDirectory ));

    $event = $result->event;
  
  if($event->result) :
      
      echo '<div class="alert alert-success">Project Directory Generate Successfully.</div>';
  $nextstep = $step + 1;
      
  ?>      
<div><a href="<?php echo "pos_generator.php?id=$id&step=$nextstep&subdomain=$subDomainName"; ?>" class="btn btn-primary" >Next</a></div>
 <?php  
  else :
        echo '<div class="alert alert-danger">Project Directory Generation failed.</div>'; 
  endif;

endif;

if($_REQUEST['step']==2) :

    $xmlapi = new xmlapi('127.0.0.1');

    $xmlapi->set_port( 2083 );

    $xmlapi->password_auth($cpanelusr,$cpanelpass);

    $xmlapi->set_debug(0); //output actions in the error log 1 for true and 0 false 
    //
//the actual $databasename and $databaseuser will contain the cpanel prefix for a particular account. 
  //Ex: prefix_dbname and prefix_dbuser
        
    $dbConf = getDbConfig();
    
    $databasename = $dbConf['dbname'];
    $databaseuser = $dbConf['dbuser']; //be careful this can only have a maximum of 7 characters	
    $databasepass = $dbConf['dbpassword'];   
     
    $createdb = $xmlapi->api1_query($cpanelusr, "Mysql", "adddb", array($databasename)); //creates the database 	 
    
    $objCreateDB = $createdb->event;
    
    if($objCreateDB->result) :
        
        //echo "<p>Database ".$dbData['db_name']." created successfully.</p>";    
    
            $usr = $xmlapi->api1_query($cpanelusr, "Mysql", "adduser", array($databaseuser, $databasepass)); //creates the user 

            $objCreateUser = $usr->event;
            if($objCreateUser->result) :
               // echo "<p>Database User:". $dbData['db_user'] ."created successfully.</p>";
               // echo "<p>User password:  $databasepass</p>";
                
                //gives all privileges to the newly created user on the new db
                $addusr = $xmlapi->api1_query($cpanelusr, "Mysql", "adduserdb", 
                            array("".$prefix."_".$databasename."", "".$prefix."_".$databaseuser."", "all")); 
                if($usr) :
                   echo '<div class="alert alert-success"><ol>'                   
                        . '<li>Project Directory Generate Successfully.</li>'
                        . '<li>Assign all privileges to the newly created user.</li>'
                        . '</ol></div>';
                   
                    $nextstep = $step + 1;

                    ?>      
                  <div><a href="<?php echo "pos_generator.php?id=$id&step=$nextstep&subdomain=$subDomainName"; ?>" class="btn btn-primary" >Next</a></div>
                   <?php  
                    else :
                          echo '<div class="alert alert-danger">Database Creation Fail.</div>'; 
                    endif;	
            endif;
        endif;
    endif;
 
 
//Import Sql to database
if($_REQUEST['step']==3) :
    
    if( sqlImport() ) :
        
        
    echo '<div class="alert alert-success"><ol>'                   
            . '<li>Project Directory Generate Successfully.</li>'
            . '<li>Assign all privileges to the newly created user.</li>'
            . '<li>Sample Data imported to database.</li>'
            . '</ol></div>';
                   
    $nextstep = $step + 1;

    ?>      
  <div><a href="<?php echo "pos_generator.php?id=$id&step=$nextstep&subdomain=$subDomainName"; ?>" class="btn btn-primary" >Next</a></div>
   <?php  
    else :
          echo '<div class="alert alert-danger">Fail to imprt data.</div>'; 
    endif;
        
    
endif;


//Copy Project Zip to Subdomain, Extract Zip and Remove zip.
if($_REQUEST['step']==4) :
    
    
    $project = 0;
    
    copyProjectToSubdomain();
    
endif;

if($_REQUEST['step']==5){
    
     
    extractProject();
    
}

if($_REQUEST['step']==6) :
    
    $dbConf = getDbConfig();

    //Update Database configuration details.
    $fname = $projectPath."/app/config/database.php";
    if(checkPathWritable($fname)) :
        $fhandle = fopen($fname,"r");
        $content = fread($fhandle,filesize($fname));
        $org = array("[USERNAME]", "[PASSWORD]", "[DBNAME]");
        $chd   = array($prefix .'_'.$dbConf['dbuser'], $prefix .'_'.$dbConf['dbpassword'], $prefix .'_'.$dbConf['dbname']);
        $content = str_replace($org, $chd , $content);
        $fhandle = fopen($fname, "w");
        $fw1 = fwrite($fhandle, $content);
        if($fw1 ){
            $msg .= "<li>Database configurations Updated.</li>";
        }
        fclose($fhandle);
    else :
        $msg .= '<li class="alert alert-danger">Database file not readable.</li>';
    endif;
    
    
    
    //Set Project Baseurl.
    $fname1 = $projectPath."/app/config/config.php";
        if(checkPathWritable($fname1)) :
        $fhandle1 = fopen($fname1,"r");
        $content1 = fread($fhandle1,filesize($fname1));    
        $content1 = str_replace('[PROJECT_BASE_URL]', $ProjectBaseURL , $content1);
        $fhandle1 = fopen($fname1,"w");
        $fw2 = fwrite($fhandle1,$content1);

        if($fw2 ){
            $msg .= "<li>Project Base url set.</li>";
        }
        
        fclose($fhandle1);
    else :
        $msg .= '<li class="alert alert-danger">Project Base url could not set.</li>';
    endif;
    
        echo '<div class="alert alert-success"><ol>'                   
                . '<li>Project Directory Generate Successfully.</li>'
                . '<li>Assign all privileges to the newly created user.</li>'
                . '<li>Sample Data imported to database.</li>'
                . '<li>Project Zip Copy Successfully.</li>'
                . '<li>Project Zip Extracted Successfully.</li>'
                . '<li>Project Zip Remove Successfully.</li>'
                .$msg
                . '</ol></div>';
                   
            $nextstep = 'finish';

        ?>      
    <div><a href="<?php echo "pos_generator.php?id=$id&step=$nextstep&subdomain=$subDomainName"; ?>" class="btn btn-primary" >Finish</a></div>
        
<?php    
    
endif;

if($_REQUEST['step']=='finish'):
    
    
    echo '<div class="alert alert-success"><ol>'                   
        . '<li>Project Directory Generate Successfully.</li>'
        . '<li>Assign all privileges to the newly created user.</li>'
        . '<li>Sample Data imported to database.</li>'
        . '<li>Project Zip Copy Successfully.</li>'
        . '<li>Project Zip Extracted Successfully.</li>'
        . '<li>Project Zip Remove Successfully.</li>'
        . '<li>Database configurations Updated.</li>'
        . '<li>Project Base url Updated.</li>'
        . '</ol></div>';
    
    echo "<h3><a href='".$ProjectBaseURL."'>Check Project to Click Here : ".$ProjectBaseURL."</a></h3>";
    
    echo "<div class='alert alert-info'> Username: owner <br/> Password: 12345678</div>";
    
endif;

?>
 
	
	

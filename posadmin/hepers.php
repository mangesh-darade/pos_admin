<?php 
function prepareInput($data , $trim_only=0) {        
      
    $data = trim($data);

    if($trim_only==0) {
        $data = addslashes($data);
        $data = htmlspecialchars($data);
    }
    
    return $data;
}


function getDbConfig($subDomainName , $merchant_id)
{  
   $dbConf = isPosLogExists($merchant_id);
    
   if($dbConf === false)
   { 
        $user = $merchant_id . $subDomainName; 

        $dbConf['dbname']     = $subDomainName;
        $dbConf['dbuser']     = substr($user,0,7);	
        $dbConf['dbpassword'] = $user . "!D8&8*4P";   //!D8&8*4P  
   } 
   
   return $dbConf;
   
}
 

function checkPathWritable($filename)
{
    $pathfile = $filename;
    $path = str_replace('../', '', $pathfile);
    
	if (!is_writable($filename)) {
		if (!chmod($filename, 0777)) {
			 echo "<div class='alert alert-danger'>Cannot change the mode of file ($path)</div>";
			 return false;
		} else {
			echo "<div class='alert alert-info'>Directory Assign permission 0777.</div>";	
			return true;
		}
		echo "<div class='alert alert-danger'>$path is not writable.</div>";
		return false;
	} else {
		echo "<div class='alert alert-info'>$path is writable.</div>";
		return true;
	}
}

  
 
 

  
?>
<?php
 error_reporting(-1);
  ini_set('display_errors', 1);
  
 include_once('application_main.php');
 include_once('posadmin/xmlapi.php');
 
 
$cpanelusr  = 'sitadmin';

$cpanelpass = '3CfZyUTRm8L0';

$hostName   = 'simplypos.in';

$prefix     = 'sitadmin';

//$cpanelusr  = 'usimpos';
//
//$cpanelpass = '&rcLHjD09CV-';
//
//$hostName   = 'simplypos.us';
//
//$prefix     = 'usimpos';

$CP_xmlapi =  new xmlapi('127.0.0.1');
echo '<pre>';
print_r($CP_xmlapi);
echo '</pre>';
var_dump($CP_xmlapi);

$CP_xmlapi->set_port( 2083 );

$CP_xmlapi->password_auth($cpanelusr, $cpanelpass);

$CP_xmlapi->set_debug(1); //output actions in the error log 1 for true and 0 false 

$ProjectDirectory = 'posmerchants/testazarray';

$subDomainName = 'testax';

$resultSubdomain = $CP_xmlapi->api2_query( $cpanelusr, 'SubDomain', 'addsubdomain',  array(
                                                        'domain'                => $subDomainName,
                                                        'rootdomain'            => $hostName,
                                                        'dir'                   => $ProjectDirectory,
                                                        'disallowdot'           => '1',
                                                        'canoff'                => '0',
                                                    )
                                                ); 
        var_dump($resultSubdomain);

?>
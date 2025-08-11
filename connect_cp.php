<?php
error_reporting(-1);
  ini_set('display_errors', 1);
  
 include_once('application_main.php');
 include_once('posadmin/xmlapi.php');
 
 
$cpanelusr  = CP_USERNAME;

$cpanelpass = CP_PASSWORD;

$hostName   = CP_HOST;

$prefix     = CP_PREFIX;

$CP_xmlapi =  new xmlapi('127.0.0.1');

$CP_xmlapi->set_port( 2083 );

$CP_xmlapi->password_auth(CP_USERNAME, CP_PASSWORD);

$CP_xmlapi->set_debug(0); //output actions in the error log 1 for true and 0 false 


$cabundle= '';

$crt= '-----BEGIN CERTIFICATE REQUEST-----
MIICzzCCAbcCAQAwgYkxFzAVBgNVBAMMDiouc2ltcGx5cG9zLmluMQ8wDQYDVQQH
DAZCaG9wYWwxEzARBgNVBAoMClNpbXBseXNhZmUxIjAgBgkqhkiG9w0BCQEWE3N1
bmlsQHNpbXBseXNhZmUuaW4xFzAVBgNVBAgMDk1hZGh5YSBwcmFkZXNoMQswCQYD
VQQGEwJJTjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMQ79L9iOq5J
UfyxEg9kXE3daUwAahDpRo4sPeKnw1KTRAkwjEpGj3frowWaaIHkSFcok1Wi5MQF
+FNWdYvfxUuxT5MCbUl/wwzVMHEUo4HC9HjxPQJiJ8OzoFQ81fTU53dgom6Piu+F
9YKPj/BDxEH1pu4bql5XxwD2lvCBFOodP8uWdgglqHy0uJK6ZgAvDgU2E9khlYxY
JnFme5zNZmYncx8gb7HBVIMuR+NP/NvCSybbW5jaZZZ2HdrUpSaVz8taCxnOvkcz
DUkLJpcyXtmh/t7XrSzXyMo6GoH1jLID1JA0l101VkjMHTZz7w2u2WWS5j8CL0/Y
cum59FlUsW8CAwEAAaAAMA0GCSqGSIb3DQEBCwUAA4IBAQBuWVQojgg9C0homKfo
7p8lG06YOpT9rwx1/veDa8Y9ElsOqG6jVjHgvFX/YWMm98M9/YLMgmB0C5CgWiKa
Tjj6ZFm+UhKIdzbWMrWS+pc40h0wB94TUqOI92/HujkzK8IKKz7OSecUj9wuFlxy
DlyHj3yoS2Xc1tHGfM1uEBTjtZK9PtN+Uy0v0FUzrsj0yxJbDq1Pllatig8GnudF
8ByocIpVCn2GNSxnjruiH0nHwzrD2zLXGuqKL/wf3z1ls/5QHdXthNSFoxF99RS7
hDOZSK5XJla3WSrmrR4lD6wHm0hpLG9Her/hCKksU/MSjjhDrapDxX6XCnzx/A3r
BySk
-----END CERTIFICATE REQUEST-----';

$key = '-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAxDv0v2I6rklR/LESD2RcTd1pTABqEOlGjiw94qfDUpNECTCM
SkaPd+ujBZpogeRIVyiTVaLkxAX4U1Z1i9/FS7FPkwJtSX/DDNUwcRSjgcL0ePE9
AmInw7OgVDzV9NTnd2Cibo+K74X1go+P8EPEQfWm7huqXlfHAPaW8IEU6h0/y5Z2
CCWofLS4krpmAC8OBTYT2SGVjFgmcWZ7nM1mZidzHyBvscFUgy5H40/828JLJttb
mNpllnYd2tSlJpXPy1oLGc6+RzMNSQsmlzJe2aH+3tetLNfIyjoagfWMsgPUkDSX
XTVWSMwdNnPvDa7ZZZLmPwIvT9hy6bn0WVSxbwIDAQABAoIBADB3ypS2s1222Fw8
dAR/Olk1Fbvi4k+4/mdBQCvKWfD8VLKcXho+YVMyTTqmD6f9dWyppfJh4HUWMGaN
FU1uALIYYloiIFImD0wNIADeIyB6wZ1ZoEMFcWLh6/jCaeol5+HRaW07YQqWILSV
tuyWIFRWU1u+U48nyQxQ26kdiMfl8Bgi4+31A29g1yI+VSS47mnyulG7+d/CxHfW
zzZ2UU9PMJ8wr5DogRsulFhrSZB1+NQyb2Wdlxogj61/vzidN0PvJE5H57BSiB4E
BN5LKizIHZdd5GTWCs70vnlju99VDXA+FltEJCc0jHVSDMOnNO+pmdEMscwggbAe
9pqtlEECgYEA+13+/jgKCiRnf3r964y4jIdAsLNAupz8p+LviRXd/bVSy3f3Pptj
/cKyndHRyMXMcmMFzN3H63dB7E6k0hrV0/lu4cy18tiEe1AqLb3ixSS8UBYG9g5f
mRfryVakpgYUHNnKF7T0XiyB6XCilO16V+ahnTe+O3jvdCJRPM2N8A8CgYEAx9nU
tAoaXOlSg1Pn0lG2UV5PZyhfWd8i/72vL21OZf4EPmmyxYz6KWovSNpBpcDZuQl+
7bMySSmhozXQQf/VjrV174GBRSRpEkmpFUeS3uYX9AgJYoMgRoSPS3UzfxznwBsS
OYsE/dB1++JPBJoj9DCBs6TW8OaUAeqOTFMryKECgYAtzrBUVZQGyyGNSrWRQmCz
Q0aXrOLj3w3v7lwmiDSfMnb3G1KUNy8epGd2eTEYvGsIgWEiN1xiXaZG0QIaQ8ep
zG/XeD3EFo72BeLZ2RvFP2+NzKXSG0ZymLhgRYjVtI/fvhSlA1Xw/31hNCR8rVY5
RI85Hlptbhl8+XACe5cdIwKBgQCrTI1C3L4IEX3GT28PGTb6u6m3tCU2tUochwvX
zQs75OTiUlsHdXUfdoKdIWbPmmOEdR00xTo+984yRPgC+jSko+k4p3qUN0dQg47I
TJcZM4QoiZLxu484onropMbFF5OVWB7g78YRgFMA2dP9D9ntfn5N6ubJifonQlNC
HLAUwQKBgQDHvsnbf4+4kY9Az0mtVD/4aCw5AtHViidzok+TXKVGtXAjVc5/wWtp
etZIKGoUQ7WRvfLpe4qyNiJt0ZjPTVziU/n6PeMKJidrhx+ryOj62rKHjZG1/Oz/
8fnWXEt+BfnMNo6GwGGmKpzo0/FHaX7Ud2+K7ENCqKMT8Zt0V/rz/A==
-----END RSA PRIVATE KEY-----';

 echo '<pre>';

$subdomain= 'testssl101.simplypos.in';

$uploadkey_obj = $CP_xmlapi->api2_query( CP_USERNAME,  'SSL', 'uploadkey', array( 'host'=>$subdomain, 'key'=>$key ,  ) );

var_dump($uploadkey_obj);


$uploadcrt_obj = $CP_xmlapi->api2_query( CP_USERNAME,  'SSL', 'uploadcrt', array( 'host'=>$subdomain, 'crt'=>$crt,  ) );

var_dump($uploadcrt_obj);


$fetchcabundle_obj = $CP_xmlapi->api2_query( CP_USERNAME,  'SSL', 'fetchcabundle', array( 'host'=>$subdomain, 'crt'=>$crt,  ) );

var_dump($fetchcabundle_obj);

//RewriteMap lc int:tolower


// Install the SSL certificate.
// $result_obj = $CP_xmlapi->api2_query( CP_USERNAME,  'SSL', 'installssl', array( 'cabundle' => $cabundle, 'crt'=>$crt, 'domain'=>$subdomain, 'key'=>$key ,  ) );
//$result_obj = $CP_xmlapi->api2_query( CP_USERNAME,  'SSL', 'fetchinfo', array( 'domain'=>$subdomain ) );

//print_r($result_obj);
 
echo '</pre>';

?>
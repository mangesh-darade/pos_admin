<?php
    

//Do not change this key in any cost.
define('MASTER_ENCRYPTION_KEY', 'd0a3e4567b6d5fcd55f4b5c56211b87cd923e85677b63bf2941ef420dc8ca191');

define('CP_ACCESS_PATH'	, "VBCa9kML6jeWKpjy3FzCokVikxqBQp9QPApgV3yrCi8zJVMIxSUcs5QFJepc1ESW3k6gF3EC33uSyJ60SGZY06tA9WdzcIiVh1XhXS/k2FuFeCHJLtIMlxuk+sO2/qPn/m2xfCSPEw67Vp15Yw66+goOvQNWd1xCB7CZmKoJpRM=|RItSS6aSdEefEIl7+GgtKBrCAu4+41zXEGVYZ9qiy/4=");

//echo mc_decrypt(CP_ACCESS_PATH , MASTER_ENCRYPTION_KEY);
 
 echo mc_encrypt('U1h_oN(g;&6+KL09&*(#*Hppl56' , MASTER_ENCRYPTION_KEY);




 // Encrypt Function
     function mc_encrypt($encrypt, $key=MASTER_ENCRYPTION_KEY){
        $encrypt = serialize($encrypt);
        $iv  = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key = pack('H*', $key);
        $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
        return $encoded;
    }

    // Decrypt Function
     function mc_decrypt($decrypt, $key=MASTER_ENCRYPTION_KEY){
        $decrypt = explode('|', $decrypt.'|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
        $key = pack('H*', $key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if($calcmac!==$mac){ return false; }
        $decrypted = unserialize($decrypted);
        return stripcslashes($decrypted);
    }
    
?>
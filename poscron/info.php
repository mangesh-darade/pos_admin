<?php

 

$msg= date("d-m-Y H:i:s",1448950951);
$xmlResponse = ' msg';
$logfile = __dir__.'/cron_log.log';
file_put_contents($logfile,date("Y-m-d H:i:s")." | ".($_SERVER)."\n",FILE_APPEND | LOCK_EX);
?>
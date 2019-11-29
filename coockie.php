<?php
session_start();
$str='ПРОБА ПЕРА';
$ck='';
for($i=0; $i<100;$i++){
	$ck.=$str;
}

setcookie('test_cookie', $ck, time()+24*3600 );


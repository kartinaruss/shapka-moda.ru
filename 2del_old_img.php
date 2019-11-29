<?php

define('VIEW', true);
include './config/db.php';
mysql_connect($dblocation, $dbuser, $dbpasswd);
mysql_select_db($dbname);
mysql_set_charset('cp1251');

echo '/*'.$dbname.'*/<br>';

function myscandir($dir, $sort=0)
{
	$list = scandir($dir, $sort);

	if (!$list) return false;

	if ($sort == 0) unset($list[0],$list[1]);
	else unset($list[count($list)-1], $list[count($list)-1]);
	return $list;
}


$files = myscandir('images/product/l/');


$from = 10000;
$to = count($files);
$to = 15000;
for ($i = $from; $i < $to; $i++) {
//foreach ($files as $file) {
	$file = $files[$i];
	$sql = 'SELECT id FROM _products WHERE picture = "'.$file.'" OR album like "%'.$file.'%" /*OR album like "%|'.$file.'%"*/';
	$r = mysql_query($sql);
	if (mysql_num_rows($r) === 0) {
		$rr = 'del';
		unlink('images/product/l/'.$file);
		unlink('images/product/s/'.$file);
		unlink('images/product/x/'.$file);
	} else {
		$rr = 'ok';
	}

	echo $file.' - '.$rr.PHP_EOL;
//	$i++;

//	if ($i > 10000) break;
}






?>


<?php


header('Content-Type: text/html; charset=CP1251');

$site = 'shapka-moda.ru';
$path ='http://'.$site.'/images/product/s/';

if (isset($_GET['protect'])) {
    $protect = $_GET['protect'];

    if ($protect == '860') {

    } else {
        echo "Доступ запрещен! Неверный ключ!";
        die();
    }
} else {
    echo "Доступ запрещен! Укажите ключ!";
    die();
}


define('VIEW', true);

include './config/db.php';



$file = 'content.txt';

$content = '';

$content .= "code\t";
$content .= "name\t";
$content .= "price\t";
$content .= "type\t";
$content .= "ref\t";
$content .= "cs\r\n";


function crc32_file($file)
{
    return sprintf("%u", crc32(file_get_contents($file)));
}


$mysqli = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
$mysqli->set_charset("cp1251");


$fields = [
    'code',
    'name',
    'price',
	'99 as group_type',
    'CONCAT("'.$path.'",picture)',
    'md5_imagefile',
];





$limit = '';
if (isset($_GET['set_limit'])) {
    $limit = ' LIMIT ' . (int)$_GET['set_limit'];
}

$where = 'WHERE code <> ""';
if (isset($_GET['art'])) {
    $where = ' WHERE code = "'. $mysqli->real_escape_string($_GET['art']);
}

$sql = 'SELECT '.implode(',', $fields).' FROM _products '.$where.$limit;

$result=$mysqli->query($sql);
//$content='';
    while ($row = $result->fetch_assoc()) {
        foreach($row as &$field){
            $field=trim($field);
        }
		$content.=implode("\t",$row)."\r\n";
    }

$content .= "\r\n";
file_put_contents($file, $content);
//file_put_contents($file, iconv('utf8','windows-1251',$content));


header("Content-Type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Content-Length: " . filesize($file));
header("Content-Disposition: attachment; filename=" . $file);
readfile($file);
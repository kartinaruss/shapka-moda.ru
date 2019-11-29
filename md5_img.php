<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 01.11.2016
 * Time: 12:59
 */

//local
//$mysqli = new mysqli('localhost', 'root', '', 'el-postel');

//product
define('VIEW', true);
include './config/db.php';
$mysqli = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);

$sql = 'SELECT id, picture, code FROM _products';

$res = $mysqli->query($sql);

$path = $_SERVER['DOCUMENT_ROOT'] . '/images/product/s/';
while ($row = $res->fetch_assoc()) {
    $file = $path . $row['picture'];
    if (file_exists($path . $row['picture'])) {
        $md5 = strtoupper(md5_file($file));
//        echo $file . ' - ' . $md5 . '<br>';
        $sql = 'UPDATE _products SET md5_imagefile="' . $md5 . '" WHERE id=' . $row['id'].';<br>';
        echo $sql;
//		$mysqli->query($sql);
    } else {
        echo 'id = '. $row['id'].', code = '. $row['code'].' not found ' . $file . '<br>';
    }

}

//echo 'finished!';

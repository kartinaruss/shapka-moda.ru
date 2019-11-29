<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 28.08.2017
 * Time: 19:10
 */
die();
define('VIEW', 1);
include 'config/db.php';
$mysqli = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
$mysqli->set_charset('utf8');


$sql = 'SELECT * FROM _orders WHERE timestamp >= '.(time()-30*24*60*60);
$res = $mysqli->query($sql);
$i = 0;

$answer = [];
while ($row = $res->fetch_assoc()) {
    $items = (json_decode($row['cart'], true));
    if (is_array($items)) {
        foreach ($items as $key => $count) {
            $count = (int)$count;
            if ($count > 1)
                $count = 1;
            $id = explode(':', $key)[0];
            if (!isset($answer[$id]))
                $answer[$id] = $count;
            else
                $answer[$id] += $count;
        }
    }
}

foreach($answer as $id=>$order_count){
    $sql='UPDATE _products SET order_count='.$order_count.' WHERE id='.$id;
    $mysqli->query($sql);
}

echo 'done!';

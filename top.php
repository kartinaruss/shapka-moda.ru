<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 28.08.2017
 * Time: 19:10
 */

define('VIEW', 1);
include 'config/db.php';
$mysqli = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
$mysqli->set_charset('utf8');

$d = 30;   
if (isset($_REQUEST['d']) AND (int)$_REQUEST['d'] > 0)
    $d = (int)$_REQUEST['d'];

$sql = 'SELECT * FROM _orders WHERE timestamp >= ' . (time() - $d * 24 * 60 * 60);

$res = $mysqli->query($sql);
$i = 0;



$answer = [];
while ($row = $res->fetch_assoc()) {
    $items = (json_decode($row['cart'], true));
    if (is_array($items)) {
        foreach ($items as $key => $count) {
            $count = (int)$count;
            if ($count > 10)
                $count = 1;
            $id = explode(':', $key)[0];
			if($id<10000){
				$id+=10000;
			}
				if (!isset($answer[$id]))
					$answer[$id] = $count;
				else
					$answer[$id] += $count;
			
        }
    }
}

$size = 30;
if (isset($_REQUEST['size']) AND (int)$_REQUEST['size'] > 0)
    $size = $_REQUEST['size'];

$answer = array_slice($answer, 0, $size, true);



$sql = 'SELECT * FROM _products WHERE id IN (' . implode(',', array_keys($answer)) . ')';

$res = $mysqli->query($sql);


while ($row = $res->fetch_assoc()) {
    $result[] = [
        'id' => $row['id'],
        'code' => $row['code'],
        'key' => $row['key'],
        'name' => $row['name'],
        'picture' => $row['picture'],
        'q' => $answer[$row['id']],
    ];
}

usort($result, function ($a, $b) {

    if ($a['q'] == $b['q']) {
        return 0;
    }

    return ($a['q'] < $b['q']) ? 1 : -1;

}
);


echo '<table cellpadding="5" cellspacing="5">';
foreach ($result as $item) {

    echo '<tr>';
    echo '<td>' . $item['id'] . '</td>';
    echo '<td>' . $item['code'] . '</td>';
    echo '<td>' . $item['key'] . '</td>';
    echo '<td><a href="/item/' . $item['key'] . '" target=_blank>' . $item['name'] . '</a></td>';
    echo '<td><img width="50px" src="/images/product/s/' . $item['picture'] . '"></td>';
    echo '<td><b>' . $answer[$item['id']] . '</b></td>';
    echo '</tr>';


}

echo '</table>';


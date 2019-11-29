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

if (isset($_REQUEST['start_date'])) {

	$date1 = strtotime($_REQUEST['start_date']);

	if (isset($_REQUEST['end_date'])) {
		$date2 = strtotime($_REQUEST['end_date']);
	} else {
		$date2 = time();
	}

	echo "From ".date('d M Y', $date1)." to ".date('d M Y', $date2);
	$sql = 'SELECT * FROM _orders WHERE timestamp >= ' . $date1 . ' and timestamp < ' . $date2;
} else {
	echo "Last $d day.";
	$sql = 'SELECT * FROM _orders WHERE timestamp >= ' . (time() - $d * 24 * 60 * 60);
}
$res = $mysqli->query($sql);
$i = 0;

$answer = [];
while ($row = $res->fetch_assoc()) {
    $items = (json_decode($row['cart'], true));
    if (is_array($items)) {
        foreach ($items as $key => $count) {
            $count = (int)$count;
            if ($count >= 2)
                $count = 1;
            $id = explode(':', $key)[0];
            if (!isset($answer[$id]))
                $answer[$id] = $count;
            else
                $answer[$id] += $count;
        }
    }
}


arsort($answer);
$size = 9999;
if (isset($_REQUEST['size']) AND (int)$_REQUEST['size'] > 0)
    $size = $_REQUEST['size'];

if ($size > count($answer)) {
	$size = count($answer);
}

$answer = array_slice($answer, 0, $size, true);

$disabled = '';
if (isset($_REQUEST['disabled']) AND (int)$_REQUEST['disabled'] > 0)
    $disabled = ' AND disabled = '.$_REQUEST['disabled'];

$sql = 'SELECT * FROM _products WHERE id IN ("' . implode('","', array_keys($answer)) . '")'.$disabled;

$res = $mysqli->query($sql);


while ($row = $res->fetch_assoc()) {
    $result[] = [
        'id' => $row['id'],
        'code' => $row['code'],
        'key' => $row['key'],
        'name' => $row['name'],
        'price' => $row['price'],
        'picture' => $row['picture'],
        'price5' => $row['price5'],
        'disabled' => $row['disabled'],
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


echo '<table cellpadding="5" border="1">
<tr>
	<td><b>ID</b></td>
	<td><b>Code</b></td>
	<td><b>Key</b></td>
	<td><b>Price</b></td>
	<td><b>Url</b></td>
	<td><b>Img</b></td>
	<td><b>Count</b></td>
	<td><b>Active</b></td>
	<td><b>Price_opt</b></td>
</td>';
foreach ($result as $item) {

	if ( $item['disabled'] == 0 ) {
		$disbl = 'yes';
	} else {
		$disbl = 'no';
	}

    echo '<tr>';
    echo '<td>' . $item['id'] . '</td>';
    echo '<td>' . $item['code'] . '</td>';
    echo '<td>' . $item['key'] . '</td>';
    echo '<td>' . $item['price'] . '</td>';
    echo '<td><a href="/item/' . $item['key'] . '" target=_blank>' . $item['name'] . '</a></td>';
    echo '<td><img width="100px" src="/images/product/s/' . $item['picture'] . '"></td>';
    echo '<td><b>' . $answer[$item['id']] . '</b></td>';
    echo '<td><b>' . $disbl . '</b></td>';
    echo '<td>' .  $item['price5'] . '</td>';
    echo '</tr>';


}

echo '</table>';


<?php

define('VIEW', true);
include './config/db.php';
mysql_connect($dblocation, $dbuser, $dbpasswd);
mysql_select_db($dbname);

if (isset($_REQUEST['date'])) {
    $start_date = $_REQUEST['date'];
} else {
	die('Enter "date" parametr');
}

$end_date = date('Y-m-d', strtotime($start_date . ' +1 day'));



$sql = 'SELECT ip, count(*) ct FROM ip
WHERE time >= UNIX_TIMESTAMP("'.$start_date.'") AND time < UNIX_TIMESTAMP("'.$end_date.'")
GROUP BY ip
HAVING ct > 100
ORDER by CT DESC';

$r = mysql_query($sql);

echo '<table border="1">
<tr style="font-weight: bold">
<td>&nbsp;</td>
<td>ip</td>
<td>count</td>
<td>text</td>
</tr>';
$i=0;
while ($row=mysql_fetch_array($r)) {
	$i++;
	echo '<tr>
	<td style="padding: 3px 5px">'.$i.'</td>
	<td style="padding: 3px 5px">'.$row['ip'].'</td>
	<td style="padding: 3px 5px">'.$row['ct'].'</td>
	<td style="padding: 3px 5px">(ip.src eq '.$row['ip'].') or </td>
	</tr>';
}





?>


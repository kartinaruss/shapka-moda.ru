<?php

define('VIEW', true);
include './config/db.php';
mysql_connect($dblocation, $dbuser, $dbpasswd);
mysql_select_db($dbname);

$sql = 'SELECT id FROM _products';
$r = mysql_query($sql);
$also = '';
$str = '';
while ($row=mysql_fetch_array($r)) {
	$sql2 = '
	SELECT ps2.product_id
 	FROM _product_structure ps
 	LEFT OUTER JOIN _product_categories pc ON pc.id = ps.category_id
	LEFT OUTER JOIN _product_categories pc2 ON pc2.parent_id = pc.id
	LEFT OUTER JOIN _product_structure ps2 ON ps2.category_id = pc.id
 	LEFT OUTER JOIN _products p ON p.id = ps2.product_id
 	WHERE ps.product_id =  '.$row['id'].'
    AND pc2.id is null
    AND p.disabled = 0
    AND ps2.product_id <> '.$row['id'].'
    ORDER BY RAND() LIMIT 9
	';
	$r2 = mysql_query($sql2);
	$also = '';
	$str = '';
	while ($row2=mysql_fetch_array($r2)) {
		if ($also === "") {        	$also = $row2['product_id'];
		} else {            $also .= '|'.$row2['product_id'];
		}	}
	$str = 'UPDATE _products SET also = "'.$also.'" WHERE id = '.$row['id'].';';
	echo $str.'<br>';
}





?>


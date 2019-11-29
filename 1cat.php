<?php

define('VIEW', true);
include './config/db.php';
mysql_connect($dblocation, $dbuser, $dbpasswd);
mysql_select_db($dbname);
mysql_set_charset('utf8');

if (isset($_REQUEST['opt'])) {	$opt = ' and p.opt = "'.$_REQUEST['opt'].'"';
}

if (isset($_REQUEST['disabled'])) {
	$disabled = ' and p.disabled = '.$_REQUEST['disabled'];
}

echo '<table border="1">
<tr>
	<td>ID
	</td>
	<td>code
	</td>
	<td>name
	</td>
	<td>price
	</td>
	<td>price_opt
	</td>
	<td>category
	</td>
	<td>img
	</td>
	<td>disabled
	</td>
</tr>';

	$sql = 'SELECT DISTINCT p.id, p.code, p.name, p.price, p.price5, p.key, p.picture, pc.name pcname, p.params, p.disabled
			FROM _products p
			LEFT OUTER JOIN _product_structure ps ON ps.product_id = p.id
			LEFT OUTER JOIN _product_categories pc ON pc.id = ps.category_id
			LEFT OUTER JOIN _product_categories pc2 ON pc2.parent_id = pc.id
			WHERE
			    pc2.id is null '.@$opt.' '.@$disabled.'
			ORDER BY p.price, pc.name, p.brief, p.main DESC, p.position_main ASC';
	$r = mysql_query($sql);
	while ($row=mysql_fetch_array($r)) {
		$also .= $row['product_id'];
echo '<tr>
	<td>'.$row['id'].'
	</td>
	<td>'.$row['code'].'
	</td>
	<td>'.$row['name'].'
	</td>
	<td>'.$row['price'].'
	</td>
	<td>'.$row['price5'].'
	</td>
	<td>'.$row['pcname'].'
	</td>
	<td><a target="_blanc" href="./item/'.$row['key'].'"><img src="./images/product/s/'.$row['picture'].'" width="150px"></a>
	</td>
	<td>'.( ($row['disabled'] == '1') ? 'no' : 'yes' ).'
	</td>
</tr>';
	}
echo '</table>';





?>


<?php

mysql_connect('localhost', 'postel', 'F5u9B1i0');
mysql_select_db('el-postel');
mysql_set_charset('cp1251');

echo '<table border="1">
<tr>
	<td>ID
	</td>
	<td>Артикул
	</td>
	<td>Наименование
	</td>
	<td>Цена
	</td>
	<td>Категория
	</td>
	<td>Ссылка
	</td>
	<td>Картинка
	</td>
</tr>';

	$sql = 'SELECT DISTINCT p.id, p.code, p.name, p.price, p.key, p.picture, pc.name pcname
			FROM _products p
			LEFT OUTER JOIN _product_structure ps ON ps.product_id = p.id
			LEFT OUTER JOIN _product_categories pc ON pc.id = ps.category_id
			LEFT OUTER JOIN _product_categories pc2 ON pc2.parent_id = pc.id
			WHERE
			    pc2.id is null
				and p.disabled = 0
			ORDER BY p.main DESC, p.position_main ASC';
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
	<td>'.$row['pcname'].'
	</td>
	<td><a target="_blanc" href="http://el-postel.ru/item/'.$row['key'].'">http://el-postel.ru/item/'.$row['key'].'</a>
	</td>
	<td><a target="_blanc" href="http://el-postel.ru/images/product/l/'.$row['picture'].'"><img src="http://el-postel.ru/images/product/s/'.$row['picture'].'"></a>
	</td>
</tr>';
	}
echo '</table>';





?>


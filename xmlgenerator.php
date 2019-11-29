<?php

define ( 'VIEW', 1 );
include("./config/db.php");

$dbcnx=@mysql_connect($dblocation, $dbuser, $dbpasswd);

@mysql_select_db($dbname, $dbcnx);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");



$cresults = array();
$categories = mysql_query("SELECT id, parent_id, name FROM _product_categories where `disabled`=0");
while($result = mysql_fetch_assoc($categories))
{
    $cresults[] = $result;
}

$cats = array();

foreach($cresults as $cat) {
	
	$trigger = 0;
	foreach($cresults as $cat2) {
		
		if ($cat2['parent_id'] == $cat['id'])
			$trigger = 1;
	}
	
	if ($trigger == 0)
		$cats[] = $cat['id'];
	
}

$oresults = array();
$offers = mysql_query("SELECT _products.id, _products.key, _products.price, _products.price_old, _products.name, _products.picture, _product_structure.category_id FROM _products,_product_structure, _product_categories WHERE _products.id=_product_structure.product_id and _products.disabled=0 and _product_categories.id=_product_structure.category_id and _product_categories.disabled=0 ".(count($cats)>0?"and _product_structure.category_id IN(".implode(",",$cats).")":"")." group by _products.id;");
while($result = mysql_fetch_assoc($offers))
{




    $result['url'] = "http://shapka-rus.ru/item/".$result['key'];;
    $result['img'] = "http://shapka-rus.ru/images/product/l/".$result['picture'];

    $oresults[] = $result;
}

header("Content-Type: application/xml\r\n");
echo '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?php echo date("Y-m-d H:i", time())?>">
<shop>
<name>SHAPKA-RUS</name>
<company>Магазин головныз уборов премиум класса </company>
<url><?php echo "http://shapka-rus.ru"; ?></url>
<phone>+7 (800) 555-31-68</phone>
<currencies>
  <currency id="RUR" rate="1"/>
</currencies>
<categories>
<?php
foreach($cresults as $cat)
{
echo '<category id="'.$cat['id'].'" '.($cat['parent_id']>0?' parentId="'.$cat['parent_id'].'"':'').' >'.$cat['name'].'</category>';
}
?>
</categories>
<offers>
<?php
foreach($oresults as $offer)
{

echo '<offer id="'.$offer['id'].'" available="true" >'."\r\n".'
<url>'.$offer['url'].'</url>'."\r\n".'
<price>'.$offer['price'].'</price>'."\r\n".'
<oldprice>'.$offer['price_old'].'</oldprice>'."\r\n".'
<currencyId>RUB</currencyId>'."\r\n".'
<categoryId>'.$offer['category_id'].'</categoryId>'."\r\n".'
<picture>'.$offer['img'].'</picture>'."\r\n".'
<name>'.$offer['name'].'</name>'."\r\n".'
<currencyId>RUB</currencyId>'."\r\n".'
</offer>'."\r\n";
}
?>
</offers>
</shop></yml_catalog>
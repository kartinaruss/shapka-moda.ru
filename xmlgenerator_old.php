<?php

define ( 'VIEW', 1 );
include("./config/db.php");

$dbcnx=@mysql_connect($dblocation, $dbuser, $dbpasswd);

@mysql_select_db($dbname, $dbcnx);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");



$cresults = array();
$categories = mysql_query("SELECT id, parent_id, name FROM _product_categories");
while($result = mysql_fetch_assoc($categories))
{
    $cresults[] = $result;
}

$oresults = array();
$offers = mysql_query("SELECT _products.id, _products.key, _products.price, _products.price_old, _products.name, _products.picture, _product_structure.category_id FROM _products,_product_structure WHERE _products.id=_product_structure.product_id and _products.disabled=0 group by _products.id;");
while($result = mysql_fetch_assoc($offers))
{




    $result['url'] = "http://".$_SERVER['HTTP_HOST']."/item/".$result['key'];;
    $result['img'] = "http://".$_SERVER['HTTP_HOST']."/images/product/l/".$result['picture'];

    $oresults[] = $result;
}

header("Content-Type: application/xml\r\n");
echo '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?php echo date("Y-m-d H:i", time())?>">
<shop>
<name>El-Postel</name>
<company>ИМагазин постельного белья</company>
<url><?php echo "http://".$_SERVER['HTTP_HOST']; ?></url>
<phone>+7 (800) 555-31-68</phone>
<categories>
<?php
foreach($cresults as $cat)
{
echo '<category id="'.$cat['id'].'" >'.$cat['name'].'</category>';
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
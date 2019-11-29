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
$offers = mysql_query("SELECT _products.id, _products.key, _products.price, _products.price_old, _products.name, _products.picture, _product_structure.category_id FROM _products,_product_structure WHERE _products.id=_product_structure.product_id and _products.disabled=0 and _products.disabled = 0 group by _products.id;");
while($result = mysql_fetch_assoc($offers))
{




    //$result['url'] = "http://".$_SERVER['HTTP_HOST']."/item/".$result['key'];;
    //$result['img'] = "http://".$_SERVER['HTTP_HOST']."/images/product/l/".$result['picture'];

    $result['url'] = "https://el-postel.ru/item/".$result['key'];;
    $result['img'] = "https://el-postel.ru/images/product/x/".$result['picture'];

    $oresults[] = $result;
}

header("Content-Type: application/xml\r\n");
echo '<!--?xml version="1.0" encoding="UTF-8"?-->'."\r\n";
?>
<rss version="2.0"
xmlns:g="http://base.google.com/ns/1.0">
<channel>
<title>El-Postel</title>
<link>https://el-postel.ru</link>
<description>Магазин постельного белья El-Postel.ru</description>
<?php
foreach($oresults as $offer)
{
    $olprise = $offer['price']*1.886;
    $olprise2 =  round($olprise, -2);
echo '<item>
<title>'.htmlspecialchars($offer['name']).'</title>'."\r\n".'
<link> '.$offer['url'].'</link>
<description>'.htmlspecialchars($offer['name']).'</description>'."\r\n".'
<g:image_link>'.$offer['img'].'</g:image_link>'."\r\n".'
<g:price>'.$offer['price_old'].' RUB</g:price>'."\r\n".'
<g:sale_price>'.$offer['price'].' RUB</g:sale_price>'."\r\n".'
<g:google_product_category>4171</g:google_product_category>'."\r\n".'
<g:product_type>'.htmlspecialchars('Дом и сад > Постельное бельё').'</g:product_type>'."\r\n".'
<g:condition>new</g:condition>'."\r\n".'
<g:id>'.$offer['id'].'</g:id>'."\r\n".'
<g:availability>in stock</g:availability>'."\r\n".'
</item>'."\r\n";
flush();
}
?>

</channel>
</rss>
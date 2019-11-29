<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/23/2016
 * Time: 5:48 PM
 */

DIE('die');

mysql_connect('localhost', 'postel', 'F5u9B1i0');
mysql_select_db('el-postel');
mysql_set_charset('cp1251');

$q = 'SELECT p.* FROM `_products` p
/*LEFT OUTER JOIN _product_structure ps ON p.id = ps.product_id
WHERE ps.category_id = 422*/
';
$r = mysql_query($q);

function jsondecode ($sText){
    if (!$sText) return false;
    $sText = iconv('cp1251', 'utf8', $sText);
    $aJson = json_decode($sText, true);
    $aJson = iconvarray($aJson);
    return $aJson;
}

function iconvarray($aJson){
    foreach ($aJson as $key => $value) {
        if (is_array($value)) {
            $aJson[$key] = iconvarray($value);
        } else {
            $aJson[$key] = iconv('utf8', 'cp1251', $value);
        }
    }
    return $aJson;
}

function iconvarray2($aJson){
    foreach ($aJson as $key => $value) {
        if (is_array($value)) {
            $aJson[$key] = iconvarray2($value);
        } else {
            $aJson[$key] = iconv('cp1251', 'utf8', $value);
        }
    }
    return $aJson;
}

while ($row = mysql_fetch_array($r)) {


    $old_params = jsondecode($row['params'], true);
    $new_params = $old_params;
    $price_min = 999999;


    $i = 0;
    while (1) {

        if (array_key_exists($i, $old_params[0]['values'])) {
         	$price = $old_params[0]['values'][$i]['price'];
         	$price_old = $old_params[0]['values'][$i]['price_old'];
//         	if ($price < $price_min) {
//            	$price_min = $price;
//         	}
//		    $price = $price + 300;
//		    $price = round($price, -2) - 10;

            $new_params[0]['values'][$i]['price'] = $price;
            $new_params[0]['values'][$i]['price_old'] = round($price/0.28, -2) - 10;

            $i++;

        } else {
            break;
        }
    }


    $price = $row['price'];
//    if ($price_min < 999999) {
//	    $price = $price_min;
//	}
//    $price = $price + 300;
//    $price = round($price, -2) - 10;
    $old_price = round($price/0.28, -2) - 10;
//    echo $old_price;

    $q = str_replace('\\', '\\\\', "UPDATE `_products` SET `price`='".$price."', `price_old`='".$old_price."', `params`='".json_encode(iconvarray2($new_params))."' WHERE (`id`='".$row['id']."'); /*".$row['code']."*/");
    mysql_query($q);

//	echo $q.'<br>';

    $a = 0;


}

echo 'ok';
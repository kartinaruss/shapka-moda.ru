<?php

		function getip22()
		{
		  if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
		    $ip = getenv("HTTP_CLIENT_IP");

		  elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		    $ip = getenv("HTTP_X_FORWARDED_FOR");

		  elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		    $ip = getenv("REMOTE_ADDR");

		  elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		    $ip = $_SERVER['REMOTE_ADDR'];

		  else
		    $ip = "unknown";

		  return($ip);
		}
if (getip22() != '127.0.0.1') {
	$mysqli=new mysqli('localhost', 'shapka', 'Y3g7F7h6', 'shapka-moda.ru');
	$sql='INSERT INTO ip SET ip="'.getip22().'", time='.time();
	$mysqli->query($sql);
}
$_COOKIE_SEO_LIFETIME = 1209600;
if(!empty($_SERVER['QUERY_STRING'])){
    $query_string=strtolower($_SERVER['QUERY_STRING']);
    if(false !== strpos($query_string, 'utm')){
        setcookie('full_query_string', $query_string, time() + (3600 * 24 * 365), '/');
    }

    setcookie('utm_source', (isset($_GET['utm_source']) ? $_GET['utm_source'] : '-'), time() + $_COOKIE_SEO_LIFETIME, '/');
}

//if(isset($_GET['utm_campaign']) && isset($_GET['utm_content']))
//{
//
//    $ucampaign = $_GET['utm_campaign'];
//    $ucontent = $_GET['utm_content'];
//    $utmterm = $_GET['utm_term'] ? $_GET['utm_term'] : '';
//    setcookie('utm_campaign', $ucampaign, time() + 7862400);
//    setcookie('utm_content', $ucontent, time() + 7862400);
//    setcookie('utm_term', $utmterm, time() + 7862400);
//
//}
//else
//{
//    /*echo "Кука компании: " . $_COOKIE['utm_campaign'];*/
//}
/**
 * Index.
 * Единственный доступный исполняемый файл.
 *
 * @author dandelion <web.dandelion@gmail.com>
 * @version 0.4
 */


//include("SxGeo.php");
//$SxGeo = new SxGeo();
//echo $SxGeo->getCountry(getip());




define("VIEW", true);
/**
 * SEO things
 */
if(in_array($_SERVER['REQUEST_URI'],array("/index.php","/index")))
{
    header("Location: /",true,301);
    exit();
}
/**
 * Начальная загрузка
 */

@include_once 'clickfrogru_udp_tcp.php';

@session_set_cookie_params(3110400, '/');

define('INDEX_PHP', 'index.php');
define('DIR_ROOT',    dirname(__FILE__));
define('DIR_HOME',    dirname(__FILE__));
define('DIR_PRIVATE', DIR_HOME);
define('DIR_PUBLIC',  DIR_ROOT);


define('ROISTAT_AB_AUTO_SUBMIT', false);
require_once DIR_ROOT . '/ABTest.php'; // Путь до ABTest.php
ABTest::instance()->activateTest('abtest'); // Название кампании из tests.php
ABTest::instance()->submit();

$ArrABtestVal = array('v0','v1','v2','v3','v4');

$ABtestValueReal = @ABTest::instance()->getTestValue('abtest');

@define('ABTEST_VARIANT',(in_array($ABtestValueReal,$ArrABtestVal)?$ABtestValueReal:'v0'));

$_COOKIE_SEO_LIFETIME = 1209600;
//if(!isset($_GET['utm_source']) && !isset($_GET['utm_medium']) && !isset($_GET['utm_campaign']) && !isset($_GET['utm_content']) && !isset($_GET['utm_term']))
//{
//    $result_engine = '';
//
//    if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
//    {
//        $tmp= @explode("?",$_SERVER['HTTP_REFERER']);
//        $chk_site=$tmp[0];  // Имя сайта
//
//        if (strpos($chk_site,'google.') !== false) {
//            $result_engine='google';
//        }
//
//        if (strpos($chk_site,'yandex.') !== false) {
//            $result_engine='yandex';
//        }
//    }
//
//    if($result_engine == 'google')
//    {
//        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//        $utm_allget = '';
//
//        if(!isset($_COOKIE['utm_allget']) or empty($_COOKIE['utm_allget'])){
//
//            $utm_allget = http_build_query(array('utm_source' => 'google_seo', 'utm_campaign'=>'seo'));
//
//        }else{
//
//            parse_str($_COOKIE['utm_allget'],$tmp);
//
//            if(isset($tmp['utm_source'])){
//
//                if(substr($tmp['utm_source'], -10) != 'google_seo'){
//                    $tmp['utm_source'] .= '_google_seo';
//                }
//
//            }else{
//                $tmp['utm_source'] = 'google_seo';
//            }
//
//            if(isset($tmp['utm_campaign'])){
//
//                if(substr($tmp['utm_campaign'], -3) != 'seo'){
//                    $tmp['utm_campaign'] .= '_seo';
//                }
//
//            }else{
//                $tmp['utm_campaign'] = 'seo';
//            }
//
//            $utm_allget = http_build_query($tmp);
//        }
//
//        setcookie('utm_allget', $utm_allget, time()+$_COOKIE_SEO_LIFETIME, '/');
//        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//        setcookie('utm_campaign', 'google', time()+$_COOKIE_SEO_LIFETIME, '/');
//        setcookie('utm_source', 'seo', time()+$_COOKIE_SEO_LIFETIME, '/');
//
//        setcookie('utm_medium', '-', time()+$_COOKIE_SEO_LIFETIME, '/');
//        setcookie('utm_content', '-', time()+$_COOKIE_SEO_LIFETIME, '/');
//        setcookie('utm_term', '-', time()+$_COOKIE_SEO_LIFETIME, '/');
//
//
//    }
//    if($result_engine == 'yandex')
//    {
//
//        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//        $utm_allget = '';
//
//        if(!isset($_COOKIE['utm_allget']) or empty($_COOKIE['utm_allget'])){
//
//            $utm_allget = http_build_query(array('utm_source' => 'yandex_seo', 'utm_campaign'=>'seo'));
//
//        }else{
//
//            parse_str($_COOKIE['utm_allget'],$tmp);
//
//            if(isset($tmp['utm_source'])){
//
//                if(substr($tmp['utm_source'], -10) != 'yandex_seo'){
//                    $tmp['utm_source'] .= '_yandex_seo';
//                }
//
//            }else{
//                $tmp['utm_source'] = 'yandex_seo';
//            }
//
//            if(isset($tmp['utm_campaign'])){
//
//                if(substr($tmp['utm_campaign'], -3) != 'seo'){
//                    $tmp['utm_campaign'] .= '_seo';
//                }
//
//            }else{
//                $tmp['utm_campaign'] = 'seo';
//            }
//
//            $utm_allget = http_build_query($tmp);
//        }
//
//        setcookie('utm_allget', $utm_allget, time()+$_COOKIE_SEO_LIFETIME, '/');
//        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//        setcookie('utm_campaign', 'yandex', time()+$_COOKIE_SEO_LIFETIME, '/');
//        setcookie('utm_source', 'seo', time()+$_COOKIE_SEO_LIFETIME, '/');
//
//        setcookie('utm_medium', '-', time()+$_COOKIE_SEO_LIFETIME, '/');
//        setcookie('utm_content', '-', time()+$_COOKIE_SEO_LIFETIME, '/');
//        setcookie('utm_term', '-', time()+$_COOKIE_SEO_LIFETIME, '/');
//    }
//}
//else
//{
//    setcookie('utm_source', (isset($_GET['utm_source']) ? $_GET['utm_source'] : '-'), time()+$_COOKIE_SEO_LIFETIME, '/');
//    setcookie('utm_medium', (isset($_GET['utm_medium']) ? $_GET['utm_medium'] : '-'), time()+$_COOKIE_SEO_LIFETIME, '/');
//    setcookie('utm_campaign', (isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : '-'), time()+$_COOKIE_SEO_LIFETIME, '/');
//    setcookie('utm_content', (isset($_GET['utm_content']) ? $_GET['utm_content'] : '-'), time()+$_COOKIE_SEO_LIFETIME, '/');
//    setcookie('utm_term', (isset($_GET['utm_term']) ? $_GET['utm_term'] : '-'), time()+$_COOKIE_SEO_LIFETIME, '/');
//    setcookie('utm_allget', (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '-'), time()+$_COOKIE_SEO_LIFETIME, '/');
//
//}

require 'engine/include/bootstrap.php';
ini_set('display_errors','Off');
if (isset($_GET['ref']))
{
    setcookie('ref',$_GET['ref'],time()+COOKIE_LIVE_TIME,COOKIE_PATH);
    header('Location: '.array_shift(explode('?',URL_THIS)));
}

try
{

    $page = Page::getInstance();
    $content = $page->build()->getContent();

    if (strpos( $content, "[abtest_" ) !== false) {

		if( ABTEST_VARIANT == 'new') {
			$content = str_replace( "[abtest_new]", "", $content );
			$content = str_replace( "[/abtest_new]", "", $content );
			$content = preg_replace( "'\\[abtest_old\\](.*?)\\[/abtest_old\\]'is", "", $content );
		}
		else {
			$content = str_replace( "[abtest_old]", "", $content );
			$content = str_replace( "[/abtest_old]", "", $content );
			$content = preg_replace( "'\\[abtest_new\\](.*?)\\[/abtest_new\\]'is", "", $content );
		}

	}

	if (strpos( $content, "[abtest_" ) !== false){//
		for($i=0;$i<5;$i++) {

			if (ABTEST_VARIANT == "v".$i) {
				$content = str_replace( "[abtest_v".$i."]", "", $content );
				$content = str_replace( "[/abtest_v".$i."]", "", $content );
			}
			else {
				$content = preg_replace( "'\\[abtest_v".$i."\\](.*?)\\[/abtest_v".$i."\\]'is", "", $content );
			}

		}


	}

    //$prot223 = $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http' ? 'http:' : 'https:';
    $prot223 = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 443 == $_SERVER['SERVER_PORT']) ? 'https:' : 'http:';
    $content = str_replace('http:',$prot223, $content);



    /*
        echo '<pre>';
        print_r($_GET);
        echo '</pre>';
        */

    die($content);
}
catch (Exception $error)
{
    if (!PRODUCTION)
        die($error->getFile().' <b>[line '.$error->getLine().']</b> '.$error->getMessage());
}

<?php

/**
 * Константы
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
 //$prot22 = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http' ? 'http:' : 'https:');

 $prot22 = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 443 == $_SERVER['SERVER_PORT']) ? 'https' : 'http';
// $prot22 = 'https';

define('URL_HOME', $prot22.'://'.$_SERVER['SERVER_NAME'].str_replace('index.php', '', $_SERVER['PHP_SELF']));
define('URL_THIS', $prot22.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
define('URL_APP', substr($_SERVER['REQUEST_URI'], strlen(str_replace('index.php', '', $_SERVER['PHP_SELF']))));
define('URL_REFERER', @$_SERVER['HTTP_REFERER']);
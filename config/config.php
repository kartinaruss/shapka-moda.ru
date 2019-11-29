<?php

/**
 * Всякие константы конфигурации
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
define('PRODUCTION', true);
//define('PHP_DEBUG', isset($_COOKIE['debug'])&&$_COOKIE['debug']&&!PRODUCTION);
define('DEBUG_HACKER_CONSOLE', false);
define('STATS', isset($_GET['debug'])&&$_GET['debug']);

define('CACHE_USE', false);
define('CACHE_TYPE', 'file'); // file|memory
define('CACHE_PREFIX', 'bm');  // [-a-z0-9_]

define('MINIFY', false);
define('MINIFY_HTML', false);
define('MINIFY_JS', false);
define('MINIFY_CSS', false);

define('PAGE_403', 'access/forbidden');
define('PAGE_404', 'page/not/found');

define('COOKIE_PATH', '/');
define('COOKIE_LIVE_TIME', 60*60*24*30);

define('PREFIX_TABLE_NAME', '_');

define('PAGINATOR_COUNT_OF_FIRST_PAGES', 5);
define('PAGINATOR_COUNT_OF_LAST_PAGES', 5);
define('PAGINATOR_COUNT_OF_MIDDLE_PAGES', 4);
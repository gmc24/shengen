<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', __DIR__);
define('FILES_DIR', __DIR__.DS."assets".DS."FILES");

define("APP_DIR", ROOT_DIR.DS.'backend');
define("CACHE_DIR", ROOT_DIR.DS.'assets'.DS.'cache');
define("VIEWS_DIR", APP_DIR.DS.'views');
define("FUNC_DIR", APP_DIR.DS.'functions');

define("TWIG_CACHE", false);

define("HOST", 'http://shengen.loc');
define("ADMIN_EMAIL", 'admin@adm.in');
define("ADMIN_NAME", 'SiteName');

//DB
define("DB_HOST", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASS", null);
define("DB_NAME", "shengen");



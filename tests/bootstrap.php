<?php

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT_PATH', __DIR__);

set_include_path(ROOT_PATH . PATH_SEPARATOR . get_include_path());

require __DIR__ . '/../vendor/autoload.php';

$loader = new Loader();
$loader->registerDirs([ROOT_PATH])->register();
$loader->registerNamespaces(['Test' => ROOT_PATH])->register();

$di = new FactoryDefault();
Di::reset();
Di::setDefault($di);

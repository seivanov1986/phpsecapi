<?php

define ('DEBUG', true);

if (defined('DEBUG') && DEBUG === true) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

require_once('vendor/phpseclib/Crypt/AES.php');
require_once('vendor/phpseclib/Crypt/RSA.php');
require_once('vendor/phpseclib/Math/BigInteger.php');

require_once('secapi/loader.php');

$config = require_once('config/database.php');

(new \secapi\core\Router())
    ->setConfig($config)
    ->start();
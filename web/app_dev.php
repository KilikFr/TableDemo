<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

if (!(in_array(@$ip, ['127.0.0.1', 'fe80::1', '::1'])
    || php_sapi_name() === 'cli-server'
    || (ip2long(@$ip) & ip2long('192.168.0.0')) == ip2long('192.168.0.0')
    || (ip2long(@$ip) & ip2long('172.16.0.0')) == ip2long('172.16.0.0')
)
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information. (ip: '.$ip.')');
}

/**
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require __DIR__.'/../app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read https://symfony.com/doc/current/setup.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
/*
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1','34.232.24.15'), true) || PHP_SAPI === 'cli-server')
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

*/

require __DIR__.'/../app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

function pr($array){
    echo "<pre>";
    print_r($array);
}


function prx($array){
    echo "<pre>";
    print_r($array);
    exit;
}

        function parse_csv_assoc($str,&$f){ 
        if (empty($f)) { $f = str_getcsv($str); }
            return array_combine($f, str_getcsv($str));         
        }
		
function assoc_getcsv($csv_path) {
        $f = array();

        return array_values(array_slice(array_map('parse_csv_assoc', file($csv_path), $f),1));
    }
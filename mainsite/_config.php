<?php

global $project;
$project = 'mainsite';

global $database;
$database = SS_DATABASE_NAME;

// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");

//GD::set_default_quality(90);
//Image::set_backend("OptimisedGDBackend");
ImagickBackend::set_default_quality(90);
Image::set_backend("ImagickBackend");


Requirements::set_write_js_to_body(false);

if (Director::isLive()) {
	SS_Log::add_writer(new SS_LogEmailWriter('leo@leochen.co.nz'), SS_Log::ERR);
}

/*
|--------------------------------------------------------------------------
| Check if Memcache is available, if so load it.
|--------------------------------------------------------------------------
*/
$host = Director::isLive() ? '127.0.0.1' : 'localhost';
$port = 11211;
$isMemcacheAvailable = false;

if (class_exists('Memcached')) {
    $memcache = new Memcached();
    $isMemcacheAvailable = @$memcache->addServer($host, $port);
} elseif (class_exists('Memcache')) {
    $memcache = new Memcache();
    $isMemcacheAvailable = @$memcache->connect($host, $port);
}

if ($isMemcacheAvailable === false) {
} else {
    if (Director::isLive()) {
        SS_Cache::add_backend(
            'primary_memcached',
            'Memcached',
            array(
                'servers' => array(
                    'host' => $host,
                    'port' => $port,
                    'persistent' => true,
                    'weight' => 1,
                    'timeout' => 5,
                    'retry_interval' => 15,
                    'status' => true,
                    'failure_callback' => null
                )
            )
        );
        SS_Cache::pick_backend('primary_memcached', 'any', 10);
    }
}

SS_Cache::set_cache_lifetime('CategoryPage', 31536000);
SS_Cache::set_cache_lifetime('Work', 31536000);

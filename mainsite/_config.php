<?php

global $project;
$project = 'mainsite';

global $database;
$database = SS_DATABASE_NAME;

// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");

if (!extension_loaded('imagick')) {
  GD::set_default_quality(90);
  Image::set_backend("OptimisedGDBackend");
} else {
  ImagickBackend::set_default_quality(90);
  Image::set_backend("ImagickBackend");
}

Requirements::set_write_js_to_body(false);

if (Director::isLive()) {
	SS_Log::add_writer(new SS_LogEmailWriter('leo@leochen.co.nz'), SS_Log::ERR);
}

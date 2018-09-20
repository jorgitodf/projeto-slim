<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

use Slim\App;

$config['displayErrorDetails'] = true;

$app = new App(['settings' => $config]);
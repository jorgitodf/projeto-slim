<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

use Slim\App;
use App\Src\Whoops;

$config['displayErrorDetails'] = true;

$app = new App(['settings' => $config]);

$whoops = new Whoops;
$whoops->run($app);

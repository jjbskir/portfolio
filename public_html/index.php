<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL | E_STRICT);


$app = require __DIR__.'/../src/app.php';

$app->run();

<?php

$app = new App();
$app->init();

$router = $app->initRouter();

//$basePath = dirname($_SERVER['PHP_SELF']) === '/' ? '' : dirname($_SERVER['PHP_SELF']);
$router->with('', __DIR__ . '/src/routes.php');

$router->dispatch();

die();
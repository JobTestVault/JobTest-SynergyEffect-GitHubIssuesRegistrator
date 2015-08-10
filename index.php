<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Slim\Slim([
    'mode' => 'development',
    'templates.path' => './templates'
]);

$app->get('/', function () use ($app) {
    $app->render('index.php', []);
});
$app->post('/', function () use ($app) {
    echo "Hello";
});

$app->run();
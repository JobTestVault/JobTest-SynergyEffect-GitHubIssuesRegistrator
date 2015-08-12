<?php

require __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = new \Slim\Slim([
    'mode' => 'development',
    'templates.path' => './templates'
]);
$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => 'CHANGE_ME',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));


$github = new \GitHub_Tools(__DIR__);

$github_test = function () use ($github) {
    if (!$github->isGitHubRepo()) {
        throw new Exception('This repo is not from github!');
    }
};

$app->get('/', $github_test, function () use ($app, $github) {    
    $app->render('index.php', [
        
    ]);
});
$app->post('/', $github_test, function () use ($app, $github) { 
    $title = $app->request()->post('title');
    $_SESSION['login'] = $app->request()->post('login');
    $_SESSION['pass'] = $app->request()->post('password');
    $description = $app->request()->post('description');
    if (empty($title)) {
        $app->flash('error', 'Title is missing');
        return $app->redirect('./');
    }
    if (empty($_SESSION['login'])) {
        $app->flash('error', 'GitHub login is missing');
        return $app->redirect('./');
    } 
    if (empty($_SESSION['pass'])) {
        $app->flash('error', 'GitHub password is missing');
        return $app->redirect('./');
    }    
    try {
        $ret = $github->createTicket($_SESSION['login'], $_SESSION['pass'], $title, $description);
        if (!isset($ret['html_url'])) {
            throw new Exception('Issue can\t be created');
        }
        $app->flash('success', 'Ticket was created at <a href="' . $ret['html_url'] . '" target="_blank">' . $ret['html_url'] . '</a>');
    } catch (\Exception $ex) {        
        $app->flash('error', $ex->getMessage());
    }    
    return $app->redirect('./');
});

$app->run();
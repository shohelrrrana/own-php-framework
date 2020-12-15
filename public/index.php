<?php
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
require __DIR__ . './../vendor/autoload.php';

use \Core\Application;
use \App\Controllers\HomeController;
use \App\Controllers\ContactController;
use \App\Controllers\AuthController;

$app = new Application();

$app->router->get( '/', [ HomeController::class, 'index' ] );

$app->router->get( '/auth/login', [ AuthController::class, 'login' ] );
$app->router->post( '/auth/login', [ AuthController::class, 'login' ] );
$app->router->get( '/auth/register', [ AuthController::class, 'register' ] );
$app->router->post( '/auth/register', [ AuthController::class, 'register' ] );

$app->router->get( '/contact', [ ContactController::class, 'index' ] );
$app->router->post( '/contact', [ ContactController::class, 'index' ] );

$app->run();

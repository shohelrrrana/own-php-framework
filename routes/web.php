<?php
/**
 * --------------------------------------------------------
 * Here will be register all routes which will need
 * ---------------------------------------------------------
 */

use Core\Router\Route;
use App\Controllers\HomeController;
use App\Controllers\ContactController;
use App\Controllers\AuthController;

Route::get( '/', [ HomeController::class, 'index' ] );

Route::get( '/auth/login', [ AuthController::class, 'login' ] );
Route::post( '/auth/login', [ AuthController::class, 'login' ] );
Route::get( '/auth/register', [ AuthController::class, 'register' ] );
Route::post( '/auth/register', [ AuthController::class, 'register' ] );

Route::get( '/contact', [ ContactController::class, 'index' ] );
Route::post( '/contact', [ ContactController::class, 'index' ] );

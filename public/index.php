<?php

/**
 *Own php framework
 *
 * @author Shohel Rana <shohelrrrana@gmail.com>
 */

/**
 * -----------------------------------------------
 * Register the autoloader
 * -----------------------------------------------
 *
 * Load the autoloader that will generated class that will be used
 */
require __DIR__ . './../vendor/autoload.php';

/**
 * -------------------------------------------------
 * Run the application
 * -------------------------------------------------
 *
 * Handle the request and send response
 */

use Core\Bootstrap\Application;

$app = new Application();
$app->run();

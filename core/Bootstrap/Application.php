<?php


namespace Core\Bootstrap;

use Core\Router\Route;

/**
 * Class Application
 *
 * @package Core\Bootstrap
 */
class Application {
	/**
	 * Put instance of Route class
	 *
	 * @var Route $route
	 */
	private Route $route;

	/**
	 * Application constructor.
	 */
	public function __construct () {
		$this->route = new Route();
	}

	/**
	 * Run the application
	 *
	 * @return void
	 */
	public function run () {
		$this->checkDebugMode();
		$this->defineConstants();
		$this->includeFiles();

		$this->route->resolve();
	}

	/**
	 * Define necessary constants
	 *
	 * @return void
	 */
	private function defineConstants () {
		define( 'DS', DIRECTORY_SEPARATOR );
		define( 'ROOT_PATH', realpath( dirname( dirname( __DIR__ ) ) ) );
		define( 'VIEW_PATH', ROOT_PATH . DS . 'app' . DS . 'views' );
	}

	/**
	 * Check the application debug mode
	 *
	 * @return void
	 */
	public function checkDebugMode () {
		if ( defined( 'DEBUG' ) && DEBUG === true ) {
			ini_set( 'display_errors', 1 );
			ini_set( 'display_startup_errors', 1 );
			error_reporting( E_ALL );
		} else {
			ini_set( 'display_errors', 0 );
			error_reporting( 0 );
		}
	}

	/**
	 * Include necessary no class files
	 *
	 * @return void
	 */
	public function includeFiles () {
		require_once ROOT_PATH . DS . 'routes' . DS . 'web.php';
		require_once ROOT_PATH . DS . 'routes' . DS . 'api.php';
	}
}
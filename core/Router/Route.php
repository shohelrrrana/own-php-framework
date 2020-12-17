<?php

namespace Core\Router;

use Core\Http\Request;
use Core\Http\Response;

/**
 * Class Route
 *
 * @package Core\Router
 */
class Route {
	/**
	 * Put registered routes
	 *
	 * @var array
	 */
	private static array   $routes = [];

	/**
	 * @var Request
	 */
	public Request         $request;

	/**
	 * @var Response
	 */
	public Response        $response;

	/**
	 * Route constructor.
	 */
	public function __construct () {
		$this->request  = new Request();
		$this->response = new Response();
	}

	/**
	 * Register get routes
	 *
	 * @param $path
	 * @param $callback
	 *
	 * @return void
	 */
	public static function get ( $path, $callback ) {
		self::$routes['get'][ $path ] = $callback;
	}

	/**
	 * Register post routes
	 *
	 * @param $path
	 * @param $callback
	 *
	 * @return void
	 */
	public static function post ( $path, $callback ) {
		self::$routes['post'][ $path ] = $callback;
	}

	/**
	 * Register delete routes
	 *
	 * @param $path
	 * @param $callback
	 *
	 * @return void
	 */
	public static function delete ( $path, $callback ) {
		self::$routes['delete'][ $path ] = $callback;
	}

	/**
	 * Resolve the request
	 *
	 * @return void
	 */
	public function resolve () {
		$method = $this->request->method();
		$path   = $this->request->path();

		$callback = self::$routes[ $method ][ $path ] ?? false;

		if ( $callback === false ) {
			$this->response->setStatusCode( 404 );
			echo "Not found";
			exit();
		}

		if ( is_array( $callback ) ) {
			$callback[0] = new $callback[0];
		}

		if ( is_callable( $callback ) ) {
			echo call_user_func( $callback, $this->request );
		}
	}
}
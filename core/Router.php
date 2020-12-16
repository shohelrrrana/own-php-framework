<?php

namespace Core;

class Router {
	protected array   $routes = [];
	public Request    $request;
	public Response   $response;

	public function __construct () {
		$this->request  = new Request();
		$this->response = new Response();
	}

	public function get ( $path, $callback ) {
		$this->routes['get'][ $path ] = $callback;
	}

	public function post ( $path, $callback ) {
		$this->routes['post'][ $path ] = $callback;
	}

	public function delete ( $path, $callback ) {
		$this->routes['delete'][ $path ] = $callback;
	}

	public function resolve () {
		$method = $this->request->method();
		$path   = $this->request->path();

		$callback = $this->routes[ $method ][ $path ] ?? false;

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
<?php


namespace Core;

class Application {
	public Router   $router;
	public Request  $request;
	public Response $response;

	public function __construct () {
		$this->defineConstants();
		$this->router   = new Router();
		$this->request  = new Request();
		$this->response = new Response();
	}

	public function run () {
		$this->router->resolve();
	}

	private function defineConstants () {
		define( 'ROOT_PATH', dirname( __DIR__ ) );
		define( 'VIEW_PATH', ROOT_PATH . '/app/views' );
	}
}